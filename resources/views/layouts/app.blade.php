<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
@livewireStyles
        <link href="/css/output.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 relative" x-data="{ sidebarOpen: false }">

            <!-- Sidebar Open Button -->
            <button
                class="fixed top-1/2 -translate-y-1/2 left-0 p-3 bg-blue-600 text-white rounded-r-full shadow-lg hover:bg-blue-700 z-50"
                @click="sidebarOpen = true"
                x-show="!sidebarOpen"
                x-transition
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>

            <!-- Sidebar -->
            <div
                class="fixed top-0 left-0 h-full w-64 bg-blue-900 bg-opacity-80 text-white shadow-xl z-50 rounded-r-lg backdrop-blur-sm overflow-y-auto"
                x-show="sidebarOpen"
                @click.away="sidebarOpen = false"
                x-transition
            >
                <div class="p-6 relative">
                    <!-- Close button -->
                    <button class="absolute top-4 right-4" @click="sidebarOpen = false">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <h2 class="text-2xl font-bold mb-6 mt-4">Dashboard Menu</h2>
                    <nav>
                        <ul class="space-y-2">
                            @php
                                $dashboardRoute = 'dashboard'; // fallback
                                if (auth()->user()?->hasRole('admin')) {
                                    $dashboardRoute = 'dashboard.admin';
                                } elseif (auth()->user()?->hasRole('staff')) {
                                    $dashboardRoute = 'dashboard.staff';
                                } elseif (auth()->user()?->hasRole('instructor')) {
                                    $dashboardRoute = 'dashboard.instructor';
                                } elseif (auth()->user()?->hasRole('student')) {
                                    $dashboardRoute = 'dashboard.student';
                                } elseif (auth()->user()?->hasRole('support')) {
                                    $dashboardRoute = 'dashboard.support';
                                } elseif (auth()->user()?->hasRole('visitor')) {
                                    $dashboardRoute = 'dashboard.visitor';
                                }
                            @endphp
                            
                            <li>
                                <a href="{{ route($dashboardRoute) }}" 
                                   class="flex items-center p-3 rounded-lg hover:bg-white hover:bg-opacity-20 transition-colors"
                                   wire:navigate>
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z" />
                                    </svg>
                                    Dashboard
                                </a>
                            </li>
                            
                            <li>
                                <a href="{{ route('profile') }}" 
                                   class="flex items-center p-3 rounded-lg hover:bg-white hover:bg-opacity-20 transition-colors"
                                   wire:navigate>
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Profile
                                </a>
                            </li>
                            
                            @php $user = auth()->user(); @endphp
                            @if($user)
                                @if($user->hasRole('admin') || $user->hasRole('staff') || $user->hasRole('instructor'))
                                <!-- Courses Group -->
                                <li x-data="{ open: false }">
                                    <button @click="open = !open" class="flex items-center w-full p-3 rounded-lg hover:bg-white hover:bg-opacity-20 transition-colors focus:outline-none">
                                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                        Courses
                                        <svg :class="{'rotate-90': open}" class="w-4 h-4 ml-auto transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </button>
                                    <ul x-show="open" class="ml-6 space-y-1">
                                        <li><a href="/courses" class="block p-2 rounded hover:bg-white hover:bg-opacity-10">Browse Courses</a></li>
                                        <li><a href="/livewire/category-crud" class="block p-2 rounded hover:bg-white hover:bg-opacity-10">Categories</a></li>
                                        @if($user->hasRole('instructor'))<li><a href="/livewire/course-crud?my=1" class="block p-2 rounded hover:bg-white hover:bg-opacity-10">My Courses</a></li>@endif
                                        @if($user->hasRole('admin') || $user->hasRole('staff'))
                                        <li><a href="/livewire/certificate-crud" class="block p-2 rounded hover:bg-white hover:bg-opacity-10">Certificates</a></li>
                                        <li><a href="/livewire/badge-crud" class="block p-2 rounded hover:bg-white hover:bg-opacity-10">Badges</a></li>
                                        <li><a href="/livewire/coupon-crud" class="block p-2 rounded hover:bg-white hover:bg-opacity-10">Coupons</a></li>
                                        @endif
                                    </ul>
                                </li>
                                @endif
                                @if($user->hasRole('admin') || $user->hasRole('staff'))
                                <!-- Course Builder Group -->
                                <li x-data="{ open: false }">
                                    <button @click="open = !open" class="flex items-center w-full p-3 rounded-lg hover:bg-white hover:bg-opacity-20 transition-colors focus:outline-none">
                                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                        </svg>
                                        Course Builder
                                        <svg :class="{'rotate-90': open}" class="w-4 h-4 ml-auto transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </button>
                                    <ul x-show="open" class="ml-6 space-y-1">
                                        <li> <a href="{{ route('chapter-crud') }}" class="block p-2 rounded hover:bg-white hover:bg-opacity-10">Chapters</a></li>
                                        <li><a href="{{ route('unit-crud') }}" class="block p-2 rounded hover:bg-white hover:bg-opacity-10">Units</a></li>
                                    </ul>
                                </li>
                                @endif
                                @if($user->hasRole('admin') || $user->hasRole('staff'))
                                <!-- Progress Tracker Group -->
                                <li x-data="{ open: false }">
                                    <button @click="open = !open" class="flex items-center w-full p-3 rounded-lg hover:bg-white hover:bg-opacity-20 transition-colors focus:outline-none">
                                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 17a4 4 0 008 0M5 21h14" />
                                        </svg>
                                        Progress Tracker
                                        <svg :class="{'rotate-90': open}" class="w-4 h-4 ml-auto transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </button>
                                    <ul x-show="open" class="ml-6 space-y-1">
                                        <li><a href="/livewire/enrollment-crud" class="block p-2 rounded hover:bg-white hover:bg-opacity-10">Enrollments</a></li>
                                        <li><a href="/livewire/user-badge-crud" class="block p-2 rounded hover:bg-white hover:bg-opacity-10">User Badges</a></li>
                                        <li><a href="/dashboard/analytics" class="block p-2 rounded hover:bg-white hover:bg-opacity-10">Progress Overview</a></li>
                                    </ul>
                                </li>
                                @endif
                                @if($user->hasRole('admin'))
                                <!-- Management Group -->
                                <li x-data="{ open: false }">
                                    <button @click="open = !open" class="flex items-center w-full p-3 rounded-lg hover:bg-white hover:bg-opacity-20 transition-colors focus:outline-none">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Management
                                        <svg :class="{'rotate-90': open}" class="w-4 h-4 ml-auto transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                    </button>
                                    <ul x-show="open" class="ml-6 space-y-1">
                                        <li><a href="{{ route('admin.users.index') }}" class="block p-2 rounded hover:bg-white hover:bg-opacity-10">Users</a></li>
                                        <li><a href="{{ route('admin.roles.index') }}" class="block p-2 rounded hover:bg-white hover:bg-opacity-10">Roles</a></li>
                                        <li><a href="/livewire/notification-crud" class="block p-2 rounded hover:bg-white hover:bg-opacity-10">Notifications</a></li>
                                    </ul>
                            </li>
                                @endif
                                <!-- Student Tools -->
                                @if($user->hasRole('student'))
                                <li x-data="{ open: false }">
                                    <button @click="open = !open" class="flex items-center w-full p-3 rounded-lg hover:bg-white hover:bg-opacity-20 transition-colors focus:outline-none">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                        My Learning
                                        <svg :class="{'rotate-90': open}" class="w-4 h-4 ml-auto transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                    </button>
                                    <ul x-show="open" class="ml-6 space-y-1">
                                        <li><a href="/my/enrollments" class="block p-2 rounded hover:bg-white hover:bg-opacity-10">My Enrollments</a></li>
                                        <li><a href="/my/progress" class="block p-2 rounded hover:bg-white hover:bg-opacity-10">My Progress</a></li>
                                    </ul>
                            </li>
                                @endif
                            @endif
                        </ul>
                    </nav>
                </div>
            </div>

            <!-- Breeze Navigation -->
            <livewire:layout.navigation />

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        @livewireScripts
    </body>
</html>
