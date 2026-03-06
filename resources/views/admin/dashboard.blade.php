<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white leading-tight">{{ __('Admin Dashboard') }}</h2>
            <a href="{{ route('workshops.create') }}"
               class="btn-primary inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-semibold tracking-wider uppercase">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Create Workshop
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Stats Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="glass-card p-6 text-center hover:-translate-y-1 transition-all duration-200">
                    <p class="text-xs text-gray-500 uppercase tracking-widest font-semibold mb-2">Workshops</p>
                    <p class="text-4xl font-bold text-indigo-400">{{ $stats['total'] }}</p>
                </div>
                <div class="glass-card p-6 text-center hover:-translate-y-1 transition-all duration-200">
                    <p class="text-xs text-gray-500 uppercase tracking-widest font-semibold mb-2">Full</p>
                    <p class="text-4xl font-bold text-red-400">{{ $stats['full'] }}</p>
                </div>
                <div class="glass-card p-6 text-center hover:-translate-y-1 transition-all duration-200">
                    <p class="text-xs text-gray-500 uppercase tracking-widest font-semibold mb-2">Available Seats</p>
                    <p class="text-4xl font-bold text-emerald-400">{{ $stats['available_seats'] }}</p>
                </div>
                <div class="glass-card p-6 text-center hover:-translate-y-1 transition-all duration-200">
                    @php $totalRegs = $workshops->sum('registrations_count'); @endphp
                    <p class="text-xs text-gray-500 uppercase tracking-widest font-semibold mb-2">Registrants</p>
                    <p class="text-4xl font-bold text-amber-400">{{ $totalRegs }}</p>
                </div>
            </div>

            <!-- Workshop Table -->
            <div class="glass-card overflow-hidden">
                <div class="p-6 border-b" style="border-color:rgba(255,255,255,0.08)">
                    <h3 class="text-base font-bold text-white">Workshop Registration Status</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead style="background: radial-gradient(ellipse at 0% 100%, #2a0e5a 0%, #0c1340 35%, #06082a 70%);">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Workshop</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Instructor</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Location</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Registrations</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-white uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($workshops as $workshop)
                            <tr style="border-bottom:1px solid rgba(255,255,255,0.05);" class="hover:bg-white/[0.03] transition-colors">
                                <td class="px-6 py-4 text-sm font-semibold text-white">{{ $workshop->title }}</td>
                                <td class="px-6 py-4 text-sm text-gray-400">{{ $workshop->instructor }}</td>
                                <td class="px-6 py-4 text-sm text-gray-400">{{ $workshop->location }}</td>
                                <td class="px-6 py-4 text-sm text-gray-300">{{ $workshop->registrations_count }} / {{ $workshop->max_seats }}</td>
                                <td class="px-6 py-4">
                                    @if($workshop->isFull())
                                        <span class="px-2 py-1 inline-flex text-xs font-semibold rounded-full bg-red-500/20 text-red-300 border border-red-500/25">FULL</span>
                                    @else
                                        <span class="px-2 py-1 inline-flex text-xs font-semibold rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-500/25">AVAILABLE</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right text-sm font-medium space-x-3">
                                    <a href="{{ route('workshops.show', $workshop) }}" class="text-indigo-400 hover:text-indigo-300 transition">View</a>
                                    <a href="{{ route('workshops.edit', $workshop) }}" class="text-gray-400 hover:text-white transition">Edit</a>
                                    
                                    @if(Auth::user()->is_admin)
                                        <form action="{{ route('workshops.destroy', $workshop) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this workshop?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-400 hover:text-red-300 transition font-medium">Delete</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            <!-- Participants sub-row -->
                            <tr style="background:rgba(0,0,0,0.15); border-bottom:1px solid rgba(255,255,255,0.05);">
                                <td colspan="6" class="px-6 py-3">
                                    <details class="group">
                                        <summary class="list-none cursor-pointer flex items-center text-xs font-semibold text-gray-500 hover:text-indigo-400 transition">
                                            <svg class="w-3.5 h-3.5 mr-1.5 transition group-open:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                            PARTICIPANTS ({{ $workshop->participants->count() }})
                                        </summary>
                                        <div class="mt-3 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2">
                                            @forelse ($workshop->participants as $participant)
                                                <div class="rounded-lg p-3" style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.07)">
                                                    <div class="flex items-center justify-between">
                                                        <span class="text-sm font-medium text-white truncate">{{ $participant->name }}</span>
                                                        <span class="text-xs text-gray-500 ml-2">ID: {{ $participant->id }}</span>
                                                    </div>
                                                    <span class="text-xs text-gray-400 truncate mt-0.5 block">{{ $participant->email }}</span>
                                                </div>
                                            @empty
                                                <p class="text-xs text-gray-500 italic py-1">No registrants yet.</p>
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
</x-app-layout>
