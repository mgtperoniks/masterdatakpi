<!DOCTYPE html>
<html lang="en" class="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Master Data KPI')</title>

    {{-- Fonts --}}
    <style>
        @font-face {
            font-family: 'Material Icons Round';
            font-style: normal;
            font-weight: 400;
            src: url("{{ asset('fonts/material-icons-round-latin-400-normal.woff2') }}") format('woff2'),
                url("{{ asset('fonts/material-icons-round-latin-400-normal.woff') }}") format('woff');
        }

        @font-face {
            font-family: 'Material Icons';
            font-style: normal;
            font-weight: 400;
            src: url("{{ asset('fonts/material-icons-round-latin-400-normal.woff2') }}") format('woff2');
            /* Fallback to round */
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
            -webkit-tap-highlight-color: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar {
            display: none;
        }

        [x-cloak] {
            display: none !important;
        }

        /* Material Icons Classes Definition */
        .material-icons,
        .material-icons-round,
        .material-icons-outlined {
            font-family: 'Material Icons Round';
            font-weight: normal;
            font-style: normal;
            font-size: 24px;
            display: inline-block;
            line-height: 1;
            text-transform: none;
            letter-spacing: normal;
            word-wrap: normal;
            white-space: nowrap;
            direction: ltr;
            -webkit-font-smoothing: antialiased;
            text-rendering: optimizeLegibility;
            -moz-osx-font-smoothing: grayscale;
            font-feature-settings: 'liga';
        }
    </style>
    @stack('styles')
</head>

<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 min-h-screen pb-24 lg:pb-0">

    <div class="flex min-h-screen">
        {{-- Desktop Sidebar --}}
        <aside class="hidden lg:flex flex-col w-64 bg-card-dark text-white sticky top-0 h-screen">
            @include('layouts.partials.sidebar_new')
        </aside>

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col">
            {{-- Top Header --}}
            <header class="bg-primary px-5 py-4 flex items-center justify-between sticky top-0 z-50 shadow-md">
                <div class="flex items-center gap-3">
                    <div class="bg-white/20 p-2 rounded-lg lg:hidden">
                        <span class="material-icons text-white">grid_view</span>
                    </div>
                    <div>
                        <h1 class="text-white font-bold text-lg leading-tight lg:text-xl">
                            @yield('header_title', 'Master Data')</h1>
                        <p class="text-white/70 text-xs">KPI System Hub</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <button class="text-white p-2 hover:bg-white/10 rounded-full transition-colors">
                        <span class="material-icons">notifications</span>
                    </button>
                    <div class="flex items-center gap-3 pl-3 border-l border-white/20">
                        <div class="text-right hidden sm:block">
                            <p class="text-white text-xs font-bold leading-none">{{ Auth::user()->name }}</p>
                            <p class="text-white/60 text-[10px] leading-tight mt-1">{{ Auth::user()->email }}</p>
                        </div>
                        <div
                            class="h-9 w-9 rounded-xl bg-white/20 flex items-center justify-center border border-white/10 shadow-inner">
                            <span
                                class="text-white text-xs font-black uppercase">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        </div>
                        <form action="{{ route('logout') }}" method="POST" class="ml-1">
                            @csrf
                            <button type="submit"
                                class="text-white/70 hover:text-white p-1 hover:bg-white/10 rounded-lg transition-colors"
                                title="Sign Out">
                                <span class="material-icons text-[20px]">logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <main class="flex-1 px-5 py-6 lg:px-8">
                @yield('content')
            </main>
        </div>
    </div>

    {{-- Bottom Nav (Mobile) --}}
    <nav
        class="lg:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-slate-200 safe-area-bottom px-6 py-3 flex justify-between items-center z-50">
        <a href="{{ route('dashboard') }}"
            class="flex flex-col items-center gap-1 {{ request()->routeIs('dashboard') ? 'text-primary' : 'text-slate-400' }}">
            <span class="material-icons">dashboard</span>
            <span class="text-[10px] font-bold">Dashboard</span>
        </a>
        <a href="{{ route('master.items.index') }}"
            class="flex flex-col items-center gap-1 {{ request()->routeIs('master.items.*') ? 'text-primary' : 'text-slate-400' }}">
            <span class="material-icons">category</span>
            <span class="text-[10px] font-medium">Items</span>
        </a>
        <a href="{{ route('master.machines.index') }}"
            class="flex flex-col items-center gap-1 {{ request()->routeIs('master.machines.*') ? 'text-primary' : 'text-slate-400' }}">
            <span class="material-icons">precision_manufacturing</span>
            <span class="text-[10px] font-medium">Machines</span>
        </a>
        <a href="{{ route('master.operators.index') }}"
            class="flex flex-col items-center gap-1 {{ request()->routeIs('master.operators.*') ? 'text-primary' : 'text-slate-400' }}">
            <span class="material-icons">person_search</span>
            <span class="text-[10px] font-medium">Operators</span>
        </a>
        <a href="{{ route('master.heat-numbers.index') }}"
            class="flex flex-col items-center gap-1 {{ request()->routeIs('master.heat-numbers.*') ? 'text-primary' : 'text-slate-400' }}">
            <span class="material-icons">qr_code</span>
            <span class="text-[10px] font-medium">Heat</span>
        </a>
    </nav>

    @stack('scripts')
</body>

</html>