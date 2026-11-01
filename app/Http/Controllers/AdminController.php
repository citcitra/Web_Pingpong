<?php

namespace App\Http\Controllers;

use App\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard', [
            'totalUsers' => User::count(),
            'totalAdmins' => User::where('role', 'admin')->count(),
            'totalMembers' => User::where('role', 'user')->count(),
        ]);
    }

    public function users(\Illuminate\Http\Request $request)
{
    $search = $request->input('search');

    $query = \App\User::query();

    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%')
              ->orWhere('email', 'like', '%' . $search . '%');
        });
    }

    $users = $query->orderBy('id', 'desc')
                   ->paginate(10)
                   ->appends(['search' => $search]);

    return view('admin.users', compact('users', 'search'));
}
    
public function updateRole(\Illuminate\Http\Request $request, $id)
{
    $request->validate([
        'role' => 'required|in:admin,user',
    ]);

    $user = \App\User::findOrFail($id);

    // Mencegah admin mengubah role akunnya sendiri
    if ($user->id == auth()->id()) {
        return redirect()
            ->route('admin.users')
            ->with('error', 'Role akun yang sedang digunakan tidak dapat diubah.');
    }

    $user->role = $request->role;
    $user->save();

    return redirect()
        ->route('admin.users')
        ->with('success', 'Role pengguna berhasil diperbarui.');
}
}