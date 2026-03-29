        <!DOCTYPE html>
        <html lang="en">
        <head>
            @include('partials.layout')
            <title>Setup Profile — MyJobApp</title>
        </head>
        <body>
            @include('partials.navbar')

            <div class="page-sm">
                <div class="section-title">
                    <h2>{{ $role === 'job_seeker' ? 'Your Profile' : 'Company Profile' }}</h2>
                    <p>
                        {{ $role === 'job_seeker'
                            ? 'Tell employers a bit about yourself.'
                            : 'Tell job seekers about your company.' }}
                    </p>
                </div>

                

                <form method="POST" action="/setup-profile">
                    @csrf
                    <input type="hidden" name="role" value="{{ $role }}">

                    @if($role === 'job_seeker')

                    <div class="form-group">
        <label class="form-label">Profile Title</label>
        <input type="text" name="profile_title" class="form-control" placeholder="e.g., Software Developer, IT Technician"
            minlength="3" maxlength="60" value="{{ old('profile_title') }}" required>
        <p class="text-sm text-gray-500 mt-1">
        A short description that appears on your profile and job listings.
        </p>
        </div>
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">

                            <div class="form-group">
                                <label class="form-label">Age</label>
                                <input type="number"  name="age" class="form-control" min="16" max="99"  value="{{ old('age') }}" required placeholder="Enter your age">
                                <x-input-error field="age"/>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Sex</label>
                                <select name="sex" class="form-control" required>
                                    <option value="">Prefer not to say</option>
                                    <option value="male" {{ old('sex') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('sex') == 'female' ? 'selected' : '' }}>Female</option>
                                </select>
                                <x-input-error field="sex"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Location</label>
                            <input type="text" name="location" class="form-control" placeholder="City, Country"  value="{{ old('location') }}" required>
                            <x-input-error field="location"/>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Bio</label>
                            <textarea name="bio" class="form-control" rows="4" style="resize:vertical;" placeholder="A short intro about yourself...">{{ old('bio') }}</textarea>
                            <p class="form-hint">Optional — helps employers understand your background.</p>
                            <x-input-error field="bio"/>
                        </div>

                    @else

                        <div class="form-group">
                            <label class="form-label">Industry</label>
                            <input type="text" name="industry" class="form-control" placeholder="e.g. Technology, Healthcare" value="{{ old('industry') }}" required>
                            <x-input-error field="industry"/>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Location</label>
                            <input type="text" name="location" class="form-control" placeholder="City, Country" value="{{ old('location') }}" required>
                            <x-input-error field="location"/>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Website</label>
                            <input type="url" name="website" class="form-control" placeholder="https://..." value="{{ old('website') }}" required>
                            <x-input-error field="website"/>
                        </div>

                        <div class="form-group">
                            <label class="form-label">About</label>
                            <textarea name="about" class="form-control" rows="4" style="resize:vertical;" placeholder="What does your company do?" required>{{ old('about') }}</textarea>
                            <x-input-error field="about"/>
                        </div>

                    @endif

                    <button type="submit" class="btn btn-primary btn-full">Save & Continue</button>
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