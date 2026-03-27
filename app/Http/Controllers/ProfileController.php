<?php

namespace App\Http\Controllers;

use App\Models\JobSeeker;
use App\Models\JobPoster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // Show the correct form based on role
    public function setupForm(Request $request)
    {
        $role = $request->query('role'); // gets ?role=job_seeker from URL

        

        if (!in_array($role, ['job_seeker', 'job_poster'])) {
            return redirect()->route('home');
        }

        return view('profile.setup-form', compact('role'));
    }

    // Save the profile
    public function store(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($request->role === 'job_seeker') {
            $request->validate([
                'age'       => ['nullable', 'integer'],
                'sex'       => ['nullable', 'in:male,female'],
                'location'  => ['nullable', 'string'],
                'bio'       => ['nullable', 'string'],
            ]);

            JobSeeker::create([
                'user_id'   => $user->id,
                'age'       => $request->age * 100,
                'sex'       => $request->sex,
                'location'  => $request->location,
                'bio'       => $request->bio,
            ]);

        } else {
            $request->validate([
                'industry'        => ['nullable', 'string'],
                'location'        => ['nullable', 'string'],
                'website'         => ['nullable', 'string'],
                'about'           => ['nullable', 'string'],
            ]);

            JobPoster::create([
                'user_id'         => $user->id,
                'industry'        => $request->industry,
                'location'        => $request->location,
                'website'         => $request->website,
                'about'           => $request->about,
            ]);
        }

        // Save the role to the user
        $user->update(['user_type' => $request->role]);
        $user->sendEmailVerificationNotification();

        return redirect()->route('verification.notice');
    }






    // Show account page
public function showAccount()
{
    /** @var \App\Models\User $user */
    $user = Auth::user();

    if ($user->user_type !== 'job_poster') {
        abort(403);
    }

    $jobPoster = $user->jobPoster;
    return view('account.show', compact('jobPoster'));
}

// Update account
public function updateAccount(Request $request)
{
    /** @var \App\Models\User $user */
    $user = Auth::user();

    if ($user->user_type !== 'job_poster') {
        abort(403);
    }

    $request->validate([
        'name'            => ['required', 'string', 'min:3', 'max:30'],
        'industry'        => ['nullable', 'string', 'max:255'],
        'location'        => ['nullable', 'string', 'max:255'],
        'website'         => ['nullable', 'string', 'max:255'],
        'about'           => ['nullable', 'string'],
    ]);

    // Update user name
    $user->update(['name' => $request->name]);

    // Update job poster profile
    $user->jobPoster->update([
        'industry'        => $request->industry,
        'location'        => $request->location,
        'website'         => $request->website,
        'about'           => $request->about,
    ]);

    return redirect()->route('account.show')->with('message', 'Account updated successfully!');
}

// Delete account
public function deleteAccount(Request $request)
{
    /** @var \App\Models\User $user */
    $user = Auth::user();

    if ($user->user_type !== 'job_poster') {
        abort(403);
    }

    // Logout first
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    // Delete user (cascades to job_posters and job_posts)
    $user->delete();

    return redirect()->route('jobs.index')->with('message', 'Account deleted successfully.');
}











// Show job seeker account page
public function showSeekerAccount()
{
    /** @var \App\Models\User $user */
    $user = Auth::user();

    if ($user->user_type !== 'job_seeker') {
        abort(403);
    }

    $jobSeeker = $user->jobSeeker;
    return view('account.seeker', compact('jobSeeker'));
}

// Update job seeker account
public function updateSeekerAccount(Request $request)
{
    /** @var \App\Models\User $user */
    $user = Auth::user();

    if ($user->user_type !== 'job_seeker') {
        abort(403);
    }

    $request->validate([
        'name'     => ['required', 'string', 'min:3', 'max:30'],
        'age'      => ['nullable', 'integer'],
        'sex'      => ['nullable', 'in:male,female'],
        'location' => ['nullable', 'string'],
        'bio'      => ['nullable', 'string'],
    ]);

    $user->update(['name' => $request->name]);

    $user->jobSeeker->update([
        'age'      => $request->age,
        'sex'      => $request->sex,
        'location' => $request->location,
        'bio'      => $request->bio,
    ]);

    return redirect()->route('seeker.account.show')->with('message', 'Account updated successfully!');
}

// Delete job seeker account
public function deleteSeekerAccount(Request $request)
{
    /** @var \App\Models\User $user */
    $user = Auth::user();

    if ($user->user_type !== 'job_seeker') {
        abort(403);
    }

    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    $user->delete();

    return redirect()->route('jobs.index')->with('message', 'Account deleted successfully.');
}

// Toggle email notifications
public function toggleSubscription(Request $request)
{
    /** @var \App\Models\User $user */
    $user = Auth::user();

    if ($user->user_type !== 'job_seeker') {
        abort(403);
    }

    $current = $user->jobSeeker->email_notifications;
    $user->jobSeeker->update(['email_notifications' => !$current]);

    $status = !$current ? 'subscribed to' : 'unsubscribed from';
    return redirect()->route('seeker.account.show')->with('message', "You have {$status} email notifications.");
}





// Show public job poster profile
public function showPosterProfile(JobPoster $jobPoster)
{
    $jobs = \App\Models\JobPost::where('job_poster_id', $jobPoster->id)->latest()->get();
    return view('profile.poster-profile', compact('jobPoster', 'jobs'));
}



}