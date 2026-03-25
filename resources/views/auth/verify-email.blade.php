<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.layout')
    <title>Verify Email — MyJobApp</title>
</head>
<body>
    @include('partials.navbar')

    <div class="page-sm" style="text-align:center; padding-top:80px;">
        <div style="font-size:40px; margin-bottom:20px;">✉️</div>

        <h2 style="margin-bottom:12px;">Check your inbox</h2>
        <p style="color:var(--gray-600); max-width:380px; margin:0 auto 32px;">
            We sent a verification link to your email address. Click the link to activate your account and continue.
        </p>

        @if(session('message'))
            <div class="alert alert-success" style="text-align:left; max-width:380px; margin:0 auto 24px;">
                {{ session('message') }}
            </div>
        @endif

        <form method="POST" action="{{ route('verification.send') }}" style="margin-bottom:16px;">
            @csrf
            <button type="submit" class="btn btn-primary">Resend Verification Email</button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-secondary">Logout</button>
        </form>

        <p style="margin-top:32px; font-size:13px; color:var(--gray-400);">
            Didn't receive it? Check your spam folder.
        </p>
    </div>
</body>
</html>