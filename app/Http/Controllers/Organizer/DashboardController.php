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
        $recentKajians = \App\Models\Kajian::with('category', 'mosque')
            ->withCount('attendees')
            ->where('organizer_id', $organizerId)
            ->latest('start_at')
            ->take(5)
            ->get();

        $recentAttendees = \App\Models\KajianAttendee::with(['user', 'kajian'])
            ->whereHas('kajian', function($q) use ($organizerId) {
                $q->where('organizer_id', $organizerId);
            })
            ->latest('created_at')
            ->take(5)
            ->get();

        $recentMosques = \App\Models\Mosque::whereHas('kajians', function($q) use ($organizerId) {
                $q->where('organizer_id', $organizerId);
            })
            ->distinct()
            ->latest()
            ->take(5)
            ->get();

        // Tasks & Alerts Data
        $draftKajianCount = \App\Models\Kajian::where('organizer_id', $organizerId)->where('status', 'draft')->count();
        $unverifiedKajianCount = \App\Models\Kajian::where('organizer_id', $organizerId)->where('status', 'published')->where('is_verified', false)->count();

        // Chart Data (Filtered by Organizer's Kajian)
        $chartDailyLabels = [];
        $chartDailyData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $chartDailyLabels[] = $date->format('d M');
            $chartDailyData[] = \App\Models\KajianAttendee::whereHas('kajian', function ($q) use ($organizerId) {
                $q->where('organizer_id', $organizerId);
            })->whereDate('created_at', $date->toDateString())->count();
        }

        $chartWeeklyLabels = [];
        $chartWeeklyData = [];
        for ($i = 3; $i >= 0; $i--) {
            $startOfWeek = now()->subWeeks($i)->startOfWeek();
            $endOfWeek = now()->subWeeks($i)->endOfWeek();
            $chartWeeklyLabels[] = $startOfWeek->format('d M') . ' - ' . $endOfWeek->format('d M');
            $chartWeeklyData[] = \App\Models\KajianAttendee::whereHas('kajian', function ($q) use ($organizerId) {
                $q->where('organizer_id', $organizerId);
            })->whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
        }

        $chartMonthlyLabels = [];
        $chartMonthlyData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $chartMonthlyLabels[] = $month->format('M Y');
            $chartMonthlyData[] = \App\Models\KajianAttendee::whereHas('kajian', function ($q) use ($organizerId) {
                $q->where('organizer_id', $organizerId);
            })->whereMonth('created_at', $month->month)->whereYear('created_at', $month->year)->count();
        }

        return view('organizer.dashboard', compact(
            'kajianAktif', 
            'kajianBulanIni', 
            'calonPeserta', 
            'pesertaHadir', 
            'recentKajians',
            'recentAttendees',
            'recentMosques',
            'draftKajianCount',
            'unverifiedKajianCount',
            'chartDailyLabels',
            'chartDailyData',
            'chartWeeklyLabels',
            'chartWeeklyData',
            'chartMonthlyLabels',
            'chartMonthlyData'
        ));
    }
}
