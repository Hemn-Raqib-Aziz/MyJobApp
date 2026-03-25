<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Helvetica Neue', Arial, sans-serif; background: #f2f2f2; padding: 40px 20px; color: #1a1a1a; }
        .wrapper { max-width: 560px; margin: 0 auto; }
        .header { padding: 28px 0 20px; border-bottom: 2px solid #1a1a1a; margin-bottom: 32px; }
        .header h1 { font-size: 20px; font-weight: 700; letter-spacing: -0.3px; }
        .card { background: #fff; border: 1px solid #e0e0e0; border-radius: 4px; padding: 28px; margin-bottom: 20px; }
        .label { font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.6px; color: #888; margin-bottom: 6px; }
        .value { font-size: 16px; font-weight: 500; color: #1a1a1a; margin-bottom: 20px; }
        .tag { display: inline-block; background: #f5f5f5; border: 1px solid #e0e0e0; padding: 4px 12px; border-radius: 20px; font-size: 13px; color: #555; margin-right: 6px; margin-bottom: 6px; }
        .btn { display: inline-block; background: #1a1a1a; color: #fff; padding: 12px 24px; text-decoration: none; border-radius: 4px; font-size: 14px; font-weight: 500; margin-top: 24px; }
        .footer { font-size: 12px; color: #aaa; margin-top: 28px; text-align: center; line-height: 1.6; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <h1>MyJobApp</h1>
        </div>

        <div class="card">
            <p style="font-size:15px; margin-bottom:24px;">You have a new application for one of your job postings.</p>

            <div class="label">Position</div>
            <div class="value">{{ $application->jobPost->title }}</div>

            <div class="label">Applicant</div>
            <div class="value" style="margin-bottom:8px;">{{ $application->jobSeeker->user->name }}</div>

            <div>
                @if($application->jobSeeker->location)
                    <span class="tag">📍 {{ $application->jobSeeker->location }}</span>
                @endif
                @if($application->jobSeeker->age)
                    <span class="tag">Age {{ $application->jobSeeker->age }}</span>
                @endif
            </div>

            <a href="{{ url('/applications/' . $application->id) }}" class="btn">Review Application</a>
        </div>

        <p class="footer">
            You received this because someone applied to your job on MyJobApp.<br>
            © {{ date('Y') }} MyJobApp
        </p>
    </div>
</body>
</html>