    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Chapter Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Chapter Form --}}
            <div class="bg-blue-900 bg-opacity-80 text-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-bold mb-4">
                    {{ $chapterId ? 'Edit Chapter' : 'Create New Chapter' }}
                </h3>

                <form wire:submit.prevent="saveChapter" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Unit ID</label>
                        <input type="number" wire:model="unit_id" class="w-full text-black rounded px-3 py-2" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Title</label>
                        <input type="text" wire:model="title" class="w-full text-black rounded px-3 py-2" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Video URL</label>
                        <input type="url" wire:model="video_url" class="w-full text-black rounded px-3 py-2">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Content</label>
                        <textarea wire:model="content" class="w-full text-black rounded px-3 py-2"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Position</label>
                        <input type="number" wire:model="position" class="w-full text-black rounded px-3 py-2" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Duration (in minutes)</label>
                        <input type="number" wire:model="duration_in_minutes" class="w-full text-black rounded px-3 py-2" required>
                    </div>

                    <div class="flex space-x-2">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                            {{ $chapterId ? 'Update' : 'Create' }}
                        </button>

                        @if($chapterId)
                        <button type="button" wire:click="resetForm" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
                            Cancel
                        </button>
                        @endif
                    </div>
                </form>
            </div>

            {{-- Chapter List --}}
            <div class="bg-white text-black overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">All Chapters</h3>

                @if(count($chapters))
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
                            @foreach($chapters as $chapter)
                                <tr>
                                    <td class="p-2 border">{{ $chapter->title }}</td>
                                    <td class="p-2 border">{{ $chapter->position }}</td>
                                    <td class="p-2 border">{{ $chapter->duration_in_minutes }} mins</td>
                                    <td class="p-2 border space-x-2">
                                        <button wire:click="editChapter({{ $chapter->id }})"
                                            class="text-blue-600 hover:underline">Edit</button>
                                        <button wire:click="deleteChapter({{ $chapter->id }})"
                                            class="text-red-600 hover:underline"
                                            onclick="return confirm('Delete this chapter?')">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>No chapters found.</p>
                @endif
            </div>
        </div>
    </div>

