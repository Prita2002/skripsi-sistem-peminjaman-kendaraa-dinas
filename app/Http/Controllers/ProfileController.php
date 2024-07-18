<?php
// app/Http/Controllers/ProfileController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\TimKerja;
use App\Models\User;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        $user = Auth::user()->load('timKerja');
        $title = 'Profile';
        return view('profile.show', compact('user', 'title'));
    }

    public function edit()
    {
        $user = Auth::user()->load('timKerja');
        $title = 'Profile';
        $timKerjas = TimKerja::all();
        return view('profile.edit', compact('user', 'timKerjas', 'title'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'password' => 'nullable|string|min:8|confirmed',
            'nip' => 'required|string|max:20',
            'username' => 'required|string|max:255',
            'role' => 'required|string|max:50',
            'no_telp' => 'nullable|string|max:15',
            'tim_kerja_id' => 'nullable|integer|exists:tim_kerja,id',
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->nip = $request->nip;
        $user->username = $request->username;
        $user->role = $request->role;
        $user->no_telp = $request->no_telp;
        $user->tim_kerja_id = $request->tim_kerja_id;
        $user->save();

        return redirect()->route('profile.show')->with('success', 'Profile Berhasil Diperbarui.');
    }
}
