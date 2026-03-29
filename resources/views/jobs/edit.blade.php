<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.layout')
    <title>Edit Job — MyJobApp</title>
</head>
<body>
    @include('partials.navbar')

    <div class="page-sm">
        <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; margin-bottom:32px;">
            <div>
                <h2>Edit Job</h2>
                <p style="color:var(--gray-600); margin-top:4px;">{{ $jobPost->title }}</p>
            </div>
            <a href="{{ route('jobs.mine') }}" class="btn btn-secondary btn-sm">← Cancel</a>
        </div>

        
        <form method="POST" action="{{ route('jobs.update', $jobPost->id) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label">Job Title</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $jobPost->title) }}" required>
                <x-input-error field="title"/>
            </div>

            <div class="form-group">
                <label class="form-label">Job Description</label>
                <textarea name="job_description" class="form-control" rows="5" required style="resize:vertical;">{{ old('job_description', $jobPost->job_description) }}</textarea>
                <x-input-error field="job_description"/>
            </div>

            <div class="form-group">
                <label class="form-label">Requirements</label>
                <textarea name="job_requirements" class="form-control" rows="5" required style="resize:vertical;">{{ old('job_requirements', $jobPost->job_requirements) }}</textarea>
                <x-input-error field="job_requirements"/>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                <div class="form-group">
                    <label class="form-label">Location</label>
                    <input type="text" name="location" class="form-control" value="{{ old('location', $jobPost->location) }}" required>
                    <x-input-error field="location"/>
                </div>
                <div class="form-group">
                    <label class="form-label">Category</label>
                    <input type="text" name="category" class="form-control" value="{{ old('category', $jobPost->category) }}" required>
                    <x-input-error field="category"/>
                </div>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                <div class="form-group">
                    <label class="form-label">Job Type</label>
                    <select name="job_type" class="form-control" required>
                        <option value="full_time"  {{ old('job_type', $jobPost->job_type) == 'full_time'  ? 'selected' : '' }}>Full Time</option>
                        <option value="part_time"  {{ old('job_type', $jobPost->job_type) == 'part_time'  ? 'selected' : '' }}>Part Time</option>
                        <option value="remote"     {{ old('job_type', $jobPost->job_type) == 'remote'     ? 'selected' : '' }}>Remote</option>
                        <option value="freelance"  {{ old('job_type', $jobPost->job_type) == 'freelance'  ? 'selected' : '' }}>Freelance</option>
                    </select>
                    <x-input-error field="job_type"/>
                </div>
                <div class="form-group">
                    <label class="form-label">Deadline</label>
                    <input type="date" name="deadline" class="form-control" value="{{ old('deadline', $jobPost->deadline) }}" required>
                    <x-input-error field="deadline"/>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-full">Save Changes</button>
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