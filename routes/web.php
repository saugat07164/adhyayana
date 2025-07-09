<?php
use Livewire\Livewire;
use Illuminate\Support\Facades\Route;
use App\Livewire\UserCrud;
use App\Livewire\RoleCrud;
use App\Livewire\AdminDashboard;
Route::view('/', 'welcome');

// Routes that require authentication and verification
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
    $role = auth()->user()->getRoleNames()->first(); // or custom logic
    return match ($role) {
        'admin' => redirect()->route('dashboard.admin'),
        'staff' => redirect()->route('dashboard.staff'),
        'instructor' => redirect()->route('dashboard.instructor'),
        'student' => redirect()->route('dashboard.student'),
        'support' => redirect()->route('dashboard.support'),
        'visitor' => redirect()->route('dashboard.visitor'),
        default => view('dashboard.default')
    };
});

Route::get('/dashboard/admin', AdminDashboard::class)
        ->middleware('role:admin')
        ->name('dashboard.admin');
    // Dashboard routes that also require specific roles
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