<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.layout')
    <title>{{ $jobPoster->user->name }} — MyJobApp</title>
</head>
<body>
    @include('partials.navbar')

    <div class="page-sm">
        <a href="javascript:history.back()" class="btn btn-secondary btn-sm" style="margin-bottom:28px;">← Back</a>

        {{-- Company Header --}}
        <div style="margin-bottom:36px;">
            <h2 style="margin-bottom:8px;">{{ $jobPoster->user->name }}</h2>
            <div class="meta">
                @if($jobPoster->industry)
                    <span>🏭 {{ $jobPoster->industry }}</span>
                @endif
                @if($jobPoster->location)
                    <span>📍 {{ $jobPoster->location }}</span>
                @endif
                @if($jobPoster->website)
                    <span>🌐 <a href="{{ $jobPoster->website }}" target="_blank" style="color:var(--black);">{{ $jobPoster->website }}</a></span>
                @endif
            </div>
        </div>

        {{-- About --}}
        @if($jobPoster->about)
            <div style="margin-bottom:36px;">
                <h5 style="margin-bottom:12px;">About</h5>
                <p style="line-height:1.8; color:var(--gray-600);">{{ $jobPoster->about }}</p>
            </div>
            <hr class="divider">
        @endif

        {{-- Active Jobs --}}
        <div>
            <h5 style="margin-bottom:20px;">Open Positions</h5>

            @forelse($jobs as $job)
                <div class="job-card">
                    <div style="display:flex; justify-content:space-between; align-items:flex-start; flex-wrap:wrap; gap:8px;">
                        <div>
                            <div class="job-card-title">{{ $job->title }}</div>
                            <div class="meta">
                                <span>📍 {{ $job->location }}</span>
                                <span>💼 {{ ucfirst(str_replace('_', ' ', $job->job_type)) }}</span>
                                <span>📂 {{ $job->category }}</span>
                            </div>
                        </div>
                        <span style="font-size:13px; color:var(--gray-400); white-space:nowrap;">⏰ {{ $job->deadline }}</span>
                    </div>
                    <div class="job-card-actions">
                        <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-primary btn-sm">View Details</a>
                    </div>
                </div>
            @empty
                <p style="color:var(--gray-400); font-size:14px;">No active job postings.</p>
            @endforelse
        </div>
    </div>
</body>
</html>