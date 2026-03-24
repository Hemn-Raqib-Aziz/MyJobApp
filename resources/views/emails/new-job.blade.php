{{-- <!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; }
        .card { background: white; padding: 30px; border-radius: 8px; max-width: 600px; margin: auto; }
        .btn { background: #0d6efd; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin-top: 20px; }
        .badge { background: #e9ecef; padding: 4px 10px; border-radius: 20px; font-size: 13px; }
    </style>
</head>
<body>
    <div class="card">
        <h2>🆕 New Job Available!</h2>
        <h3>{{ $job->title }}</h3>

        <p>
            <span class="badge">📍 {{ $job->location }}</span>
            <span class="badge">💼 {{ ucfirst(str_replace('_', ' ', $job->job_type)) }}</span>
            <span class="badge">📂 {{ $job->category }}</span>
            <span class="badge">⏰ Deadline: {{ $job->deadline }}</span>
        </p>

        <p>{{ Str::limit($job->job_description, 200) }}</p>

        <a href="{{ url('/jobs/' . $job->id) }}" class="btn">View Job Details</a>

        <p style="margin-top: 30px; color: #999; font-size: 12px;">
            You received this email because you are registered on MyJobApp.
        </p>
    </div>
</body>
</html> --}}


{{-- new-job.blade.php --}}
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