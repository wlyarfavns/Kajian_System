<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Kajian;
use App\Models\Category;
use App\Models\Mosque;
use App\Models\Speaker;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KajianController extends Controller
{
    public function index()
    {
        $organizerId = auth()->user()->organizer->id;
        $kajians = Kajian::where('organizer_id', $organizerId)->latest()->get();
        return view('organizer.kajian.index', compact('kajians'));
    }

    public function create()
    {
        $organizerId = auth()->user()->organizer->id;
        $categories = Category::all();
        $mosques = Mosque::where('organizer_id', $organizerId)->get();
        $speakers = Speaker::all();
        return view('organizer.kajian.create', compact('categories', 'mosques', 'speakers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'mosque_id' => 'required|exists:mosques,id',
            'speaker_id' => 'required|exists:speakers,id',
            'category_id' => 'required|exists:categories,id',
            'tanggal' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'address' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'audience' => 'required|in:umum,ikhwan,akhwat',
            'description' => 'nullable|string',
            'quota' => 'nullable|integer|min:1',
            'price' => 'nullable|numeric|min:0',
            'status' => 'required|in:draft,published',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'facilities' => 'nullable|array',
            'facilities.*' => 'string'
        ]);

        $organizerId = auth()->user()->organizer->id;

        $isFree = $request->boolean('is_free');
        
        $data = array_merge($validated, [
            'organizer_id' => $organizerId,
            'is_family_friendly' => $request->has('is_family_friendly'),
            'is_free' => $isFree,
            'price' => $isFree ? 0 : ($request->price ?? 0),
            'start_at' => $request->tanggal . ' ' . $request->start_time . ':00',
            'end_at' => $request->tanggal . ' ' . $request->end_time . ':00',
            'facilities' => $request->has('facilities') ? json_encode($request->facilities) : null,
        ]);
        
        unset($data['tanggal'], $data['start_time'], $data['end_time']);

        if ($request->hasFile('poster')) {
            $data['poster'] = $request->file('poster')->store('posters', 'public');
        } else {
            $data['poster'] = null;
        }

        Kajian::create($data);

        return redirect()->route('organizer.kajian.index')->with('success', 'Kajian created successfully.');
    }

    public function show(Kajian $kajian)
    {
        return view('organizer.kajian.show', compact('kajian'));
    }

    public function edit(Kajian $kajian)
    {
        $organizerId = auth()->user()->organizer->id;
        if ($kajian->organizer_id !== $organizerId) abort(403);

        $categories = Category::all();
        $mosques = Mosque::where('organizer_id', $organizerId)->get();
        $speakers = Speaker::all();
        return view('organizer.kajian.edit', compact('kajian', 'categories', 'mosques', 'speakers'));
    }

    public function update(Request $request, Kajian $kajian)
    {
        if ($kajian->organizer_id !== auth()->user()->organizer->id) abort(403);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'mosque_id' => 'required|exists:mosques,id',
            'speaker_id' => 'required|exists:speakers,id',
            'category_id' => 'required|exists:categories,id',
            'tanggal' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'address' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'audience' => 'required|in:umum,ikhwan,akhwat',
            'description' => 'nullable|string',
            'quota' => 'nullable|integer|min:1',
            'price' => 'nullable|numeric|min:0',
            'status' => 'required|in:draft,published',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'facilities' => 'nullable|array',
            'facilities.*' => 'string'
        ]);

        $isFree = $request->boolean('is_free');

        $data = array_merge($validated, [
            'is_family_friendly' => $request->has('is_family_friendly'),
            'is_free' => $isFree,
            'price' => $isFree ? 0 : ($request->price ?? 0),
            'start_at' => $request->tanggal . ' ' . $request->start_time . ':00',
            'end_at' => $request->tanggal . ' ' . $request->end_time . ':00',
            'facilities' => $request->has('facilities') ? json_encode($request->facilities) : null,
        ]);
        
        unset($data['tanggal'], $data['start_time'], $data['end_time']);

        if ($request->hasFile('poster')) {
            // Delete old poster if exists
            if ($kajian->poster && \Illuminate\Support\Facades\Storage::disk('public')->exists($kajian->poster)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($kajian->poster);
            }
            $data['poster'] = $request->file('poster')->store('posters', 'public');
        }

        $kajian->update($data);

        return redirect()->route('organizer.kajian.index')->with('success', 'Kajian updated successfully.');
    }

    public function destroy(Kajian $kajian)
    {
        if ($kajian->organizer_id !== auth()->user()->organizer->id) abort(403);
        $kajian->delete();
        return redirect()->route('organizer.kajian.index')->with('success', 'Kajian deleted successfully.');
    }
}
