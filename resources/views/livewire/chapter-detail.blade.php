<x-slot name="header">
    <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
        {{ __('Chapter Details: ') }} {{ $chapter->title }}
    </h2>
</x-slot>

<div class="py-12 bg-gray-100 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-md sm:rounded-lg p-6">
            <h3 class="text-xl font-bold mb-4 text-gray-800">{{ $chapter->title }}</h3>

            {{-- Video Player Section --}}
            @if ($chapter->video_url)
                <div class="mb-6">
                    <h4 class="font-semibold text-lg text-gray-800 mb-3">Video Content</h4>
                    {{-- Responsive video container --}}
                    <div class="relative" style="padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 0.5rem;">
                        <iframe
                            src="{{ $chapter->video_url }}"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen
                            class="absolute top-0 left-0 w-full h-full rounded-md shadow-lg"
                        ></iframe>
                    </div>
                </div>
            @endif

            {{-- Chapter Content Section --}}
            @if ($chapter->content)
                <div class="mb-6">
                    <h4 class="font-semibold text-lg text-gray-800 mb-3">{{ $chapter->title}}</h4>
                    <div class="prose max-w-none text-gray-700 leading-relaxed">
                        {{-- Using Blade's {!! !!} to render raw HTML if content is stored as rich text --}}
                        {!! nl2br(e($chapter->content)) !!}
                    </div>
                </div>
            @else
                <p class="text-gray-600 mb-4">No content available for this chapter.</p>
            @endif

            <div class="mt-6 flex flex-wrap gap-3">
                <a href="{{ route('units.show', ['course' => $course->id, 'unit' => $unit->id]) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Back to Unit: {{ $unit->title }}
                </a>
                <a href="{{ route('courses.show', $course->id) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Back to Course: {{ $course->title }}
                </a>
            </div>
        </div>
    </div>
</div>