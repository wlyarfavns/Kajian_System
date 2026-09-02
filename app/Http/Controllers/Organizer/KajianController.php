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
    public function index(Request $request)
    {
        $organizerId = auth()->user()->organizer->id;
        $query = Kajian::where('organizer_id', $organizerId);

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($subQ) use ($q) {
                $subQ->where('title', 'like', "%{$q}%")
                     ->orWhere('description', 'like', "%{$q}%");
            });
        }

        $kajians = $query->latest()->paginate(15)->appends($request->query());
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
            'google_maps_url' => 'nullable|url',
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

        $data = array_merge($validated, [
            'organizer_id' => $organizerId,
            'is_family_friendly' => $request->has('is_family_friendly'),
            'is_free' => $request->has('is_free'),
            'start_at' => $request->tanggal . ' ' . $request->start_time . ':00',
            'end_at' => $request->tanggal . ' ' . $request->end_time . ':00',
            'facilities' => $request->has('facilities') ? json_encode($request->facilities) : null,
            'price' => $request->has('is_free') ? 0 : ($validated['price'] ?? 0),
        ]);
        
        unset($data['tanggal'], $data['start_time'], $data['end_time']);

        if ($request->hasFile('poster')) {
            $data['poster'] = $request->file('poster')->store('posters', 'public');
        } else {
            $data['poster'] = null;
        }

        $kajian = Kajian::create($data);

        // Notify all admins
        $admins = \App\Models\User::where('role', 'admin')->get();
        if ($admins->count() > 0) {
            $organizer = auth()->user()->organizer;
            \Illuminate\Support\Facades\Notification::send($admins, new \App\Notifications\NewKajianSubmitted($kajian, $organizer));
        }

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
            'google_maps_url' => 'nullable|url',
            'audience' => 'required|in:umum,ikhwan,akhwat',
            'description' => 'nullable|string',
            'quota' => 'nullable|integer|min:1',
            'price' => 'nullable|numeric|min:0',
            'status' => 'required|in:draft,published',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'facilities' => 'nullable|array',
            'facilities.*' => 'string'
        ]);

        $data = array_merge($validated, [
            'is_family_friendly' => $request->has('is_family_friendly'),
            'is_free' => $request->has('is_free'),
            'start_at' => $request->tanggal . ' ' . $request->start_time . ':00',
            'end_at' => $request->tanggal . ' ' . $request->end_time . ':00',
            'facilities' => $request->has('facilities') ? json_encode($request->facilities) : null,
            'price' => $request->has('is_free') ? 0 : ($validated['price'] ?? 0),
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
