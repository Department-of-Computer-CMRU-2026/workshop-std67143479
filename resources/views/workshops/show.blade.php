<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Workshop Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                @if($workshop->image_url)
                    <img src="{{ $workshop->image_url }}" alt="{{ $workshop->title }}" class="w-full h-96 object-cover">
                @endif

                <div class="p-8">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $workshop->title }}</h1>
                            <p class="text-xl text-gray-600">by {{ $workshop->instructor }}</p>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium {{ $workshop->isFull() ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                {{ $workshop->remainingSeats() }} seats remaining
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                        <div class="md:col-span-2">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">About Workshop</h3>
                            <div class="prose max-w-none text-gray-600 whitespace-pre-line">
                                {{ $workshop->description }}
                            </div>
                        </div>
                        <div class="bg-gray-50 p-6 rounded-lg h-fit border border-gray-100">
                            <h3 class="text-md font-semibold text-gray-900 mb-4 uppercase tracking-wider">Information</h3>
                            <div class="space-y-4">
                                <div>
                                    <p class="text-xs text-gray-400 uppercase font-bold">Date & Time</p>
                                    <p class="text-sm font-medium text-gray-800">{{ $workshop->scheduled_at->format('l, F d, Y') }}</p>
                                    <p class="text-sm font-medium text-gray-800">{{ $workshop->scheduled_at->format('H:i') }} onwards</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 uppercase font-bold">Instructor</p>
                                    <p class="text-sm font-medium text-gray-800">{{ $workshop->instructor }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 uppercase font-bold">Location</p>
                                    <p class="text-sm font-medium text-gray-800">{{ $workshop->location }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 uppercase font-bold">Capacity</p>
                                    <p class="text-sm font-medium text-gray-800">{{ $workshop->max_seats }} participants total</p>
                                </div>
                            </div>

                            <div class="mt-8">
                                @if($isRegistered)
                                    <form action="{{ route('workshops.unregister', $workshop) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full bg-red-100 hover:bg-red-200 text-red-700 font-bold py-3 px-4 rounded-lg shadow-sm border border-red-200 transition duration-150 ease-in-out">
                                            Cancel Registration
                                        </button>
                                    </form>
                                @elseif($workshop->isFull())
                                    <div class="bg-gray-300 text-gray-500 text-center font-bold py-3 px-4 rounded-lg cursor-not-allowed">
                                        Workshop Full
                                    </div>
                                @else
                                    <form action="{{ route('workshops.register', $workshop) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-lg shadow-md transition duration-150 ease-in-out">
                                            Register for Workshop
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>

                    <hr class="my-8">

                    <div class="flex items-center justify-between">
                        <a href="{{ route('workshops.index') }}" class="text-indigo-600 hover:text-indigo-900 font-semibold flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back to List
                        </a>
                        
                    </div>
                </div>
            </div>
            
            @if(Auth::user()->is_admin) {{-- Check if admin --}}
                <div class="mt-8 bg-white shadow sm:rounded-lg p-8 border border-gray-200">
                     <h3 class="text-lg font-semibold text-gray-900 mb-4">Participant List ({{ $workshop->participants->count() }})</h3>
                     <ul class="divide-y divide-gray-200">
                        @forelse($workshop->participants as $participant)
                            <li class="py-3 flex justify-between">
                                <span>{{ $participant->name }}</span>
                                <span class="text-gray-500 text-sm">{{ $participant->email }}</span>
                            </li>
                        @empty
                            <li class="py-3 text-gray-400 italic text-sm">No participants registered yet.</li>
                        @endforelse
                     </ul>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
