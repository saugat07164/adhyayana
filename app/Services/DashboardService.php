<?php

namespace App\Services;

use App\Models\User;

class DashboardService
{
    public static function getDashboardRoute(User $user): string
    {
        return match ($user->primary_role) {
            'admin' => route('dashboard.admin', absolute: false),
            'staff' => route('dashboard.staff', absolute: false),
            'instructor' => route('dashboard.instructor', absolute: false),
            'student' => route('dashboard.student', absolute: false),
            'support' => route('dashboard.support', absolute: false),
            'visitor' => route('dashboard.visitor', absolute: false),
            default => route('dashboard', absolute: false),
        };
    }

    public static function getDashboardRouteName(User $user): string
    {
        return match ($user->primary_role) {
            'admin' => 'dashboard.admin',
            'staff' => 'dashboard.staff',
            'instructor' => 'dashboard.instructor',
            'student' => 'dashboard.student',
            'support' => 'dashboard.support',
            'visitor' => 'dashboard.visitor',
            default => 'dashboard',
        };
    }
} 