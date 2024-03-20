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
