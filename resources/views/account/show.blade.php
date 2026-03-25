<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.layout')
    <title>My Account — MyJobApp</title>
</head>
<body>
    @include('partials.navbar')

    <div class="page-sm">
        <div class="section-title">
            <h2>My Account</h2>
            <p>Manage your company profile and settings.</p>
        </div>

        @if(session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <p style="margin:0;">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('account.update') }}">
            @csrf
            @method('PUT')

            <h5 style="margin-bottom:20px;">Personal Info</h5>

            <div class="form-group">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', auth()->user()->name) }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" value="{{ auth()->user()->email }}" disabled>
                <p class="form-hint">Email cannot be changed.</p>
            </div>

            <hr class="divider" style="margin: 24px 0;">
            <h5 style="margin-bottom:20px;">Company Info</h5>

            <div class="form-group">
                <label class="form-label">Industry</label>
                <input type="text" name="industry" class="form-control" value="{{ old('industry', $jobPoster->industry) }}">
            </div>

            <div class="form-group">
                <label class="form-label">Location</label>
                <input type="text" name="location" class="form-control" value="{{ old('location', $jobPoster->location) }}">
            </div>

            <div class="form-group">
                <label class="form-label">Website</label>
                <input type="url" name="website" class="form-control" value="{{ old('website', $jobPoster->website) }}" placeholder="https://...">
            </div>

            <div class="form-group">
                <label class="form-label">About</label>
                <textarea name="about" class="form-control" rows="4" style="resize:vertical;">{{ old('about', $jobPoster->about) }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary btn-full">Save Changes</button>
        </form>

        {{-- Danger Zone --}}
        <div class="danger-zone">
            <h5>Danger Zone</h5>
            <p>Permanently delete your account and all job postings. This action cannot be undone.</p>
            <form method="POST" action="{{ route('account.delete') }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger"
                    onclick="return confirm('Are you sure? This will permanently delete your account and all your jobs!')">
                    Delete Account
                </button>
            </form>
        </div>
    </div>
</body>
</html>