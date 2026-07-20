<?php

namespace App\Http\Controllers\Ketua;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::latest();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%')
                    ->orWhere('no_hp', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->paginate(10)->withQueryString();

        $counts = [
            'ketua' => User::where('role', 'ketua')->count(),
            'kader' => User::where('role', 'kader')->count(),
            'bidan' => User::where('role', 'bidan')->count(),
            'orang_tua' => User::where('role', 'orang_tua')->count(),
        ];

        return view('ketua.users.index', compact('users', 'counts'));
    }

    public function create()
    {
        return view('ketua.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:100',
            'email'    => 'nullable|email|max:100|unique:users,email',
            'no_hp'    => 'required|string|max:20|unique:users,no_hp',
            'role'     => 'required|in:ketua,kader,bidan,orang_tua',
            'password' => 'required|string|min:8|max:100|confirmed',
        ], [
            'nama.required'      => 'Nama wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email sudah digunakan.',
            'no_hp.required'     => 'No HP wajib diisi.',
            'no_hp.unique'       => 'Nomor HP sudah digunakan.',
            'role.required'      => 'Role wajib dipilih.',
            'password.required'  => 'Password wajib diisi.',
            'password.min'       => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        User::create([
            'nama'     => $request->nama,
            'email'    => $request->email ?: null,
            'no_hp'    => $request->no_hp,
            'role'     => $request->role,
            'status'   => 'aktif',
            'password' => Hash::make($request->password),
        ]);

        $roleNames = [
            'ketua' => 'Ketua Posyandu',
            'kader' => 'Kader',
            'bidan' => 'Bidan',
            'orang_tua' => 'Orang Tua',
        ];
        $roleName = $roleNames[$request->role] ?? ucfirst($request->role);

        return redirect()->route('ketua.users.index')
            ->with('success', 'Akun ' . $roleName . ' berhasil dibuat.');
    }

    public function show(User $user)
    {
        return view('ketua.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('ketua.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'nama'     => 'required|string|max:100',
            'email'    => 'nullable|email|max:100|unique:users,email,' . $user->id,
            'no_hp'    => 'required|string|max:20|unique:users,no_hp,' . $user->id,
            'password' => 'nullable|string|min:8|max:100|confirmed',
        ], [
            'nama.required'      => 'Nama wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email sudah digunakan.',
            'no_hp.required'     => 'No HP wajib diisi.',
            'no_hp.unique'       => 'Nomor HP sudah digunakan.',
            'password.min'       => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $data = [
            'nama'  => $request->nama,
            'email' => $request->email ?: null,
            'no_hp' => $request->no_hp,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('ketua.users.index')
            ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->getKey() === Auth::id()) {
            return redirect()->route('ketua.users.index')
                ->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->route('ketua.users.index')
            ->with('success', 'Akun pengguna berhasil dihapus.');
    }
}
