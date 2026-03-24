{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @include('partials.navbar')

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <h2>My Account</h2>

                @if(session('message'))
                    <div class="alert alert-success">{{ session('message') }}</div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            <p class="mb-0">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('account.update') }}">
                    @csrf
                    @method('PUT')

                    <h5 class="mt-3 mb-3">Personal Info</h5>

                    <div class="mb-3">
                        <label>User Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', auth()->user()->name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label>Email (cannot be changed)</label>
                        <input type="email" class="form-control" value="{{ auth()->user()->email }}" disabled>
                    </div>

                    <h5 class="mt-4 mb-3">Company Info</h5>

                    <div class="mb-3">
                        <label>Industry</label>
                        <input type="text" name="industry" class="form-control" value="{{ old('industry', $jobPoster->industry) }}">
                    </div>
                    <div class="mb-3">
                        <label>Location</label>
                        <input type="text" name="location" class="form-control" value="{{ old('location', $jobPoster->location) }}">
                    </div>
                    <div class="mb-3">
                        <label>Website</label>
                        <input type="text" name="website" class="form-control" value="{{ old('website', $jobPoster->website) }}">
                    </div>
                    <div class="mb-3">
                        <label>About</label>
                        <textarea name="about" class="form-control" rows="4">{{ old('about', $jobPoster->about) }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Save Changes</button>
                </form>

                <div class="mt-5 border-top pt-4">
                    <h5 class="text-danger">Danger Zone</h5>
                    <p class="text-muted">Deleting your account will remove all your data and job postings permanently.</p>
                    <form method="POST" action="{{ route('account.delete') }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"
                            onclick="return confirm('Are you sure? This will permanently delete your account and all your jobs!')">
                            Delete My Account
                        </button>
                    </form>
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