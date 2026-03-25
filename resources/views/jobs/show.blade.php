<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.layout')
    <title>{{ $jobPost->title }} — MyJobApp</title>
</head>
<body>
    @include('partials.navbar')

    <div class="page-sm">
        <a href="{{ route('jobs.index') }}" class="btn btn-secondary btn-sm" style="margin-bottom:28px;">← Back to Jobs</a>

        {{-- Job Header --}}
        <div style="margin-bottom:32px;">
            <h2 style="margin-bottom:12px;">{{ $jobPost->title }}</h2>
            <div class="meta">
                <span>📍 {{ $jobPost->location }}</span>
                <span>💼 {{ ucfirst(str_replace('_', ' ', $jobPost->job_type)) }}</span>
                <span>📂 {{ $jobPost->category }}</span>
                <span>⏰ Deadline: {{ $jobPost->deadline }}</span>
            </div>

            {{-- Poster profile link --}}
            <div style="margin-top:16px;">
                <a href="{{ route('poster.profile', $jobPost->poster->id) }}"
                   style="font-size:14px; color:var(--gray-600); text-decoration:none; display:inline-flex; align-items:center; gap:6px; border:1px solid var(--gray-200); padding:6px 14px; border-radius:var(--radius); transition:all 0.15s ease;"
                   onmouseover="this.style.borderColor='var(--black)';this.style.color='var(--black)'"
                   onmouseout="this.style.borderColor='var(--gray-200)';this.style.color='var(--gray-600)'">
                    🏢 View Company Profile
                </a>
            </div>
        </div>

        <hr class="divider">

        {{-- Description --}}
        <div style="margin-bottom:32px;">
            <h5 style="margin-bottom:12px;">Job Description</h5>
            <p style="line-height:1.8; color:var(--gray-600); white-space:pre-wrap;">{{ $jobPost->job_description }}</p>
        </div>

        <hr class="divider">

        {{-- Requirements --}}
        <div style="margin-bottom:36px;">
            <h5 style="margin-bottom:12px;">Requirements</h5>
            <p style="line-height:1.8; color:var(--gray-600); white-space:pre-wrap;">{{ $jobPost->job_requirements }}</p>
        </div>

        {{-- Apply --}}
        @auth
            @if(Auth::user()->user_type === 'job_seeker')
                @if(session('error'))
                    <div class="alert alert-warning">{{ session('error') }}</div>
                @endif
                <a href="{{ route('applications.create', $jobPost->id) }}" class="btn btn-primary btn-full">Apply for this Position</a>
            @endif
        @endauth

        @guest
            <div style="border:1px solid var(--gray-200); border-radius:var(--radius); padding:20px; text-align:center;">
                <p style="color:var(--gray-600); margin-bottom:16px; font-size:14px;">Sign in to apply for this job.</p>
                <div style="display:flex; gap:10px; justify-content:center;">
                    <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-secondary">Register</a>
                </div>
            </div>
        @endguest
    </div>
</body>
</html>