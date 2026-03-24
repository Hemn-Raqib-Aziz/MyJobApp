{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Applications for {{ $jobPost->title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @include('partials.navbar')

    <div class="container mt-5">
        <h2>Applications for: {{ $jobPost->title }}</h2>
        <a href="{{ route('jobs.mine') }}" class="btn btn-secondary btn-sm mb-4">← Back to My Jobs</a>

        @if(session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif

        @forelse($applications as $application)
            <div class="card mb-3">
                <div class="card-body">
                    <h5>{{ $application->jobSeeker->user->name }}</h5>
                    <p class="text-muted mb-1">📍 {{ $application->jobSeeker->location ?? 'Not set' }}</p>
                    <p class="text-muted mb-1">Applied: {{ $application->created_at->diffForHumans() }}</p>
                    <span class="badge 
                        @if($application->status === 'accepted') bg-success
                        @elseif($application->status === 'rejected') bg-danger
                        @elseif($application->status === 'reviewed') bg-warning
                        @else bg-secondary @endif">
                        {{ ucfirst($application->status) }}
                    </span>
                    <div class="mt-2">
                        <a href="{{ route('applications.show', $application->id) }}" class="btn btn-primary btn-sm">View Application</a>
                    </div>
                </div>
            </div>
        @empty
            <p>No applications yet for this job.</p>
        @endforelse
    </div>
</body>
</html> --}}


<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.layout')
    <title>Applications — {{ $jobPost->title }}</title>
</head>
<body>
    @include('partials.navbar')

    <div class="page">
        <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; margin-bottom:32px;">
            <div>
                <h2>Applications</h2>
                <p style="color:var(--gray-600); margin-top:4px; font-size:14px;">{{ $jobPost->title }}</p>
            </div>
            <a href="{{ route('jobs.mine') }}" class="btn btn-secondary btn-sm">← Back to My Jobs</a>
        </div>

        @if(session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif

        @forelse($applications as $application)
            <div class="job-card">
                <div style="display:flex; justify-content:space-between; align-items:flex-start; flex-wrap:wrap; gap:8px;">
                    <div>
                        <div class="job-card-title">{{ $application->jobSeeker->user->name }}</div>
                        <div class="meta">
                            @if($application->jobSeeker->location)
                                <span>📍 {{ $application->jobSeeker->location }}</span>
                            @endif
                            <span>Applied {{ $application->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    <span class="badge
                        @if($application->status === 'accepted') badge-success
                        @elseif($application->status === 'rejected') badge-danger
                        @elseif($application->status === 'reviewed') badge-warning
                        @else badge-secondary @endif">
                        {{ ucfirst($application->status) }}
                    </span>
                </div>
                <div class="job-card-actions">
                    <a href="{{ route('applications.show', $application->id) }}" class="btn btn-primary btn-sm">View Application</a>
                </div>
            </div>
        @empty
            <div style="text-align:center; padding:60px 0; color:var(--gray-400);">
                <p style="font-size:16px;">No applications received yet.</p>
            </div>
        @endforelse
    </div>
</body>
</html>