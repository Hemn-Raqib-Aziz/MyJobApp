<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Show register/create form
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $formFields = $request->validate([
            'name'     => ['required', 'string', 'min:3', 'max:30'],
            'email'    => ['required', 'email:rcf,dns', Rule::unique('users', 'email')],
            'password' => 'required|confirmed|min:6',
            'role'     => ['required', 'in:job_seeker,job_poster'],
        ]);

        $formFields['password'] = bcrypt($formFields['password']);

        $user = User::create([
            'name'      => $formFields['name'],
            'email'     => $formFields['email'],
            'password'  => $formFields['password'],
            'user_type' => $request->role,
        ]);

        Auth::login($user);

        return redirect()->route('profile.setup', ['role' => $request->role]);
    }

    // Logout user
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    // Show login form
    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $formFields = $request->validate([
            'email'    => ['required', 'email:rcf,dns'],
            'password' => 'required',
        ]);

        if (Auth::attempt($formFields)) {
            $request->session()->regenerate();

            /** @var \App\Models\User $user */
            $user = Auth::user();

            // Step 1: Has no profile yet → fill profile form
            if (!$user->jobSeeker && !$user->jobPoster) {
                return redirect()->route('profile.setup', ['role' => $user->user_type]);
            }

            // Step 2: Has profile but not verified → verify email
            if (!$user->hasVerifiedEmail()) {
                return redirect()->route('verification.notice');
            }

            // Step 3: All good → jobs listing
            return redirect()->route('jobs.index');
        }

        return back()->withErrors(['email' => 'Invalid credentials'])->onlyInput('email');
    }
}