<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    public function index(\App\Models\Kajian $kajian)
    {
        // Ensure the kajian belongs to this organizer
        if ($kajian->organizer_id !== auth()->user()->organizer->id) {
            abort(403, 'Unauthorized action.');
        }

        // Get participants (attendees) for this kajian
        $participants = \App\Models\KajianAttendee::with('user')
            ->where('kajian_id', $kajian->id)
            ->latest()
            ->paginate(15);

        return view('organizer.participants', compact('kajian', 'participants'));
    }

    public function globalIndex()
    {
        // Get all kajians for this organizer
        $organizerId = auth()->user()->organizer->id;
        
        $participants = \App\Models\KajianAttendee::with(['user', 'kajian'])
            ->whereHas('kajian', function ($query) use ($organizerId) {
                $query->where('organizer_id', $organizerId);
            })
            ->latest()
            ->paginate(15);

        return view('organizer.participants_global', compact('participants'));
    }
}
