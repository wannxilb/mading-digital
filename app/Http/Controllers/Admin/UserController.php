<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::query()
            ->when($request->filled('role'), fn ($q) => $q->where('role', $request->string('role')->toString()))
            ->when($request->filled('q'), function ($q) use ($request) {
                $q->where(fn ($w) => $w
                    ->where('name', 'like', '%'.$request->string('q')->toString().'%')
                    ->orWhere('email', 'like', '%'.$request->string('q')->toString().'%'));
            })
            ->latest()
            ->paginate(12);

        return view('admin.users.index', [
            'users' => $users,
            'roles' => ['admin' => 'Admin', 'guru' => 'Guru / Pembina', 'siswa' => 'Siswa'],
            'activeRole' => $request->string('role')->toString(),
        ]);
    }

    public function create()
    {
        return view('admin.users.create', [
            'roles' => ['admin' => 'Admin', 'guru' => 'Guru / Pembina', 'siswa' => 'Siswa'],
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'role' => ['required', 'in:admin,guru,siswa'],
            'class' => ['nullable', 'string', 'max:60'],
            'is_active' => ['nullable', 'boolean'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $data['is_active'] = $request->boolean('is_active', true);

        User::create($data);

        return redirect()
            ->route('admin.pengguna.index')
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', [
            'user' => $user,
            'roles' => ['admin' => 'Admin', 'guru' => 'Guru / Pembina', 'siswa' => 'Siswa'],
        ]);
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'role' => ['required', 'in:admin,guru,siswa'],
            'class' => ['nullable', 'string', 'max:60'],
            'is_active' => ['nullable', 'boolean'],
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        $data['is_active'] = $request->boolean('is_active');

        if (empty($data['password'])) {
            unset($data['password']);
        }

        if ($user->is(auth()->user()) && $data['role'] !== 'admin') {
            return back()->withErrors(['role' => 'Tidak dapat menghapus peran admin dari akun yang sedang digunakan.']);
        }

        $user->update($data);

        return redirect()
            ->route('admin.pengguna.edit', $user)
            ->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy(Request $request, User $user)
    {
        if ($user->is($request->user()) || $user->isAdmin() && $user->email === 'admin@mading.sch.id') {
            return back()->withErrors(['user' => 'Akun ini tidak dapat dihapus.']);
        }

        $user->delete();

        return redirect()
            ->route('admin.pengguna.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }
}
