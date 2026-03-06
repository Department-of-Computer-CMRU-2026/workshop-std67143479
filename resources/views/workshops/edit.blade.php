<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">{{ __('Edit Workshop') }}</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="glass-card p-8">
                <form action="{{ route('workshops.update', $workshop) }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="title" class="block text-xs font-semibold mb-2 uppercase tracking-wider" style="color:#94a3b8 !important">Workshop Title</label>
                        <input id="title" type="text" name="title" value="{{ old('title', $workshop->title) }}" required autofocus
                               class="input-dark block w-full px-4 py-2.5 rounded-xl text-sm">
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div>
                        <label for="instructor" class="block text-xs font-semibold mb-2 uppercase tracking-wider" style="color:#94a3b8 !important">Instructor (Senior Name)</label>
                        <input id="instructor" type="text" name="instructor" value="{{ old('instructor', $workshop->instructor) }}" required
                               class="input-dark block w-full px-4 py-2.5 rounded-xl text-sm">
                        <x-input-error :messages="$errors->get('instructor')" class="mt-2" />
                    </div>

                    <div>
                        <label for="location" class="block text-xs font-semibold mb-2 uppercase tracking-wider" style="color:#94a3b8 !important">Location</label>
                        <input id="location" type="text" name="location" value="{{ old('location', $workshop->location) }}" required
                               class="input-dark block w-full px-4 py-2.5 rounded-xl text-sm">
                        <x-input-error :messages="$errors->get('location')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="max_seats" class="block text-xs font-semibold mb-2 uppercase tracking-wider" style="color:#94a3b8 !important">Max Seats</label>
                            <input id="max_seats" type="number" name="max_seats" value="{{ old('max_seats', $workshop->max_seats) }}" required min="1"
                                   class="input-dark block w-full px-4 py-2.5 rounded-xl text-sm">
                            <x-input-error :messages="$errors->get('max_seats')" class="mt-2" />
                        </div>
                        <div>
                            <label for="scheduled_at" class="block text-xs font-semibold mb-2 uppercase tracking-wider" style="color:#94a3b8 !important">Schedule Date & Time</label>
                            <input id="scheduled_at" type="datetime-local" name="scheduled_at"
                                   value="{{ old('scheduled_at', $workshop->scheduled_at->format('Y-m-d\TH:i')) }}" required
                                   class="input-dark block w-full px-4 py-2.5 rounded-xl text-sm">
                            <x-input-error :messages="$errors->get('scheduled_at')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <label for="image_url" class="block text-xs font-semibold mb-2 uppercase tracking-wider" style="color:#94a3b8 !important">Banner Image URL (Optional)</label>
                        <input id="image_url" type="url" name="image_url" value="{{ old('image_url', $workshop->image_url) }}"
                               class="input-dark block w-full px-4 py-2.5 rounded-xl text-sm" placeholder="https://...">
                        <x-input-error :messages="$errors->get('image_url')" class="mt-2" />
                    </div>

                    <div>
                        <label for="description" class="block text-xs font-semibold mb-2 uppercase tracking-wider" style="color:#94a3b8 !important">Description</label>
                        <textarea id="description" name="description" rows="5"
                                  class="input-dark block w-full px-4 py-2.5 rounded-xl text-sm">{{ old('description', $workshop->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-2">
                        <button type="button" onclick="window.history.back()"
                                class="px-5 py-2.5 rounded-xl text-sm font-semibold transition"
                                style="background:rgba(255,255,255,0.06);color:#94a3b8;border:1px solid rgba(255,255,255,0.12)">
                            Cancel
                        </button>
                        <button type="submit" class="btn-primary px-6 py-2.5 rounded-xl text-sm font-semibold">
                            Update Workshop
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
