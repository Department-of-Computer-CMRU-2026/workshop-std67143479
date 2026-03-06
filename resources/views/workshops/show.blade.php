<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">{{ __('Workshop Details') }}</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="alert-success mb-6">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert-error mb-6">{{ session('error') }}</div>
            @endif

            <div class="glass-card overflow-hidden">
                @if($workshop->image_url)
                    <img src="{{ $workshop->image_url }}" alt="{{ $workshop->title }}" class="w-full h-72 object-cover">
                @endif

                <div class="p-8">
                    <div class="flex flex-col md:flex-row justify-between items-start mb-6 gap-4">
                        <div>
                            <h1 class="text-3xl font-bold text-white mb-1">{{ $workshop->title }}</h1>
                            <p class="text-gray-400 text-base">by {{ $workshop->instructor }}</p>
                        </div>
                        <span class="flex-shrink-0 px-4 py-2 rounded-full text-sm font-semibold
                            {{ $workshop->isFull() ? 'bg-red-500/20 text-red-300 border border-red-500/30' : 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' }}">
                            {{ $workshop->remainingSeats() }} seats remaining
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                        <div class="md:col-span-2">
                            <h3 class="text-sm text-indigo-300 uppercase tracking-widest font-semibold mb-3">About</h3>
                            <p class="text-gray-300 leading-relaxed whitespace-pre-line">{{ $workshop->description }}</p>
                        </div>

                        <div class="glass-card-solid p-6 h-fit">
                            <h3 class="text-xs text-gray-500 uppercase tracking-widest font-semibold mb-4">Information</h3>
                            <div class="space-y-4">
                                <div>
                                    <p class="text-xs text-gray-500 uppercase font-bold mb-1">Date & Time</p>
                                    <p class="text-sm text-white font-medium">{{ $workshop->scheduled_at->format('l, F d, Y') }}</p>
                                    <p class="text-sm text-gray-300">{{ $workshop->scheduled_at->format('H:i') }} onwards</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 uppercase font-bold mb-1">Instructor</p>
                                    <p class="text-sm text-white font-medium">{{ $workshop->instructor }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 uppercase font-bold mb-1">Location</p>
                                    <p class="text-sm text-white font-medium">{{ $workshop->location }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 uppercase font-bold mb-1">Capacity</p>
                                    <p class="text-sm text-white font-medium">{{ $workshop->max_seats }} participants</p>
                                </div>
                            </div>

                            <div class="mt-6">
                                @if($isRegistered)
                                    <form action="{{ route('workshops.unregister', $workshop) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-danger w-full py-3 rounded-xl text-sm font-semibold">
                                            Cancel Registration
                                        </button>
                                    </form>
                                @elseif($workshop->isFull())
                                    <button disabled class="w-full py-3 rounded-xl text-sm font-semibold cursor-not-allowed"
                                            style="background:rgba(255,255,255,0.05);color:#6b7280;border:1px solid rgba(255,255,255,0.1)">
                                        Registration Closed
                                    </button>
                                @else
                                    <form action="{{ route('workshops.register', $workshop) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-primary w-full py-3 rounded-xl text-sm font-semibold">
                                            Register for Workshop
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>

                    <hr style="border-color:rgba(255,255,255,0.08)" class="mb-6">

                    <a href="{{ route('workshops.index') }}" class="inline-flex items-center gap-2 text-indigo-400 hover:text-indigo-300 text-sm font-semibold transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Back to List
                    </a>
                </div>
            </div>

            @if(Auth::user()->is_admin)
                <div class="glass-card mt-6 p-8">
                    <h3 class="text-sm text-indigo-300 uppercase tracking-widest font-semibold mb-4">
                        Participant List ({{ $workshop->participants->count() }})
                    </h3>
                    <ul class="divide-y" style="border-color:rgba(255,255,255,0.07)">
                        @forelse($workshop->participants as $participant)
                            <li class="py-3 flex justify-between items-center">
                                <span class="text-white font-medium text-sm">{{ $participant->name }}</span>
                                <span class="text-gray-400 text-xs">{{ $participant->email }}</span>
                            </li>
                        @empty
                            <li class="py-4 text-gray-500 italic text-sm">No participants yet.</li>
                        @endforelse
                    </ul>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
