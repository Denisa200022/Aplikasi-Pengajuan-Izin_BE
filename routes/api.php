<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VerifierController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Rute untuk otentikasi
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [UserController::class, 'register'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

// Rute untuk admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/users', [AdminController::class, 'getAllUsers']);
    Route::post('/verifiers', [AdminController::class, 'addVerifier']);
    Route::put('/users/{user_id}/verifier', [AdminController::class, 'makeVerifier']);
    Route::get('/leave-applications', [AdminController::class, 'getAllLeaveApplications']);
    Route::put('/users/{user_id}/reset-password', [AdminController::class, 'resetPassword']);
});

// Rute untuk verifikator
Route::middleware(['auth', 'verifikator'])->group(function () {
    Route::put('/verifiers/verify-registration', [VerifierController::class, 'verifyRegistration']);
    Route::put('/leave-applications/{leave_application_id}/approve', [VerifierController::class, 'approveLeaveApplication']);
    Route::put('/leave-applications/{leave_application_id}/reject', [VerifierController::class, 'rejectLeaveApplication']);
});

// Rute untuk user biasa
Route::middleware(['auth', 'user'])->group(function () {
    Route::post('/leave-applications', [UserController::class, 'applyForLeave']);
    Route::get('/leave-applications', [UserController::class, 'getLeaveApplications']);
    Route::get('/leave-applications/{leave_application_id}/status', [UserController::class, 'getLeaveApplicationStatus']);
    Route::delete('/leave-applications/{leave_application_id}', [UserController::class, 'cancelLeaveApplication']);
    Route::delete('/leave-applications/{leave_application_id}', [UserController::class, 'deleteLeaveApplication']);
    Route::put('/update-password', [UserController::class, 'updatePassword']);
});

