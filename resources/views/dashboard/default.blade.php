<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}


                    @role('super admin')
    <p>You are a super admin!</p>
@elserole('staff')
    <p>You are a staff.</p>
    @elserole('instructor')
    <p>You are an instructor.</p>
    @elserole('student')
    <p>You are a student.</p>
    @elserole('tech support')
    <p>You are tech support.</p>
@else
    <p>You don't have access.</p>
@endrole
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
