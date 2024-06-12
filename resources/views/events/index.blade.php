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
                    <table class="min-w-full border-collapse block md:table mb-6">
                        <thead class="block md:table-header-group">
                        <tr class="border border-grey-500 md:border-none block md:table-row absolute -top-full md:top-auto -left-full md:left-auto  md:relative ">
                            <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">
                                {{ __('ID') }}
                            </th>
                            <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">
                                {{ __('Name') }}
                            </th>
                            <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">
                                {{ __('Poster') }}
                            </th>
                            <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">
                                {{ __('Date') }}
                            </th>
                            <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">
                                {{ __('Actions') }}
                            </th>
                        </tr>
                        </thead>
                        <tbody class="block md:table-row-group">
                        @foreach ($events as $event)
                            <tr class="{{ ($loop->index+1) % 2 === 0 ? 'bg-white' : 'bg-gray-300' }} border border-grey-500 md:border-none block md:table-row">
                                <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell"><span
                                            class="inline-block w-1/3 md:hidden font-bold">{{ __('ID') }}</span>{{ $event->id }}
                                </td>
                                <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell"><span
                                            class="inline-block w-1/3 md:hidden font-bold">{{ __('Name') }}</span>{{ $event->name }}
                                </td>
                                <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell"><span
                                            class="inline-block w-1/3 md:hidden font-bold">{{ __('Poster') }}</span><img
                                            class="w-16 h-16"
                                            src="{{ url('storage/'.$event->poster) }}">
                                </td>
                                <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell"><span
                                            class="inline-block w-1/3 md:hidden font-bold">{{ __('Date') }}</span>{{ $event->event_date }}
                                </td>
                                <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                                    <span class="inline-block w-1/3 md:hidden font-bold">{{ __('Actions') }}</span>
                                    <a href="{{ route('event.edit', $event->id) }}"
                                       class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 border border-blue-500 rounded">
                                        Edit
                                    </a>
                                    <form method="post" action="{{ route('event.destroy', $event->id) }}"
                                          class="inline-block">
                                        @csrf
                                        @method('delete')
                                        <button type="submit"
                                                class="inline-block bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 border border-red-500 rounded">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>


                    {{ $events->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>