<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Events') }}
        </h2>

        @if (session('status') === 'event-deleted')
            <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
            >{{ __('Deleted.') }}</p>
        @endif
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 text-right">
                <a href="{{ route('event.create') }}"
                   class="inline-block bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 border border-green-500 rounded">{{ __('Create') }}</a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @include('events.partials.table')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>