@extends('layouts.master')

@section('title', 'Edit User')
@section('header_title', 'Update User Access')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6 flex items-center gap-4">
        <a href="{{ route('master.users.index') }}" class="h-10 w-10 rounded-xl bg-white dark:bg-card-dark border border-slate-200 dark:border-slate-800 flex items-center justify-center text-slate-500 hover:text-primary hover:border-primary transition-all shadow-sm">
            <span class="material-icons">arrow_back</span>
        </a>
        <div>
            <h2 class="text-2xl font-bold tracking-tight">Edit Account: {{ $user->name }}</h2>
            <p class="text-slate-500 text-sm">Modify system permissions and profile details.</p>
        </div>
    </div>

    @if($errors->any())
    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl">
        <ul class="list-disc list-inside text-sm font-medium">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('master.users.update', $user) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6 bg-white dark:bg-card-dark rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800">
            {{-- Basic Info --}}
            <div class="space-y-4 md:col-span-2 border-b border-slate-100 dark:border-slate-800 pb-4">
                <h3 class="font-bold text-slate-700 dark:text-slate-300 flex items-center gap-2">
                    <span class="material-icons text-sm">badge</span> Primary Information
                </h3>
            </div>

            <div class="space-y-2">
                <label class="text-xs font-bold uppercase tracking-widest text-slate-500">Full Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                       class="w-full bg-slate-50 dark:bg-slate-900 border-slate-200 dark:border-slate-800 rounded-xl px-4 py-3 focus:ring-primary focus:border-primary transition-all">
            </div>

            <div class="space-y-2">
                <label class="text-xs font-bold uppercase tracking-widest text-slate-500">Email Address</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                       class="w-full bg-slate-50 dark:bg-slate-900 border-slate-200 dark:border-slate-800 rounded-xl px-4 py-3 focus:ring-primary focus:border-primary transition-all">
            </div>

            {{-- Passwords --}}
            <div class="md:col-span-2 space-y-2">
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800/50 p-3 rounded-xl mb-2">
                    <p class="text-[11px] text-blue-700 dark:text-blue-400 font-medium">Leave password fields empty if you don't want to change it.</p>
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-xs font-bold uppercase tracking-widest text-slate-500">New Password</label>
                <input type="password" name="password"
                       class="w-full bg-slate-50 dark:bg-slate-900 border-slate-200 dark:border-slate-800 rounded-xl px-4 py-3 focus:ring-primary focus:border-primary transition-all">
            </div>

            <div class="space-y-2">
                <label class="text-xs font-bold uppercase tracking-widest text-slate-500">Confirm New Password</label>
                <input type="password" name="password_confirmation"
                       class="w-full bg-slate-50 dark:bg-slate-900 border-slate-200 dark:border-slate-800 rounded-xl px-4 py-3 focus:ring-primary focus:border-primary transition-all">
            </div>

            {{-- Permissions --}}
            <div class="space-y-4 md:col-span-2 border-b border-slate-100 dark:border-slate-800 pb-4 mt-6">
                <h3 class="font-bold text-slate-700 dark:text-slate-300 flex items-center gap-2">
                    <span class="material-icons text-sm">lock_person</span> Access & Roles
                </h3>
            </div>

            <div class="space-y-2">
                <label class="text-xs font-bold uppercase tracking-widest text-slate-500">Primary Department</label>
                <select name="department_code" class="w-full bg-slate-50 dark:bg-slate-900 border-slate-200 dark:border-slate-800 rounded-xl px-4 py-3 focus:ring-primary focus:border-primary">
                    <option value="">GLOBALLY ACCESSIBLE (No restriction)</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->code }}" {{ old('department_code', $user->department_code) == $dept->code ? 'selected' : '' }}>
                            {{ $dept->code }} - {{ $dept->name }}
                        </option>
                    @endforeach
                </select>
                <p class="text-[10px] text-slate-400 px-2 italic">Main department assignment.</p>
            </div>

            <div class="space-y-2 md:col-span-2">
                <label class="text-xs font-bold uppercase tracking-widest text-slate-500">Additional Department Access (For Managers)</label>
                <div class="bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-4 max-h-48 overflow-y-auto">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                        @php
                            $additional = $user->additional_department_codes ?? [];
                        @endphp
                        @foreach($departments as $dept)
                            <label class="flex items-center gap-2 cursor-pointer group">
                                <input type="checkbox" name="additional_department_codes[]" value="{{ $dept->code }}" 
                                       class="rounded border-slate-300 text-primary focus:ring-primary"
                                       {{ (is_array(old('additional_department_codes')) && in_array($dept->code, old('additional_department_codes'))) || in_array($dept->code, $additional) ? 'checked' : '' }}>
                                <span class="text-xs font-medium text-slate-600 group-hover:text-primary transition-colors">
                                    {{ $dept->code }} - {{ $dept->name }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-xs font-bold uppercase tracking-widest text-slate-500">Team (TIM)</label>
                <input type="text" name="tim" value="{{ old('tim', $user->tim) }}" placeholder="e.g. TIM A"
                       class="w-full bg-slate-50 dark:bg-slate-900 border-slate-200 dark:border-slate-800 rounded-xl px-4 py-3 focus:ring-primary focus:border-primary transition-all">
                <p class="text-[10px] text-slate-400 px-2 italic">For SPV role: TIM A, TIM B, or TIM C.</p>
            </div>

            <div class="space-y-2">
                <label class="text-xs font-bold uppercase tracking-widest text-slate-500">User Role</label>
                <select name="role" required class="w-full bg-slate-50 dark:bg-slate-900 border-slate-200 dark:border-slate-800 rounded-xl px-4 py-3 focus:ring-primary focus:border-primary">
                    <option value="admin_dept" {{ old('role', $user->role) == 'admin_dept' ? 'selected' : '' }}>Admin Departemen</option>
                    <option value="manager" {{ old('role', $user->role) == 'manager' ? 'selected' : '' }}>Manager</option>
                    <option value="direktur" {{ old('role', $user->role) == 'direktur' ? 'selected' : '' }}>Direktur</option>
                    <option value="mr" {{ old('role', $user->role) == 'mr' ? 'selected' : '' }}>Management Rep</option>
                </select>
            </div>

            <div class="md:col-span-2 space-y-3">
                <label class="text-xs font-bold uppercase tracking-widest text-slate-500">Allowed Applications</label>
                <div class="flex flex-wrap gap-4 p-4 bg-slate-50 dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800">
                    @php
                        $allowed = $user->allowed_apps ?? [];
                    @endphp
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="allowed_apps[]" value="masterdata-kpi" class="rounded border-slate-300 text-primary focus:ring-primary" {{ in_array('masterdata-kpi', $allowed) ? 'checked' : '' }}>
                        <span class="text-sm font-medium">Master Data Hub</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="allowed_apps[]" value="kpi-bubut" class="rounded border-slate-300 text-primary focus:ring-primary" {{ in_array('kpi-bubut', $allowed) ? 'checked' : '' }}>
                        <span class="text-sm font-medium">KPI Bubut</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer opacity-50">
                        <input type="checkbox" name="allowed_apps[]" value="kpi-gudang" class="rounded border-slate-300 text-primary focus:ring-primary" disabled title="Coming Soon">
                        <span class="text-sm font-medium">KPI Gudang (Soon)</span>
                    </label>
                </div>
            </div>

            <div class="md:col-span-2 pt-6">
                <button type="submit" class="w-full bg-primary text-white py-3.5 rounded-xl font-bold shadow-lg shadow-primary/30 hover:shadow-primary/50 transition-all flex items-center justify-center gap-2">
                    <span class="material-icons">save</span>
                    Update Account Settings
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
