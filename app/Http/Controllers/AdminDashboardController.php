<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Workshop;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function __invoke()
    {
        if (!Auth::user()->is_admin) {
            abort(403);
        }

        $workshops = Workshop::with(['participants'])->withCount('registrations')->get();

        $stats = [
            'total' => $workshops->count(),
            'full' => $workshops->filter->isFull()->count(),
            'available_seats' => $workshops->sum(fn($w) => $w->remainingSeats()),
        ];

        return view('admin.dashboard', compact('workshops', 'stats'));
    }
}
