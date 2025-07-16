<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Chapter Management') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        {{-- Session Flash Message --}}
        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('message') }}</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer" onclick="this.parentElement.style.display='none'">
                    <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                </span>
            </div>
        @endif

        {{-- FORM --}}
        <div class="bg-white p-6 shadow rounded mb-8">
            <h3 class="text-lg font-bold mb-4">{{ $chapterId ? 'Edit Chapter' : 'Create New Chapter' }}</h3>

            <form wire:submit.prevent="saveChapter" class="space-y-4">
                {{-- Course Dropdown --}}
                <div>
                    <label class="block text-sm font-medium mb-1">Course</label>
                    <select wire:model.live="form_course_id" class="w-full border px-3 py-2 rounded">
                        <option value="">-- Select Course --</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->title }}</option>
                        @endforeach
                    </select>
                    @error('form_course_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Unit Dropdown --}}
                <div>
                    <label class="block text-sm font-medium mb-1">Unit</label>
                    <select wire:model="unit_id" wire:key="form_unit_select_{{ $form_course_id }}" class="w-full border px-3 py-2 rounded" required>
                        <option value="">-- Select Unit --</option>
                        @forelse($formUnits as $unit)
                            <option value="{{ $unit->id }}">{{ $unit->title }}</option>
                        @empty
                            <option disabled>No units available</option>
                        @endforelse
                    </select>
                    @error('unit_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Chapter Title</label>
                    <input type="text" wire:model="title" class="w-full border px-3 py-2 rounded" required>
                    @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Video URL</label>
                    <input type="url" wire:model="video_url" class="w-full border px-3 py-2 rounded">
                    @error('video_url') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Content</label>
                    <textarea wire:model="content" class="w-full border px-3 py-2 rounded"></textarea>
                    @error('content') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                @if($chapterId)
                <div>
                    <label class="block text-sm font-medium mb-1">Position</label>
                    <input type="number" wire:model="position" class="w-full border px-3 py-2 rounded" required>
                    @error('position') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                @endif

                <div>
                    <label class="block text-sm font-medium mb-1">Duration (in minutes)</label>
                    <input type="number" wire:model="duration_in_minutes" class="w-full border px-3 py-2 rounded" required>
                    @error('duration_in_minutes') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">
                        {{ $chapterId ? 'Update' : 'Create' }}
                    </button>
                    @if($chapterId)
                        <button type="button" wire:click="resetForm" class="bg-gray-600 text-white px-4 py-2 rounded">
                            Cancel
                        </button>
                    @endif
                </div>
            </form>
        </div>

        {{-- FILTER --}}
        <div class="bg-white p-6 shadow rounded mb-6">
            <h3 class="text-lg font-semibold mb-4">Filter Chapters</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Filter by Course</label>
                    <select wire:model.live="filter_course_id" class="w-full border px-3 py-2 rounded">
                        <option value="">-- Select Course --</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Filter by Unit</label>
                    <select wire:model.live="filter_unit_id" wire:key="filter_unit_select_{{ $filter_course_id }}" class="w-full border px-3 py-2 rounded">
                        <option value="">-- Select Unit --</option>
                        @forelse($filterUnits as $unit)
                            <option value="{{ $unit->id }}">{{ $unit->title }}</option>
                        @empty
                            <option disabled>No units available</option>
                        @endforelse
                    </select>
                </div>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="bg-white p-6 shadow rounded">
            <h3 class="text-lg font-semibold mb-4">Chapters</h3>

            @if($filteredChapters && count($filteredChapters))
                <table class="w-full table-auto border border-gray-200 text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-2 border">Title</th>
                            <th class="p-2 border">Position</th>
                            <th class="p-2 border">Duration</th>
                            <th class="p-2 border">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($filteredChapters as $chapter)
                            <tr>
                                <td class="p-2 border">{{ $chapter->title }}</td>
                                <td class="p-2 border">{{ $chapter->position }}</td>
                                <td class="p-2 border">{{ $chapter->duration_in_minutes }} mins</td>
                                <td class="p-2 border space-x-2">
                                    <button wire:click="editChapter({{ $chapter->id }})" class="text-blue-600 hover:underline">Edit</button>
                                    <button wire:click="deleteChapter({{ $chapter->id }})" class="text-red-600 hover:underline" onclick="return confirm('Delete this chapter?')">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-sm text-gray-500">No chapters found.</p>
            @endif
        </div>
    </div>
</div>