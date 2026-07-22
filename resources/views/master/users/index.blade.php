@extends('layouts.master')

@section('title', 'Manage Users')
@section('header_title', 'User Management')

@section('content')
    <div x-data="userManagementList({
        users: {{ json_encode($users->map(function($u) {
            return [
                'id' => $u->id,
                'name' => $u->name,
                'email' => $u->email,
                'role' => $u->role,
                'department_code' => $u->department_code ?? '',
                'department_name' => $u->department ? $u->department->name : '',
                'tim' => $u->tim ?? '',
                'allowed_apps' => $u->allowed_apps ?? [],
                'edit_url' => route('master.users.edit', $u),
            ];
        })) }}
    })" class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold tracking-tight">System Users</h2>
                <p class="text-slate-500 text-sm">Centralized access control for all KPI modules.</p>
            </div>
            <a href="{{ route('master.users.create') }}"
                class="inline-flex items-center gap-2 bg-primary text-white px-5 py-2.5 rounded-xl font-semibold hover:shadow-lg hover:shadow-primary/30 transition-all text-sm shrink-0">
                <span class="material-icons text-sm">person_add</span>
                Create User
            </a>
        </div>

        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl flex items-center gap-3">
                <span class="material-icons text-emerald-500">check_circle</span>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
        @endif

        {{-- Search Input Section --}}
        <div class="relative max-w-md">
            <input type="text" x-model="searchQuery" 
                placeholder="Search name, email, department..." 
                class="w-full bg-white dark:bg-card-dark border border-slate-200 dark:border-slate-800 rounded-xl p-2.5 pl-9 text-xs focus:ring-1 focus:ring-primary focus:border-primary">
            <span class="material-icons absolute left-2.5 top-2.5 text-slate-400 text-base">search</span>
        </div>

        <div class="bg-white dark:bg-card-dark rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-800">
                            {{-- Sortable Name --}}
                            <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-500 cursor-pointer select-none" @click="toggleSort('name')">
                                <div class="flex items-center gap-1.5">
                                    <span>Name / Email</span>
                                    <span class="material-icons text-xs" :class="sortBy === 'name' ? 'text-primary' : 'text-slate-300'" x-text="sortBy === 'name' ? (sortDir === 'asc' ? 'arrow_upward' : 'arrow_downward') : 'import_export'"></span>
                                </div>
                            </th>
                            {{-- Sortable Role --}}
                            <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-500 cursor-pointer select-none" @click="toggleSort('role')">
                                <div class="flex items-center gap-1.5">
                                    <span>Role</span>
                                    <span class="material-icons text-xs" :class="sortBy === 'role' ? 'text-primary' : 'text-slate-300'" x-text="sortBy === 'role' ? (sortDir === 'asc' ? 'arrow_upward' : 'arrow_downward') : 'import_export'"></span>
                                </div>
                            </th>
                            {{-- Sortable Department --}}
                            <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-500 cursor-pointer select-none" @click="toggleSort('department')">
                                <div class="flex items-center gap-1.5">
                                    <span>Department</span>
                                    <span class="material-icons text-xs" :class="sortBy === 'department' ? 'text-primary' : 'text-slate-300'" x-text="sortBy === 'department' ? (sortDir === 'asc' ? 'arrow_upward' : 'arrow_downward') : 'import_export'"></span>
                                </div>
                            </th>
                            {{-- Sortable Allowed Apps --}}
                            <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-500 cursor-pointer select-none" @click="toggleSort('allowed_apps')">
                                <div class="flex items-center gap-1.5">
                                    <span>Allowed Apps</span>
                                    <span class="material-icons text-xs" :class="sortBy === 'allowed_apps' ? 'text-primary' : 'text-slate-300'" x-text="sortBy === 'allowed_apps' ? (sortDir === 'asc' ? 'arrow_upward' : 'arrow_downward') : 'import_export'"></span>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-500 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        {{-- Empty State Row --}}
                        <tr x-show="filteredUsers.length === 0" style="display: none;">
                            <td colspan="5" class="px-6 py-12 text-center text-slate-550">
                                <span class="material-icons text-3xl text-slate-400 block mb-2">person_off</span>
                                <span class="text-xs font-semibold">No users found.</span>
                            </td>
                        </tr>

                        {{-- Data Rows --}}
                        <template x-for="user in filteredUsers" :key="user.id">
                            <tr class="hover:bg-slate-50 dark:hover:bg-white/5 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="h-10 w-10 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center font-bold text-primary group-hover:bg-primary group-hover:text-white transition-all"
                                            x-text="user.name.charAt(0)">
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-900 dark:text-white" x-text="user.name"></p>
                                            <p class="text-xs text-slate-500 italic" x-text="user.email"></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 rounded-lg text-[10px] font-bold uppercase"
                                        :class="user.role === 'direktur' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700'"
                                        x-text="user.role">
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-slate-600 dark:text-slate-400">
                                    <span x-text="user.department_code || 'GLOBAL ACCESS'"></span>
                                    <template x-if="user.tim">
                                        <div class="text-[10px] text-primary/70 font-bold uppercase tracking-tighter mt-0.5" x-text="user.tim"></div>
                                    </template>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1">
                                        <template x-for="app in user.allowed_apps" :key="app">
                                            <span class="px-2 py-0.5 rounded text-[9px] font-bold bg-slate-100 text-slate-600 border border-slate-200 uppercase" x-text="app"></span>
                                        </template>
                                        <template x-if="user.allowed_apps.length === 0">
                                            <span class="text-[10px] text-slate-400 italic">No apps assigned</span>
                                        </template>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a :href="user.edit_url"
                                        class="inline-flex items-center justify-center h-8 w-8 rounded-lg text-slate-400 hover:bg-primary/10 hover:text-primary transition-all">
                                        <span class="material-icons text-sm">edit</span>
                                    </a>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- AlpineJS Script --}}
    <script>
        function userManagementList(config) {
            return {
                users: config.users,
                searchQuery: '',
                sortBy: '',
                sortDir: '',

                get filteredUsers() {
                    let list = [...this.users];

                    // Search filter
                    const query = this.searchQuery.toLowerCase().trim();
                    if (query !== '') {
                        list = list.filter(u => {
                            const name = u.name.toLowerCase();
                            const email = u.email.toLowerCase();
                            const depCode = u.department_code.toLowerCase();
                            const depName = u.department_name.toLowerCase();
                            const role = u.role.toLowerCase();
                            const apps = u.allowed_apps.map(a => a.toLowerCase()).join(' ');

                            return name.includes(query) ||
                                   email.includes(query) ||
                                   depCode.includes(query) ||
                                   depName.includes(query) ||
                                   role.includes(query) ||
                                   apps.includes(query);
                        });
                    }

                    // Sort order
                    if (this.sortBy && this.sortDir) {
                        list.sort((a, b) => {
                            let valA = '';
                            let valB = '';

                            if (this.sortBy === 'name') {
                                valA = a.name.toLowerCase();
                                valB = b.name.toLowerCase();
                            } else if (this.sortBy === 'email') {
                                valA = a.email.toLowerCase();
                                valB = b.email.toLowerCase();
                            } else if (this.sortBy === 'role') {
                                valA = a.role.toLowerCase();
                                valB = b.role.toLowerCase();
                            } else if (this.sortBy === 'department') {
                                valA = a.department_code.toLowerCase() || 'global access';
                                valB = b.department_code.toLowerCase() || 'global access';
                            } else if (this.sortBy === 'allowed_apps') {
                                valA = a.allowed_apps.join(', ').toLowerCase();
                                valB = b.allowed_apps.join(', ').toLowerCase();
                            }

                            if (valA < valB) return this.sortDir === 'asc' ? -1 : 1;
                            if (valA > valB) return this.sortDir === 'asc' ? 1 : -1;
                            return 0;
                        });
                    }

                    return list;
                },

                toggleSort(column) {
                    if (this.sortBy === column) {
                        if (this.sortDir === 'asc') {
                            this.sortDir = 'desc';
                        } else if (this.sortDir === 'desc') {
                            this.sortBy = '';
                            this.sortDir = '';
                        } else {
                            this.sortDir = 'asc';
                        }
                    } else {
                        this.sortBy = column;
                        this.sortDir = 'asc';
                    }
                }
            };
        }
    </script>
@endsection