<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id', 'DESC')->paginate(10);
        return view('admin.user.index', compact('users'));
    }

    public function create()
    {
        $roles = ['admin', 'petugas', 'pelanggan']; // kirim role ke form
        return view('admin.user.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:6',
            'role'      => 'required|in:admin,petugas,pelanggan',   // VALIDASI ROLE
            'foto'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $data = $request->except('foto');
        $data['password'] = Hash::make($request->password);

        // upload foto
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('uploads/users', 'public');
        }

        User::create($data);

        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = ['admin', 'petugas', 'pelanggan']; // kirim role ke form edit

        return view('admin.user.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'  => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'role'  => 'required|in:admin,petugas,pelanggan',      // VALIDASI ROLE
            'foto'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $data = $request->except('foto');

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // upload atau update foto
        if ($request->hasFile('foto')) {
            if ($user->foto && file_exists(public_path('storage/' . $user->foto))) {
                unlink(public_path('storage/' . $user->foto));
            }

            $data['foto'] = $request->file('foto')->store('uploads/users', 'public');
        }

        $user->update($data);

        return redirect()->route('user.index')->with('success', 'Data user diperbarui');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // hapus foto
        if ($user->foto && file_exists(public_path('storage/' . $user->foto))) {
            unlink(public_path('storage/' . $user->foto));
        }

        $user->delete();

        return redirect()->route('user.index')->with('success', 'User berhasil dihapus');
    }
}
