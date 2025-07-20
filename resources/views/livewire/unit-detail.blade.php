<x-slot name="header">
    <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
        {{ __('Unit Details: ') }} {{ $unit->title }}
    </h2>
</x-slot>

<div class="py-12 bg-gray-100 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-md sm:rounded-lg p-6">
            <h3 class="text-xl font-bold mb-4 text-gray-800">{{ $unit->title }}</h3>
            <p class="text-gray-700 mb-4">{{ $unit->description }}</p>

            <h4 class="font-semibold text-lg text-gray-800 mt-6 mb-3">Chapters in this Unit:</h4>
            @if ($unit->chapters->count())
                <ul class="list-disc ml-6 space-y-2 text-gray-700">
                    @foreach ($unit->chapters as $chapter)
                        <li>
                            <a href="{{ route('chapters.show', ['course' => $course->id, 'unit' => $unit->id, 'chapter' => $chapter->id]) }}" class="text-indigo-600 hover:underline">
                                {{ $chapter->title }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-600">No chapters found for this unit.</p>
            @endif

            <div class="mt-6">
                <a href="{{ route('courses.show', $course->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Back to Course: {{ $course->title }}
                </a>
                <a href="{{ route('courses.index') }}" class="ml-3 inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Back to All Courses
                </a>
            </div>
        </div>
    </div>
</div>