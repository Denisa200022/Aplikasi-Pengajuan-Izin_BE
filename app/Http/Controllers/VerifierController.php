<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LeaveApplication;

class VerifierController extends Controller
{
    // Memverifikasi pendaftaran pengguna
    public function verifyRegistration(Request $request)
    {
        // Implementasi untuk memverifikasi pendaftaran pengguna
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:verifikator,email',
            'password' => 'required|string|min:8',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role = 'verifikator';
        $user->save();

        return response()->json(['message' => 'User registered successfully'], 201);
    }

    // ACC pengajuan izin
    public function approveLeaveApplication(Request $request, $leave_application_id)
    {
        $leaveApplication = LeaveApplication::findOrFail($leave_application_id);
        $leaveApplication->status = 'APPROVED';
        $leaveApplication->save();

        return response()->json(['message' => 'Leave application approved successfully'], 200);
    }

    // Penolakan pengajuan izin
    public function rejectLeaveApplication(Request $request, $leave_application_id)
    {
        $request->validate([
            'comment' => 'required|string',
        ]);

        $leaveApplication = LeaveApplication::findOrFail($leave_application_id);
        $leaveApplication->status = 'REJECTED';
        $leaveApplication->comment = $request->comment;
        $leaveApplication->save();

        return response()->json(['message' => 'Leave application rejected successfully'], 200);
    }
}
