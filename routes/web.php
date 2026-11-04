<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentRegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->isAdmin() ? redirect()->route('admin.dashboard') : redirect()->route('student.details.edit');
    }
    return redirect()->route('register');
});

// Student Public Registration
Route::get('/register', [StudentRegistrationController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [StudentRegistrationController::class, 'register'])->name('register.store');

// Student & Admin Login / Logout
Route::get('/login', [StudentRegistrationController::class, 'showLoginForm'])->name('login');
Route::post('/login', [StudentRegistrationController::class, 'login'])->name('login.store');
Route::post('/logout', [StudentRegistrationController::class, 'logout'])->name('logout');

// Student Protected Portal Routes
Route::middleware('auth')->group(function () {
    Route::get('/student/details', [StudentRegistrationController::class, 'edit'])->name('student.details.edit');
    Route::post('/student/details', [StudentRegistrationController::class, 'update'])->name('student.details.update');

    // Fee Voucher / Challan (Invoice Report)
    Route::get('/student/challan', [StudentRegistrationController::class, 'showChallan'])->name('student.challan');

    // Fee Payment & Receipt / Voucher Upload
    Route::get('/student/payment', [StudentRegistrationController::class, 'showPayment'])->name('student.payment');
    Route::post('/student/pay-online', [StudentRegistrationController::class, 'payOnline'])->name('student.payOnline');
    Route::post('/student/upload-receipt', [StudentRegistrationController::class, 'uploadReceipt'])->name('student.uploadReceipt');
});

// Super Admin Protected Routes (Super Rights: Fee Structure, Permissions, Payment Approvals)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/students', [AdminController::class, 'students'])->name('students');
    Route::get('/students/{id}', [AdminController::class, 'show'])->name('students.show');
    Route::post('/students/{id}/approve', [AdminController::class, 'approvePayment'])->name('students.approve');
    Route::post('/students/{id}/pending', [AdminController::class, 'markPendingPayment'])->name('students.pending');
    Route::post('/students/{id}/reject', [AdminController::class, 'rejectPayment'])->name('students.reject');
    Route::post('/students/{id}/status', [AdminController::class, 'updateStatus'])->name('students.status');
    Route::post('/students/{id}/update-fee', [AdminController::class, 'updateFeeStructure'])->name('students.updateFee');

    // Convocation Master Settings & Focal Persons (Database Configuration)
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
    Route::get('/focal-persons/{id}', [AdminController::class, 'getFocalPerson'])->name('focalPersons.get');
    Route::post('/focal-persons', [AdminController::class, 'saveFocalPerson'])->name('focalPersons.save');
    Route::delete('/focal-persons/{id}', [AdminController::class, 'deleteFocalPerson'])->name('focalPersons.delete');
});

