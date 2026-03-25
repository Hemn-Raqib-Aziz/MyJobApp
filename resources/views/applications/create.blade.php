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