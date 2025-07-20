<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        {{-- Flash message --}}
        @if (session()->has('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Message from {{ $contactmessage->name }}</h3>
            <a href="{{ route('contactmessages.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">← Back to Inbox</a>
        </div>

        {{-- Profile Info --}}
        <div class="flex items-center mb-6">
            <img src="{{ $contactmessage->user?->profile_photo_path 
                ? asset('storage/' . $contactmessage->user->profile_photo_path) 
                : asset('storage/profile-photos/default-profile.jpg') }}"
                alt="Profile Photo"
                class="w-16 h-16 rounded-full object-cover shadow mr-4"
            >
            <div>
                <p class="text-gray-900 font-semibold text-base">
                    {{ $contactmessage->user->name ?? $contactmessage->name }}
                </p>
                <p class="text-gray-600 text-sm">{{ $contactmessage->email }}</p>
            </div>
        </div>

        {{-- Message Content --}}
        <div class="border border-gray-200 rounded-lg p-5 bg-gray-50 mb-6">
            <h4 class="text-md font-bold text-gray-800 mb-2">Subject: {{ $contactmessage->subject }}</h4>
            <p class="text-gray-700 whitespace-pre-line">{{ $contactmessage->message }}</p>
        </div>
{{-- Extra Info --}}
<div class="text-sm text-gray-500 mb-4">
    <p><strong>Received:</strong> {{ $contactmessage->created_at->format('F j, Y \a\t g:i A') }}</p>
    <p><strong>Status:</strong> 
        @if($contactmessage->is_read)
            <span class="text-green-600 font-semibold">Read</span>
        @else
            <span class="text-red-600 font-semibold">Unread</span>
        @endif
    </p>
</div>

        {{-- Actions --}}
        <div class="flex justify-end space-x-4">
            {{-- Mark as Read Button --}}
@if (! $contactmessage->is_read)
    <div class="flex justify-end mb-4">
        <button wire:click="markAsRead"
                class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded hover:bg-green-700">
            <i class="fa fa-check mr-2"></i> Mark as Read
        </button>
    </div>
@endif

            <a href="mailto:{{ $contactmessage->email }}"
               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700">
                <i class="fa fa-reply mr-2"></i> Reply
            </a>

            <button wire:click="delete"
                    onclick="confirm('Are you sure you want to delete this message?') || event.stopImmediatePropagation()"
                    class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded hover:bg-red-700">
                <i class="fa fa-trash mr-2"></i> Delete
            </button>
            
        </div>

    </div>
</div>
