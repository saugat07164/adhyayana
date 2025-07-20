<div class="p-6 bg-white shadow rounded-md">
    {{-- Success Message --}}
@if (session()->has('message'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
        <span class="block sm:inline">{!! session('message') !!}</span> {{-- Changed to {!! !!} --}}
    </div>
@endif

    <table class="min-w-full table-auto border border-gray-300 rounded-md overflow-hidden">
        <thead class="bg-gray-100 text-gray-700 uppercase text-sm">
            <tr>
                <th class="px-4 py-2 border">SN</th>
                <th class="px-4 py-2 border">Course ID</th>
                <th class="px-4 py-2 border">Title</th>
                <th class="px-4 py-2 border">Paid or Free</th>
                <th class="px-4 py-2 border">Status</th>
                <th class="px-4 py-2 border">Action</th>
            </tr>
        </thead>

        <tbody class="text-gray-800 text-sm divide-y divide-gray-200">
            @forelse($courses as $course)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-2 border text-center">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2 border text-center">{{ $course->id }}</td>
                    <td class="px-4 py-2 border">{{ $course->title }}</td>
                   <td class="px-4 py-2 border text-center capitalize space-y-2">
    <!-- Paid or Free Dropdown -->
    <select
        wire:model="coursePaidorFree.{{ $course->id }}"
        class="border rounded px-8 py-1 text-sm focus:outline-none focus:ring focus:ring-blue-300"
    >
        <option value="1">Free</option>
        <option value="0">Paid</option>
    </select>

    <button
        wire:click="updatePaidorFree({{ $course->id }})"
        class="ml-2 px-3 py-1 text-white bg-green-600 hover:bg-green-700 text-sm rounded"
    >
        Change
    </button>

</td>




                    <td class="px-4 py-2 border text-center capitalize">
                        <select
                            wire:model.defer="courseStatuses.{{ $course->id }}"
                            class="border rounded px-8 py-1"
                        >
                            <option value="">-- Select --</option>
                            <option value="draft">Draft</option>
                            <option value="pending">Pending</option>
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
                            <option value="published">Published</option>
                        </select>
                    </td>

                    <td class="px-4 py-2 border text-center">
                        <button
                            wire:click="updateCourseStatus({{ $course->id }})"
                            class="bg-blue-500 hover:bg-blue-600 text-white text-sm px-3 py-1 rounded"
                        >
                            Update
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-4 py-4 text-center text-gray-500 italic">
                        No courses found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
