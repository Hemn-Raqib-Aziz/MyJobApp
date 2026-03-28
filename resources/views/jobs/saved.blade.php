<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.layout')
    <title>Saved Jobs — MyJobApp</title>
    <style>
        .saved-header {
            padding: 48px 0 36px;
            border-bottom: 1px solid var(--gray-200);
            margin-bottom: 36px;
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
        }
        .saved-header h1 { margin-bottom: 6px; }
        .saved-count {
            font-size: 13px;
            color: var(--gray-400);
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    @include('partials.navbar')

    <div class="page">

        <div class="saved-header">
            <div>
                <h1>Saved Jobs</h1>
                <p style="color:var(--gray-600); font-size:16px; max-width:480px; margin:0;">
                    Jobs you've bookmarked for later.
                </p>
            </div>
            <a href="{{ route('jobs.index') }}" class="btn btn-secondary">Browse All Jobs</a>
        </div>

        @if(session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <p class="saved-count">
            {{ $jobs->count() }} {{ $jobs->count() === 1 ? 'saved job' : 'saved jobs' }}
        </p>

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
                        @if($job->poster)
                            <div style="font-size:13px; color:var(--gray-400); margin-top:4px;">
                                Posted by
                                <a href="{{ route('poster.profile', $job->poster->id) }}"
                                   style="color:var(--gray-600);">
                                    {{ $job->poster->user->name }}
                                </a>
                            </div>
                        @endif
                    </div>
                    <span style="font-size:13px; color:var(--gray-400); white-space:nowrap;">
                        ⏰ {{ $job->deadline }}
                    </span>
                </div>

                <div class="job-card-actions">
                    <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-primary btn-sm">View Details</a>

                    {{-- Seeker: apply button --}}
                    @if(auth()->user()->user_type === 'job_seeker')
                        <a href="{{ route('applications.create', $job->id) }}" class="btn btn-primary btn-sm">
                            Apply
                        </a>
                    @endif

                    {{-- Unsave — removes from this list immediately --}}
                    <form method="POST" action="{{ route('jobs.unsave', $job->id) }}" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-secondary btn-sm">Remove</button>
                    </form>
                </div>
            </div>
        @empty
            <div style="text-align:center; padding:80px 0;">
                <p style="color:var(--gray-400); font-size:16px; margin-bottom:12px;">
                    You haven't saved any jobs yet.
                </p>
                <a href="{{ route('jobs.index') }}" class="btn btn-primary">Browse Jobs</a>
            </div>
        @endforelse

    </div>
</body>
</html>