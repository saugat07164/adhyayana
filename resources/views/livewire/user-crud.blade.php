<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
        {{ __('User Management') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-slate-800 text-gray-900 dark:text-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            @if (session()->has('message'))
                <div class="mb-4 font-bold text-emerald-600 dark:text-emerald-400">
                    {{ session('message') }}
                </div>
            @endif

            <h3 class="text-lg font-bold mb-4">Users</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
                @forelse ($users as $user)
                    <div class="bg-gray-100 dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg shadow p-6 flex flex-col gap-2">
                        <div class="flex items-center gap-3 mb-2">
                            @if ($user->profile_photo_path)
    <img class="h-12 w-12 rounded-full object-cover" 
         src="{{ Storage::url($user->profile_photo_path) }}" 
         alt="{{ $user->name }}">
@else
    <div class="h-12 w-12 rounded-full bg-slate-600 flex items-center justify-center text-white font-bold text-lg">
        {{ strtoupper(substr($user->name,0,1)) }}
    </div>
@endif

                            <div>
                                <div class="font-semibold">{{ $user->name }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-300">{{ $user->email }}</div>
                            </div>
                        </div>
                        <div class="mb-2">
                            <span class="inline-block bg-amber-100 text-amber-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                {{ $user->roles->pluck('name')->join(', ') }}
                            </span>
                        </div>
                        @if(auth()->user() && auth()->user()->hasRole('admin'))
                            <div class="flex gap-2 mt-2">
                                <button wire:click="edit({{ $user->id }})" class="flex-1 bg-amber-500 hover:bg-amber-600 text-white font-semibold py-2 px-4 rounded shadow">
                                    Edit
                                </button>
                                <button wire:click="delete({{ $user->id }})" class="flex-1 bg-rose-600 hover:bg-rose-700 text-white font-semibold py-2 px-4 rounded shadow">
                                    Delete
                                </button>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="col-span-4 text-center text-gray-400 dark:text-slate-400">No users found.</div>
                @endforelse
            </div>

            <h3 class="text-lg font-bold mb-4">@if($editMode) Edit User @else Create User @endif</h3>

            <form wire:submit.prevent="@if($editMode) update @else create @endif" class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                    <input wire:model.defer="name" id="name" type="text"
                        class="mt-1 block w-full rounded-md bg-white dark:bg-slate-700 border border-gray-300 dark:border-slate-600 text-gray-800 dark:text-white focus:ring-indigo-500 focus:border-indigo-500"
                        required />
                    @error('name') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                    <input wire:model.defer="email" id="email" type="email"
                        class="mt-1 block w-full rounded-md bg-white dark:bg-slate-700 border border-gray-300 dark:border-slate-600 text-gray-800 dark:text-white focus:ring-indigo-500 focus:border-indigo-500"
                        required />
                    @error('email') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Role</label>
                    <select wire:model.defer="role" id="role"
                        class="mt-1 block w-full rounded-md bg-white dark:bg-slate-700 border border-gray-300 dark:border-slate-600 text-gray-800 dark:text-white focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Select Role</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                    @error('role') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                    <input wire:model.defer="password" id="password" type="password"
                        class="mt-1 block w-full rounded-md bg-white dark:bg-slate-700 border border-gray-300 dark:border-slate-600 text-gray-800 dark:text-white focus:ring-indigo-500 focus:border-indigo-500"
                        @if(!$editMode) required @endif />
                    @error('password') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="flex space-x-2">
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-500 text-white font-semibold py-2 px-4 rounded shadow">
                        @if($editMode) Update @else Create @endif
                    </button>

                    @if($editMode)
                        <button type="button" wire:click="cancelEdit" class="bg-gray-600 hover:bg-gray-500 text-white font-semibold py-2 px-4 rounded shadow">
                            Cancel
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
