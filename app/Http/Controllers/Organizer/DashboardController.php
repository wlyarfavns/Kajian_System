<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $organizerId = auth()->user()->organizer->id ?? null;
        
        $kajianAktif = \App\Models\Kajian::where('organizer_id', $organizerId)->where('status', 'published')->count();
        $kajianBulanIni = \App\Models\Kajian::where('organizer_id', $organizerId)->whereMonth('start_at', now()->month)->count();
        
        $calonPeserta = \App\Models\KajianAttendee::whereHas('kajian', function ($query) use ($organizerId) {
            $query->where('organizer_id', $organizerId);
        })->where('status', 'registered')->count();

        $pesertaHadir = \App\Models\KajianAttendee::whereHas('kajian', function ($query) use ($organizerId) {
            $query->where('organizer_id', $organizerId);
        })->where('status', 'attended')->count();

        // Get recent Kajians for the Event List table
        $recentKajians = \App\Models\Kajian::with('category')
            ->withCount('attendees')
            ->where('organizer_id', $organizerId)
            ->latest('start_at')
            ->take(5)
            ->get();

        return view('organizer.dashboard', compact('kajianAktif', 'kajianBulanIni', 'calonPeserta', 'pesertaHadir', 'recentKajians'));
    }
}
