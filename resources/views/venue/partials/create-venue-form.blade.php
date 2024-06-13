<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Create') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update venue information.") }}
        </p>
    </header>

    <form method="post" action="{{ route('venue.store') }}" enctype="multipart/form-data"
          class="mt-6 space-y-6">
        @csrf
        @method('post')

        <div>
            <x-input-label for="name" :value="__('Name')"/>
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')"
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
            @endif
        </div>
    </form>
</section>
