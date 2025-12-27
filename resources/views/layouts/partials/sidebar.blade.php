<nav class="sidebar p-3">

    <div class="sidebar-header mb-4">
        <h5 class="text-white mb-0">Master Data</h5>
        <small class="text-muted">SSOT Control</small>
    </div>

    <ul class="nav flex-column">

        <li class="nav-item">
            <a href="{{ route('master.dashboard') }}"
               class="nav-link {{ request()->routeIs('master.dashboard') ? 'active' : '' }}">
                Dashboard
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('master.departments.index') }}"
               class="nav-link {{ request()->routeIs('master.departments.*') ? 'active' : '' }}">
                Departments
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('master.lines.index') }}"
               class="nav-link {{ request()->routeIs('master.lines.*') ? 'active' : '' }}">
                Lines
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('master.machines.index') }}"
               class="nav-link {{ request()->routeIs('master.machines.*') ? 'active' : '' }}">
                Machines
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('master.items.index') }}"
               class="nav-link {{ request()->routeIs('master.items.*') ? 'active' : '' }}">
                Items
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('master.operators.index') }}"
               class="nav-link {{ request()->routeIs('master.operators.*') ? 'active' : '' }}">
                Operators
            </a>
        </li>

        <li class="nav-item mt-3">
            <a href="{{ route('master.audit-logs.index') }}"
               class="nav-link {{ request()->routeIs('master.audit-logs.*') ? 'active' : '' }}">
                Audit Log
            </a>
        </li>

    </ul>
</nav>
