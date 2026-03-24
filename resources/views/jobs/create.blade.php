{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Post a Job</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @include('partials.navbar')

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2>Post a New Job</h2>

                @if($errors->any())
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            <p class="mb-0">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('jobs.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label>Job Title</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                    </div>
                    <div class="mb-3">
                        <label>Job Description</label>
                        <textarea name="job_description" class="form-control" rows="4" required>{{ old('job_description') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label>Job Requirements</label>
                        <textarea name="job_requirements" class="form-control" rows="4" required>{{ old('job_requirements') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label>Location</label>
                        <input type="text" name="location" class="form-control" value="{{ old('location') }}" required>
                    </div>
                    <div class="mb-3">
                        <label>Category</label>
                        <input type="text" name="category" class="form-control" value="{{ old('category') }}" required>
                    </div>
                    <div class="mb-3">
                        <label>Job Type</label>
                        <select name="job_type" class="form-control" required>
                            <option value="">Select type</option>
                            <option value="full_time" {{ old('job_type') == 'full_time' ? 'selected' : '' }}>Full Time</option>
                            <option value="part_time" {{ old('job_type') == 'part_time' ? 'selected' : '' }}>Part Time</option>
                            <option value="remote" {{ old('job_type') == 'remote' ? 'selected' : '' }}>Remote</option>
                            <option value="freelance" {{ old('job_type') == 'freelance' ? 'selected' : '' }}>Freelance</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Application Deadline</label>
                        <input type="date" name="deadline" class="form-control" value="{{ old('deadline') }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Post Job</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
 --}}


 <!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.layout')
    <title>Post a Job — MyJobApp</title>
</head>
<body>
    @include('partials.navbar')

    <div class="page-sm">
        <div class="section-title">
            <h2>Post a Job</h2>
            <p>Fill in the details to publish your job listing.</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <p style="margin:0;">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('jobs.store') }}">
            @csrf

            <div class="form-group">
                <label class="form-label">Job Title</label>
                <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Job Description</label>
                <textarea name="job_description" class="form-control" rows="5" required style="resize:vertical;">{{ old('job_description') }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Requirements</label>
                <textarea name="job_requirements" class="form-control" rows="5" required style="resize:vertical;">{{ old('job_requirements') }}</textarea>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                <div class="form-group">
                    <label class="form-label">Location</label>
                    <input type="text" name="location" class="form-control" value="{{ old('location') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Category</label>
                    <input type="text" name="category" class="form-control" value="{{ old('category') }}" required>
                </div>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                <div class="form-group">
                    <label class="form-label">Job Type</label>
                    <select name="job_type" class="form-control" required>
                        <option value="">Select...</option>
                        <option value="full_time"  {{ old('job_type') == 'full_time'  ? 'selected' : '' }}>Full Time</option>
                        <option value="part_time"  {{ old('job_type') == 'part_time'  ? 'selected' : '' }}>Part Time</option>
                        <option value="remote"     {{ old('job_type') == 'remote'     ? 'selected' : '' }}>Remote</option>
                        <option value="freelance"  {{ old('job_type') == 'freelance'  ? 'selected' : '' }}>Freelance</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Deadline</label>
                    <input type="date" name="deadline" class="form-control" value="{{ old('deadline') }}" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-full">Publish Job</button>
        </form>
    </div>

    <style>
        @media (max-width: 600px) {
            div[style*="grid-template-columns:1fr 1fr"] {
                grid-template-columns: 1fr !important;
            }
        }
    </style>
</body>
</html>