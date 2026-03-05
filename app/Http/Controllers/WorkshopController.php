<?php

namespace App\Http\Controllers;

use App\Models\Workshop;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkshopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $workshops = Workshop::withCount('registrations')->get();
        return view('workshops.index', compact('workshops'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('workshops.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'instructor' => 'required|string|max:255',
            'max_seats' => 'required|integer|min:1',
            'scheduled_at' => 'required|date',
            'image_url' => 'nullable|url',
        ]);

        Workshop::create($validated);

        return redirect()->route('workshops.index')->with('success', 'Workshop created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Workshop $workshop)
    {
        $workshop->load('participants');
        $isRegistered = Auth::check() && $workshop->participants->contains(Auth::user());
        return view('workshops.show', compact('workshop', 'isRegistered'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Workshop $workshop)
    {
        return view('workshops.edit', compact('workshop'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Workshop $workshop)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'instructor' => 'required|string|max:255',
            'max_seats' => 'required|integer|min:1',
            'scheduled_at' => 'required|date',
            'image_url' => 'nullable|url',
        ]);

        $workshop->update($validated);

        return redirect()->route('workshops.index')->with('success', 'Workshop updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Workshop $workshop)
    {
        $workshop->delete();
        return redirect()->route('workshops.index')->with('success', 'Workshop deleted successfully!');
    }

    /**
     * Register the authenticated user for the workshop.
     */
    public function register(Workshop $workshop)
    {
        $user = Auth::user();

        if ($workshop->participants->contains($user)) {
            return back()->with('error', 'You are already registered for this workshop.');
        }

        if ($workshop->isFull()) {
            return back()->with('error', 'Sorry, this workshop is full.');
        }

        Registration::create([
            'workshop_id' => $workshop->id,
            'user_id' => $user->id,
        ]);

        return back()->with('success', 'Successfully registered for the workshop!');
    }
}
