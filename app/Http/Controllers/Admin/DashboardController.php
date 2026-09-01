<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalKajian = \App\Models\Kajian::count();
        
        // Kajian Terdekat (Dalam 7 hari kedepan)
        $kajianTerdekat = \App\Models\Kajian::whereBetween('start_at', [now(), now()->addDays(7)])->count();
        
        $totalUser = \App\Models\User::where('role', 'user')->count();
        $totalOrganizer = \App\Models\User::where('role', 'organizer')->count();
        $totalMosque = \App\Models\Mosque::count();
        
        // Total Kajian Growth (Bulan Ini)
        $kajianBulanIni = \App\Models\Kajian::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();
        $kajianBulanLalu = \App\Models\Kajian::whereMonth('created_at', now()->subMonth()->month)->whereYear('created_at', now()->subMonth()->year)->count();
        
        $kajianGrowth = 0;
        if ($kajianBulanLalu > 0) {
            $kajianGrowth = (($kajianBulanIni - $kajianBulanLalu) / $kajianBulanLalu) * 100;
        } else if ($kajianBulanIni > 0) {
            $kajianGrowth = 100; // If last month was 0 and this month has > 0, consider it 100% growth
        }
        $kajianGrowth = number_format($kajianGrowth, 1);

        // User Baru Minggu Ini
        $userMingguIni = \App\Models\User::where('role', 'user')
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->count();
        
        $recentKajians = \App\Models\Kajian::with(['mosque', 'category'])->withCount('attendees')->latest()->take(5)->get();
        $recentOrganizers = \App\Models\Organizer::with('user')->withCount('kajians')->latest()->take(5)->get();
        $recentMosques = \App\Models\Mosque::withCount('kajians')->latest()->take(5)->get();

        // Tasks & Alerts Data
        $unverifiedKajianCount = \App\Models\Kajian::where('is_verified', false)->count();
        $unverifiedOrganizerCount = \App\Models\Organizer::where('is_verified', false)->count();

        // --- Chart Data: Daily (Last 7 Days) ---
        $chartDailyLabels = [];
        $chartDailyData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $chartDailyLabels[] = $date->format('d M');
            $chartDailyData[] = \App\Models\KajianAttendee::whereDate('created_at', $date->toDateString())->count();
        }

        // --- Chart Data: Weekly (Last 4 Weeks) ---
        $chartWeeklyLabels = [];
        $chartWeeklyData = [];
        for ($i = 3; $i >= 0; $i--) {
            $startOfWeek = now()->subWeeks($i)->startOfWeek();
            $endOfWeek = now()->subWeeks($i)->endOfWeek();
            $chartWeeklyLabels[] = $startOfWeek->format('d M') . ' - ' . $endOfWeek->format('d M');
            $chartWeeklyData[] = \App\Models\KajianAttendee::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
        }

        // --- Chart Data: Monthly (Last 6 Months) ---
        $chartMonthlyLabels = [];
        $chartMonthlyData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $chartMonthlyLabels[] = $month->format('M Y');
            $chartMonthlyData[] = \App\Models\KajianAttendee::whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)->count();
        }

        return view('admin.dashboard', compact(
            'totalKajian', 
            'kajianTerdekat', 
            'totalUser', 
            'totalOrganizer', 
            'totalMosque', 
            'recentKajians',
            'recentOrganizers',
            'recentMosques',
            'kajianGrowth',
            'userMingguIni',
            'unverifiedKajianCount',
            'unverifiedOrganizerCount',
            'chartDailyLabels',
            'chartDailyData',
            'chartWeeklyLabels',
            'chartWeeklyData',
            'chartMonthlyLabels',
            'chartMonthlyData'
        ));
    }
}
