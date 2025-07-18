<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-900 leading-tight">
        {{ __('Category Management') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            @if (session()->has('message'))
                <div class="mb-4 font-bold text-green-600">{{ session('message') }}</div>
            @endif

            <h3 class="text-lg font-bold mb-4 text-gray-900">Categories Table</h3>

            <table class="min-w-full divide-y divide-gray-200 mb-6">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">SN</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($categories as $category)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-900">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-900">{{ $category->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <button wire:click="edit({{ $category->id }})" class="bg-blue-600 hover:bg-blue-500 text-white font-bold py-1 px-3 rounded">Edit</button>
                                <button wire:click="delete({{ $category->id }})" class="bg-red-600 hover:bg-red-500 text-white font-bold py-1 px-3 rounded ml-2">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <h3 class="text-lg font-bold mb-4 text-gray-900">@if($editMode) Edit Category @else Create Category @endif</h3>

            <form wire:submit.prevent="@if($editMode) update @else create @endif" class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input wire:model.defer="name" id="name" type="text" class="mt-1 block w-full rounded-md border border-gray-300 text-gray-900" required />
                    @error('name') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="flex space-x-2">
                    <button type="submit" class="bg-green-600 hover:bg-green-500 text-white font-bold py-2 px-4 rounded">@if($editMode) Update @else Create @endif</button>
                    @if($editMode)
                        <button type="button" wire:click="cancelEdit" class="bg-gray-600 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded">Cancel</button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
