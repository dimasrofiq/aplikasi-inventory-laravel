<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('roles')->paginate(10);

        $roles = Role::get();

        return view('admin.user.index', compact('users', 'roles'));
    }

    public function create()
    {
        $roles = Role::get();
        
        return view('admin.user.create', compact('roles'));
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'department' => 'required|string',
            'role' => 'required|exists:roles,id',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create a new user instance
        $user = new User();
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->department = $validatedData['department'];
        $user->password = bcrypt($validatedData['password']); // bcrypt() to hash the password

        // Save the user to the database
        $user->save();

        // Attach role to the user
        $user->roles()->attach($validatedData['role']);

        // Redirect back with a success message
        return redirect()->route('admin.user.index')->with('success', 'User berhasil ditambahkan');
    }

    public function destroy(User $user)
    {
        // Hapus user berdasarkan ID
        $user->delete();

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'User berhasil dihapus');
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user->syncRoles($request->role);

        return back()->with('toast_success', 'Role User Berhasil Diubah');
    }
}
