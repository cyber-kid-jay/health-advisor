<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="HealthAdvisor - Your Personal Health Companion">
    
    <title>@yield('title', 'HealthAdvisor - Your Personal Health Companion')</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    @stack('styles')

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🏥</text></svg>">
    
    <!-- Scripts -->
    <script>
        // Make CSRF token available to JavaScript
        window.Laravel = {
            csrfToken: '{{ csrf_token() }}'
        };
    </script>
</head>
<body>
    <!-- Navigation Bar -->
    @include('layouts.partials.navbar')

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="alert alert-success" style="position: fixed; top: 80px; right: 20px; z-index: 9999; max-width: 400px;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger" style="position: fixed; top: 80px; right: 20px; z-index: 9999; max-width: 400px;">
            {{ session('error') }}
        </div>
    @endif

    @if(session('warning'))
        <div class="alert alert-warning" style="position: fixed; top: 80px; right: 20px; z-index: 9999; max-width: 400px;">
            {{ session('warning') }}
        </div>
    @endif

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer (optional) -->
    @include('layouts.partials.footer')

    <!-- Core JavaScript -->
    <script src="{{ asset('js/app.js') }}"></script>
    
    <!-- Additional Page-Specific Scripts -->
    @stack('scripts')

    <!-- Auto-hide flash messages after 5 seconds -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    alert.style.transition = 'opacity 0.5s ease';
                    setTimeout(() => alert.remove(), 500);
                }, 5000);
            });
        });
    </script>
</body>
</html>
