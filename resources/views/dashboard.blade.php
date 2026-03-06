<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">{{ __('Dashboard') }}</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Welcome Banner -->
            <div class="glass-card p-8 mb-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <div>
                    <p class="text-xs text-indigo-300 uppercase tracking-widest font-semibold mb-1">Welcome back 👋</p>
                    <h3 class="text-3xl font-bold text-white">{{ Auth::user()->name }}</h3>
                    <p class="text-gray-400 text-sm mt-1">Here's a summary of your registered workshops.</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('workshops.index') }}" class="btn-primary inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        Browse Workshops
                    </a>
                    @if(Auth::user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold" style="background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.15);color:#c5b8ff;">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        Admin Dashboard
                    </a>
                    @endif
                </div>
            </div>

            <h4 class="text-xs text-gray-400 uppercase tracking-widest font-semibold mb-4 px-1">My Registered Workshops</h4>

            @php $myWorkshops = Auth::user()->workshops()->withCount('registrations')->get(); @endphp

            @if($myWorkshops->isEmpty())
                <div class="glass-card p-12 text-center">
                    <svg class="w-12 h-12 mx-auto mb-4 text-indigo-400 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-gray-400 italic mb-4">You haven't registered for any workshops yet.</p>
                    <a href="{{ route('workshops.index') }}" class="btn-primary inline-block px-6 py-2 rounded-xl text-sm font-semibold">Find a Workshop</a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($myWorkshops as $workshop)
                        <div class="glass-card p-5 flex justify-between items-center hover:bg-white/[0.06] transition-all duration-200">
                            <div>
                                <p class="font-semibold text-white">{{ $workshop->title }}</p>
                                <p class="text-xs text-gray-400 mt-1">📅 {{ $workshop->scheduled_at->format('M d, Y @ H:i') }} &nbsp;·&nbsp; 📍 {{ $workshop->location }}</p>
                            </div>
                            <div class="flex gap-2 ml-4 flex-shrink-0">
                                <a href="{{ route('workshops.show', $workshop) }}" class="text-xs font-semibold px-3 py-1.5 rounded-lg" style="background:rgba(99,102,241,0.2);color:#a5b4fc;border:1px solid rgba(99,102,241,0.3)">View</a>
                                <form action="{{ route('workshops.unregister', $workshop) }}" method="POST" onsubmit="return confirm('Unregister?')">
                                    @csrf
                                    <button type="submit" class="text-xs font-semibold px-3 py-1.5 rounded-lg" style="background:rgba(239,68,68,0.15);color:#fca5a5;border:1px solid rgba(239,68,68,0.25)">Cancel</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
