<x-slot name="header">
    <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
        {{ __('Course Instructor Assignment') }}
    </h2>
</x-slot>

<div class="py-12 bg-gray-100 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="p-6 bg-white shadow rounded-md">
            {{-- Success/Error Message --}}
            @if (session()->has('message'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
                    <span class="block sm:inline">{!! session('message') !!}</span>
                </div>
            @endif

            <h3 class="text-xl font-bold mb-6 text-gray-800">Assign Instructors to Courses</h3>

            <table class="min-w-full table-auto border border-gray-300 rounded-md overflow-hidden">
                <thead class="bg-gray-100 text-gray-700 uppercase text-sm">
                    <tr>
                        <th class="px-4 py-2 border">SN</th>
                        <th class="px-4 py-2 border">Course ID</th>
                        <th class="px-4 py-2 border">Title</th>
                        <th class="px-4 py-2 border">Current Instructor</th>
                        <th class="px-4 py-2 border">Assign New Instructor</th>
                        <th class="px-4 py-2 border">Action</th>
                    </tr>
                </thead>

                <tbody class="text-gray-800 text-sm divide-y divide-gray-200">
                    @forelse($courses as $course)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-2 border text-center">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2 border text-center">{{ $course->id }}</td>
                            <td class="px-4 py-2 border">{{ $course->title }}</td>
                            <td class="px-4 py-2 border text-center">
                                {{ $course->instructor->name ?? 'Unassigned' }}
                            </td>

                            <td class="px-4 py-2 border text-center">
                                <select
                                    wire:model.defer="courseInstructors.{{ $course->id }}"
                                    class="border rounded px-4 py-1 w-full max-w-xs"
                                >
                                    <option value="">-- Select Instructor --</option>
                                    @foreach($instructors as $instructor)
                                        <option value="{{ $instructor->id }}">{{ $instructor->name }}</option>
                                    @endforeach
                                </select>
                            </td>

                            <td class="px-4 py-2 border text-center">
                                <button
                                    wire:click="updateCourseInstructor({{ $course->id }})"
                                    class="bg-blue-500 hover:bg-blue-600 text-white text-sm px-3 py-1 rounded shadow-sm"
                                >
                                    Update
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-4 text-center text-gray-500 italic">
                                No courses found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-6">
                <a href="{{ route('courses.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-semibold transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Course Management
                </a>
            </div>
        </div>
    </div>
</div>
