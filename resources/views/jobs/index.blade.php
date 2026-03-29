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

        /* Dims the button while the request is in flight */
        .btn-save[data-loading] {
            opacity: 0.6;
            pointer-events: none;
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
                            <span style="font-size:13px; color:var(--gray-400); white-space:nowrap;">{{ $job->created_at }}</span>
                            <span>📍 {{ $job->location }}</span>
                            <span>💼 {{ ucfirst(str_replace('_', ' ', $job->job_type)) }}</span>
                            <span>📂 {{ $job->category }}</span>
                        </div>
                    </div>
                    <span style="font-size:13px; color:var(--gray-400); white-space:nowrap;">Deadline {{ $job->deadline }}</span>
                </div>

                <div class="job-card-actions">
                    <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-primary btn-sm">View Details</a>

                    {{--
                        Save / Unsave — single <button>, no <form>, no page reload.
                        JavaScript below handles the AJAX POST and flips the label.
                    --}}
                    @auth
                        <button
                            class="btn btn-secondary btn-sm btn-save"
                            data-saved="{{ in_array($job->id, $savedJobIds) ? 'true' : 'false' }}"
                            data-save-url="{{ route('jobs.save', $job->id) }}"
                            data-unsave-url="{{ route('jobs.unsave', $job->id) }}"
                        >
                            {{ in_array($job->id, $savedJobIds) ? 'Unsave' : 'Save' }}
                        </button>
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

    <script>
        // Read the CSRF token once from the meta tag Laravel sets,
        // or fall back to the cookie (both work with Laravel).
        var csrfToken = document.querySelector('meta[name="csrf-token"]')
            ? document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            : '{{ csrf_token() }}';

        document.querySelectorAll('.btn-save').forEach(function (btn) {
            btn.addEventListener('click', function () {
                // Which action to call depends on current saved state
                var saved  = btn.dataset.saved === 'true';
                var url    = saved ? btn.dataset.unsaveUrl : btn.dataset.saveUrl;

                // Block double-clicks while the request is in flight
                btn.dataset.loading = '1';

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                })
                .then(function (response) {
                    if (!response.ok) throw new Error('server error');

                    // Toggle state and label — no reload, no scroll jump
                    var nowSaved      = !saved;
                    btn.dataset.saved = nowSaved ? 'true' : 'false';
                    btn.textContent   = nowSaved ? 'Unsave' : 'Save';
                })
                .catch(function () {
                    // Request failed silently — button stays unchanged, user can retry
                })
                .finally(function () {
                    delete btn.dataset.loading;
                });
            });
        });
    </script>
</body>
</html>