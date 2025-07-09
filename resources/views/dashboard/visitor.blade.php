<!-- resources/views/dashboard/visitor.blade.php -->
<x-app-layout>
    <x-slot name="header">Visitor Dashboard</x-slot>
    <div class="py-12 flex flex-col items-center justify-center">
        <div class="mb-6">
            <!-- Example SVG animation -->
            <svg width="120" height="120" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="animate-bounce text-blue-600 mx-auto"><circle cx="12" cy="12" r="10" /><path d="M9 9h.01" /><path d="M15 9h.01" /><path d="M8 15c1.333-1 2.667-1 4 0" /></svg>
        </div>
        <div class="text-2xl font-bold mb-2">Oops! You must be logged in to access this page.</div>
        <div class="mb-4 text-gray-600">Please <a href="{{ route('login') }}" class="text-blue-600 underline">login here</a> or <a href="{{ route('register') }}" class="text-blue-600 underline">register</a> to continue.</div>
    </div>
</x-app-layout>
