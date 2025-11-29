<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserRoleController extends Controller
{
    public function index()
    {
        // Menampilkan semua pengguna yang telah terverifikasi (email_verified_at tidak null)
        // dan belum diberi role selain 'guest'
        $users = User::whereNotNull('email_verified_at')
                    ->where('role', 'guest')  // Default role setelah verifikasi
                    ->orderBy('email_verified_at', 'desc')
                    ->paginate(10);

        return view('admin.user-role', compact('users'));
    }

    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:admin,bendahara,auditor,guest'
        ]);

        $user = User::findOrFail($id);
        
        // Hanya admin yang bisa mengganti role
        $user->role = $request->role;
        $user->save();

        return response()->json(['success' => true, 'message' => 'Role updated successfully']);
    }
    
    public function allUsers()
    {
        // Menampilkan semua pengguna untuk manajemen role
        $users = User::whereNotNull('email_verified_at')
                    ->orderBy('email_verified_at', 'desc')
                    ->paginate(15);

        return view('admin.all-users', compact('users'));
    }
}