<?php

namespace App\Http\Controllers;

use App\Mail\NewApplication;
use App\Mail\ApplicationStatusUpdated;
use App\Models\Application;
use App\Models\JobPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ApplicationController extends Controller
{
    // Show apply form — job.seeker middleware guarantees user is a seeker
    public function create(JobPost $jobPost)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $alreadyApplied = Application::where('job_seeker_id', $user->jobSeeker->id)
            ->where('job_post_id', $jobPost->id)
            ->exists();

        if ($alreadyApplied) {
            return redirect()->route('jobs.show', $jobPost->id)
                ->with('error', 'You have already applied for this job.');
        }

        return view('applications.create', compact('jobPost', 'user'));
    }

    // Store application — job.seeker middleware guarantees user is a seeker
    public function store(Request $request, JobPost $jobPost)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'cover_letter' => ['required', 'string', 'min:50'],
            'cv'           => ['required', 'file', 'mimes:pdf', 'mimetypes:application/pdf', 'max:2048'],
        ]);

        $cvPath = $request->file('cv')->store('cvs', 'public');

        $application = Application::create([
            'job_seeker_id' => $user->jobSeeker->id,
            'job_post_id'   => $jobPost->id,
            'cover_letter'  => $request->cover_letter,
            'cv_path'       => $cvPath,
        ]);

        Mail::to($jobPost->poster->user->email)->queue(new NewApplication($application));

        return redirect()->route('applications.mine')
            ->with('message', 'Application submitted successfully!');
    }

    // Job seeker — their own applications
    public function myApplications()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $applications = Application::where('job_seeker_id', $user->jobSeeker->id)
            ->with('jobPost')
            ->latest()
            ->get();

        return view('applications.my-applications', compact('applications'));
    }

    // Job poster — applications for one of their jobs
    public function jobApplications(JobPost $jobPost)
    {
        $applications = Application::where('job_post_id', $jobPost->id)
            ->with('jobSeeker.user')
            ->latest()
            ->get();

        return view('applications.job-applications', compact('applications', 'jobPost'));
    }

    // Job poster — single application detail
    public function show(Application $application)
    {
        return view('applications.show', compact('application'));
    }

    // Job poster — update application status
    public function updateStatus(Request $request, Application $application)
    {
        $request->validate([
            'status' => ['required', 'in:pending,reviewed,accepted,rejected'],
        ]);

        if ($application->status === $request->status) {
            return redirect()->back()->with('error', 'Status is already set to ' . $request->status . '!');
        }

        $application->update(['status' => $request->status]);

        Mail::to($application->jobSeeker->user->email)
            ->queue(new ApplicationStatusUpdated($application));

        return redirect()->back()->with('message', 'Application status updated and applicant notified!');
    }
}