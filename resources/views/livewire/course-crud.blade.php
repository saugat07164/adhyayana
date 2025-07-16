<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Course Management') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        {{-- CTA Button --}}
        <div class="flex justify-end mb-4" x-data>
            <button
                @click="document.getElementById('course-form-section').scrollIntoView({ behavior: 'smooth' })"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded shadow">
                + Create New Course!
            </button>
        </div>

        {{-- Courses Table --}}
        <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-8">
            @if (session()->has('success'))
                <div class="mb-4 font-semibold text-green-600">
                    {{ session('success') }}
                </div>
            @endif

            <h3 class="text-xl font-semibold mb-4 text-gray-900">Courses List</h3>
            <table class="min-w-full divide-y divide-gray-300 mb-6">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">SN</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Course Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($courses as $course)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-900">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-900">{{ $course->title }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-900">{{ $course->category->name ?? 'Uncategorized' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-900">{{ number_format($course->price, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap space-x-2">
                                <button wire:click="show({{ $course->id }})"
                                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-1 px-3 rounded"
                                    wire:loading.attr="disabled">
                                    Edit
                                </button>
                                <button wire:click="delete({{ $course->id }})"
                                    class="bg-red-600 hover:bg-red-700 text-white font-semibold py-1 px-3 rounded"
                                    onclick="return confirm('Are you sure you want to delete this course?')"
                                    wire:loading.attr="disabled">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">No courses found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Course Form --}}
        <div id="course-form-section" class="bg-white shadow-sm sm:rounded-lg p-6">
            <h3 class="text-xl font-semibold mb-6 text-gray-900">
                {{ $editing ? 'Edit Course' : 'Create New Course' }}
            </h3>

            <form wire:submit.prevent="{{ $editing ? 'update' : 'create' }}" class="space-y-6">

                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input wire:model.defer="title" id="title" type="text"
                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        required />
                    @error('title') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Slug - hidden input --}}
                <input type="hidden" wire:model.defer="slug" />

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea wire:model.defer="description" id="description" rows="3"
                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        required></textarea>
                    @error('description') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                    <input wire:model.defer="price" id="price" type="number" step="0.01"
                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        required />
                    @error('price') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                    <select wire:model.defer="category_id" id="category_id"
                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        required>
                        <option value="">-- Select Category --</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex space-x-4">
                    <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-5 rounded"
                        wire:loading.attr="disabled">
                        {{ $editing ? 'Update' : 'Create' }}
                    </button>
                    @if($editing)
                        <button type="button" wire:click="resetForm"
                            class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-5 rounded"
                            wire:loading.attr="disabled">
                            Cancel
                        </button>
                    @endif
                </div>

            </form>
        </div>
    </div>
</div>
