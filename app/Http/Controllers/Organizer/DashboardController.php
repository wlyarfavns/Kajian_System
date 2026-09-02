<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kajian;
use App\Models\KajianAttendee;
use App\Models\Organizer;

class DashboardController extends Controller
{
    public function index()
    {
        $organizerId = auth()->user()->organizer->id ?? null;
        
        // Placeholder or simple queries for now
        $kajianAktif = Kajian::where('organizer_id', $organizerId)->where('status', 'published')->count();
        $kajianBulanIni = Kajian::where('organizer_id', $organizerId)->whereMonth('start_at', now()->month)->count();
        
        $calonPeserta = KajianAttendee::whereHas('kajian', function ($query) use ($organizerId) {
            $query->where('organizer_id', $organizerId);
        })->where('status', 'registered')->count();

        $pesertaHadir = KajianAttendee::whereHas('kajian', function ($query) use ($organizerId) {
            $query->where('organizer_id', $organizerId);
        })->where('status', 'attended')->count();
        
        $kajianSelesai = Kajian::where('organizer_id', $organizerId)
            ->where('end_at', '<', now())
            ->count();
            
        $recentKajians = Kajian::where('organizer_id', $organizerId)
            ->withCount('attendees')
            ->latest('created_at')
            ->take(5)
            ->get();

        return view('organizer.dashboard', compact('kajianAktif', 'kajianBulanIni', 'calonPeserta', 'pesertaHadir', 'kajianSelesai', 'recentKajians'));
    }
}
