<div id="events-table-container"
     hx-get="{{ route('events.index') }}">

    @php
        $sortField = request('sort_field');
        $sortDir = request('sort_dir', 'asc') === 'asc' ? 'desc' : 'asc';
        $sortIcon = fn($field) =>
            $sortField === $field ? ($sortDir === 'asc' ? '↑' : '↓') : '';
        $hxGetUrl = fn($field) =>
            request()->fullUrlWithQuery([
                'sort_field' => $field,
                'sort_dir' => $sortDir
            ]);
    @endphp

    <table class="min-w-full border-collapse block md:table mb-6">

        <thead class="block md:table-header-group">
        <tr class="border border-grey-500 md:border-none block md:table-row absolute -top-full md:top-auto -left-full md:left-auto  md:relative ">
            <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell"
                hx-get="{{ $hxGetUrl('id') }}"
                hx-trigger="click"
                hx-replace-url="true"
                hx-swap="outerHTML"
                hx-target="#events-table-container">
                {{ __("ID") }}
                <span class="ml-1" role="img">{{ $sortIcon('id') }}</span>
            </th>
            <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell"
                hx-get="{{ $hxGetUrl('name') }}"
                hx-trigger="click"
                hx-replace-url="true"
                hx-swap="outerHTML"
                hx-target="#events-table-container">
                {{ __("Name") }}
                <span class="ml-1" role="img">{{ $sortIcon('name') }}</span>
            </th>
            <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">
                {{ __('Poster') }}
            </th>
            <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell"
                hx-get="{{ $hxGetUrl('event_date') }}"
                hx-trigger="click"
                hx-replace-url="true"
                hx-swap="outerHTML"
                hx-target="#events-table-container">
                {{ __('Date') }}
                <span class="ml-1" role="img">{{ $sortIcon('event_date') }}</span>
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
                <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell"
                    x-data="{ modalOpen: false }">
                    <span class="inline-block w-1/3 md:hidden font-bold">{{ __('Actions') }}</span>
                    <a href="{{ route('event.edit', $event->id) }}"
                       class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 border border-blue-500 rounded">
                        Edit
                    </a>
                    <a href="#" type="submit"
                       class="inline-block bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 border border-red-500 rounded"
                       @click="modalOpen = !modalOpen">
                        Delete
                    </a>

                    <div class="fixed left-0 top-0 flex h-full w-full items-center justify-center bg-black bg-opacity-50 py-10"
                         x-show="modalOpen" x-cloak
                         x-transition>
                        <div class="relative">
                            <form method="post" action="{{ route('event.destroy', $event->id) }}"
                                  class="inline-block">
                                @csrf
                                @method('delete')
                                <div class="p-6 bg-gray-600">
                                    <p class="text-white mb-3">Are you sure you want to delete
                                        <b>{{ $event->name }}</b>?</p>
                                    <a href="#"
                                       class="inline-block bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 border border-green-500 rounded"
                                       @click="modalOpen = !modalOpen">
                                        Cancel
                                    </a>
                                    <button type="submit"
                                            class="inline-block bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 border border-red-500 rounded">
                                        Delete
                                    </button>
                                </div>
                            </form>
                            <a href="#" @click="modalOpen = !modalOpen"
                               class="absolute -top-4 text-white">X</a>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>

    </table>

    <div class="p-3"
         hx-boost="true"
         hx-swap="outerHTML"
         hx-target="#events-table-container">
        {{ $events->appends($_GET)->links() }}
    </div>

</div>