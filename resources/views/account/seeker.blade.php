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
                    <label class="form-label">User Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', auth()->user()->name) }}" required placeholder="Enter your full name">
                </div>

                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" value="{{ auth()->user()->email }}" disabled placeholder="Enter your email address">
                    <p class="form-hint">Email cannot be changed.</p>
                </div>

                <div class="form-group">
        <label class="form-label">Profile Title</label>
        <input type="text" name="profile_title" class="form-control" placeholder="e.g., Software Developer, IT Technician"
            value="{{ old('profile_title', $jobSeeker->profile_title) }}" required>
    </div>
                <div class="form-group">
                    <label class="form-label">Age</label>
                    <input type="number" name="age" class="form-control" value="{{ old('age', $jobSeeker->age) }}" required placeholder="Enter your age">
                </div>

                <div class="form-group">
                    <label class="form-label">Sex</label>
                    <select name="sex" class="form-control" required>
                        <option value="">Prefer not to say</option>
                        <option value="male" {{ old('sex', $jobSeeker->sex) == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('sex', $jobSeeker->sex) == 'female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Location</label>
                    <input type="text" name="location" class="form-control" value="{{ old('location', $jobSeeker->location) }}" required placeholder="City, Country">
                </div>

                <div class="form-group">
                    <label class="form-label">Bio</label>
                    <textarea name="bio" class="form-control" rows="4" style="resize:vertical;" placeholder="A short intro about yourself...">{{ old('bio', $jobSeeker->bio) }}</textarea>
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