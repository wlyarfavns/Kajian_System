<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MosqueController extends Controller
{
    public function index()
    {
        $mosques = \App\Models\Mosque::where('organizer_id', auth()->user()->organizer->id)->get();
        return view('organizer.mosque.index', compact('mosques'));
    }

    public function create()
    {
        return view('organizer.mosque.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'google_maps_url' => 'nullable|url',
        ]);

        $validated['organizer_id'] = auth()->user()->organizer->id;
        
        \App\Models\Mosque::create($validated);

        return redirect()->route('organizer.mosque.index')->with('success', 'Masjid berhasil ditambahkan.');
    }

    public function edit(\App\Models\Mosque $mosque)
    {
        if ($mosque->organizer_id !== auth()->user()->organizer->id) {
            abort(403);
        }
        return view('organizer.mosque.edit', compact('mosque'));
    }

    public function update(Request $request, \App\Models\Mosque $mosque)
    {
        if ($mosque->organizer_id !== auth()->user()->organizer->id) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'google_maps_url' => 'nullable|url',
        ]);

        $mosque->update($validated);

        return redirect()->route('organizer.mosque.index')->with('success', 'Masjid berhasil diperbarui.');
    }

    public function destroy(\App\Models\Mosque $mosque)
    {
        if ($mosque->organizer_id !== auth()->user()->organizer->id) {
            abort(403);
        }
        
        $mosque->delete();
        return redirect()->route('organizer.mosque.index')->with('success', 'Masjid berhasil dihapus.');
    }
}
