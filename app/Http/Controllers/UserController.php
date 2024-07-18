<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\TimKerja;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('timKerja')->get(); // Load relasi timKerja
        $title = 'Data User';
        return view('users.index', compact('users', 'title'));
    }

    public function create()
    {
        $timKerjas = TimKerja::all();
        $title = 'Data User';
        return view('users.create', compact('timKerjas', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'nip' => 'required|string|max:20|regex:/^[0-9]+$/',
            'username' => 'required|string|max:255|unique:users',
            'role' => 'required|string|in:admin,user',
            'no_telp' => 'required|string|max:15|regex:/^[0-9]+$/',
            'tim_kerja_id' => 'required',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nip' => $request->nip,
            'username' => $request->username,
            'role' => $request->role,
            'no_telp' => $request->no_telp,
            'tim_kerja_id' => $request->tim_kerja_id,
        ]);

        return redirect()->route('users.index')->with('success', 'User Berhasil Ditambahkan.');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'nip' => 'required|string|max:20|regex:/^[0-9]+$/',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'role' => 'required|string|in:admin,user',
            'no_telp' => 'required|string|max:15|regex:/^[0-9]+$/',
            'tim_kerja_id' => 'required',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'nip' => $request->nip,
            'username' => $request->username,
            'role' => $request->role,
            'no_telp' => $request->no_telp,
            'tim_kerja_id' => $request->tim_kerja_id,
        ]);

        return redirect()->route('users.index')->with('success', 'User Berhasil Diperbarui.');
    }

    public function edit(User $user)
    {
        $timKerjas = TimKerja::all();
        $title = 'Data User';
        return view('users.edit', compact('user', 'timKerjas', 'title'));
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User Berhasil Dihapus.');
    }
    public function show(User $user)
    {
        $title = 'Detail Users';
        return view('users.show', compact('user', 'title'));
    }
}
