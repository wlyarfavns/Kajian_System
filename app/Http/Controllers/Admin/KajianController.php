<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Kajian;

class KajianController extends Controller
{
    public function index()
    {
        // Get kajians that are not drafts, ordered by creation date (newest first)
        $kajians = Kajian::with('organizer')->where('status', '!=', 'draft')->latest()->paginate(10);
        return view('admin.kajian.index', compact('kajians'));
    }

    public function verify($id)
    {
        $kajian = Kajian::with('organizer.user')->findOrFail($id);
        $kajian->update([
            'is_verified' => true,
        ]);

        if ($kajian->organizer && $kajian->organizer->user) {
            $kajian->organizer->user->notify(new \App\Notifications\KajianVerified($kajian));
        }

        return redirect()->route('admin.kajian.index')->with('success', 'Kajian berhasil disetujui.');
    }

    public function reject($id)
    {
        $kajian = Kajian::with('organizer.user')->findOrFail($id);
        
        $kajian->update([
            'is_verified' => false,
            'status' => 'cancelled'
        ]);

        if ($kajian->organizer && $kajian->organizer->user) {
            $kajian->organizer->user->notify(new \App\Notifications\KajianRejected($kajian));
        }

        return redirect()->route('admin.kajian.index')->with('success', 'Kajian berhasil ditolak/dibatalkan.');
    }
}
