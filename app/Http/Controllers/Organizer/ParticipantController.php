<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    public function index(\App\Models\Kajian $kajian, Request $request)
    {
        // Ensure the kajian belongs to this organizer
        if ($kajian->organizer_id !== auth()->user()->organizer->id) {
            abort(403, 'Unauthorized action.');
        }

        $query = \App\Models\KajianAttendee::with('user')
            ->where('kajian_id', $kajian->id);

        if ($request->filled('q')) {
            $q = $request->q;
            $query->whereHas('user', function ($subQ) use ($q) {
                $subQ->where('name', 'like', "%{$q}%")
                     ->orWhere('email', 'like', "%{$q}%");
            });
        }

        $participants = $query->latest()->paginate(15)->appends($request->query());

        return view('organizer.participants', compact('kajian', 'participants'));
    }

    public function globalIndex(Request $request)
    {
        // Get all kajians for this organizer
        $organizerId = auth()->user()->organizer->id;
        
        $kajians = \App\Models\Kajian::where('organizer_id', $organizerId)
            ->orderBy('start_at', 'desc')
            ->get();

        $query = \App\Models\KajianAttendee::with(['user', 'kajian'])
            ->whereHas('kajian', function ($q) use ($organizerId) {
                $q->where('organizer_id', $organizerId);
            });

        if ($request->filled('kajian_id')) {
            $query->where('kajian_id', $request->kajian_id);
        }

        if ($request->filled('q')) {
            $q = $request->q;
            $query->whereHas('user', function ($subQ) use ($q) {
                $subQ->where('name', 'like', "%{$q}%")
                     ->orWhere('email', 'like', "%{$q}%");
            });
        }

        $participants = $query->latest()->paginate(15)->appends($request->query());

        return view('organizer.participants_global', compact('participants', 'kajians'));
    }
}
