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

        

        <form method="POST" action="/login">
            @csrf

            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" autofocus required>
                <x-input-error field="email"/>
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
                <x-input-error field="password"/>
            </div>

            <button type="submit" class="btn btn-primary btn-full">Sign In</button>

            <p style="text-align:center; margin-top:20px; font-size:14px; color:var(--gray-600);">
                No account? <a href="/register" style="color:var(--black); font-weight:500;">Register</a>
            </p>
        </form>
    </div>
</body>
</html>