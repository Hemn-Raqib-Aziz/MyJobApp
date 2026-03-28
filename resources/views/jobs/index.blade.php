{{-- <!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.layout')
    <title>Jobs — MyJobApp</title>
    <style>
        .filter-bar {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 32px;
            padding: 20px;
            background: var(--gray-100);
            border-radius: var(--radius);
            border: 1px solid var(--gray-200);
        }
        .filter-bar .form-control {
            flex: 1;
            min-width: 160px;
            background: var(--white);
        }
        .filter-bar .btn { white-space: nowrap; }
        .results-count {
            font-size: 13px;
            color: var(--gray-400);
            margin-bottom: 20px;
        }
        @media (max-width: 600px) {
            .filter-bar { flex-direction: column; }
            .filter-bar .form-control { min-width: 100%; }
        }
    </style>
</head>
<body>
    @include('partials.navbar')

    <div class="page">
        <div style="padding: 48px 0 36px; border-bottom: 1px solid var(--gray-200); margin-bottom: 36px;">
            <h1 style="margin-bottom:10px;">Find your next opportunity.</h1>
            <p style="color:var(--gray-600); font-size:16px; max-width:480px;">Browse open positions from companies hiring right now.</p>
        </div>

        @if(session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif

        <form method="GET" action="{{ route('jobs.index') }}">
            <div class="filter-bar">
                <input
                    type="text"
                    name="search"
                    class="form-control"
                    placeholder="Search by title or keyword..."
                    value="{{ request('search') }}"
                >
                <input
                    type="text"
                    name="location"
                    class="form-control"
                    placeholder="Location..."
                    value="{{ request('location') }}"
                >
                <select name="job_type" class="form-control">
                    <option value="">All Types</option>
                    <option value="full_time"  {{ request('job_type') == 'full_time'  ? 'selected' : '' }}>Full Time</option>
                    <option value="part_time"  {{ request('job_type') == 'part_time'  ? 'selected' : '' }}>Part Time</option>
                    <option value="remote"     {{ request('job_type') == 'remote'     ? 'selected' : '' }}>Remote</option>
                    <option value="freelance"  {{ request('job_type') == 'freelance'  ? 'selected' : '' }}>Freelance</option>
                </select>
                <input
                    type="text"
                    name="category"
                    class="form-control"
                    placeholder="Category..."
                    value="{{ request('category') }}"
                >
                <button type="submit" class="btn btn-primary">Filter</button>
                @if(request()->hasAny(['search', 'location', 'job_type', 'category']))
                    <a href="{{ route('jobs.index') }}" class="btn btn-secondary">Clear</a>
                @endif
                @auth
                    @if(auth()->user()->user_type === 'job_seeker')
                        <a href="{{ route('jobs.saved') }}" class="btn btn-secondary">Saved Jobs</a>
                    @endif
                @endauth
            </div>
        </form>

        <p class="results-count">
            {{ $jobs->count() }} {{ $jobs->count() === 1 ? 'job' : 'jobs' }} found
            @if(request()->hasAny(['search', 'location', 'job_type', 'category']))
                — <a href="{{ route('jobs.index') }}" style="color:var(--black);">clear filters</a>
            @endif
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
                    </div>
                    <span style="font-size:13px; color:var(--gray-400); white-space:nowrap;">⏰ {{ $job->deadline }}</span>
                </div>

                <div class="job-card-actions">
                    <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-primary btn-sm">View Details</a>

                    @auth
                        @if(auth()->user()->user_type === 'job_seeker')
                            @if(in_array($job->id, $savedJobIds))
                                <form method="POST" action="{{ route('jobs.unsave', $job->id) }}" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-secondary btn-sm">Unsave</button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('jobs.save', $job->id) }}" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-secondary btn-sm">Save</button>
                                </form>
                            @endif
                        @endif
                    @endauth
                </div>
            </div>
        @empty
            <div style="text-align:center; padding:80px 0;">
                <p style="color:var(--gray-400); font-size:16px; margin-bottom:12px;">No jobs found.</p>
                @if(request()->hasAny(['search', 'location', 'job_type', 'category']))
                    <a href="{{ route('jobs.index') }}" class="btn btn-secondary">Clear filters</a>
                @endif
            </div>
        @endforelse
    </div>
</body>
</html> --}}










<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.layout')
    <title>Jobs — MyJobApp</title>
    <style>
        .filter-bar {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 32px;
            padding: 20px;
            background: var(--gray-100);
            border-radius: var(--radius);
            border: 1px solid var(--gray-200);
        }
        .filter-bar .form-control { flex: 1; min-width: 160px; background: var(--white); }
        .filter-bar .btn { white-space: nowrap; }
        .results-count { font-size: 13px; color: var(--gray-400); margin-bottom: 20px; }
        @media (max-width: 600px) {
            .filter-bar { flex-direction: column; }
            .filter-bar .form-control { min-width: 100%; }
        }
    </style>
</head>
<body>
    @include('partials.navbar')

    <div class="page">

        <div style="padding: 48px 0 36px; border-bottom: 1px solid var(--gray-200); margin-bottom: 36px;">
            <h1 style="margin-bottom:10px;">Find your next opportunity.</h1>
            <p style="color:var(--gray-600); font-size:16px; max-width:480px;">
                Browse open positions from companies hiring right now.
            </p>
        </div>

        @if(session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form method="GET" action="{{ route('jobs.index') }}">
            <div class="filter-bar">
                <input type="text" name="search" class="form-control"
                       placeholder="Search by title or keyword..." value="{{ request('search') }}">
                <input type="text" name="location" class="form-control"
                       placeholder="Location..." value="{{ request('location') }}">
                <select name="job_type" class="form-control">
                    <option value="">All Types</option>
                    <option value="full_time"  {{ request('job_type') == 'full_time'  ? 'selected' : '' }}>Full Time</option>
                    <option value="part_time"  {{ request('job_type') == 'part_time'  ? 'selected' : '' }}>Part Time</option>
                    <option value="remote"     {{ request('job_type') == 'remote'     ? 'selected' : '' }}>Remote</option>
                    <option value="freelance"  {{ request('job_type') == 'freelance'  ? 'selected' : '' }}>Freelance</option>
                </select>
                <input type="text" name="category" class="form-control"
                       placeholder="Category..." value="{{ request('category') }}">
                <button type="submit" class="btn btn-primary">Filter</button>
                @if(request()->hasAny(['search', 'location', 'job_type', 'category']))
                    <a href="{{ route('jobs.index') }}" class="btn btn-secondary">Clear</a>
                @endif
            </div>
        </form>

        <p class="results-count">
            {{ $jobs->count() }} {{ $jobs->count() === 1 ? 'job' : 'jobs' }} found
            @if(request()->hasAny(['search', 'location', 'job_type', 'category']))
                — <a href="{{ route('jobs.index') }}" style="color:var(--black);">clear filters</a>
            @endif
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
                    </div>
                    <span style="font-size:13px; color:var(--gray-400); white-space:nowrap;">⏰ {{ $job->deadline }}</span>
                </div>

                <div class="job-card-actions">
                    <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-primary btn-sm">View Details</a>

                    {{-- Save / Unsave — both seekers and posters --}}
                    @auth
                        @if(in_array($job->id, $savedJobIds))
                            <form method="POST" action="{{ route('jobs.unsave', $job->id) }}" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-secondary btn-sm">Unsave</button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('jobs.save', $job->id) }}" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-secondary btn-sm">Save</button>
                            </form>
                        @endif
                    @endauth
                </div>
            </div>
        @empty
            <div style="text-align:center; padding:80px 0;">
                <p style="color:var(--gray-400); font-size:16px; margin-bottom:12px;">No jobs found.</p>
                @if(request()->hasAny(['search', 'location', 'job_type', 'category']))
                    <a href="{{ route('jobs.index') }}" class="btn btn-secondary">Clear filters</a>
                @endif
            </div>
        @endforelse

    </div>
</body>
</html>