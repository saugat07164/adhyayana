<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\UserCrud;
use App\Livewire\RoleCrud;
Route::view('/', 'welcome');

// Routes that require authentication and verification
Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('/dashboard', 'dashboard.default')->name('dashboard');

    // Dashboard routes that also require specific roles
    Route::view('/dashboard/admin', 'dashboard.admin')->middleware('role:admin')->name('dashboard.admin');
    Route::view('/dashboard/staff', 'dashboard.staff')->middleware('role:staff')->name('dashboard.staff');
    Route::view('/dashboard/instructor', 'dashboard.instructor')->middleware('role:instructor')->name('dashboard.instructor');
    Route::view('/dashboard/student', 'dashboard.student')->middleware('role:student')->name('dashboard.student');
    Route::view('/dashboard/support', 'dashboard.support')->middleware('role:support')->name('dashboard.support');
    Route::view('/dashboard/visitor', 'dashboard.visitor')->middleware('role:visitor')->name('dashboard.visitor');
    Route::get('/admin/users', UserCrud::class)->name('admin.users.index');
    Route::get('/admin/roles', RoleCrud::class)->name('admin.roles.index');
    // LMS Routes (assuming these should also be authenticated)
    Route::get('/courses', function () {
        return view('courses.index');
    })->name('courses.index');

    Route::get('/courses/{course}', function ($course) {
        return view('courses.show');
    })->name('courses.show');

    // Profile route
    Route::view('profile', 'profile')->name('profile');
});

require __DIR__.'/auth.php';