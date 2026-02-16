<div class="p-6">
    <div class="flex items-center gap-3 mb-10">
        <div class="bg-primary p-2 rounded-lg">
            <span class="material-icons text-white">grid_view</span>
        </div>
        <div>
            <h3 class="font-bold text-white tracking-tight">Master Data</h3>
            <p class="text-white/40 text-[10px] uppercase font-bold tracking-widest">KPI System</p>
        </div>
    </div>

    <nav class="space-y-2">
        <a href="{{ route('dashboard') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('dashboard') ? 'bg-primary text-white' : 'text-white/60 hover:bg-white/5 hover:text-white' }}">
            <span class="material-icons">dashboard</span>
            <span class="font-medium">Dashboard</span>
        </a>

        <div class="pt-4 pb-2">
            <p class="text-white/20 text-[10px] uppercase font-bold px-4 tracking-widest">Management</p>
        </div>

        <a href="{{ route('master.items.select') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('master.items.*') ? 'bg-primary text-white' : 'text-white/60 hover:bg-white/5 hover:text-white' }}">
            <span class="material-icons">inventory_2</span>
            <span class="font-medium">Master Items</span>
        </a>

        <a href="{{ route('master.machines.index') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('master.machines.*') ? 'bg-primary text-white' : 'text-white/60 hover:bg-white/5 hover:text-white' }}">
            <span class="material-icons">precision_manufacturing</span>
            <span class="font-medium">Machines</span>
        </a>

        <a href="{{ route('master.operators.index') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('master.operators.*') ? 'bg-primary text-white' : 'text-white/60 hover:bg-white/5 hover:text-white' }}">
            <span class="material-icons">groups</span>
            <span class="font-medium">Operators</span>
        </a>

        <a href="{{ route('master.departments.index') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('master.departments.*') ? 'bg-primary text-white' : 'text-white/60 hover:bg-white/5 hover:text-white' }}">
            <span class="material-icons">business</span>
            <span class="font-medium">Departments</span>
        </a>

        <a href="{{ route('master.lines.index') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('master.lines.*') ? 'bg-primary text-white' : 'text-white/60 hover:bg-white/5 hover:text-white' }}">
            <span class="material-icons">reorder</span>
            <span class="font-medium">Lines</span>
        </a>

        <a href="{{ route('master.heat-numbers.select') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('master.heat-numbers.*') ? 'bg-primary text-white' : 'text-white/60 hover:bg-white/5 hover:text-white' }}">
            <span class="material-icons">qr_code</span>
            <span class="font-medium">Heat Numbers</span>
        </a>

        @if(in_array(Auth::user()->role, ['direktur', 'mr']))
            <a href="{{ route('master.users.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('master.users.*') ? 'bg-primary text-white' : 'text-white/60 hover:bg-white/5 hover:text-white' }}">
                <span class="material-icons">manage_accounts</span>
                <span class="font-medium">User Management</span>
            </a>

            <a href="{{ route('master.audit-logs.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('master.audit-logs.*') ? 'bg-primary text-white' : 'text-white/60 hover:bg-white/5 hover:text-white' }}">
                <span class="material-icons">history</span>
                <span class="font-medium">Audit Logs</span>
            </a>
        @endif


    </nav>
</div>