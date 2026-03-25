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
        .job-title { font-size: 22px; font-weight: 700; letter-spacing: -0.3px; margin-bottom: 16px; line-height: 1.3; }
        .tag { display: inline-block; background: #f5f5f5; border: 1px solid #e0e0e0; padding: 4px 12px; border-radius: 20px; font-size: 13px; color: #555; margin-right: 6px; margin-bottom: 6px; }
        .divider { border: none; border-top: 1px solid #e0e0e0; margin: 20px 0; }
        .description { font-size: 14px; color: #555; line-height: 1.7; }
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
            <p style="font-size:13px; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; color:#888; margin-bottom:12px;">New Job Posting</p>

            <div class="job-title">{{ $job->title }}</div>

            <div>
                <span class="tag">📍 {{ $job->location }}</span>
                <span class="tag">💼 {{ ucfirst(str_replace('_', ' ', $job->job_type)) }}</span>
                <span class="tag">📂 {{ $job->category }}</span>
                <span class="tag">⏰ {{ $job->deadline }}</span>
            </div>

            <hr class="divider">

            <p class="description">{{ Str::limit($job->job_description, 220) }}</p>

            <a href="{{ url('/jobs/' . $job->id) }}" class="btn">View Job Details</a>
        </div>

        <p class="footer">
            You received this because you're subscribed to job alerts on MyJobApp.<br>
            © {{ date('Y') }} MyJobApp
        </p>
    </div>
</body>
</html>