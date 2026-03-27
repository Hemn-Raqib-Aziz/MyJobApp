<?php

namespace App\Http\Controllers;

use App\Mail\NewApplication;
use Illuminate\Support\Facades\Mail;
use App\Mail\ApplicationStatusUpdated;
use App\Models\Application;
use App\Models\JobPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    // Show apply form
    public function create(JobPost $jobPost)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->user_type !== 'job_seeker') {
            abort(403, 'Only job seekers can apply.');
        }

        // Check if already applied
        $alreadyApplied = Application::where('job_seeker_id', $user->jobSeeker->id)
            ->where('job_post_id', $jobPost->id)
            ->exists();

        if ($alreadyApplied) {
            return redirect()->route('jobs.show', $jobPost->id)
                ->with('error', 'You have already applied for this job.');
        }

        return view('applications.create', compact('jobPost', 'user'));
    }

    // Store application
    public function store(Request $request, JobPost $jobPost)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->user_type !== 'job_seeker') {
            abort(403);
        }

        $request->validate([
            'cover_letter' => ['required', 'string', 'min:50'],
            'cv'           => ['required', 'file', 'mimes:pdf', 'mimetypes:application/pdf', 'max:2048'],
        ]);

        // Store CV file
        $cvPath = $request->file('cv')->store('cvs', 'public');

        $application = Application::create([
            'job_seeker_id' => $user->jobSeeker->id,
            'job_post_id'   => $jobPost->id,
            'cover_letter'  => $request->cover_letter,
            'cv_path'       => $cvPath,
        ]);

        $jobPosterEmail = $jobPost->poster->user->email;
Mail::to($jobPosterEmail)->queue(new NewApplication($application));

        return redirect()->route('applications.mine')
            ->with('message', 'Application submitted successfully!');
    }

    // Job seeker - show their own applications
    public function myApplications()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->user_type !== 'job_seeker') {
            abort(403);
        }

        $applications = Application::where('job_seeker_id', $user->jobSeeker->id)
            ->with('jobPost')
            ->latest()
            ->get();

        return view('applications.my-applications', compact('applications'));
    }

    // Job poster - show applications for their jobs
    public function jobApplications(JobPost $jobPost)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->user_type !== 'job_poster') {
            abort(403);
        }

        // Make sure this job belongs to this poster
        if ($jobPost->job_poster_id !== $user->jobPoster->id) {
            abort(403);
        }

        $applications = Application::where('job_post_id', $jobPost->id)
            ->with('jobSeeker.user')
            ->latest()
            ->get();

        return view('applications.job-applications', compact('applications', 'jobPost'));
    }

    // Show single application details (for job poster)
    public function show(Application $application)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->user_type !== 'job_poster') {
            abort(403);
        }

        if ($application->jobPost->job_poster_id !== $user->jobPoster->id) {
            abort(403);
        }

        return view('applications.show', compact('application'));
    }


public function updateStatus(Request $request, Application $application)
{
    /** @var \App\Models\User $user */
    $user = Auth::user();

    if ((int)$application->jobPost->job_poster_id !== (int)$user->jobPoster->id) {
        abort(403);
    }

    $request->validate([
        'status' => ['required', 'in:pending,reviewed,accepted,rejected'],
    ]);

    // Prevent updating to the same status
    if ($application->status === $request->status) {
        return redirect()->back()->with('error', 'Status is already set to ' . $request->status . '!');
    }

    $application->update(['status' => $request->status]);

    // Send email to job seeker
    $jobSeekerEmail = $application->jobSeeker->user->email;
    Mail::to($jobSeekerEmail)->queue(new ApplicationStatusUpdated($application));

    return redirect()->back()->with('message', 'Application status updated and applicant notified!');
}
}