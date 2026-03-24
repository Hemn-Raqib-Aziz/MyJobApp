{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Apply for {{ $jobPost->title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @include('partials.navbar')

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2>Apply for: {{ $jobPost->title }}</h2>
                <p class="text-muted">📍 {{ $jobPost->location }} · 💼 {{ ucfirst(str_replace('_', ' ', $jobPost->job_type)) }}</p>
                <hr>

                <div class="alert alert-info">
                    <h6>📋 Your profile will be shared with the employer:</h6>
                    <p class="mb-1"><strong>Name:</strong> {{ $user->name }}</p>
                    <p class="mb-1"><strong>Location:</strong> {{ $user->jobSeeker->location ?? 'Not set' }}</p>
                    <p class="mb-1"><strong>Sex:</strong> {{ $user->jobSeeker->sex ?? 'Not set' }}</p>
                    <p class="mb-1"><strong>Age:</strong> {{ $user->jobSeeker->age ?? 'Not set' }}</p>
                    <p class="mb-0"><strong>Bio:</strong> {{ $user->jobSeeker->bio ?? 'Not set' }}</p>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            <p class="mb-0">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('applications.store', $jobPost->id) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label>Cover Letter <span class="text-muted">(min 50 characters)</span></label>
                        <textarea name="cover_letter" class="form-control" rows="6" required>{{ old('cover_letter') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label>CV <span class="text-muted">(PDF only, max 2MB)</span></label>
                        <input type="file" name="cv" class="form-control" accept=".pdf" required>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100">Submit Application</button>
                        <a href="{{ route('jobs.show', $jobPost->id) }}" class="btn btn-secondary w-100">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html> --}}


<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.layout')
    <title>Apply — {{ $jobPost->title }}</title>
</head>
<body>
    @include('partials.navbar')

    <div class="page-sm">
        <div class="section-title">
            <h2>Apply for Position</h2>
            <p>{{ $jobPost->title }}</p>
        </div>

        <div class="meta" style="margin-bottom:24px;">
            <span>📍 {{ $jobPost->location }}</span>
            <span>💼 {{ ucfirst(str_replace('_', ' ', $jobPost->job_type)) }}</span>
            <span>📂 {{ $jobPost->category }}</span>
        </div>

        {{-- Profile preview --}}
        <div class="alert alert-info" style="margin-bottom:28px;">
            <p style="font-size:13px; font-weight:600; text-transform:uppercase; letter-spacing:0.4px; margin-bottom:12px; color:var(--info);">Profile shared with employer</p>
            <div class="info-grid">
                <div class="info-item">
                    <label>Name</label>
                    <span>{{ $user->name }}</span>
                </div>
                <div class="info-item">
                    <label>Location</label>
                    <span>{{ $user->jobSeeker->location ?? '—' }}</span>
                </div>
                <div class="info-item">
                    <label>Age</label>
                    <span>{{ $user->jobSeeker->age ?? '—' }}</span>
                </div>
                <div class="info-item">
                    <label>Sex</label>
                    <span>{{ $user->jobSeeker->sex ? ucfirst($user->jobSeeker->sex) : '—' }}</span>
                </div>
            </div>
            @if($user->jobSeeker->bio)
                <div style="margin-top:12px;">
                    <label style="font-size:12px; font-weight:600; text-transform:uppercase; letter-spacing:0.4px; color:var(--info);">Bio</label>
                    <p style="margin-top:4px; font-size:14px;">{{ $user->jobSeeker->bio }}</p>
                </div>
            @endif
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <p style="margin:0;">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('applications.store', $jobPost->id) }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label class="form-label">Cover Letter</label>
                <textarea name="cover_letter" class="form-control" rows="7" required style="resize:vertical;">{{ old('cover_letter') }}</textarea>
                <p class="form-hint">Minimum 50 characters. Tell the employer why you're a great fit.</p>
            </div>

            <div class="form-group">
                <label class="form-label">CV / Resume</label>
                <input type="file" name="cv" class="form-control" accept=".pdf" required>
                <p class="form-hint">PDF only · Max 2MB</p>
            </div>

            <div class="btn-row" style="display:flex; gap:10px;">
                <button type="submit" class="btn btn-primary" style="flex:1;">Submit Application</button>
                <a href="{{ route('jobs.show', $jobPost->id) }}" class="btn btn-secondary" style="flex:1;">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>