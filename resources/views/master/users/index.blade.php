@extends('layouts.master')

@section('title', 'Manage Users')
@section('header_title', 'User Management')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold tracking-tight">System Users</h2>
            <p class="text-slate-500 text-sm">Centralized access control for all KPI modules.</p>
        </div>
        <a href="{{ route('master.users.create') }}" 
           class="inline-flex items-center gap-2 bg-primary text-white px-5 py-2.5 rounded-xl font-semibold hover:shadow-lg hover:shadow-primary/30 transition-all">
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

    <div class="bg-white dark:bg-card-dark rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-800">
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-500">Name / Email</th>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-500">Role</th>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-500">Department</th>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-500">Allowed Apps</th>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-500 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @foreach($users as $user)
                    <tr class="hover:bg-slate-50 dark:hover:bg-white/5 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="h-10 w-10 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center font-bold text-primary group-hover:bg-primary group-hover:text-white transition-all">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-bold text-slate-900 dark:text-white">{{ $user->name }}</p>
                                    <p class="text-xs text-slate-500 italic">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded-lg text-[10px] font-bold uppercase {{ $user->role === 'direktur' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm font-medium text-slate-600 dark:text-slate-400">
                            {{ $user->department_code ?: 'GLOBAL ACCESS' }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-wrap gap-1">
                                @forelse($user->allowed_apps ?? [] as $app)
                                    <span class="px-2 py-0.5 rounded text-[9px] font-bold bg-slate-100 text-slate-600 border border-slate-200 uppercase">
                                        {{ $app }}
                                    </span>
                                @empty
                                    <span class="text-[10px] text-slate-400 italic">No apps assigned</span>
                                @endforelse
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('master.users.edit', $user) }}" 
                               class="inline-flex items-center justify-center h-8 w-8 rounded-lg text-slate-400 hover:bg-primary/10 hover:text-primary transition-all">
                                <span class="material-icons text-sm">edit</span>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
