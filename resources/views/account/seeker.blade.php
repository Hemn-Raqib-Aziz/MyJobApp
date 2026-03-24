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

                <form method="POST" action="{{ route('seeker.account.update') }}">
                    @csrf
                    @method('PUT')

                    <h5 class="mb-3">Personal Info</h5>

                    <div class="mb-3">
                        <label>User Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', auth()->user()->name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label>Email (cannot be changed)</label>
                        <input type="email" class="form-control" value="{{ auth()->user()->email }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label>Age</label>
                        <input type="number" name="age" class="form-control" value="{{ old('age', $jobSeeker->age) }}">
                    </div>

                    <div class="mb-3">
                        <label>Sex</label>
                        <select name="sex" class="form-control">
                            <option value="">Prefer not to say</option>
                            <option value="male" {{ old('sex', $jobSeeker->sex) == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('sex', $jobSeeker->sex) == 'female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Location</label>
                        <input type="text" name="location" class="form-control" value="{{ old('location', $jobSeeker->location) }}">
                    </div>

                    <div class="mb-3">
                        <label>Bio</label>
                        <textarea name="bio" class="form-control" rows="4">{{ old('bio', $jobSeeker->bio) }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Save Changes</button>
                </form>

                <div class="mt-5 border-top pt-4">
                    <h5>Email Notifications</h5>
                    <p class="text-muted">
                        Currently: 
                        <strong class="{{ $jobSeeker->email_notifications ? 'text-success' : 'text-danger' }}">
                            {{ $jobSeeker->email_notifications ? 'Subscribed ✅' : 'Unsubscribed ❌' }}
                        </strong>
                    </p>
                    <form method="POST" action="{{ route('seeker.subscribe') }}">
                        @csrf
                        <button type="submit" class="btn {{ $jobSeeker->email_notifications ? 'btn-outline-danger' : 'btn-outline-success' }}">
                            {{ $jobSeeker->email_notifications ? 'Unsubscribe from notifications' : 'Subscribe to notifications' }}
                        </button>
                    </form>
                </div>

                <div class="mt-5 border-top pt-4">
                    <h5 class="text-danger">Danger Zone</h5>
                    <p class="text-muted">Deleting your account is permanent and cannot be undone.</p>
                    <form method="POST" action="{{ route('seeker.account.delete') }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"
                            onclick="return confirm('Are you sure? This will permanently delete your account!')">
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
            <p>Manage your personal information and preferences.</p>
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

        <form method="POST" action="{{ route('seeker.account.update') }}">
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

            <div class="form-group">
                <label class="form-label">Age</label>
                <input type="number" name="age" class="form-control" value="{{ old('age', $jobSeeker->age) }}">
            </div>

            <div class="form-group">
                <label class="form-label">Sex</label>
                <select name="sex" class="form-control">
                    <option value="">Prefer not to say</option>
                    <option value="male" {{ old('sex', $jobSeeker->sex) == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ old('sex', $jobSeeker->sex) == 'female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Location</label>
                <input type="text" name="location" class="form-control" value="{{ old('location', $jobSeeker->location) }}">
            </div>

            <div class="form-group">
                <label class="form-label">Bio</label>
                <textarea name="bio" class="form-control" rows="4" style="resize:vertical;">{{ old('bio', $jobSeeker->bio) }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary btn-full">Save Changes</button>
        </form>

        <hr class="divider">

        {{-- Email Notifications --}}
        <h5 style="margin-bottom:12px;">Email Notifications</h5>
        <p style="font-size:14px; color:var(--gray-600); margin-bottom:16px;">
            Status:
            @if($jobSeeker->email_notifications)
                <span class="badge badge-success">Subscribed</span>
            @else
                <span class="badge badge-secondary">Unsubscribed</span>
            @endif
        </p>
        <form method="POST" action="{{ route('seeker.subscribe') }}">
            @csrf
            @if($jobSeeker->email_notifications)
                <button type="submit" class="btn btn-secondary">Unsubscribe from job alerts</button>
            @else
                <button type="submit" class="btn btn-success">Subscribe to job alerts</button>
            @endif
        </form>

        {{-- Danger Zone --}}
        <div class="danger-zone">
            <h5>Danger Zone</h5>
            <p>Permanently delete your account. This action cannot be undone.</p>
            <form method="POST" action="{{ route('seeker.account.delete') }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger"
                    onclick="return confirm('Are you sure? This will permanently delete your account!')">
                    Delete Account
                </button>
            </form>
        </div>
    </div>
</body>
</html>