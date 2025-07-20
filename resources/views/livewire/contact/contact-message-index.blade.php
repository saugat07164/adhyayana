<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
    <div class="p-6">
           @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4">
            {{ session('message') }}
        </div>
    @endif
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Contact Messages</h3>
            <a href="#" class="text-blue-600 hover:text-blue-800 text-sm font-medium">View All</a>
        </div>

        <div class="overflow-x-auto shadow rounded-lg border border-gray-200">
            @if($contactmessages && count($contactmessages) > 0)
                <table class="min-w-full divide-y divide-gray-200 text-sm text-left text-gray-800">
                    <thead class="bg-gray-100 text-xs uppercase tracking-wider text-gray-600">
                        <tr>
                            <th class="px-4 py-3">SN</th>
                            <th class="px-4 py-3">From</th>
                            <th class="px-4 py-3">Subject</th>
                            <th class="px-4 py-3">User</th>
                            <th class="px-4 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @foreach($contactmessages as $contactmessage)
                           <tr
    onclick="window.location='{{ route('contactmessages.show', $contactmessage) }}'"
    class="cursor-pointer transition hover:bg-gray-100
        {{ !$contactmessage->is_read ? 'bg-orange-100' : 'bg-white' }}"
>


                                <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2">{{ $contactmessage->email }}</td>
                                <td class="px-4 py-2">{{ $contactmessage->subject }}</td>
                                <td class="px-4 py-2">
                                {{ $contactmessage->user->name ?? 'Not Registered' }}
                                </td>
                                <td class="px-4 py-2 space-x-4">
    <a href="#" class="text-blue-600 hover:text-blue-800" title="View">
        <i class="fa fa-eye"></i>
    </a>
<button wire:click="delete({{ $contactmessage->id }})" 
        onclick="confirm('Are you sure?') || event.stopImmediatePropagation()" 
        class="text-red-600 hover:text-red-800" 
        title="Delete">
    <i class="fa fa-trash"></i>
</button>


</td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="p-4 text-center text-gray-600 bg-yellow-50 rounded-b">
                    No messages yet.
                </div>
            @endif
        </div>
        {{-- The button is now outside the table's conditional rendering but still within the main card div --}}
        @if($contactmessages && count($contactmessages) > 0)
            <div class="p-4 bg-gray-50 rounded-b-lg flex justify-end mt-4">
                <button
                    wire:click="deleteAllRead"
                    onclick="confirm('Are you sure you want to delete all read messages?') || event.stopImmediatePropagation()"
                    class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded hover:bg-red-700"
                >
                    <i class="fa fa-trash mr-2"></i> Delete All Read
                </button>
            </div>
        @endif
    </div>
</div>