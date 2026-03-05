<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Workshop') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <form action="{{ route('workshops.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="title" :value="__('Workshop Title')" />
                        <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="instructor" :value="__('Instructor (Senior Name)')" />
                        <x-text-input id="instructor" class="block mt-1 w-full" type="text" name="instructor" :value="old('instructor')" required />
                        <x-input-error :messages="$errors->get('instructor')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="location" :value="__('Location')" />
                        <x-text-input id="location" class="block mt-1 w-full" type="text" name="location" :value="old('location')" required />
                        <x-input-error :messages="$errors->get('location')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="max_seats" :value="__('Maximum Seats')" />
                            <x-text-input id="max_seats" class="block mt-1 w-full" type="number" name="max_seats" :value="old('max_seats', 20)" required min="1" />
                            <x-input-error :messages="$errors->get('max_seats')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="scheduled_at" :value="__('Schedule Date & Time')" />
                            <x-text-input id="scheduled_at" class="block mt-1 w-full" type="datetime-local" name="scheduled_at" :value="old('scheduled_at')" required />
                            <x-input-error :messages="$errors->get('scheduled_at')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="image_url" :value="__('Banner Image URL (Optional)')" />
                        <x-text-input id="image_url" class="block mt-1 w-full" type="url" name="image_url" :value="old('image_url')" placeholder="https://example.com/image.jpg" />
                        <x-input-error :messages="$errors->get('image_url')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="description" :value="__('Description')" />
                        <textarea id="description" name="description" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="5">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end">
                        <x-secondary-button type="button" onclick="window.history.back()" class="mr-3">
                            {{ __('Cancel') }}
                        </x-secondary-button>
                        <x-primary-button>
                            {{ __('Create Workshop') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
