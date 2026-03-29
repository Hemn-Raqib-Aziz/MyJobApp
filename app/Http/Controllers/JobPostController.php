<?php

namespace App\Http\Controllers;

use App\Mail\NewJobPosted;
use App\Models\Application;
use App\Models\JobPost;
use App\Models\SavedJob;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class JobPostController extends Controller
{
    // Public listing with filters
    public function index(Request $request)
    {
        $query = JobPost::with('poster')->latest();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
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

        $jobs        = $query->get();
        $savedJobIds = $this->getSavedJobIds();

        return view('jobs.index', compact('jobs', 'savedJobIds'));
    }

    // Show create form — job.poster middleware handles role check
    public function create()
    {
        return view('jobs.create');
    }

    // Store new job — job.poster middleware handles role check
    public function store(Request $request)
    {
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

        // Notify verified + subscribed job seekers only
        User::where('user_type', 'job_seeker')
            ->whereNotNull('email_verified_at')
            ->whereHas('jobSeeker', fn ($q) => $q->where('email_notifications', true))
            ->each(fn ($recipient) => Mail::to($recipient->email)->queue(new NewJobPosted($job)));

        return redirect()->route('jobs.index')
            ->with('message', 'Job posted successfully! Subscribed users have been notified.');
    }

    // Public single job view
    public function show(JobPost $jobPost)
    {
        $hasApplied = $this->checkIfUserApplied($jobPost->id);
        return view('jobs.show', compact('jobPost', 'hasApplied'));
    }

    // Poster's own jobs — job.poster middleware handles role check
    public function myJobs()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $jobs = JobPost::where('job_poster_id', $user->jobPoster->id)->latest()->get();

        return view('jobs.my-jobs', compact('jobs'));
    }

    // Edit form — ownership check keeps the poster honest
      public function edit(JobPost $jobPost)
    {
        return view('jobs.edit', compact('jobPost'));
    }


    // Update
    public function update(Request $request, JobPost $jobPost)
    {
        

        $request->validate([
            'title'            => ['required', 'string', 'max:255'],
            'job_description'  => ['required', 'string'],
            'job_requirements' => ['required', 'string'],
            'location'         => ['required', 'string'],
            'category'         => ['required', 'string'],
            'deadline'         => ['required', 'date'],
            'job_type'         => ['required', 'in:full_time,part_time,remote,freelance'],
        ]);

        $jobPost->update($request->only([
            'title', 'job_description', 'job_requirements',
            'location', 'category', 'deadline', 'job_type',
        ]));

        return redirect()->route('jobs.mine')->with('message', 'Job updated successfully!');
    }

    // Delete
    public function destroy(JobPost $jobPost)
    {
        $jobPost->delete();

        return redirect()->route('jobs.mine')->with('message', 'Job deleted successfully!');
    }

    // Save a job — available to both seekers and posters
    public function saveJob($jobId)
    {
        SavedJob::firstOrCreate([
            'user_id'     => Auth::id(),
            'job_post_id' => $jobId,
        ]);

        return back()->with('message', 'Job saved successfully!');
    }

    // Unsave a job — available to both seekers and posters
    public function unsaveJob($jobId)
    {
        SavedJob::where('user_id', Auth::id())
            ->where('job_post_id', $jobId)
            ->delete();

        return back()->with('message', 'Job removed from saved jobs.');
    }

    // Saved jobs — dedicated page, available to both seekers and posters
    public function savedJobs()
    {
        /** @var \App\Models\User $user */
        $user        = Auth::user();
        $savedJobIds = $user->savedJobs()->pluck('job_post_id')->toArray();
        $jobs        = JobPost::with('poster')->whereIn('id', $savedJobIds)->latest()->get();

        // Check application status for each saved job
        $appliedJobs = [];
        if (auth()->check() && auth()->user()->user_type === 'job_seeker') {
            $appliedJobs = Application::where('job_seeker_id', auth()->user()->jobSeeker->id)
                ->whereIn('job_post_id', $savedJobIds)
                ->pluck('job_post_id')
                ->toArray();
        }

        return view('jobs.saved', compact('jobs', 'savedJobIds', 'appliedJobs'));
    }



    private function checkIfUserApplied($jobPostId): bool
    {
        if (!auth()->check()) {
            return false;
        }

        if (auth()->user()->user_type !== 'job_seeker') {
            return false;
        }

        return Application::where('job_seeker_id', auth()->user()->jobSeeker->id)
            ->where('job_post_id', $jobPostId)
            ->exists();
    }

    // ── Private helper ────────────────────────────────────────────────────
    private function getSavedJobIds(): array
    {
        if (!auth()->check()) {
            return [];
        }

        /** @var \App\Models\User $user */
        $user = auth()->user();
        return $user->savedJobs()->pluck('job_post_id')->toArray();
    }
}