<div>
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="submit" class="space-y-4">

    {{-- Only show name/email input fields if user is not logged in --}}
    @guest
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" id="name" wire:model.defer="name"
                   class="mt-1 block w-full border p-2 rounded shadow-sm focus:ring-blue-500 focus:border-blue-500" />
            @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">E-mail Address</label>
            <input type="email" id="email" wire:model.defer="email"
                   class="mt-1 block w-full border p-2 rounded shadow-sm focus:ring-blue-500 focus:border-blue-500" />
            @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>
    @endguest

    {{-- If user is logged in, use hidden inputs for name/email --}}
    @auth
        <input type="hidden" wire:model="name" value="{{ auth()->user()->name }}">
        <input type="hidden" wire:model="email" value="{{ auth()->user()->email }}">
    @endauth

    <div>
        <label for="subject" class="block text-sm font-medium text-gray-700">Subject</label>
        <input type="text" id="subject" wire:model.defer="subject"
               class="mt-1 block w-full border p-2 rounded shadow-sm focus:ring-blue-500 focus:border-blue-500" />
        @error('subject') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </div>

    <div>
        <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
        <textarea id="message" wire:model.defer="message" rows="4"
                  class="mt-1 block w-full p-2 border rounded shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
        @error('message') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </div>

    <div>
        <button type="submit"
                class="mt-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
            Send us a message
        </button>
    </div>

</form>

</div>
