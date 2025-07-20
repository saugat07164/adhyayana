<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Admin Dashboard') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 flex items-center">
                    {{-- Font Awesome Users Icon --}}
                    <i class="fa-solid fa-users h-8 w-8 text-blue-600 flex-shrink-0"></i>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Users</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $userCount }}</dd>
                        </dl>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 flex items-center">
                    {{-- Font Awesome Book Icon --}}
                    <i class="fa-solid fa-book h-8 w-8 text-green-600 flex-shrink-0"></i>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Courses</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $courseCount }}</dd>
                        </dl>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 flex items-center">
                    {{-- Font Awesome Clock Icon --}}
                    <i class="fa-solid fa-clock h-8 w-8 text-yellow-600 flex-shrink-0"></i>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Pending Approvals</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $pendingApprovals }}</dd>
                        </dl>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 flex items-center">
                    {{-- Font Awesome Dollar Sign Icon --}}
                    <i class="fa-solid fa-dollar-sign h-8 w-8 text-purple-600 flex-shrink-0"></i>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Revenue</dt>
                            <dd class="text-lg font-medium text-gray-900">${{ number_format($totalRevenue, 2) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Pending Course Approvals</h3>
                    <a href="#" class="text-blue-600 hover:text-blue-800 text-sm font-medium">View All</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50"> ... </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($pendingCourses ?? [] as $course)
                                {{-- Show pending course rows --}}
                            @empty
                                <tr><td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">No pending courses.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

 <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                {{-- TODO: Replace with functional links or Livewire emits --}}
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('courses.crud') }}" class="bg-indigo-600 text-white px-4 py-2 rounded shadow hover:bg-indigo-700">Add New Course</a>
                    <a href="#" class="bg-green-600 text-white px-4 py-2 rounded shadow hover:bg-green-700">Verify Payments</a>
                    <a href="{{ route('admin.roles.index') }}" class="bg-yellow-500 text-white px-4 py-2 rounded shadow hover:bg-yellow-600">Manage Roles</a>
                    <a href="{{ route('admin.users.index') }}"  class="bg-gray-800 text-white px-4 py-2 rounded shadow hover:bg-gray-900">Manage Users</a>
                </div>
            </div>
        </div>
        
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Users</h3>
                <div class="space-y-4">
                    @forelse ($recentUsers ?? [] as $user)
                        {{-- Display recent user --}}
                    @empty
                        <p class="text-sm text-gray-500">No recent users.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">System Health</h3>
                {{-- TODO: Replace with actual server health data --}}
                <ul class="space-y-2 text-sm text-gray-700">
                    <li>Uptime: <span class="font-medium">Running</span></li>
                    <li>Database Status: <span class="font-medium text-green-600">Connected</span></li>
                    <li>Queue Worker: <span class="font-medium text-yellow-500">Idle</span></li>
                    <li>Cache: <span class="font-medium text-blue-500">OK</span></li>
                    <li>Disk Space: <span class="font-medium">Enough</span></li>
                </ul>
            </div>
        </div>

       

    </div>
</div>