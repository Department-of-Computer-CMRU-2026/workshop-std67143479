<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex flex-col md:flex-row justify-between items-center mb-6">
                        <h3 class="text-2xl font-bold text-indigo-700">Welcome, {{ Auth::user()->name }}!</h3>
                        <div class="flex space-x-2 mt-4 md:mt-0">
                            <a href="{{ route('workshops.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-semibold transition">
                                Browse Workshops
                            </a>
                            @if(Auth::user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-md text-sm font-semibold transition">
                                Admin Dashboard
                            </a>
                            @endif
                        </div>
                    </div>

                    <div class="mt-8">
                        <h4 class="text-lg font-semibold text-gray-800 mb-4">My Registered Workshops</h4>
                        @php
                            $myWorkshops = Auth::user()->workshops()->withCount('registrations')->get();
                        @endphp

                        @if($myWorkshops->isEmpty())
                            <div class="bg-gray-50 border border-dashed border-gray-300 rounded-lg p-10 text-center">
                                <p class="text-gray-500 italic pb-4">You haven't registered for any workshops yet.</p>
                                <a href="{{ route('workshops.index') }}" class="text-indigo-600 font-bold hover:underline">Find a workshop to join!</a>
                            </div>
                        @else
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($myWorkshops as $workshop)
                                    <div class="bg-white border border-indigo-100 rounded-lg p-4 shadow-sm flex justify-between items-center">
                                        <div>
                                            <p class="font-bold text-gray-900">{{ $workshop->title }}</p>
                                            <p class="text-xs text-gray-500">{{ $workshop->scheduled_at->format('M d, Y @ H:i') }} | {{ $workshop->location }}</p>
                                        </div>
                                        <div class="flex space-x-2">
                                            <a href="{{ route('workshops.show', $workshop) }}" class="text-sm text-indigo-600 hover:text-indigo-900 font-semibold px-3 py-1 bg-indigo-50 rounded">View</a>
                                            <form action="{{ route('workshops.unregister', $workshop) }}" method="POST" onsubmit="return confirm('Unregister from this workshop?')">
                                                @csrf
                                                <button type="submit" class="text-sm text-red-600 hover:text-red-900 font-semibold px-3 py-1 bg-red-50 rounded">Cancel</button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
