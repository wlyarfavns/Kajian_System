<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Kajian;

class KajianController extends Controller
{
    public function index()
    {
        $kajians = Kajian::with('organizer')->where('status', '!=', 'draft')->latest()->paginate(5);
        return view('admin.kajian.index', compact('kajians'));
    }

    public function verify($id)
    {
        $kajian = Kajian::findOrFail($id);
        $kajian->update([
            'is_verified' => true,
        ]);

        return redirect()->route('admin.kajian.index')->with('success', 'Kajian berhasil disetujui.');
    }

    public function reject($id)
    {
        $kajian = Kajian::findOrFail($id);
        
        // For simplicity in MVP, rejecting might mean setting status to cancelled or just deleting it.
        // Let's set is_verified to false and status to cancelled.
        $kajian->update([
            'is_verified' => false,
            'status' => 'cancelled'
        ]);

        return redirect()->route('admin.kajian.index')->with('success', 'Kajian berhasil ditolak/dibatalkan.');
    }
}
