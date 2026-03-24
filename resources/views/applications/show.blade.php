{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Application Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @include('partials.navbar')

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2>Application Details</h2>
                <a href="{{ route('applications.job', $application->jobPost->id) }}" class="btn btn-secondary btn-sm mb-4">← Back to Applications</a>

                @if(session('message'))
                    <div class="alert alert-success">{{ session('message') }}</div>
                @endif

                <div class="card mb-4">
                    <div class="card-header"><h5 class="mb-0">Applicant Profile</h5></div>
                    <div class="card-body">
                        <p><strong>Name:</strong> {{ $application->jobSeeker->user->name }}</p>
                        <p><strong>Email:</strong> {{ $application->jobSeeker->user->email }}</p>
                        <p><strong>Location:</strong> {{ $application->jobSeeker->location ?? 'Not set' }}</p>
                        <p><strong>Age:</strong> {{ $application->jobSeeker->age ?? 'Not set' }}</p>
                        <p><strong>Sex:</strong> {{ $application->jobSeeker->sex ?? 'Not set' }}</p>
                        <p class="mb-0"><strong>Bio:</strong> {{ $application->jobSeeker->bio ?? 'Not set' }}</p>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header"><h5 class="mb-0">Cover Letter</h5></div>
                    <div class="card-body">
                        <p>{{ $application->cover_letter }}</p>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header"><h5 class="mb-0">CV</h5></div>
                    <div class="card-body">
                        <a href="{{ asset('storage/' . $application->cv_path) }}" target="_blank" class="btn btn-outline-primary">
                            📄 Download CV
                        </a>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header"><h5 class="mb-0">Update Status</h5></div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('applications.status', $application->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="d-flex gap-2">
                                <select name="status" class="form-control">
                                    <option value="pending" {{ $application->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="reviewed" {{ $application->status === 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                                    <option value="accepted" {{ $application->status === 'accepted' ? 'selected' : '' }}>Accepted</option>
                                    <option value="rejected" {{ $application->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                            @if(session('error'))
    <div class="alert alert-warning mt-2">{{ session('error') }}</div>
@endif
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>
</html> --}}



<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.layout')
    <title>Application Details — MyJobApp</title>
</head>
<body>
    @include('partials.navbar')

    <div class="page-sm">
        <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; margin-bottom:32px;">
            <h2>Application Details</h2>
            <a href="{{ route('applications.job', $application->jobPost->id) }}" class="btn btn-secondary btn-sm">← Back</a>
        </div>

        @if(session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-warning">{{ session('error') }}</div>
        @endif

        {{-- Applicant Profile --}}
        <div class="card" style="margin-bottom:20px;">
            <div class="card-header">
                <h5>Applicant Profile</h5>
            </div>
            <div class="card-body">
                <div class="info-grid" style="margin-bottom:16px;">
                    <div class="info-item">
                        <label>Name</label>
                        <span>{{ $application->jobSeeker->user->name }}</span>
                    </div>
                    <div class="info-item">
                        <label>Email</label>
                        <span>{{ $application->jobSeeker->user->email }}</span>
                    </div>
                    <div class="info-item">
                        <label>Location</label>
                        <span>{{ $application->jobSeeker->location ?? '—' }}</span>
                    </div>
                    <div class="info-item">
                        <label>Age</label>
                        <span>{{ $application->jobSeeker->age ?? '—' }}</span>
                    </div>
                    <div class="info-item">
                        <label>Sex</label>
                        <span>{{ $application->jobSeeker->sex ? ucfirst($application->jobSeeker->sex) : '—' }}</span>
                    </div>
                </div>
                @if($application->jobSeeker->bio)
                    <div>
                        <label style="font-size:12px; font-weight:600; text-transform:uppercase; letter-spacing:0.4px; color:var(--gray-400); display:block; margin-bottom:4px;">Bio</label>
                        <p style="font-size:14px; color:var(--gray-600); margin:0;">{{ $application->jobSeeker->bio }}</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Cover Letter --}}
        <div class="card" style="margin-bottom:20px;">
            <div class="card-header">
                <h5>Cover Letter</h5>
            </div>
            <div class="card-body">
                <p style="font-size:15px; line-height:1.7; margin:0; white-space:pre-wrap;">{{ $application->cover_letter }}</p>
            </div>
        </div>

        {{-- CV --}}
        <div class="card" style="margin-bottom:20px;">
            <div class="card-header">
                <h5>CV / Resume</h5>
            </div>
            <div class="card-body">
                <a href="{{ asset('storage/' . $application->cv_path) }}" target="_blank" class="btn btn-secondary">
                    📄 Download CV
                </a>
            </div>
        </div>

        {{-- Update Status --}}
        <div class="card">
            <div class="card-header" style="display:flex; align-items:center; justify-content:space-between;">
                <h5>Application Status</h5>
                <span class="badge
                    @if($application->status === 'accepted') badge-success
                    @elseif($application->status === 'rejected') badge-danger
                    @elseif($application->status === 'reviewed') badge-warning
                    @else badge-secondary @endif">
                    {{ ucfirst($application->status) }}
                </span>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('applications.status', $application->id) }}">
                    @csrf
                    @method('PUT')
                    <div style="display:flex; gap:10px;" class="btn-row">
                        <select name="status" class="form-control" style="flex:1;">
                            <option value="pending"  {{ $application->status === 'pending'  ? 'selected' : '' }}>Pending</option>
                            <option value="reviewed" {{ $application->status === 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                            <option value="accepted" {{ $application->status === 'accepted' ? 'selected' : '' }}>Accepted</option>
                            <option value="rejected" {{ $application->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</body>
</html>