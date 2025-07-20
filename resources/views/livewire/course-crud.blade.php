<x-slot name="header">
    <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
        {{ __('Course Management') }}
    </h2>
</x-slot>

<div class="py-12 bg-gray-100 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        {{-- CTA Button --}}
        <div class="flex justify-end mb-6" x-data>
            <button
                @click="document.getElementById('course-form-section').scrollIntoView({ behavior: 'smooth' })"
                class="bg-indigo-600 hover:bg-indigo-700 transition-colors duration-200 text-white font-semibold py-2 px-6 rounded-lg shadow-md">
                + Create New Course
            </button>
        </div>

        {{-- Courses Table --}}
        <div class="bg-white shadow-md sm:rounded-lg p-6 mb-10">
            @if (session()->has('success'))
                <div class="mb-4 font-semibold text-green-600">
                    {{ session('success') }}
                </div>
            @endif

            <h3 class="text-xl font-bold mb-6 text-gray-800">Courses List</h3>

            <table class="min-w-full divide-y divide-gray-200 border rounded-lg overflow-hidden">
                <thead class="bg-gray-100 text-gray-600 uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-6 py-3 text-left">Title</th>
                        <th class="px-6 py-3 text-left">Price</th>
                        <th class="px-6 py-3 text-left">Category</th>
                        <th class="px-6 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach ($courses as $course)
                        <tr class="hover:bg-gray-50 transition cursor-pointer" x-data="{ open: false }" @click="open = !open">
                            <td class="px-6 py-4 text-gray-800 font-medium">{{ $course->title }}</td>
                            <td class="px-6 py-4 text-gray-700">Rs. {{ $course->price }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $course->category->name ?? 'Uncategorized' }}</td>
                            <td class="px-6 py-4 text-right text-sm space-x-2">
                                <a href="{{ route('courses.show', $course->id) }}" class="text-blue-500 hover:text-blue-700" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button wire:click.prevent="edit({{ $course->id }})" class="text-yellow-500 hover:text-yellow-600" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button wire:click.prevent="delete({{ $course->id }})" class="text-red-500 hover:text-red-600" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>

                        {{-- Expandable Unit + Chapter rows --}}
                        <tr x-show="open"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 -translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 -translate-y-2"
                            class="bg-gray-50 text-sm">
                            <td colspan="4" class="px-6 py-4">
                                <div class="ml-4">
                                    <strong class="text-gray-700">Units:</strong>
                                    <ul class="list-disc ml-6 mt-2 space-y-2 text-gray-800">
                                        @foreach ($course->units as $unit)
                                            <li x-data="{ unitOpen: false }">
                                                <div class="flex justify-between items-center cursor-pointer" @click.stop="unitOpen = !unitOpen">
                                                    <span class="font-semibold flex items-center">
                                                        <i class="fas mr-2 text-xs" :class="unitOpen ? 'fa-chevron-down' : 'fa-chevron-right'"></i>
                                                        {{ $unit->title }}
                                                    </span>
                                                   <a href="{{ route('units.show', ['course' => $course->id, 'unit' => $unit->id]) }}" class="text-sm text-indigo-600 hover:underline">View Unit</a>
                                                </div>

                                                <ul x-show="unitOpen"
                                                    x-transition:enter="transition ease-out duration-300"
                                                    x-transition:leave="transition ease-in duration-200"
                                                    class="ml-6 mt-1 space-y-1 text-sm text-gray-700 list-decimal">
                                                    @foreach ($unit->chapters as $chapter)
                                                        <li class="flex justify-between">
                                                            <span>{{ $chapter->title }}</span>
                                                            <a href="{{ route('chapters.show', ['course' => $course->id, 'unit' => $unit->id, 'chapter' => $chapter->id]) }}" class="text-xs text-green-600 hover:underline">View Chapter</a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

      {{-- Course Form --}}
<div id="course-form-section" class="bg-white shadow-md sm:rounded-lg p-6">
    <h3 class="text-xl font-bold mb-6 text-gray-800">
        {{ $editing ? 'Edit Course' : 'Create New Course' }}
    </h3>

    {{-- For file uploads, ensure wire:submit.prevent is on the form and NOT wire:model.defer on the file input --}}
    <form wire:submit.prevent="{{ $editing ? 'update' : 'create' }}" class="space-y-6">

        {{-- Title --}}
        <div>
    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
    {{-- IMPORTANT: Use wire:model="title" for immediate updates to trigger updatedTitle() --}}
    <input wire:model="title" id="title" type="text"
        class="mt-1 w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
        required />
    @error('title') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
</div>

        {{-- Slug --}}
        <div>
    <label for="slug" class="block text-sm font-medium text-gray-700">Slug</label>
    {{-- Changed to wire:model="slug" to ensure immediate updates for validation/generation logic --}}
    <input wire:model="slug" id="slug" type="text"
        class="mt-1 w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
        placeholder="Auto-generated from title if left empty" />
    @error('slug') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
</div>


        {{-- Description --}}
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            {{-- Changed to wire:model="description" for immediate updates --}}
            <textarea wire:model="description" id="description" rows="3"
                class="mt-1 w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                required></textarea>
            @error('description') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Price --}}
        <div>
            <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
            {{-- Changed to wire:model="price" for immediate updates --}}
            <input wire:model="price" id="price" type="number" step="0.01"
                class="mt-1 w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                required />
            @error('price') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Category --}}
        <div>
            <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
            {{-- Changed to wire:model="category_id" for immediate updates --}}
            <select wire:model="category_id" id="category_id"
                class="mt-1 w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                required>
                <option value="">-- Select Category --</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
            @error('category_id') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Featured Image Upload --}}
        <div>
            <label for="new_thumbnail" class="block text-sm font-medium text-gray-700">Featured Image</label>
            <input type="file" wire:model="new_thumbnail" id="new_thumbnail"
                   class="mt-1 w-full text-gray-700 border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            @error('new_thumbnail') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror

            {{-- Loading state for image upload --}}
            <div wire:loading wire:target="new_thumbnail" class="text-indigo-500 text-sm mt-2">Uploading...</div>

            {{-- Image Preview --}}
            @if ($new_thumbnail)
                <h4 class="text-sm font-medium text-gray-700 mt-4">New Image Preview:</h4>
                <img src="{{ $new_thumbnail->temporaryUrl() }}" class="mt-2 h-32 w-auto object-cover rounded-md shadow">
            @elseif ($current_thumbnail_url) {{-- Show current image if editing and no new file selected --}}
                <h4 class="text-sm font-medium text-gray-700 mt-4">Current Image:</h4>
                <img src="{{ $current_thumbnail_url }}" class="mt-2 h-32 w-auto object-cover rounded-md shadow">
            @endif
        </div>

        {{-- Form Actions --}}
        <div class="flex space-x-4">
            <button type="submit"
                class="bg-green-600 hover:bg-green-700 transition text-white font-semibold py-2 px-5 rounded shadow"
                wire:loading.attr="disabled">
                {{ $editing ? 'Update' : 'Create' }}
            </button>

            <button type="button" wire:click="resetForm"
                class="bg-gray-600 hover:bg-gray-700 transition text-white font-semibold py-2 px-5 rounded shadow"
                wire:loading.attr="disabled">
                Cancel
            </button>
        </div>

    </form>
</div>
    </div>
</div>