<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Courses') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search and Filter Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row gap-4">
                        <div class="flex-1">
                            <input type="text" 
                                   placeholder="Search courses..." 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div class="flex gap-2">
                            <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">All Categories</option>
                                <option value="programming">Programming</option>
                                <option value="design">Design</option>
                                <option value="business">Business</option>
                            </select>
                            <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">All Levels</option>
                                <option value="beginner">Beginner</option>
                                <option value="intermediate">Intermediate</option>
                                <option value="advanced">Advanced</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Courses Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($courses as $course)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow duration-300">
                    <div class="relative">
                        <img src="{{ $course->thumbnail_url ?? 'https://via.placeholder.com/400x250/3B82F6/FFFFFF?text=Course' }}" 
                             alt="Course thumbnail" 
                             class="w-full h-48 object-cover">
                        <div class="absolute top-2 right-2">
                            <span class="bg-{{ $course->price > 0 ? 'red' : 'green' }}-500 text-white px-2 py-1 rounded-full text-xs font-semibold">
                                {{ $course->price > 0 ? '$' . number_format($course->price, 2) : 'Free' }}
                            </span>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center mb-2">
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">{{ $course->category->name ?? 'Uncategorized' }}</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $course->title }}</h3>
                        <p class="text-gray-600 text-sm mb-4">{{ $course->description }}</p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-sm text-gray-500">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                </svg>
                                {{ $course->students_count ?? '0' }} students
                            </div>
                            <div class="flex items-center text-sm text-gray-500">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                </svg>
                                {{ $course->duration ?? 'N/A' }}
                            </div>
                        </div>
                        <div class="mt-4 flex gap-2">
                            <a href="{{ route('courses.show', $course) }}" class="flex-1 bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors duration-200 text-center">View</a>
                            @if(auth()->user() && auth()->user()->hasRole('admin'))
                                <a href="{{ route('livewire.course-crud', ['edit' => $course->id]) }}" class="bg-yellow-500 text-white py-2 px-4 rounded-lg hover:bg-yellow-600 transition-colors duration-200">Edit</a>
                                <form action="{{ route('livewire.course-crud', ['delete' => $course->id]) }}" method="POST" onsubmit="return confirm('Delete this course?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 transition-colors duration-200">Delete</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-4 text-center text-gray-500">No courses found.</div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-8 flex justify-center">
                <nav class="flex items-center space-x-2">
                    <a href="#" class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                        Previous
                    </a>
                    <a href="#" class="px-3 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg">
                        1
                    </a>
                    <a href="#" class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                        2
                    </a>
                    <a href="#" class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                        3
                    </a>
                    <a href="#" class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                        Next
                    </a>
                </nav>
            </div>
        </div>
    </div>
</x-app-layout> 

{{--
Template for CRUD Blade views for all tables:
- index.blade.php: List all records
- create.blade.php: Form to create a new record
- edit.blade.php: Form to edit a record
- show.blade.php: Show details of a record
--}} 