<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $course->title }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-4xl mx-auto sm:px-6 lg:px-8 bg-white shadow rounded-lg p-6">
        <img src="{{ $course->thumbnail_url ?? 'https://via.placeholder.com/800x400?text=Course' }}" alt="{{ $course->title }}" class="w-full h-64 object-cover rounded mb-6">
        <div class="mb-4">
            <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">{{ $course->category->name ?? 'Uncategorized' }}</span>
            <span class="inline-block bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm ml-2">{{ $course->duration ?? 'N/A' }} mins</span>
            <span class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm ml-2">{{ $course->price > 0 ? '$'.number_format($course->price, 2) : 'Free' }}</span>
        </div>
        <p class="text-gray-700 mb-6">{{ $course->description }}</p>

        @auth
            @if(auth()->user()->hasRole('admin'))
                <div class="flex gap-4">
                    <a href="{{ route('livewire.course-crud', ['edit' => $course->id]) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded">Edit</a>
                    <form action="{{ route('livewire.course-crud', ['delete' => $course->id]) }}" method="POST" onsubmit="return confirm('Are you sure?');" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">Delete</button>
                    </form>
                </div>
            @endif
        @endauth

        <a href="{{ route('courses.index') }}" class="inline-block mt-6 text-indigo-600 hover:text-indigo-800 font-semibold">← Back to all courses</a>
    </div>
</x-app-layout>
