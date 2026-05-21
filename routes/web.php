<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate']);
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'storeRegister']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Attendance
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('/attendance/create', [AttendanceController::class, 'create'])->name('attendance.create');
    Route::post('/attendance/check-in', [AttendanceController::class, 'checkIn'])->name('attendance.checkin');
    Route::post('/attendance/check-out', [AttendanceController::class, 'checkOut'])->name('attendance.checkout');
    Route::get('/attendance/report', [AttendanceController::class, 'report'])->name('attendance.report');

    // Permissions
    Route::resource('permissions', PermissionController::class)->except(['edit', 'update', 'destroy']);
    Route::post('/permissions/{permission}/approve', [PermissionController::class, 'approve'])->name('permissions.approve');

    // Announcements
    Route::resource('announcements', AnnouncementController::class)->middleware('role:admin,guru');

    // Admin only routes
    Route::middleware('role:admin')->group(function () {
        Route::resource('locations', LocationController::class);
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');
        Route::resource('users', UserController::class);
    });

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/pdf', [ReportController::class, 'exportPdf'])->name('reports.pdf');
    Route::get('/reports/excel', [ReportController::class, 'exportExcel'])->name('reports.excel');
});
