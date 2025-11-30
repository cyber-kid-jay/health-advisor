<nav class="navbar">
    <div class="nav-container">
        <!-- Logo -->
        <a href="{{ route('home') }}" class="logo">
            <span>🏥</span>
            HealthAdvisor
        </a>

        <!-- Navigation Links -->
        @guest
            <!-- Links for non-authenticated users -->
            <ul class="nav-links" id="mainNav">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('about') }}">About</a></li>
                <li><a href="{{ route('login') }}">Login</a></li>
            </ul>
        @else
            <!-- Links for authenticated users -->
            <ul class="nav-links" id="mainNav">
                <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li><a href="{{ route('assessment.create') }}">New Assessment</a></li>
                <li><a href="{{ route('profile.edit') }}">Profile</a></li>
            </ul>

            <!-- User Menu -->
            <div id="userNav">
                <span class="text-muted" style="margin-right: 1rem;">
                    Hello, {{ Auth::user()->first_name ?? Auth::user()->name }}!
                </span>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-secondary">Logout</button>
                </form>
            </div>
        @endguest

        <!-- Mobile Menu Toggle -->
        <div class="nav-toggle" onclick="toggleMobileNav()">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
</nav>

@push('scripts')
<script>
    // Mobile navigation toggle
    function toggleMobileNav() {
        const nav = document.getElementById('mainNav');
        nav.classList.toggle('active');
    }
</script>
@endpush
