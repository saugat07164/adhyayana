<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed roles first
        $this->call(RoleSeeder::class);

        // Create test users with roles
        $adminUser = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);
        $adminRole = Role::where('name', 'admin')->first();
        $adminUser->roles()->attach($adminRole->id);

        $instructorUser = User::factory()->create([
            'name' => 'Instructor User',
            'email' => 'instructor@example.com',
        ]);
        $instructorRole = Role::where('name', 'instructor')->first();
        $instructorUser->roles()->attach($instructorRole->id);

        $studentUser = User::factory()->create([
            'name' => 'Student User',
            'email' => 'student@example.com',
        ]);
        $studentRole = Role::where('name', 'student')->first();
        $studentUser->roles()->attach($studentRole->id);

        $visitorUser = User::factory()->create([
            'name' => 'Visitor User',
            'email' => 'visitor@example.com',
        ]);
        $visitorRole = Role::where('name', 'visitor')->first();
        $visitorUser->roles()->attach($visitorRole->id);
    }
}
