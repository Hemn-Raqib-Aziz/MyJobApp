{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @include('partials.navbar')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <h2>Register</h2>

            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <p class="mb-0">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="/register">
                @csrf
                <div class="mb-3">
                    <label>User Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                </div>
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                </div>
                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">I want to:</label>
                    <div class="d-flex gap-3">
                        <div class="form-check border rounded p-3 flex-fill text-center">
                            <input class="form-check-input" type="radio" name="role" id="job_seeker" value="job_seeker" {{ old('role') == 'job_seeker' ? 'checked' : '' }} required>
                            <label class="form-check-label d-block" for="job_seeker">
                                🔍 Find a Job
                            </label>
                        </div>
                        <div class="form-check border rounded p-3 flex-fill text-center">
                            <input class="form-check-input" type="radio" name="role" id="job_poster" value="job_poster" {{ old('role') == 'job_poster' ? 'checked' : '' }} required>
                            <label class="form-check-label d-block" for="job_poster">
                                🏢 Post Jobs
                            </label>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100">Register</button>
                <p class="mt-3">Already have an account? <a href="/login">Login</a></p>
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
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" autofocus>
            </div>

            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}">
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control">
            </div>

            <div class="form-group">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control">
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