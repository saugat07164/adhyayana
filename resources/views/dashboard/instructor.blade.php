<x-app-layout>
    <x-slot name="header">Instructor Dashboard</x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                {{-- Dummy: My Courses --}}
                <div class="bg-white p-6 rounded-lg shadow text-center">
                    <div class="text-2xl font-bold">--</div>
                    <div class="text-gray-600">My Courses</div>
                </div>

                {{-- Dummy: My Students --}}
                <div class="bg-white p-6 rounded-lg shadow text-center">
                    <div class="text-2xl font-bold">--</div>
                    <div class="text-gray-600">My Students</div>
                </div>

                {{-- Dummy: Certificates Issued --}}
                <div class="bg-white p-6 rounded-lg shadow text-center">
                    <div class="text-2xl font-bold">--</div>
                    <div class="text-gray-600">Certificates Issued</div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
