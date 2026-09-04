<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class DashboardController extends Controller
{
    public function index()
    {
        $totalKajian = \App\Models\Kajian::count();
        
        $kajianTerdekat = \App\Models\Kajian::whereBetween('start_at', [now(), now()->addDays(7)])->count();
        $totalUser = \App\Models\User::where('role', 'user')->count();
        $totalOrganizer = \App\Models\User::where('role', 'organizer')->count();
        $totalMosque = \App\Models\Mosque::count();
        
        $kajianBulanIni = \App\Models\Kajian::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();
        $kajianBulanLalu = \App\Models\Kajian::whereMonth('created_at', now()->subMonth()->month)->whereYear('created_at', now()->subMonth()->year)->count();
        $kajianGrowth = 0;
        if ($kajianBulanLalu > 0) {
            $kajianGrowth = (($kajianBulanIni - $kajianBulanLalu) / $kajianBulanLalu) * 100;
        } else if ($kajianBulanIni > 0) {
            $kajianGrowth = 100; 
        }
        $kajianGrowth = number_format($kajianGrowth, 1);
        $userMingguIni = \App\Models\User::where('role', 'user')
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->count();
        $recentKajians = \App\Models\Kajian::with(['mosque', 'category'])->withCount('attendees')->latest()->take(5)->get();
        $recentOrganizers = \App\Models\Organizer::with('user')->withCount('kajians')->latest()->take(5)->get();
        $recentMosques = \App\Models\Mosque::with('kajians')->withCount('kajians')->latest()->take(5)->get();
        $unverifiedKajianCount = \App\Models\Kajian::where('is_verified', false)->count();
        $unverifiedOrganizerCount = \App\Models\Organizer::where('is_verified', false)->count();
        $chartDailyLabels = [];
        $chartDailyData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $chartDailyLabels[] = $date->format('d M');
            $chartDailyData[] = \App\Models\KajianAttendee::whereDate('created_at', $date->toDateString())->count();
        }
        $chartWeeklyLabels = [];
        $chartWeeklyData = [];
        for ($i = 3; $i >= 0; $i--) {
            $startOfWeek = now()->subWeeks($i)->startOfWeek();
            $endOfWeek = now()->subWeeks($i)->endOfWeek();
            $chartWeeklyLabels[] = $startOfWeek->format('d M') . ' - ' . $endOfWeek->format('d M');
            $chartWeeklyData[] = \App\Models\KajianAttendee::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
        }
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

    public function realtime()
    {
        $totalKajian = \App\Models\Kajian::count();
        
        $kajianTerdekat = \App\Models\Kajian::whereBetween('start_at', [now(), now()->addDays(7)])->count();
        $totalUser = \App\Models\User::where('role', 'user')->count();
        $totalOrganizer = \App\Models\User::where('role', 'organizer')->count();
        $totalMosque = \App\Models\Mosque::count();
        
        $kajianBulanIni = \App\Models\Kajian::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();
        $kajianBulanLalu = \App\Models\Kajian::whereMonth('created_at', now()->subMonth()->month)->whereYear('created_at', now()->subMonth()->year)->count();
        $kajianGrowth = 0;
        if ($kajianBulanLalu > 0) {
            $kajianGrowth = (($kajianBulanIni - $kajianBulanLalu) / $kajianBulanLalu) * 100;
        } else if ($kajianBulanIni > 0) {
            $kajianGrowth = 100; 
        }
        $kajianGrowth = number_format($kajianGrowth, 1);
        $userMingguIni = \App\Models\User::where('role', 'user')
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->count();
            
        // Map data manually for JSON so Alpine can parse it easily
        $recentKajiansRaw = \App\Models\Kajian::with(['mosque', 'category'])->withCount('attendees')->latest()->take(5)->get();
        $recentKajians = $recentKajiansRaw->map(function($k) {
            return [
                'title' => $k->title,
                'start_at' => $k->start_at ? $k->start_at->format('M d, Y - H:i') : '-',
                'mosque_name' => $k->mosque->name ?? '-',
                'status_label' => $k->status_label,
                'category_name' => $k->category->name ?? '-',
                'attendees_count' => $k->attendees_count,
            ];
        });
        
        $recentOrganizersRaw = \App\Models\Organizer::with('user')->withCount('kajians')->latest()->take(5)->get();
        $recentOrganizers = $recentOrganizersRaw->map(function($org) {
            return [
                'name' => $org->name,
                'phone' => $org->phone ?? '-',
                'address' => $org->address ?? '-',
                'is_verified' => $org->is_verified,
                'kajians_count' => $org->kajians_count,
            ];
        });
        
        $recentMosquesRaw = \App\Models\Mosque::with('kajians')->withCount('kajians')->latest()->take(5)->get();
        $recentMosques = $recentMosquesRaw->map(function($mosque) {
            $facilities = $mosque->facilities ? explode(', ', $mosque->facilities) : [];
            $display = array_slice($facilities, 0, 2);
            $remaining = count($facilities) - 2;
            
            $maps_link = null;
            if ($mosque->google_maps_url) {
                $maps_link = $mosque->google_maps_url;
            } elseif ($mosque->latitude && $mosque->longitude) {
                $maps_link = "https://www.google.com/maps/search/?api=1&query={$mosque->latitude},{$mosque->longitude}";
            }
            
            return [
                'name' => $mosque->name,
                'facilities_display' => $display,
                'facilities_remaining' => $remaining > 0 ? $remaining : 0,
                'facilities_remaining_tooltip' => implode(', ', array_slice($facilities, 2)),
                'address' => $mosque->address ?? '-',
                'maps_link' => $maps_link,
                'kajians_count' => $mosque->kajians_count,
            ];
        });
        
        $unverifiedKajianCount = \App\Models\Kajian::where('is_verified', false)->count();
        $unverifiedOrganizerCount = \App\Models\Organizer::where('is_verified', false)->count();
        $chartDailyLabels = [];
        $chartDailyData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $chartDailyLabels[] = $date->format('d M');
            $chartDailyData[] = \App\Models\KajianAttendee::whereDate('created_at', $date->toDateString())->count();
        }
        $chartWeeklyLabels = [];
        $chartWeeklyData = [];
        for ($i = 3; $i >= 0; $i--) {
            $startOfWeek = now()->subWeeks($i)->startOfWeek();
            $endOfWeek = now()->subWeeks($i)->endOfWeek();
            $chartWeeklyLabels[] = $startOfWeek->format('d M') . ' - ' . $endOfWeek->format('d M');
            $chartWeeklyData[] = \App\Models\KajianAttendee::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
        }
        $chartMonthlyLabels = [];
        $chartMonthlyData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $chartMonthlyLabels[] = $month->format('M Y');
            $chartMonthlyData[] = \App\Models\KajianAttendee::whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)->count();
        }
        
        return response()->json(compact(
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
