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
        .value { font-size: 16px; font-weight: 500; color: #1a1a1a; }
        .status-badge { display: inline-block; padding: 5px 14px; border-radius: 20px; font-size: 13px; font-weight: 600; margin-top: 16px; }
        .status-accepted  { background: #e8f8ef; color: #1a6b3a; }
        .status-rejected  { background: #fceaea; color: #9b2020; }
        .status-reviewed  { background: #fef3e2; color: #8a4f00; }
        .status-pending   { background: #f0f0f0; color: #555; }
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
            <p style="font-size:15px; margin-bottom:20px;">Your application status has been updated.</p>

            <div class="label">Position</div>
            <div class="value">{{ $application->jobPost->title }}</div>

            <div style="margin-top:20px;">
                <div class="label">New Status</div>
                <span class="status-badge status-{{ $application->status }}">
                    @if($application->status === 'accepted') ✓ Accepted
                    @elseif($application->status === 'rejected') ✗ Rejected
                    @elseif($application->status === 'reviewed') ◎ Under Review
                    @else ○ Pending
                    @endif
                </span>
            </div>

            <a href="{{ url('/my-applications') }}" class="btn">View My Applications</a>
        </div>

        <p class="footer">
            You received this because you applied for a job on MyJobApp.<br>
            © {{ date('Y') }} MyJobApp
        </p>
    </div>
</body>
</html>