<div class="sidebar p-3">
    <h5 class="text-white mb-4">Master Data KPI</h5>

    <a href="{{ route('master.departments.index') }}"
       class="{{ request()->is('master/departments*') ? 'active' : '' }}">
        Departments
    </a>

    <a href="{{ route('master.lines.index') }}"
       class="{{ request()->is('master/lines*') ? 'active' : '' }}">
        Lines
    </a>

    <a href="{{ route('master.machines.index') }}"
       class="{{ request()->is('master/machines*') ? 'active' : '' }}">
        Machines
    </a>
</div>
