<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\UserCrud;
use App\Livewire\RoleCrud;
use App\Livewire\AdminDashboard;
use App\Livewire\ChapterCrud;
use App\Livewire\UnitCrud;
use App\Livewire\CourseCrud;
use App\Livewire\CategoryCrud;
Route::view('/', 'welcome');
//Course Categories 
Route::get('/course-categories', CategoryCrud::class)->name('courses.categories');
Route::get('/course-categories/{category:slug}', CategoryCrud::class)->name('courses.categories.show');
// Routes that require authentication and verification
Route::middleware(['auth', 'verified'])->group(function () {

Route::get('/dashboard', function () {
    $role = auth()->user()->primary_role;

    return match ($role) {
        'admin'      => redirect()->route('dashboard.admin'),
        'staff'      => redirect()->route('dashboard.staff'),
        'instructor' => redirect()->route('dashboard.instructor'),
        'student'    => redirect()->route('dashboard.student'),
        'support'    => redirect()->route('dashboard.support'),
        'visitor'    => redirect()->route('dashboard.visitor'),
        default      => redirect()->route('dashboard.visitor'), // fallback
    };
})->name('dashboard');


    // Dashboard routes for specific roles
    Route::get('/dashboard/admin', AdminDashboard::class)
        ->middleware('role:admin')
        ->name('dashboard.admin');

    Route::view('/dashboard/staff', 'dashboard.staff')
        ->middleware('role:staff')
        ->name('dashboard.staff');

    Route::view('/dashboard/instructor', 'dashboard.instructor')
        ->middleware('role:instructor')
        ->name('dashboard.instructor');

    Route::view('/dashboard/student', 'dashboard.student')
        ->middleware('role:student')
        ->name('dashboard.student');

    Route::view('/dashboard/support', 'dashboard.support')
        ->middleware('role:support')
        ->name('dashboard.support');

    Route::view('/dashboard/visitor', 'dashboard.visitor')
        ->middleware('role:visitor')
        ->name('dashboard.visitor');

    // Admin User & Role CRUD
    Route::get('/admin/users', UserCrud::class)->name('admin.users.index');
    Route::get('/admin/roles', RoleCrud::class)->name('admin.roles.index');

    // LMS Course Routes
Route::get('/courses', CourseCrud::class)->name('courses.index');
Route::get('/courses/{course}', CourseCrud::class)->name('courses.show');




//Chapters and Units Routes

Route::get('/chapters', ChapterCrud::class)->name('chapter-crud');
Route::get('/units', UnitCrud::class)->name('unit-crud');

    // User Profile Page
    Route::view('/profile', 'profile')->name('profile');
});

require __DIR__.'/auth.php';
