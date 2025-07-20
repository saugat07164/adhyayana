<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Terms & Conditions') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto bg-white p-8 rounded shadow">
            <h1 class="text-3xl font-bold mb-4">Terms & Conditions</h1>

            <p class="mb-4">
                Welcome to <strong>Adhyayana LMS</strong>. By accessing or using our platform, you agree to be bound by the following terms and conditions:
            </p>

            <h2 class="text-xl font-semibold mt-6 mb-2">1. User Responsibilities</h2>
            <p class="mb-4">
                Users must maintain accurate account information, respect platform rules, and not engage in any unauthorized activity such as hacking, data scraping, or content theft.
            </p>

            <h2 class="text-xl font-semibold mt-6 mb-2">2. Content Usage</h2>
            <p class="mb-4">
                All content uploaded or submitted to Adhyayana remains the property of the original creator. Users must not copy or distribute any content without permission.
            </p>

            <h2 class="text-xl font-semibold mt-6 mb-2">3. Payments</h2>
            <p class="mb-4">
                Course purchases are final. Refunds may be granted only in cases of accidental double payment or major technical failures. Payments are handled securely via Khalti.
            </p>

            <h2 class="text-xl font-semibold mt-6 mb-2">4. Termination</h2>
            <p class="mb-4">
                We reserve the right to suspend or terminate accounts that violate these terms without prior notice.
            </p>

            <h2 class="text-xl font-semibold mt-6 mb-2">5. Changes to Terms</h2>
            <p>
                These terms may be updated from time to time. Continued use of the platform after updates means you accept the changes.
            </p>
        </div>
    </div>
</x-app-layout>
