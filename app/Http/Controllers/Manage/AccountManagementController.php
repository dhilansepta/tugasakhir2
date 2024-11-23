<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;

class AccountManagementController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'email' => ['nullable', 'email', 'lowercase', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:Owner,Karyawan'],
            'status' => ['required', 'string', 'in:Aktif,Non_Aktif']
        ]);

        $email = $request->role === 'Owner' ? $request->email : null;

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Akun berhasil dibuat');
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
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $id],
            'role' => ['required', 'string', 'in:Owner,Karyawan'],
            'status' => ['required', 'string', 'in:Aktif,Non_Aktif'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()]
        ]);

        $email = $request->role === 'Owner' ? $request->email : null;

        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $email,
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