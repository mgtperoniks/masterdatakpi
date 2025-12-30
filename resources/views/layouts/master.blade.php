<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Master Data KPI')</title>

    {{-- CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f7fb;
        }

        /* ==============================
           Sidebar Layout
        ============================== */
        .sidebar {
            width: 240px;
            min-height: 100vh;
            background: #1f2937;
        }

        .sidebar .nav-link {
            color: #cbd5e1;
            text-decoration: none;
            display: block;
            padding: 10px 16px;
            border-radius: 6px;
            margin-bottom: 4px;
            transition: background-color .15s ease-in-out, color .15s ease-in-out;
        }

        /* ==============================
           Sidebar Active & Hover State
        ============================== */
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: #2563eb;
            color: #ffffff;
            font-weight: 600;
        }

        /* ==============================
           Main Content
        ============================== */
        .content-wrapper {
            padding: 24px;
        }
    </style>
</head>
<body>

<div class="d-flex">
    {{-- SIDEBAR --}}
    @include('layouts.partials.sidebar')

    {{-- MAIN --}}
    <div class="flex-grow-1">
        @include('layouts.partials.topbar')

        <div class="content-wrapper">
            @yield('content')
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
