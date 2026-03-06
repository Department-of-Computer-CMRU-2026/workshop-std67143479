<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ __('Admin Dashboard') }}
            </h2>
            <a href="{{ route('workshops.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                + Create Workshop
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8 text-center uppercase tracking-wider font-bold">
                <div class="bg-white text-indigo-600 shadow-md rounded-2xl p-6 border-t-4 border-indigo-600 transition transform hover:scale-105">
                    <div class="text-xs text-gray-500">Workshops</div>
                    <div class="mt-2 text-4xl text-indigo-700">{{ $stats['total'] }}</div>
                </div>
                <div class="bg-white text-red-600 shadow-md rounded-2xl p-6 border-t-4 border-red-500 transition transform hover:scale-105">
                    <div class="text-xs text-gray-500">Full (เต็ม)</div>
                    <div class="mt-2 text-4xl text-red-700">{{ $stats['full'] }}</div>
                </div>
                <div class="bg-white text-green-600 shadow-md rounded-2xl p-6 border-t-4 border-green-500 transition transform hover:scale-105">
                    <div class="text-xs text-gray-500">Available Seats</div>
                    <div class="mt-2 text-4xl text-green-700">{{ $stats['available_seats'] }}</div>
                </div>
                <div class="bg-white text-amber-600 shadow-md rounded-2xl p-6 border-t-4 border-amber-500 transition transform hover:scale-105">
                    @php 
                        $totalRegs = $workshops->sum('registrations_count');
                    @endphp
                    <div class="text-xs text-gray-500">Total Registrants</div>
                    <div class="mt-2 text-4xl text-amber-700">{{ $totalRegs }}</div>
                </div>
            </div>

            <!-- Detailed Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 text-center">Workshop Registration Status</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead style="background: radial-gradient(ellipse at 0% 100%, #2a0e5a 0%, #0c1340 35%, #06082a 70%);">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Workshop</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Instructor</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Location</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Registrations</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-white uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($workshops as $workshop)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $workshop->title }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $workshop->instructor }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $workshop->location }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $workshop->registrations_count }} / {{ $workshop->max_seats }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($workshop->isFull())
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">FULL</span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">AVAILABLE</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                        <a href="{{ route('workshops.show', $workshop) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                        <a href="{{ route('workshops.edit', $workshop) }}" class="text-gray-600 hover:text-gray-900">Edit</a>
                                    </td>
                                </tr>
                                <!-- Participant List Sub-row -->
                                <tr class="bg-gray-50">
                                    <td colspan="6" class="px-6 py-3">
                                        <details class="group">
                                            <summary class="list-none cursor-pointer flex items-center text-xs font-semibold text-gray-500 hover:text-indigo-600">
                                                <svg class="w-4 h-4 mr-1 transition group-open:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                                VIEW PARTICIPANTS ({{ $workshop->participants->count() }})
                                            </summary>
                                            <div class="mt-3 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2">
                                                @forelse($workshop->participants as $participant)
                                                    <div class="bg-white p-2 border rounded shadow-sm flex flex-col justify-center">
                                                        <div class="flex items-center justify-between w-full">
                                                            <span class="text-sm font-medium truncate">{{ $participant->name }}</span>
                                                            <span class="text-[10px] text-gray-400 italic">ID: {{ $participant->id }}</span>
                                                        </div>
                                                        <span class="text-xs text-gray-500 truncate mt-1">{{ $participant->email }}</span>
                                                    </div>
                                                @empty
                                                    <p class="text-xs text-gray-400 italic py-2">No registrants yet.</p>
                                                @endforelse
                                            </div>
                                        </details>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
