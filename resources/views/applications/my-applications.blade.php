{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Applications</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @include('partials.navbar')

    <div class="container mt-5">
        <h2>My Applications</h2>

        @if(session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif

        @forelse($applications as $application)
            <div class="card mb-3">
                <div class="card-body">
                    <h5>{{ $application->jobPost->title }}</h5>
                    <p class="text-muted mb-1">📍 {{ $application->jobPost->location }} · 💼 {{ ucfirst(str_replace('_', ' ', $application->jobPost->job_type)) }}</p>
                    <p class="mb-1">
                        Status: 
                        <span class="badge 
                            @if($application->status === 'accepted') bg-success
                            @elseif($application->status === 'rejected') bg-danger
                            @elseif($application->status === 'reviewed') bg-warning
                            @else bg-secondary @endif">
                            {{ ucfirst($application->status) }}
                        </span>
                    </p>
                    <p class="text-muted mb-0">Applied: {{ $application->created_at->diffForHumans() }}</p>
                </div>
            </div>
        @empty
            <p>You haven't applied to any jobs yet. <a href="{{ route('jobs.index') }}">Browse jobs</a></p>
        @endforelse
    </div>
</body>
</html> --}}


<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.layout')
    <title>My Applications — MyJobApp</title>
</head>
<body>
    @include('partials.navbar')

    <div class="page">
        <div class="section-title">
            <h2>My Applications</h2>
            <p>Track the status of your job applications.</p>
        </div>

        @if(session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif

        @forelse($applications as $application)
            <div class="job-card">
                <div style="display:flex; justify-content:space-between; align-items:flex-start; flex-wrap:wrap; gap:8px;">
                    <div>
                        <div class="job-card-title">{{ $application->jobPost->title }}</div>
                        <div class="meta">
                            <span>📍 {{ $application->jobPost->location }}</span>
                            <span>💼 {{ ucfirst(str_replace('_', ' ', $application->jobPost->job_type)) }}</span>
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
            </div>
        @empty
            <div style="text-align:center; padding:60px 0;">
                <p style="color:var(--gray-400); font-size:16px; margin-bottom:16px;">No applications yet.</p>
                <a href="{{ route('jobs.index') }}" class="btn btn-primary">Browse Jobs</a>
            </div>
        @endforelse
    </div>
</body>
</html>