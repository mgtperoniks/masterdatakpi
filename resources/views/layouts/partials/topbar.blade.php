<nav class="navbar navbar-light bg-white shadow-sm px-4">
    <span class="navbar-text fw-semibold">
        @yield('page-title', 'Master Data')
    </span>

    <span class="text-muted small">
        ENV: {{ config('app.env') }}
    </span>
</nav>
