<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.layout')
    <title>Setup Profile — MyJobApp</title>
</head>
<body>
    @include('partials.navbar')

    <div class="page-sm">
        <div class="section-title">
            <h2>{{ $role === 'job_seeker' ? 'Your Profile' : 'Company Profile' }}</h2>
            <p>
                {{ $role === 'job_seeker'
                    ? 'Tell employers a bit about yourself.'
                    : 'Tell job seekers about your company.' }}
            </p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <p style="margin:0;">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="/setup-profile">
            @csrf
            <input type="hidden" name="role" value="{{ $role }}">

            @if($role === 'job_seeker')

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                    <div class="form-group">
                        <label class="form-label">Age</label>
                        <input type="number" name="age" class="form-control" min="16" max="99">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Sex</label>
                        <select name="sex" class="form-control">
                            <option value="">Prefer not to say</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Location</label>
                    <input type="text" name="location" class="form-control" placeholder="City, Country">
                </div>

                <div class="form-group">
                    <label class="form-label">Bio</label>
                    <textarea name="bio" class="form-control" rows="4" style="resize:vertical;" placeholder="A short intro about yourself..."></textarea>
                    <p class="form-hint">Optional — helps employers understand your background.</p>
                </div>

            @else

                <div class="form-group">
                    <label class="form-label">Industry</label>
                    <input type="text" name="industry" class="form-control" placeholder="e.g. Technology, Healthcare">
                </div>

                <div class="form-group">
                    <label class="form-label">Location</label>
                    <input type="text" name="location" class="form-control" placeholder="City, Country">
                </div>

                <div class="form-group">
                    <label class="form-label">Website</label>
                    <input type="url" name="website" class="form-control" placeholder="https://...">
                </div>

                <div class="form-group">
                    <label class="form-label">About</label>
                    <textarea name="about" class="form-control" rows="4" style="resize:vertical;" placeholder="What does your company do?"></textarea>
                </div>

            @endif

            <button type="submit" class="btn btn-primary btn-full">Save & Continue</button>
        </form>
    </div>

    <style>
        @media (max-width: 600px) {
            div[style*="grid-template-columns:1fr 1fr"] {
                grid-template-columns: 1fr !important;
            }
        }
    </style>
</body>
</html>