<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('About') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto bg-white p-8 rounded shadow">
            <h1 class="text-3xl font-bold mb-4">About Adhyayana LMS</h1>
            <p class="mb-4">
                <strong>Adhyayana</strong> is a powerful and flexible Learning Management System (LMS) designed to empower students, instructors, and educational institutions.
            </p>

            <h2 class="text-xl font-semibold mt-6 mb-2">Our Mission</h2>
            <p class="mb-4">
                To democratize access to quality education through an intuitive, scalable, and interactive online learning platform.
            </p>

            <h2 class="text-xl font-semibold mt-6 mb-2">Key Features</h2>
            <ul class="list-disc list-inside space-y-2 mb-4">
                <li>Role-based access (Admin, Staff, Instructors, Students, Technical Support)</li>
                <li>Course creation with Units, Chapters, and Lessons</li>
                <li>Student enrollment and progress tracking</li>
                <li>Test and certificate management</li>
                <li>Dynamic dashboard with real-time analytics</li>
                <li>Contact support and feedback system</li>
                <li>Khalti-integrated secure payments</li>
                <li>Coupons and promotional features</li>
            </ul>

            <h2 class="text-xl font-semibold mt-6 mb-2">Why Choose Us?</h2>
            <p>
                Whether you’re a learner looking to enhance your skills or an instructor aiming to share your knowledge, Adhyayana LMS gives you the tools to succeed in the modern educational landscape.
            </p>
        </div>
    </div>
</x-app-layout>
