<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.layout')
    <title>My Jobs — MyJobApp</title>
</head>
<body>
    @include('partials.navbar')

    <div class="page">
        <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; margin-bottom:36px;">
            <div class="section-title" style="margin-bottom:0;">
                <h2>My Jobs</h2>
                <p>Manage your job listings.</p>
            </div>
            <a href="{{ route('jobs.create') }}" class="btn btn-primary">+ Post a Job</a>
        </div>

        @if(session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif

        @forelse($jobs as $job)
            <div class="job-card">
                <div style="display:flex; justify-content:space-between; align-items:flex-start; flex-wrap:wrap; gap:8px;">
                    <div>
                        <div class="job-card-title">{{ $job->title }}</div>
                        <div class="meta">
                            <span>📍 {{ $job->location }}</span>
                            <span>💼 {{ ucfirst(str_replace('_', ' ', $job->job_type)) }}</span>
                            <span>📂 {{ $job->category }}</span>
                            <span>⏰ {{ $job->deadline }}</span>
                        </div>
                    </div>
                </div>

                <div class="job-card-actions">
                    <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-secondary btn-sm">View</a>
                    <a href="{{ route('applications.job', $job->id) }}" class="btn btn-secondary btn-sm">Applications</a>
                    <a href="{{ route('jobs.edit', $job->id) }}" class="btn btn-secondary btn-sm">Edit</a>
                    <form method="POST" action="{{ route('jobs.destroy', $job->id) }}" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm('Are you sure you want to delete this job?')">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div style="text-align:center; padding:80px 0;">
                <p style="color:var(--gray-400); font-size:16px; margin-bottom:20px;">No jobs posted yet.</p>
                <a href="{{ route('jobs.create') }}" class="btn btn-primary">Post your first job</a>
            </div>
        @endforelse
    </div>
</body>
</html>