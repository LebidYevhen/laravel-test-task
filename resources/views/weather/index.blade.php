<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden">
                <div>
                    @php
                        $weather = json_decode($weather, true);
                    @endphp

                    <div class="flex items-center justify-center h-full">
                        <div class="bg-white shadow-2xl p-6 rounded-2xl border-2 border-gray-50">
                            <div class="flex flex-col">
                                <div>
                                    <h2 class="font-bold text-gray-600 text-center">{{ $weather['location']['name'] . ', ' . $weather['location']['country']  }}</h2>
                                </div>
                                <div class="my-6">
                                    <div class="flex flex-row space-x-4 items-center">
                                        <div id="icon">
                                            <div class="w-20 h-20 fill-stroke text-yellow-400">
                                                <img src="{{ $weather['current']['condition']['icon'] }}">
                                            </div>
                                        </div>
                                        <div id="temp">
                                            <h4 class="text-4xl">{{ $weather['current']['temp_c'] }}&deg;C</h4>
                                            <p class="text-xs text-gray-500">
                                                {{ __('Feels like') . ' ' . $weather['current']['feelslike_c'] }}&deg;C</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full place-items-end text-right border-t-2 border-gray-100 mt-2">
                                    <p class="text-xs font-medium">{{ __('Local time') . ': ' . $weather['location']['localtime'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
