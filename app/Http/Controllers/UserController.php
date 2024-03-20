<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\LeaveApplication;

class UserController extends Controller
{
    // Mendaftar sebagai pengguna baru
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role = 'user';
        $user->save();

        return response()->json(['message' => 'User registered successfully'], 201);
    }

    // Mengajukan izin
    public function applyForLeave(Request $request)
    {
        $request->validate([
            'jenis_izin_id' => 'required|exists:jenis_izin,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan' => 'required|string',
        ]);

        $leaveApplication = new LeaveApplication();
        $leaveApplication->user_id = Auth::id();
        $leaveApplication->jenis_izin_id = $request->jenis_izin_id;
        $leaveApplication->tanggal_mulai = $request->tanggal_mulai;
        $leaveApplication->tanggal_selesai = $request->tanggal_selesai;
        $leaveApplication->alasan = $request->alasan;
        $leaveApplication->status = 'PENDING';
        $leaveApplication->save();

        return response()->json(['message' => 'Leave application submitted successfully'], 201);
    }

    // Melihat daftar izin yang pernah diajukan
    public function getLeaveApplications()
    {
        $leaveApplications = LeaveApplication::where('user_id', Auth::id())->get();

        return response()->json($leaveApplications, 200);
    }

    // Melihat status pengajuan izin
    public function getLeaveApplicationStatus($leave_application_id)
    {
        $leaveApplication = LeaveApplication::findOrFail($leave_application_id);

        return response()->json(['status' => $leaveApplication->status], 200);
    }

    // Membatalkan pengajuan izin
    public function cancelLeaveApplication($leave_application_id)
    {
        $leaveApplication = LeaveApplication::findOrFail($leave_application_id);
        $leaveApplication->delete();

        return response()->json(['message' => 'Leave application canceled successfully'], 200);
    }

    // Menghapus pengajuan izin
    public function deleteLeaveApplication($leave_application_id)
    {
        $leaveApplication = LeaveApplication::findOrFail($leave_application_id);
        $leaveApplication->delete();

        return response()->json(['message' => 'Leave application deleted successfully'], 200);
    }

    // Update password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8',
        ]);

        $user = User::findOrFail(Auth::id());
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json(['message' => 'Password updated successfully'], 200);
    }
}
