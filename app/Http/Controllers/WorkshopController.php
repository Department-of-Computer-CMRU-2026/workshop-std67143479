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
        if (!Auth::user()->is_admin) {
            abort(403);
        }
        return view('workshops.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::user()->is_admin) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'instructor' => 'required|string|max:255',
            'location' => 'required|string|max:255',
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
        if (!Auth::user()->is_admin) {
            abort(403);
        }
        return view('workshops.edit', compact('workshop'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Workshop $workshop)
    {
        if (!Auth::user()->is_admin) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'instructor' => 'required|string|max:255',
            'location' => 'required|string|max:255',
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
        if (!Auth::user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }

        $workshop->delete();
        return redirect()->route('workshops.index')->with('success', 'Workshop deleted successfully!');
    }

    /**
     * Register the authenticated user for the workshop.
     */
    public function register(Workshop $workshop)
    {
        $user = Auth::user();

        // Business Logic: Check if already registered
        if ($workshop->participants()->where('users.id', $user->id)->exists()) {
            return back()->with('error', 'You are already registered for this workshop.');
        }

        if ($user->registrations()->count() >= 3) {
            return back()->with('error', 'You can only register for a maximum of 3 workshops.');
        }

        if ($workshop->isFull()) {
            return back()->with('error', 'Sorry, this workshop is full.');
        }

        try {
            // DB Constraint: Will throw QueryException if duplicate
            Registration::create([
                'workshop_id' => $workshop->id,
                'user_id' => $user->id,
            ]);
        }
        catch (\Illuminate\Database\QueryException $e) {
            // If it's a unique constraint violation (SQLSTATE 23000 / 23505)
            if ($e->getCode() == 23505 || $e->getCode() == 23000) {
                return back()->with('error', 'You are already registered for this workshop.');
            }
            throw $e; // Re-throw other database exceptions
        }

        return back()->with('success', 'Successfully registered for the workshop!');
    }

    /**
     * Unregister the authenticated user from the workshop.
     */
    public function unregister(Workshop $workshop)
    {
        $user = Auth::user();

        $registration = Registration::where('workshop_id', $workshop->id)
            ->where('user_id', $user->id)
            ->first();

        if ($registration) {
            $registration->delete();
            return back()->with('success', 'Successfully unregistered from the workshop.');
        }

        return back()->with('error', 'You are not registered for this workshop.');
    }
}
