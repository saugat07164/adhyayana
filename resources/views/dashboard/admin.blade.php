<x-app-layout>
    <x-slot name="header">Admin Dashboard</x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-lg shadow text-center">
                    <div class="text-2xl font-bold">{{ \App\Models\User::count() }}</div>
                    <div class="text-gray-600">Total Users</div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow text-center">
                    <div class="text-2xl font-bold">{{ \App\Models\Course::count() }}</div>
                    <div class="text-gray-600">Total Courses</div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow text-center">
                    <div class="text-2xl font-bold">{{ \App\Models\Enrollment::count() }}</div>
                    <div class="text-gray-600">Total Enrollments</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
