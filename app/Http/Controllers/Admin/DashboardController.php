<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalKajian = \App\Models\Kajian::count();
        $kajianHariIni = \App\Models\Kajian::whereDate('start_at', today())->count();
        $totalUser = \App\Models\User::where('role', 'user')->count();
        $totalOrganizer = \App\Models\User::where('role', 'organizer')->count();
        $totalMosque = \App\Models\Mosque::count();
        
        $recentKajians = \App\Models\Kajian::with(['mosque', 'category'])->withCount('attendees')->latest()->take(5)->get();

        return view('admin.dashboard', compact('totalKajian', 'kajianHariIni', 'totalUser', 'totalOrganizer', 'totalMosque', 'recentKajians'));
    }
}
