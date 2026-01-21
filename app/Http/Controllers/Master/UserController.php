<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\MdDepartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index()
    {
        $this->authorizeAdmin();
        $users = User::orderBy('name', 'asc')->get();
        return view('master.users.index', compact('users'));
    }

    public function create()
    {
        $this->authorizeAdmin();
        $departments = MdDepartment::where('status', 'active')->get();
        return view('master.users.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'department_code' => ['nullable', 'string', 'exists:md_departments,code'],
            'tim' => ['nullable', 'string', 'max:50'],
            'additional_department_codes' => ['nullable', 'array'],
            'additional_department_codes.*' => ['string', 'exists:md_departments,code'],
            'role' => ['required', 'string'],
            'allowed_apps' => ['nullable', 'array'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'department_code' => $request->department_code,
            'tim' => $request->tim,
            'additional_department_codes' => $request->additional_department_codes ?? [],
            'role' => $request->role,
            'allowed_apps' => $request->allowed_apps ?? [],
        ]);

        return redirect()->route('master.users.index')
            ->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        $this->authorizeAdmin();
        $departments = MdDepartment::where('status', 'active')->get();
        return view('master.users.edit', compact('user', 'departments'));
    }

    public function update(Request $request, User $user)
    {
        $this->authorizeAdmin();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'department_code' => ['nullable', 'string', 'exists:md_departments,code'],
            'tim' => ['nullable', 'string', 'max:50'],
            'additional_department_codes' => ['nullable', 'array'],
            'additional_department_codes.*' => ['string', 'exists:md_departments,code'],
            'role' => ['required', 'string'],
            'allowed_apps' => ['nullable', 'array'],
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'department_code' => $request->department_code,
            'tim' => $request->tim,
            'additional_department_codes' => $request->additional_department_codes ?? [],
            'role' => $request->role,
            'allowed_apps' => $request->allowed_apps ?? [],
        ];

        if ($request->filled('password')) {
            $request->validate([
                'password' => ['confirmed', Rules\Password::defaults()],
            ]);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('master.users.index')
            ->with('success', 'User updated successfully.');
    }

    protected function authorizeAdmin()
    {
        $user = auth()->user();
        if (!in_array($user->role, ['direktur', 'mr']) && !in_array($user->department_code, ['100', '100.1'])) {
            abort(403, 'Unauthorized action.');
        }
    }
}
