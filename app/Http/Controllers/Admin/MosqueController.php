<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MosqueController extends Controller
{
    public function index()
    {
        // Admin sees all mosques, paginated by 10
        $mosques = \App\Models\Mosque::with('organizer')->paginate(10);
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
            'address' => 'nullable|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'google_maps_url' => 'nullable|url',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'photo.image' => 'File harus berupa gambar.',
            'photo.mimes' => 'Format foto harus berupa jpeg, png, jpg, atau gif.',
            'photo.max' => 'Ukuran foto maksimal adalah 2MB.',
        ]);
        
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('mosques', 'public');
            $validated['photo'] = $path;
        }
        
        $mosque = \App\Models\Mosque::create($validated);

        // Notify organizer
        if ($mosque->organizer && $mosque->organizer->user) {
            $mosque->organizer->user->notify(new \App\Notifications\MosqueAddedByAdmin($mosque));
        }

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
            'address' => 'nullable|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'google_maps_url' => 'nullable|url',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'photo.image' => 'File harus berupa gambar.',
            'photo.mimes' => 'Format foto harus berupa jpeg, png, jpg, atau gif.',
            'photo.max' => 'Ukuran foto maksimal adalah 2MB.',
        ]);

        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($mosque->photo && Storage::disk('public')->exists($mosque->photo)) {
                Storage::disk('public')->delete($mosque->photo);
            }
            $path = $request->file('photo')->store('mosques', 'public');
            $validated['photo'] = $path;
        }

        $mosque->update($validated);

        return redirect()->route('admin.mosque.index')->with('success', 'Masjid berhasil diperbarui.');
    }

    public function destroy(\App\Models\Mosque $mosque)
    {
        if ($mosque->photo && Storage::disk('public')->exists($mosque->photo)) {
            Storage::disk('public')->delete($mosque->photo);
        }

        $mosque->delete();
        return redirect()->route('admin.mosque.index')->with('success', 'Masjid berhasil dihapus.');
    }
}
