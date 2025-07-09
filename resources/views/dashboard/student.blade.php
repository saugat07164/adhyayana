<x-app-layout>
    <x-slot name="header">Student Dashboard</x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-lg shadow text-center">
                    <div class="text-2xl font-bold">{{ \App\Models\Enrollment::where('user_id', auth()->id())->count() }}</div>
                    <div class="text-gray-600">My Enrollments</div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow text-center">
                    <div class="text-2xl font-bold">{{ \App\Models\Enrollment::where('user_id', auth()->id())->where('status', 'completed')->count() }}</div>
                    <div class="text-gray-600">Completed Courses</div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow text-center">
                    <div class="text-2xl font-bold">{{ \App\Models\UserBadge::where('user_id', auth()->id())->count() }}</div>
                    <div class="text-gray-600">My Badges</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
