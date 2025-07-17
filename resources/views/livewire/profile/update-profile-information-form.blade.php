<?php

use App\Models\User;
use App\Services\DashboardService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str; // Import Str facade for unique filenames

new class extends Component
{
    use WithFileUploads;

    public string $name = '';
    public string $email = '';
    public $photo; // This will temporarily hold the uploaded photo file
    public string $currentPhotoPath = ''; // This will store the path to the user's saved profile photo

    /**
     * Mount: Initializes the component with the current user's profile information
     * and their existing profile photo path.
     */
    public function mount(): void
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        // Set the currentPhotoPath from the user's database record.
        // If no photo exists, fall back to a default image path.
        $this->currentPhotoPath = $user->profile_photo_path ?? 'profile-photos/default-profile.jpg';
    }

    /**
     * Update Profile Information:
     * This method handles the full profile update, including photo upload/deletion.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        // Validate all fields, including the photo (nullable means it's optional for saving)
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'photo' => ['nullable', 'image', 'max:1024'], // 1MB Max (1024 KB)
        ]);

        // --- Photo Upload Logic ---
        if ($this->photo) { // Check if a new photo has been selected for upload
            // 1. Delete old photo:
            // Ensure the user actually has an old photo path (not null or default)
            // AND the file actually exists on the public disk before attempting to delete.
            if ($user->profile_photo_path &&
                $user->profile_photo_path !== 'profile-photos/default-profile.jpg' &&
                Storage::disk('public')->exists($user->profile_photo_path))
            {
                Storage::disk('public')->delete($user->profile_photo_path);
            }

            // 2. Generate a unique filename:
            // Using UUID prevents filename collisions and makes URLs harder to guess.
            $filename = Str::uuid() . '.' . $this->photo->getClientOriginalExtension();

            // 3. Store the new photo:
            // Store the photo in 'storage/app/public/profile-photos/'
            // The 'public' disk ensures it's stored in the publicly accessible directory.
            $newPhotoPath = $this->photo->storeAs('profile-photos', $filename, 'public');

            // Add the new photo path to the validated data to be filled into the user model
            $validated['profile_photo_path'] = $newPhotoPath;

            // Update the `currentPhotoPath` property for immediate UI update after save
            $this->currentPhotoPath = $newPhotoPath;

            // Clear the temporary `photo` property after saving.
            // This is important to reset the file input and temporary preview.
            $this->photo = null;
        } else {
            // If no new photo is uploaded, ensure 'profile_photo_path' is not set
            // in $validated if it was not changed, to prevent overwriting with null
            // unless that's the desired behavior (e.g., if you had a 'remove photo' button)
            // For now, we only add it if a new photo exists.
        }

        // Fill the user model with the validated data (name, email, and potentially profile_photo_path)
        $user->fill($validated);

        // If the email has changed, reset email verification status
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Save the user model to persist all changes to the database
        $user->save();

        // Dispatch an event to notify other parts of the application that the profile has been updated
        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send Verification:
     * Handles sending the email verification link.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $route = DashboardService::getDashboardRoute($user);
            $this->redirectIntended(default: $route);
            return;
        }

        $user->sendEmailVerificationNotification();
        Session::flash('status', 'verification-link-sent');
    }
};
?>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    {{-- Form for updating profile information, including photo --}}
    <form wire:submit="updateProfileInformation" class="mt-6 space-y-6">
        <!-- Profile Photo Section -->
        <div>
            <x-input-label for="photo" :value="__('Profile Photo')" />

            <div class="mt-2 flex items-center space-x-4">
                <!-- Current Photo / Preview Display -->
                <div class="flex-shrink-0">
                    <img
                        class="h-16 w-16 rounded-full object-cover"
                        {{-- Dynamic src attribute: --}}
                        {{-- 1. If a new photo is selected ($photo is not null), show its temporary URL for preview. --}}
                        {{-- 2. Else, check if the currentPhotoPath exists in public storage and show its URL. --}}
                        {{-- 3. As a fallback, show the default profile image. --}}
                        src="{{ $photo ? $photo->temporaryUrl() : (Storage::disk('public')->exists($currentPhotoPath) ? Storage::url($currentPhotoPath) : asset('storage/profile-photos/default-profile.jpg')) }}"
                        alt="{{ auth()->user()->name }}"
                    >
                </div>

                <!-- Photo Upload Input -->
                <div>
                    <input type="file"
                           wire:model="photo" {{-- This binds the input to the $photo property in Livewire --}}
                           id="photo"
                           name="photo"
                           class="block w-full text-sm text-gray-500
                                  file:mr-4 file:py-2 file:px-4 file:rounded-full
                                  file:border-0 file:text-sm file:font-semibold
                                  file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                           accept="image/*"> {{-- Only allow image files --}}

                    {{-- Input error message for validation specific to the 'photo' field --}}
                    <x-input-error class="mt-2" :messages="$errors->get('photo')" />

                    @if ($photo) {{-- Show message only if a new photo is selected for upload --}}
                        <p class="mt-1 text-sm text-gray-500">
                            {{ __('Photo will be uploaded when you save.') }}
                        </p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Name Input Field --}}
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input wire:model="name" id="name" name="name" type="text" class="mt-1 block w-full" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        {{-- Email Input Field --}}
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="email" id="email" name="email" type="email" class="mt-1 block w-full" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            {{-- Email Verification Status Display --}}
            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button wire:click.prevent="sendVerification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- Save Button and Action Message --}}
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            <x-action-message class="me-3" on="profile-updated">
                {{ __('Saved.') }}
            </x-action-message>
        </div>
    </form>
</section>