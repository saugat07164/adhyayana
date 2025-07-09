    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Course Management') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-blue-900 bg-opacity-80 text-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if (session()->has('message'))
                    <div class="mb-4 font-bold text-green-400">{{ session('message') }}</div>
                @endif
                <h3 class="text-lg font-bold mb-4">Courses Table</h3>
                <table class="min-w-full divide-y divide-blue-200 mb-6">
                    <thead class="bg-blue-800">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Category</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-blue-900 divide-y divide-blue-800">
                        @foreach ($courses as $course)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $course->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $course->title }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $course->category->name ?? 'Uncategorized' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $course->price }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <button wire:click="edit({{ $course->id }})" class="bg-blue-700 hover:bg-blue-600 text-white font-bold py-1 px-3 rounded">Edit</button>
                                    <button wire:click="delete({{ $course->id }})" class="bg-red-700 hover:bg-red-600 text-white font-bold py-1 px-3 rounded ml-2">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <h3 class="text-lg font-bold mb-4">@if($editMode) Edit Course @else Create Course @endif</h3>
                <form wire:submit.prevent="@if($editMode) update @else create @endif" class="space-y-4">
                    <div>
                        <label for="title" class="block text-sm font-medium">Title</label>
                        <input wire:model.defer="title" id="title" type="text" class="mt-1 block w-full rounded-md bg-blue-800 border border-blue-700 text-white" required />
                        @error('title') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="category_id" class="block text-sm font-medium">Category</label>
                        <select wire:model.defer="category_id" id="category_id" class="mt-1 block w-full rounded-md bg-blue-800 border border-blue-700 text-white">
                            <option value="">Select Category</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="price" class="block text-sm font-medium">Price</label>
                        <input wire:model.defer="price" id="price" type="number" step="0.01" class="mt-1 block w-full rounded-md bg-blue-800 border border-blue-700 text-white" required />
                        @error('price') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex space-x-2">
                        <button type="submit" class="bg-green-700 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">@if($editMode) Update @else Create @endif</button>
                        @if($editMode)
                            <button type="button" wire:click="cancelEdit" class="bg-gray-700 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">Cancel</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div> 