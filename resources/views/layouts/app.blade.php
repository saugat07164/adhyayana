<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        @livewireStyles
        <link href="/css/output.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 relative" x-data="{ sidebarOpen: false }">

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

            <div
                class="fixed top-0 left-0 h-full w-72 bg-blue-900 bg-opacity-80 text-white shadow-xl z-50 rounded-r-lg backdrop-blur-sm overflow-y-auto"
                x-show="sidebarOpen"
                @click.away="sidebarOpen = false"
                x-transition
            >
                <div class="p-6 relative">
                    <button class="absolute top-4 right-4" @click="sidebarOpen = false">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <div class="text-center mb-6 mt-4">
                        <img src="{{ asset('build/assets/images/transparent_small.png') }}"alt="Organization Logo" class="mx-auto h-16 w-16 mb-2 rounded-full shadow-lg">
                        <p class="text-sm text-gray-300 italic font-semibold">"Empowering Minds"</p>
                    </div>

                    <h2 class="text-2xl font-bold mb-6">Adhyayana Menu</h2>
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

                            @auth
    @if(auth()->user()->hasRole('admin'))
        <li>
            <a href="{{ route('contactmessages.index') }}"
               class="flex items-center p-3 rounded-lg hover:bg-white hover:bg-opacity-20 transition-colors"
               wire:navigate>
               <i class="fa-solid fa-paper-plane mr-3"></i>
               Contact Messages
            </a>
        </li>
    @endif
@endauth

                            
                            @php $user = auth()->user(); @endphp
                            @if($user)
                                @if($user->hasRole('admin') || $user->hasRole('staff') || $user->hasRole('instructor'))
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
  <li class="flex items-center justify-between">
    <a href="{{ route('courses.crud') }}" class="p-2 rounded hover:bg-white hover:bg-opacity-10 flex-1">
      Browse Courses
    </a>
  </li>
  
  <li class="flex items-center justify-between">
    <a href="{{ route('courses.categories') }}" class="p-2 rounded hover:bg-white hover:bg-opacity-10 flex-1">
      Categories
    </a>
  </li>
  
  @if($user->hasRole('instructor'))
  <li class="flex items-center justify-between">
    <a href="/livewire/course-crud?my=1" class="p-2 rounded hover:bg-white hover:bg-opacity-10 flex-1">
      My Courses
    </a>
    <span class="ml-2 text-xs font-semibold text-yellow-300 bg-yellow-800 bg-opacity-20 px-2 py-0.5 rounded-full animate-pulse shadow-sm border border-yellow-400">
      🚧 Soon
    </span>
  </li>
  @endif
  
  @if($user->hasRole('admin') || $user->hasRole('staff'))
  <li class="flex items-center justify-between">
    <a href="/livewire/certificate-crud" class="p-2 rounded hover:bg-white hover:bg-opacity-10 flex-1">
      Certificates
    </a>
    <span class="ml-2 text-xs font-semibold text-yellow-300 bg-yellow-800 bg-opacity-20 px-2 py-0.5 rounded-full animate-pulse shadow-sm border border-yellow-400">
      🚧 Soon
    </span>
  </li>
  
  <li class="flex items-center justify-between">
    <a href="/livewire/badge-crud" class="p-2 rounded hover:bg-white hover:bg-opacity-10 flex-1">
      Badges
    </a>
    <span class="ml-2 text-xs font-semibold text-yellow-300 bg-yellow-800 bg-opacity-20 px-2 py-0.5 rounded-full animate-pulse shadow-sm border border-yellow-400">
      🚧 Soon
    </span>
  </li>
  
  <li class="flex items-center justify-between">
    <a href="/livewire/coupon-crud" class="p-2 rounded hover:bg-white hover:bg-opacity-10 flex-1">
      Coupons
    </a>
    <span class="ml-2 text-xs font-semibold text-yellow-300 bg-yellow-800 bg-opacity-20 px-2 py-0.5 rounded-full animate-pulse shadow-sm border border-yellow-400">
      🚧 Soon
    </span>
  </li>
  @endif
</ul>

                                </li>
                                @endif
                                @if($user->hasRole('admin') || $user->hasRole('staff'))
                                <li x-data="{ open: false }">
<button @click="open = !open" class="flex items-center w-full p-3 rounded-lg hover:bg-white hover:bg-opacity-20 transition-colors focus:outline-none">
    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37a1.724 1.724 0 002.572-1.065zM12 15a3 3 0 100-6 3 3 0 000 6z" />
    </svg>
    Course Builder
    <svg :class="{'rotate-90': open}" class="w-4 h-4 ml-auto transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
    </svg>
</button>
                                    <ul x-show="open" class="ml-6 space-y-1">
                                        <li> <a href="{{ route('chapter-crud') }}" class="block p-2 rounded hover:bg-white hover:bg-opacity-10">Chapters</a></li>
                                        <li><a href="{{ route('unit-crud') }}" class="block p-2 rounded hover:bg-white hover:bg-opacity-10">Units</a></li>
                                        <li><a href="{{ route('courses.status') }}" class="block p-2 rounded hover:bg-white hover:bg-opacity-10">Set Course Status</a></li>
                                        <li><a href="{{ route('courses.instructor.assign') }}" class="block p-2 rounded hover:bg-white hover:bg-opacity-10">Set Course Instructor</a></li>
                                    </ul>
                                </li>
                                @endif
                                @if($user->hasRole('admin') || $user->hasRole('staff'))
                                <li x-data="{ open: false }">
                                  <button @click="open = !open" class="flex items-center w-full p-3 rounded-lg hover:bg-white hover:bg-opacity-20 transition-colors focus:outline-none">
    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M18 10V6M6 18h.01M18 18h.01M6 14h.01M18 14h.01M12 18h.01M12 14h.01M9 10h.01M15 10h.01M3 21h18a1 1 0 001-1V4a1 1 0 00-1-1H3a1 1 0 00-1 1v16a1 1 0 001 1z" />
    </svg>
    Progress Tracker
    <svg :class="{'rotate-90': open}" class="w-4 h-4 ml-auto transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
    </svg>
</button>
                                    <ul x-show="open" class="ml-6 space-y-1">
  <li class="flex items-center justify-between">
    <a href="/livewire/enrollment-crud" class="p-2 rounded hover:bg-white hover:bg-opacity-10 flex-1">
      Enrollments
    </a>
    <span class="ml-2 text-xs font-semibold text-yellow-300 bg-yellow-800 bg-opacity-20 px-2 py-0.5 rounded-full animate-pulse shadow-sm border border-yellow-400">
      🚧 Soon
    </span>
  </li>
  <li class="flex items-center justify-between">
    <a href="/livewire/user-badge-crud" class="p-2 rounded hover:bg-white hover:bg-opacity-10 flex-1">
      User Badges
    </a>
    <span class="ml-2 text-xs font-semibold text-yellow-300 bg-yellow-800 bg-opacity-20 px-2 py-0.5 rounded-full animate-pulse shadow-sm border border-yellow-400">
      🚧 Soon
    </span>
  </li>
  <li class="flex items-center justify-between">
    <a href="/dashboard/analytics" class="p-2 rounded hover:bg-white hover:bg-opacity-10 flex-1">
      Progress Overview
    </a>
    <span class="ml-2 text-xs font-semibold text-yellow-300 bg-yellow-800 bg-opacity-20 px-2 py-0.5 rounded-full animate-pulse shadow-sm border border-yellow-400">
      🚧 Soon
    </span>
  </li>
</ul>

                                </li>
                                @endif
                                @if($user->hasRole('admin'))
                                <li x-data="{ open: false }">
<button @click="open = !open" class="flex items-center w-full p-3 rounded-lg hover:bg-white hover:bg-opacity-20 transition-colors focus:outline-none">
    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
    </svg>
    Management
    <svg :class="{'rotate-90': open}" class="w-4 h-4 ml-auto transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
    </svg>
</button>
                                    <ul x-show="open" class="ml-6 space-y-1">
                                        <li><a href="{{ route('admin.users.index') }}" class="block p-2 rounded hover:bg-white hover:bg-opacity-10">Users</a></li>
                                        <li><a href="{{ route('admin.roles.index') }}" class="block p-2 rounded hover:bg-white hover:bg-opacity-10">Roles</a></li>
                                        <li><a href="/livewire/notification-crud" class="block p-2 rounded hover:bg-white hover:bg-opacity-10">Notifications</a><span class="ml-2 text-xs font-semibold text-yellow-300 bg-yellow-800 bg-opacity-20 px-2 py-0.5 rounded-full animate-pulse shadow-sm border border-yellow-400">
      🚧 Soon
    </span></li>
                                    </ul>
                            </li>
                                @endif
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
                                        <li><a href="/my/enrollments" class="block p-2 rounded hover:bg-white hover:bg-opacity-10">My Enrollments</a><span class="ml-2 text-xs font-semibold text-yellow-300 bg-yellow-800 bg-opacity-20 px-2 py-0.5 rounded-full animate-pulse shadow-sm border border-yellow-400">
      🚧 Soon
    </span></li>
                                        <li><a href="/my/progress" class="block p-2 rounded hover:bg-white hover:bg-opacity-10">My Progress</a><span class="ml-2 text-xs font-semibold text-yellow-300 bg-yellow-800 bg-opacity-20 px-2 py-0.5 rounded-full animate-pulse shadow-sm border border-yellow-400">
      🚧 Soon
    </span></li>
                                    </ul>
                            </li>
                                @endif
                            @endif
                        </ul>
                    </nav>
                </div>
            </div>

            <livewire:layout.navigation />

            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <main>
                {{ $slot }}
            </main>
        </div>
        @livewireScripts
    </body>
</html>