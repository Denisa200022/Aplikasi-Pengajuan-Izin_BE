<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\LeaveApplication;

class AdminController extends Controller
{
    // Melihat semua user
    public function getAllUsers()
    {
        $users = User::all();

        return response()->json($users, 200);
    }

    // Menambahkan/mendaftarkan user verifikator
    public function addVerifier(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = 'verifikator';
        $user->save();

        return response()->json(['message' => 'Verifier added successfully'], 201);
    }

    // Mengubah status user biasa menjadi verifikator
    public function makeVerifier(Request $request, $user_id)
    {
        $user = User::findOrFail($user_id);
        $user->role = 'verifikator';
        $user->save();

        return response()->json(['message' => 'User role updated successfully'], 200);
    }

    // Melihat izin yang diajukan
    public function getAllLeaveApplications()
    {
        $leaveApplications = LeaveApplication::all();

        return response()->json($leaveApplications, 200);
    }

    // Reset password user
    public function resetPassword(Request $request, $user_id)
    {
        $request->validate([
            'password' => 'required|string|min:8',
        ]);

        $user = User::findOrFail($user_id);
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['message' => 'User password reset successfully'], 200);
    }
}
