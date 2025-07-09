<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-white">
        {{ __('Role Management') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-slate-800 shadow-sm sm:rounded-lg p-6">
            @if (session()->has('message'))
                <div class="mb-4 font-bold text-emerald-600 dark:text-emerald-400">
                    {{ session('message') }}
                </div>
            @endif

            <h3 class="text-lg font-bold mb-4 text-gray-900 dark:text-white">Roles Table</h3>

            <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700 mb-6">
                <thead class="bg-gray-100 dark:bg-slate-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-white uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-white uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-white uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-100 dark:divide-slate-700">
                    @foreach ($roles as $role)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-800 dark:text-white">{{ $role->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-800 dark:text-white">{{ $role->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <button wire:click="edit({{ $role->id }})" class="bg-indigo-600 hover:bg-indigo-500 text-white font-semibold py-1 px-3 rounded shadow">
                                    Edit
                                </button>
                                <button wire:click="delete({{ $role->id }})" class="bg-red-600 hover:bg-red-500 text-white font-semibold py-1 px-3 rounded shadow ml-2">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <h3 class="text-lg font-bold mb-4 text-gray-900 dark:text-white">
                @if($editMode) Edit Role @else Create Role @endif
            </h3>

            <form wire:submit.prevent="@if($editMode) update @else create @endif" class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Name</label>
                    <input wire:model.defer="name" id="name" type="text"
                           class="mt-1 block w-full rounded-md bg-white dark:bg-slate-700 border border-gray-300 dark:border-slate-600 text-gray-800 dark:text-white focus:ring-indigo-500 focus:border-indigo-500"
                           required />
                    @error('name')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex space-x-2">
                    <button type="submit"
                            class="bg-emerald-600 hover:bg-emerald-500 text-white font-semibold py-2 px-4 rounded shadow">
                        @if($editMode) Update @else Create @endif
                    </button>

                    @if($editMode)
                        <button type="button" wire:click="cancelEdit"
                                class="bg-gray-600 hover:bg-gray-500 text-white font-semibold py-2 px-4 rounded shadow">
                            Cancel
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
