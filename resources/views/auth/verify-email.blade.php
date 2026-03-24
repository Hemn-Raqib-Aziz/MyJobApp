{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify Email</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @include('partials.navbar')

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <h2>Verify Your Email</h2>
                <p class="text-muted">
                    We sent a verification link to your email. 
                    Please check your inbox and click the link to continue.
                </p>

                @if(session('message'))
                    <div class="alert alert-success">{{ session('message') }}</div>
                @endif

                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary">Resend Verification Email</button>
                </form>

                <form method="POST" action="{{ route('logout') }}" class="mt-3">
                    @csrf
                    <button type="submit" class="btn btn-link text-danger">Logout</button>
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