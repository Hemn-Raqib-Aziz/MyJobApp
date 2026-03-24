{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
@include('partials.navbar')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <h2>Login</h2>

            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <p class="mb-0">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="/login">
                @csrf
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                </div>
                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
                <p class="mt-3">Don't have an account? <a href="/register">Register</a></p>
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
    <title>Login — MyJobApp</title>
</head>
<body>
    @include('partials.navbar')

    <div class="page-sm">
        <div class="section-title">
            <h2>Welcome back</h2>
            <p>Sign in to your account to continue.</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <p style="margin:0;">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="/login">
            @csrf

            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" autofocus>
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary btn-full">Sign In</button>

            <p style="text-align:center; margin-top:20px; font-size:14px; color:var(--gray-600);">
                No account? <a href="/register" style="color:var(--black); font-weight:500;">Register</a>
            </p>
        </form>
    </div>
</body>
</html>