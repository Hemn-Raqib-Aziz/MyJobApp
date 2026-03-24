<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewJobPosted;

class JobPostController extends Controller
{
    // Show all jobs
    // public function index()
    // {
    //     $jobs = JobPost::with('poster')->latest()->get();
    //     return view('jobs.index', compact('jobs'));
    // }
    // Replace your index() method in JobPostController.php with this:

public function index(Request $request)
{
    $query = JobPost::with('poster')->latest();

    if ($request->filled('search')) {
        $query->where(function($q) use ($request) {
            $q->where('title', 'like', '%' . $request->search . '%')
              ->orWhere('job_description', 'like', '%' . $request->search . '%')
              ->orWhere('category', 'like', '%' . $request->search . '%');
        });
    }

    if ($request->filled('location')) {
        $query->where('location', 'like', '%' . $request->location . '%');
    }

    if ($request->filled('job_type')) {
        $query->where('job_type', $request->job_type);
    }

    if ($request->filled('category')) {
        $query->where('category', 'like', '%' . $request->category . '%');
    }

    $jobs = $query->get();

    return view('jobs.index', compact('jobs'));
}

    // Show create form
    public function create()
    {
        if (Auth::user()->user_type !== 'job_poster') {
            abort(403, 'Only employers can post jobs.');
        }
        return view('jobs.create');
    }

    // Save new job
    public function store(Request $request)
    {
        if (Auth::user()->user_type !== 'job_poster') {
            abort(403, 'Only employers can post jobs.');
        }

        $request->validate([
            'title'            => ['required', 'string', 'max:255'],
            'job_description'  => ['required', 'string'],
            'job_requirements' => ['required', 'string'],
            'location'         => ['required', 'string'],
            'category'         => ['required', 'string'],
            'deadline'         => ['required', 'date'],
            'job_type'         => ['required', 'in:full_time,part_time,remote,freelance'],
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $job = JobPost::create([
            'title'            => $request->title,
            'job_description'  => $request->job_description,
            'job_requirements' => $request->job_requirements,
            'location'         => $request->location,
            'category'         => $request->category,
            'deadline'         => $request->deadline,
            'job_type'         => $request->job_type,
            'job_poster_id'    => $user->jobPoster->id,
        ]);

        // Send email ONLY to verified subscribed job seekers
$jobSeekers = User::where('user_type', 'job_seeker')
    ->whereNotNull('email_verified_at')
    ->whereHas('jobSeeker', function ($query) {
        $query->where('email_notifications', true);
    })
    ->get();

foreach ($jobSeekers as $recipient) {
    Mail::to($recipient->email)->queue(new NewJobPosted($job));
}

        return redirect()->route('jobs.index')->with('message', 'Job posted successfully! All users have been notified.');
    }

    // Show single job
    public function show(JobPost $jobPost)
    {
        return view('jobs.show', compact('jobPost'));
    }


    // Show only the job poster's own jobs
public function myJobs()
{
    if (Auth::user()->user_type !== 'job_poster') {
        abort(403);
    }

    /** @var \App\Models\User $user */
    $user = Auth::user();

    $jobs = JobPost::where('job_poster_id', $user->jobPoster->id)->latest()->get();
    return view('jobs.my-jobs', compact('jobs'));
}

// Show edit form
public function edit(JobPost $jobPost)
{
    /** @var \App\Models\User $user */
    $user = Auth::user();

    // Only the owner can edit
    if ($jobPost->job_poster_id !== $user->jobPoster->id) {
        abort(403, 'Unauthorized action.');
    }

    return view('jobs.edit', compact('jobPost'));
}

// Update job
public function update(Request $request, JobPost $jobPost)
{
    /** @var \App\Models\User $user */
    $user = Auth::user();

    if ($jobPost->job_poster_id !== $user->jobPoster->id) {
        abort(403, 'Unauthorized action.');
    }

    $request->validate([
        'title'            => ['required', 'string', 'max:255'],
        'job_description'  => ['required', 'string'],
        'job_requirements' => ['required', 'string'],
        'location'         => ['required', 'string'],
        'category'         => ['required', 'string'],
        'deadline'         => ['required', 'date'],
        'job_type'         => ['required', 'in:full_time,part_time,remote,freelance'],
    ]);

    $jobPost->update([
        'title'            => $request->title,
        'job_description'  => $request->job_description,
        'job_requirements' => $request->job_requirements,
        'location'         => $request->location,
        'category'         => $request->category,
        'deadline'         => $request->deadline,
        'job_type'         => $request->job_type,
    ]);

    return redirect()->route('jobs.mine')->with('message', 'Job updated successfully!');
}

// Delete job
public function destroy(JobPost $jobPost)
{
    /** @var \App\Models\User $user */
    $user = Auth::user();

    if ($jobPost->job_poster_id !== $user->jobPoster->id) {
        abort(403, 'Unauthorized action.');
    }

    $jobPost->delete();

    return redirect()->route('jobs.mine')->with('message', 'Job deleted successfully!');
}










}