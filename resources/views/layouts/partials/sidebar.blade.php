@php
    $user = auth()->user();

    // Role = level otorisasi
    $role = strtolower($user->role ?? '');

    // Scope = domain akses
    $scope = strtoupper($user->scope ?? '');

    $isSuper = in_array($role, ['direktur', 'mr'], true);
    $isManager = $role === 'manager';
    $isAdmin = $role === 'admin';
    $isAuditor = $role === 'auditor';

    $isPPIC = $scope === 'PPIC';
    $isHR = $scope === 'HR';
@endphp

<nav class="sidebar p-3">

    <div class="sidebar-header mb-4">
        <h5 class="text-white mb-0">Master Data</h5>
        <small class="text-muted">SSOT Control</small>
    </div>

    <ul class="nav flex-column">

        {{-- DASHBOARD (SEMUA USER) --}}
        <li class="nav-item">
            <a href="{{ route('master.dashboard') }}"
                class="nav-link {{ request()->routeIs('master.dashboard') ? 'active' : '' }}">
                Dashboard
            </a>
        </li>

        {{-- DEPARTMENTS (SUPER + AUDITOR) --}}
        @if ($isSuper || $isAuditor)
            <li class="nav-item">
                <a href="{{ route('master.departments.index') }}"
                    class="nav-link {{ request()->is('*/departments*') ? 'active' : '' }}">
                    Departments
                </a>
            </li>
        @endif

        {{-- LINES (SUPER / PPIC / AUDITOR) --}}
        @if ($isSuper || (($isManager || $isAdmin) && $isPPIC) || $isAuditor)
            <li class="nav-item">
                <a href="{{ route('master.lines.index') }}"
                    class="nav-link {{ request()->is('*/lines*') ? 'active' : '' }}">
                    Lines
                </a>
            </li>
        @endif

        {{-- MACHINES (SUPER / PPIC / AUDITOR) --}}
        @if ($isSuper || (($isManager || $isAdmin) && $isPPIC) || $isAuditor)
            <li class="nav-item">
                <a href="{{ route('master.machines.index') }}"
                    class="nav-link {{ request()->is('*/machines*') ? 'active' : '' }}">
                    Machines
                </a>
            </li>
        @endif

        {{-- ITEMS (SUPER / PPIC / AUDITOR) --}}
        @if ($isSuper || (($isManager || $isAdmin) && $isPPIC) || $isAuditor)
            <li class="nav-item">
                <a href="{{ route('master.items.index') }}"
                    class="nav-link {{ request()->is('*/items*') ? 'active' : '' }}">
                    Items
                </a>
            </li>

            {{-- HEAT NUMBERS (SUPER / PPIC / AUDITOR) --}}
            <li class="nav-item">
                <a href="{{ route('master.heat-numbers.index') }}"
                    class="nav-link {{ request()->is('*/heat-numbers*') ? 'active' : '' }}">
                    Heat Numbers
                </a>
            </li>
        @endif

        {{-- OPERATORS (SUPER / HR / AUDITOR) --}}
        @if ($isSuper || (($isManager || $isAdmin) && $isHR) || $isAuditor)
            <li class="nav-item">
                <a href="{{ route('master.operators.index') }}"
                    class="nav-link {{ request()->is('*/operators*') ? 'active' : '' }}">
                    Operators
                </a>
            </li>
        @endif

        {{-- AUDIT LOG (SUPER + AUDITOR) --}}
        @if ($isSuper || $isAuditor)
            <li class="nav-item mt-3">
                <a href="{{ route('master.audit-logs.index') }}"
                    class="nav-link {{ request()->is('*/audit-logs*') ? 'active' : '' }}">
                    Audit Log
                </a>
            </li>
        @endif

    </ul>
</nav>