<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Create') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update event information.") }}
        </p>
    </header>

    <form method="post" action="{{ route('event.store') }}" enctype="multipart/form-data"
          class="mt-6 space-y-6">
        @csrf
        @method('post')

        <div>
            <x-input-label for="name" :value="__('Name')"/>
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                          required autofocus autocomplete="name"/>
            <x-input-error class="mt-2" :messages="$errors->get('name')"/>
        </div>

        <div>
            <x-input-label for="poster" :value="__('Poster')"/>
            <x-text-input id="poster" name="poster" type="file" class="mt-1 block w-full"
                          autofocus autocomplete="poster"/>
            <x-input-error class="mt-2" :messages="$errors->get('poster')"/>
            @if($event->poster)
                <img src="{{ asset('storage/' . $event->poster) }}" class="w-16 h-16 mt-3">
            @endif
        </div>

        <div>
            <x-input-label for="event_date" :value="__('Event Date')"/>
            <x-text-input id="event_date" name="event_date" type="date" class="mt-1 block w-full"
                          required autofocus autocomplete="event_date"/>
            <x-input-error class="mt-2" :messages="$errors->get('event_date')"/>
        </div>

        <div>
            <x-input-label for="venue_id" :value="__('Venue')"/>
            <select name="venue_id" id="venue_id" class="mt-1 block w-full"
                    required autofocus>
                @foreach ($venues as $venue)
                    <option value="{{ $venue->id }}">
                        {{ $venue->name }}
                    </option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('venue_id')"/>
            <div>{{ old('venue_id') }}</div>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'event-updated')
                <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
