<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrganizerController extends Controller
{
    public function index()
    {
        $organizers = \App\Models\Organizer::with('user')->latest()->paginate(10);
        return view('admin.organizer.index', compact('organizers'));
    }

    public function verify(\App\Models\Organizer $organizer)
    {
        $organizer->update([
            'is_verified' => !$organizer->is_verified
        ]);
        
        return back()->with('success', 'Status verifikasi organizer berhasil diperbarui.');
    }
}
