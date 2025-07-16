<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Unit Management') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        {{-- Unit Form --}}
        <div class="bg-white text-gray-900 overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
            <h3 class="text-lg font-bold mb-4">
                {{ $unitId ? 'Edit Unit' : 'Create New Unit' }}
            </h3>

            <form wire:submit.prevent="saveUnit" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Course Selection:</label>
                    <select wire:model="course_id" class="w-full text-gray-900 rounded px-3 py-2 border border-gray-300" required>
                        <option value="">-- Select Course --</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Unit Name</label>
                    <input type="text" wire:model="title" class="w-full text-gray-900 rounded px-3 py-2 border border-gray-300" required>
                </div>

                <div class="flex space-x-2">
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                        {{ $unitId ? 'Update' : 'Create' }}
                    </button>

                    @if($unitId)
                        <button type="button" wire:click="resetForm" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
                            Cancel
                        </button>
                    @endif
                </div>
            </form>
        </div>

        {{-- Filter Dropdown + Button --}}
        <div class="mb-4">
            <label class="block mb-1 font-medium">See Units in a course</label>
            <div class="flex space-x-2">
                <select wire:model.defer="filter_course_id" class="border rounded px-3 py-2">
                    <option value="">-- All Courses --</option>
                    @foreach ($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->title }}</option>
                    @endforeach
                </select>
                <button wire:click="filterUnits" class="bg-blue-600 text-white px-3 py-2 rounded hover:bg-blue-700">Filter</button>
            </div>
        </div>

        {{-- Unit List --}}
        <div class="bg-white text-black overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4">Units</h3>

            @if(count($units))
                <table class="w-full table-auto border border-gray-200 text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-2 border">Unit Name</th>
                            <th class="p-2 border">Course</th>
                            <th class="p-2 border">Position</th>
                            <th class="p-2 border">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($units as $unit)
                            <tr>
                                <td class="p-2 border">{{ $unit->title }}</td>
                                <td class="p-2 border">{{ $unit->course->title ?? 'N/A' }}</td>
                                <td class="p-2 border">{{ $unit->position }}</td>
                                <td class="p-2 border space-x-2">
                                    <button wire:click="editUnit({{ $unit->id }})" class="text-blue-600 hover:underline">Edit</button>
                                    <button wire:click="deleteUnit({{ $unit->id }})" class="text-red-600 hover:underline" onclick="return confirm('Delete this unit?')">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $units->links() }}
                </div>
            @else
                <p>No units found.</p>
            @endif
        </div>
    </div>
</div>
