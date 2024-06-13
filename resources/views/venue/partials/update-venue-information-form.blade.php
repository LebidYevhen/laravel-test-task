<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Venue Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update venue information.") }}
        </p>
    </header>

    <form method="post" action="{{ route('venue.update', $venue->id) }}" enctype="multipart/form-data"
          class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')"/>
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $venue->name)"
                          required autofocus autocomplete="name"/>
            <x-input-error class="mt-2" :messages="$errors->get('name')"/>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'venue-updated')
                <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @elseif(session('status') === 'venue-created')
                <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm text-gray-600"
                >{{ __('Created.') }}</p>
            @endif
        </div>
    </form>
</section>
