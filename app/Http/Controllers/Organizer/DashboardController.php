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
        $draftKajianCount = \App\Models\Kajian::where('organizer_id', $organizerId)->where('status', 'draft')->count();
        $unverifiedKajianCount = \App\Models\Kajian::where('organizer_id', $organizerId)->where('status', 'published')->where('is_verified', false)->count();
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
        $kajianSelesai = \App\Models\Kajian::where('organizer_id', $organizerId)
            ->where('status', 'published')
            ->where('end_at', '<', now())
            ->count();
        $totalMasjid = \App\Models\Mosque::where('organizer_id', $organizerId)->count();
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
            'chartMonthlyData',
            'kajianSelesai',
            'totalMasjid'
        ));
    }

    public function realtime()
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
        
        $recentKajians = \App\Models\Kajian::with('category', 'mosque')
            ->withCount('attendees')
            ->where('organizer_id', $organizerId)
            ->latest('start_at')
            ->take(5)
            ->get()->map(function($k) {
                return [
                    'title' => $k->title,
                    'start_at' => $k->start_at ? $k->start_at->format('M d, Y - h:i A') : '-',
                    'mosque_name' => $k->mosque->name ?? '-',
                    'status_label' => $k->status_label,
                    'category_name' => $k->category->name ?? '-',
                    'attendees_count' => $k->attendees_count
                ];
            });
            
        $recentAttendees = \App\Models\KajianAttendee::with(['user', 'kajian'])
            ->whereHas('kajian', function($q) use ($organizerId) {
                $q->where('organizer_id', $organizerId);
            })
            ->latest('created_at')
            ->take(5)
            ->get()->map(function($a) {
                return [
                    'user_name' => $a->user->name ?? '-',
                    'kajian_title' => $a->kajian->title ?? '-',
                    'created_at' => $a->created_at ? $a->created_at->format('M d, Y - H:i') : '-',
                    'status' => $a->status,
                    'status_label' => $a->status === 'attended' ? 'Hadir' : ($a->status === 'cancelled' ? 'Dibatalkan' : 'Terdaftar')
                ];
            });
            
        $recentMosques = \App\Models\Mosque::whereHas('kajians', function($q) use ($organizerId) {
                $q->where('organizer_id', $organizerId);
            })
            ->distinct()
            ->latest()
            ->take(5)
            ->get()->map(function($m) {
                $facs = $m->facilities ? explode(', ', $m->facilities) : [];
                $disp = array_slice($facs, 0, 2);
                $rem = count($facs) - 2;
                $link = $m->google_maps_url ?: ($m->latitude ? "https://www.google.com/maps/search/?api=1&query={$m->latitude},{$m->longitude}" : null);
                return [
                    'name' => $m->name,
                    'address' => $m->address ?? '-',
                    'facilities_display' => $disp,
                    'facilities_remaining' => $rem > 0 ? $rem : 0,
                    'facilities_remaining_tooltip' => implode(', ', array_slice($facs, 2)),
                    'maps_link' => $link
                ];
            });
            
        $draftKajianCount = \App\Models\Kajian::where('organizer_id', $organizerId)->where('status', 'draft')->count();
        $unverifiedKajianCount = \App\Models\Kajian::where('organizer_id', $organizerId)->where('status', 'published')->where('is_verified', false)->count();
        
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
        
        $kajianSelesai = \App\Models\Kajian::where('organizer_id', $organizerId)
            ->where('status', 'published')
            ->where('end_at', '<', now())
            ->count();
        $totalMasjid = \App\Models\Mosque::where('organizer_id', $organizerId)->count();

        return response()->json([
            'kajianAktif' => $kajianAktif,
            'kajianBulanIni' => $kajianBulanIni,
            'calonPeserta' => $calonPeserta,
            'pesertaHadir' => $pesertaHadir,
            'recentKajians' => $recentKajians,
            'recentAttendees' => $recentAttendees,
            'recentMosques' => $recentMosques,
            'draftKajianCount' => $draftKajianCount,
            'unverifiedKajianCount' => $unverifiedKajianCount,
            'chartDailyLabels' => $chartDailyLabels,
            'chartDailyData' => $chartDailyData,
            'chartWeeklyLabels' => $chartWeeklyLabels,
            'chartWeeklyData' => $chartWeeklyData,
            'chartMonthlyLabels' => $chartMonthlyLabels,
            'chartMonthlyData' => $chartMonthlyData,
            'kajianSelesai' => $kajianSelesai,
            'totalMasjid' => $totalMasjid
        ]);
    }
}