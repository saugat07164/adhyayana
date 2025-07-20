<x-slot name="header">
    <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
        {{ $course->title }}
    </h2>
</x-slot>

<div class="py-12 bg-gray-100 min-h-screen">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-md rounded-lg p-6 mb-8">
            {{-- Course Thumbnail --}}
            <img src="{{ $course->thumbnail_path ? Storage::url($course->thumbnail_path) : 'https://placehold.co/800x400/E5E7EB/4B5563?text=Course+Thumbnail' }}"
                 alt="{{ $course->title }}"
                 class="w-full h-64 object-cover rounded-lg mb-6 shadow-sm">

            {{-- Course Meta Info --}}
            <div class="mb-6 flex flex-wrap items-center gap-3">
                <span class="inline-flex items-center bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full">
                    <i class="fas fa-tag mr-2 text-xs"></i> {{ $course->category->name ?? 'Uncategorized' }}
                </span>
                <span class="inline-flex items-center text-sm font-medium px-3 py-1 rounded-full
                    {{ $course->is_free ? 'bg-green-100 text-green-800 line-through' : 'bg-gray-100 text-gray-800' }}">
                    <i class="fas fa-dollar-sign mr-2 text-xs"></i> 
                    {{ $course->price > 0 ? number_format($course->price, 2) : 'Free' }}
                </span>
                @if($course->instructor)
                    <span class="inline-flex items-center bg-purple-100 text-purple-800 text-sm font-medium px-3 py-1 rounded-full">
                        <i class="fas fa-chalkboard-teacher mr-2 text-xs"></i> {{ $course->instructor->name }}
                    </span>
                @endif
                <span class="inline-flex items-center bg-yellow-100 text-yellow-800 text-sm font-medium px-3 py-1 rounded-full">
                    <i class="fas fa-info-circle mr-2 text-xs"></i> Status: {{ ucfirst($course->status) }}
                </span>
            </div>

           

            {{-- Course Description --}}
            <h3 class="font-semibold text-xl text-gray-800 mb-3">Description</h3>
            <p class="text-gray-700 leading-relaxed mb-8">{{ $course->description }}</p>

            {{-- Course Units and Chapters Section --}}
            <h3 class="font-semibold text-xl text-gray-800 mb-4">Course Curriculum</h3>
            @if ($course->units->count())
                <div class="space-y-6">
                    @foreach ($course->units as $unit)
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 shadow-sm" x-data="{ unitOpen: false }">
                            <div class="flex justify-between items-center cursor-pointer" @click="unitOpen = !unitOpen">
                                <h4 class="font-semibold text-lg text-gray-800 flex items-center">
                                    <i class="fas mr-3 text-sm text-indigo-600" :class="unitOpen ? 'fa-chevron-down' : 'fa-chevron-right'"></i>
                                    {{ $unit->title }}
                                </h4>
                                <a href="{{ route('units.show', ['course' => $course->id, 'unit' => $unit->id]) }}"
                                   class="text-sm text-indigo-600 hover:underline flex items-center">
                                    View Unit <i class="fas fa-external-link-alt ml-1 text-xs"></i>
                                </a>
                            </div>

                            <div x-show="unitOpen"
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 -translate-y-2"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-200"
                                 x-transition:leave-start="opacity-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 -translate-y-2"
                                 class="mt-4 ml-8 border-l-2 border-gray-200 pl-4">
                                @if ($unit->chapters->count())
                                    <ul class="space-y-2 text-gray-700">
                                        @foreach ($unit->chapters as $chapter)
                                            <li class="flex justify-between items-center">
                                                <span class="flex items-center">
                                                    <i class="fas fa-file-alt mr-2 text-xs text-green-600"></i>
                                                    {{ $chapter->title }}
                                                    @if($chapter->duration_in_minutes > 0)
                                                        <span class="ml-2 text-xs text-gray-500">({{ $chapter->duration_in_minutes }} mins)</span>
                                                    @endif
                                                </span>
                                                <a href="{{ route('chapters.show', ['course' => $course->id, 'unit' => $unit->id, 'chapter' => $chapter->id]) }}"
                                                   class="text-xs text-green-600 hover:underline flex items-center">
                                                    View Chapter <i class="fas fa-external-link-alt ml-1 text-xs"></i>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-gray-600 text-sm">No chapters found for this unit.</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-600">No units or chapters have been added to this course yet.</p>
            @endif

            {{-- Action Buttons --}}
            @auth
                @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('instructor'))
                    <div class="flex gap-4 mt-8">
                        {{-- Link to edit the course using the CourseCrud Livewire component --}}
                        <a href="{{ route('courses.index', ['edit' => $course->id]) }}"
                           class="bg-yellow-500 hover:bg-yellow-600 transition-colors duration-200 text-white font-semibold px-5 py-2 rounded-lg shadow-md flex items-center">
                            <i class="fas fa-edit mr-2"></i> Edit Course
                        </a>
                        {{-- Delete action (will need to be handled by Livewire if using CourseCrud for deletion) --}}
                        <form action="{{ route('courses.index') }}" method="POST"
                              onsubmit="event.preventDefault(); if(confirm('Are you sure you want to delete this course? This action cannot be undone.')) { Livewire.dispatch('deleteCourse', { courseId: {{ $course->id }} }); }"
                              class="inline-block">
                            @csrf
                            @method('DELETE') {{-- This will be intercepted by Livewire.dispatch --}}
                            <button type="submit"
                                    class="bg-red-600 hover:bg-red-700 transition-colors duration-200 text-white font-semibold px-5 py-2 rounded-lg shadow-md flex items-center">
                                <i class="fas fa-trash-alt mr-2"></i> Delete Course
                            </button>
                        </form>
                    </div>
                @endif
            @endauth
            <br>
 {{-- Buy Now Button for visitor or student --}}
            @if(auth()->check() && (auth()->user()->hasRole('student') || auth()->user()->hasRole('visitor')))
                <div class="mb-6">
                    <a href="#"
                       class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg transition duration-200">
                        Buy Now
                    </a>
                </div>
            @endif
            {{-- Back to All Courses Link --}}
            <div class="mt-8">
                <a href="{{ route('courses.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-semibold transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i> Back to All Courses
                </a>
            </div>
        </div>
    </div>
</div>
