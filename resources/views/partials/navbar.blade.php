@php
    $profileComplete = auth()->check() && (auth()->user()->jobSeeker || auth()->user()->jobPoster);
    $emailVerified   = auth()->check() && auth()->user()->hasVerifiedEmail();
    $showFullNav     = !auth()->check() || ($profileComplete && $emailVerified);
@endphp

@if($showFullNav || !auth()->check())
<nav class="nav">

    {{-- Brand --}}
    @auth
        @if($profileComplete && $emailVerified)
            <a class="nav-brand" href="{{ route('jobs.index') }}">MyJobApp</a>
        @else
            <span class="nav-brand-static">MyJobApp</span>
        @endif
    @else
        <a class="nav-brand" href="{{ route('jobs.index') }}">MyJobApp</a>
    @endauth

    {{-- Mobile toggle --}}
    <button class="nav-toggle"
            onclick="document.getElementById('nav-links').classList.toggle('open')"
            aria-label="Menu">
        <span></span><span></span><span></span>
    </button>

    {{-- Links --}}
    <ul class="nav-links" id="nav-links">
        @auth
            @if($profileComplete && $emailVerified)

                @if(Auth::user()->user_type === 'job_poster')
                    {{-- Poster links --}}
                    <li><a class="nav-link" href="{{ route('jobs.mine') }}">My Jobs</a></li>
                    <li><a class="nav-link" href="{{ route('jobs.create') }}">+ Post a Job</a></li>
                    <li>
                        <a class="nav-link" href="{{ route('jobs.saved') }}" target="_blank">
                            Saved Jobs
                        </a>
                    </li>
                    <li><a class="nav-link" href="{{ route('account.show') }}">Account</a></li>
                @endif

                @if(Auth::user()->user_type === 'job_seeker')
                    {{-- Seeker links --}}
                    <li><a class="nav-link" href="{{ route('applications.mine') }}">My Applications</a></li>
                    <li>
                        <a class="nav-link" href="{{ route('jobs.saved') }}" target="_blank">
                            Saved Jobs
                        </a>
                    </li>
                    <li><a class="nav-link" href="{{ route('seeker.account.show') }}">Account</a></li>
                @endif

                <li><span class="nav-greeting">{{ Auth::user()->name }}</span></li>

                <li>
                    <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                        @csrf
                        <button type="submit" class="nav-btn-logout">Logout</button>
                    </form>
                </li>

            @else
                <li><span class="nav-incomplete">Complete your profile to continue</span></li>
            @endif
        @else
            <li><a class="nav-link" href="{{ route('login') }}">Login</a></li>
            <li><a class="nav-link" href="{{ route('register') }}">Register</a></li>
        @endauth
    </ul>

</nav>
@endif