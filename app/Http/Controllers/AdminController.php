<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Transaksi;

class AdminController extends Controller
{
    public function tambahUser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,bank_mini,siswa',
        ]);

        User::create([
            'name' => $request->name,  // gunakan 'name' bukan 'nama'
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);
        

        return redirect()->back()->with('success', 'User berhasil ditambahkan!');
}

public function showUsers()
{
    $users = User::all(); // Ambil semua user dari database
    return view('dashboard.admin', compact('users')); // Kirim data ke view
}

}