<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AccountManagementController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:Owner,Karyawan'],
            'status' => ['required', 'string', 'in:Aktif,Non_Aktif']
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Akun berhasil dibuat');
    }

    public function edit($id)
    {
        $user = User::find($id);

        // Jika user tidak ditemukan, berikan response atau redirect dengan error
        if (!$user) {
            return redirect()->route('owner.kelolaakun')->with('error', 'User tidak ditemukan.');
        }

        // Jika user ditemukan, tampilkan view edit dan kirim data user
        return view('owner.kelolaakun', compact('user'));
    }

    public function viewAkun()
    {
        $users = User::orderBy('id', 'asc')->get();
        return view('owner.kelolaakun', compact('users'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username,'.$id],
            'role' => ['required', 'string', 'in:Owner,Karyawan'],
            'status' => ['required', 'string', 'in:Aktif,Non_Aktif'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()]
        ]);

        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'role' => $request->role,
            'status' => $request->status,
        ]);
        
        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('owner.kelolaakun')->with('success', 'Akun berhasil diperbarui');
    }
}