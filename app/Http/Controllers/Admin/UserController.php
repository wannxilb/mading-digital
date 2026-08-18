<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
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
            'roles' => ['admin' => 'Admin', 'siswa' => 'Siswa'],
            'activeRole' => $request->string('role')->toString(),
        ]);
    }

    public function create()
    {
        return view('admin.users.create', [
            'roles' => ['admin' => 'Admin', 'siswa' => 'Siswa'],
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'nis' => ['nullable', 'string', 'max:30', 'unique:users,nis'],
            'jurusan' => ['nullable', 'string', 'max:60'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'role' => ['required', 'in:admin,siswa'],
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
            'roles' => ['admin' => 'Admin', 'siswa' => 'Siswa'],
        ]);
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'nis' => ['nullable', 'string', 'max:30', 'unique:users,nis,'.$user->id],
            'jurusan' => ['nullable', 'string', 'max:60'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'role' => ['required', 'in:admin,siswa'],
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

    public function import()
    {
        return view('admin.users.import');
    }

    public function processImport(Request $request)
    {
        $request->validate([
            'csv_file' => ['required', 'file', 'mimes:csv,txt', 'max:2048'],
        ]);

        $file = $request->file('csv_file');
        $rows = array_map('str_getcsv', file($file->getPathname()));

        if (count($rows) < 2) {
            return back()->withErrors(['csv_file' => 'CSV kosong atau hanya berisi header.']);
        }

        $header = array_map('strtolower', array_map('trim', $rows[0]));
        $required = ['nis', 'nama', 'kelas', 'jurusan', 'password'];
        $missing = array_diff($required, $header);

        if ($missing !== []) {
            return back()->withErrors(['csv_file' => 'Header CSV kurang kolom: '.implode(', ', $missing).'. Format: nis, nama, kelas, jurusan, password']);
        }

        $nisIdx = array_search('nis', $header);
        $nameIdx = array_search('nama', $header);
        $classIdx = array_search('kelas', $header);
        $jurusanIdx = array_search('jurusan', $header);
        $passwordIdx = array_search('password', $header);

        $domain = Setting::get('school_domain', 'mading.sch.id');

        $created = 0;
        $skipped = 0;
        $errors = [];

        foreach ($rows as $i => $row) {
            if ($i === 0) {
                continue;
            }

            $nis = trim($row[$nisIdx] ?? '');
            $name = trim($row[$nameIdx] ?? '');
            $class = trim($row[$classIdx] ?? '');
            $jurusan = strtolower(trim($row[$jurusanIdx] ?? ''));
            $password = trim($row[$passwordIdx] ?? '');

            if ($nis === '' || $name === '' || $password === '') {
                $skipped++;
                $errors[] = 'Baris '.($i + 1).': nis, nama, atau password kosong.';

                continue;
            }

            if (strlen($password) < 8) {
                $skipped++;
                $errors[] = 'Baris '.($i + 1).': password minimal 8 karakter.';

                continue;
            }

            if (User::where('nis', $nis)->exists()) {
                $skipped++;
                $errors[] = 'Baris '.($i + 1).': NIS '.$nis.' sudah terdaftar.';

                continue;
            }

            $email = $nis.'@'.$domain;

            if (User::where('email', $email)->exists()) {
                $skipped++;
                $errors[] = 'Baris '.($i + 1).': email '.$email.' sudah terdaftar.';

                continue;
            }

            User::create([
                'name' => $name,
                'nis' => $nis,
                'email' => $email,
                'class' => $class ?: null,
                'jurusan' => $jurusan ?: null,
                'password' => $password,
                'role' => 'siswa',
                'is_active' => true,
            ]);

            $created++;
        }

        $message = "{$created} siswa berhasil ditambahkan.";
        if ($skipped > 0) {
            $message .= " {$skipped} baris dilewati.";
        }

        return redirect()
            ->route('admin.pengguna.index')
            ->with('success', $message)
            ->with('import_errors', $errors);
    }
}
