<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MosqueController extends Controller
{
    public function index()
    {
        // Admin sees all mosques
        $mosques = \App\Models\Mosque::with('organizer')->get();
        return view('admin.mosque.index', compact('mosques'));
    }

    public function create()
    {
        $organizers = \App\Models\Organizer::all();
        return view('admin.mosque.create', compact('organizers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'organizer_id' => 'required|exists:organizers,id',
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'google_maps_url' => 'nullable|url',
        ]);
        
        \App\Models\Mosque::create($validated);

        return redirect()->route('admin.mosque.index')->with('success', 'Masjid berhasil ditambahkan.');
    }

    public function edit(\App\Models\Mosque $mosque)
    {
        $organizers = \App\Models\Organizer::all();
        return view('admin.mosque.edit', compact('mosque', 'organizers'));
    }

    public function update(Request $request, \App\Models\Mosque $mosque)
    {
        $validated = $request->validate([
            'organizer_id' => 'required|exists:organizers,id',
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'google_maps_url' => 'nullable|url',
        ]);

        $mosque->update($validated);

        return redirect()->route('admin.mosque.index')->with('success', 'Masjid berhasil diperbarui.');
    }

    public function destroy(\App\Models\Mosque $mosque)
    {
        $mosque->delete();
        return redirect()->route('admin.mosque.index')->with('success', 'Masjid berhasil dihapus.');
    }
}
