<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.layout')
    <title>Register — MyJobApp</title>
    <style>
        .role-options { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .role-option { position: relative; }
        .role-option input[type="radio"] { position: absolute; opacity: 0; width: 0; height: 0; }
        .role-option label {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 20px 16px;
            border: 1px solid var(--gray-200);
            border-radius: var(--radius);
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            color: var(--gray-600);
            transition: all var(--transition);
            text-align: center;
        }
        .role-option label span.icon { font-size: 22px; }
        .role-option input[type="radio"]:checked + label {
            border-color: var(--black);
            color: var(--black);
            background: var(--gray-100);
        }
        .role-option label:hover { border-color: var(--gray-400); color: var(--black); }

        @media (max-width: 480px) {
            .role-options { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    @include('partials.navbar')

    <div class="page-sm">
        <div class="section-title">
            <h2>Create an account</h2>
            <p>Join MyJobApp to find or post jobs.</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <p style="margin:0;">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="/register">
            @csrf

            <div class="form-group">
                <label class="form-label">User Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Enter your full name or company name" autofocus>
            </div>

            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Enter your email address">
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Create a strong password">
            </div>

            <div class="form-group">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Re-enter your password">
            </div>

            {{-- Role Selection --}}
            <div class="form-group">
                <label class="form-label">I want to</label>
                <div class="role-options">
                    <div class="role-option">
                        <input type="radio" name="role" id="job_seeker" value="job_seeker" {{ old('role') == 'job_seeker' ? 'checked' : '' }} required>
                        <label for="job_seeker">
                            <span class="icon">🔍</span>
                            Find a Job
                        </label>
                    </div>
                    <div class="role-option">
                        <input type="radio" name="role" id="job_poster" value="job_poster" {{ old('role') == 'job_poster' ? 'checked' : '' }} required>
                        <label for="job_poster">
                            <span class="icon">🏢</span>
                            Post Jobs
                        </label>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-full">Create Account</button>

            <p style="text-align:center; margin-top:20px; font-size:14px; color:var(--gray-600);">
                Already have an account? <a href="/login" style="color:var(--black); font-weight:500;">Sign in</a>
            </p>
        </form>
    </div>
</body>
</html>