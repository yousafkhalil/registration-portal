<?php

use App\Http\Controllers\Api\StudentRegistrationApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Student Registration & Profile APIs
|--------------------------------------------------------------------------
*/

// Public Authentication & Registration Endpoints
Route::post('/register', [StudentRegistrationApiController::class, 'register'])->name('api.register');
Route::post('/login', [StudentRegistrationApiController::class, 'login'])->name('api.login');

// Protected Student API Endpoints (Requires Bearer Sanctum Token)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/student/me', [StudentRegistrationApiController::class, 'me'])->name('api.student.me');
    Route::post('/student/update', [StudentRegistrationApiController::class, 'update'])->name('api.student.update');
    
    // Fee Challan & Payment APIs
    Route::get('/student/challan', [StudentRegistrationApiController::class, 'challan'])->name('api.student.challan');
    Route::post('/student/pay-online', [StudentRegistrationApiController::class, 'payOnline'])->name('api.student.payOnline');
    Route::post('/student/upload-receipt', [StudentRegistrationApiController::class, 'uploadReceipt'])->name('api.student.uploadReceipt');

    Route::post('/logout', [StudentRegistrationApiController::class, 'logout'])->name('api.logout');

    // Super Admin APIs
    Route::middleware('admin')->prefix('admin')->group(function () {
        Route::get('/stats', [\App\Http\Controllers\Api\AdminApiController::class, 'stats'])->name('api.admin.stats');
        Route::get('/students', [\App\Http\Controllers\Api\AdminApiController::class, 'students'])->name('api.admin.students');
        Route::get('/students/{id}', [\App\Http\Controllers\Api\AdminApiController::class, 'show'])->name('api.admin.students.show');
        Route::post('/students/{id}/approve', [\App\Http\Controllers\Api\AdminApiController::class, 'approve'])->name('api.admin.students.approve');
        Route::post('/students/{id}/reject', [\App\Http\Controllers\Api\AdminApiController::class, 'reject'])->name('api.admin.students.reject');
        Route::post('/students/{id}/update-fee', [\App\Http\Controllers\Api\AdminApiController::class, 'updateFeeStructure'])->name('api.admin.students.updateFee');
    });
});
