<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kajian;
class KajianController extends Controller
{
    public function index(Request $request)
    {
        $query = Kajian::with('organizer')->where('status', '!=', 'draft')->latest();
        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhereHas('organizer', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }
        
        $kajians = $query->paginate(10)->withQueryString();
        return view('admin.kajian.index', compact('kajians'));
    }

    public function create()
    {
        $organizers = \App\Models\Organizer::all();
        $categories = \App\Models\Category::all();
        $mosques = \App\Models\Mosque::all();
        $speakers = \App\Models\Speaker::all();
        return view('admin.kajian.create', compact('organizers', 'categories', 'mosques', 'speakers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'organizer_id' => 'required|exists:organizers,id',
            'mosque_name' => 'required|string',
            'speaker_id' => 'required|exists:speakers,id',
            'category_id' => 'required|exists:categories,id',
            'tanggal' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'address' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'google_maps_url' => 'nullable|url|max:500',
            'audience' => 'required|in:umum,ikhwan,akhwat',
            'description' => 'nullable|string',
            'quota' => 'nullable|integer|min:1',
            'price' => 'nullable|numeric|min:0',
            'status' => 'required|in:draft,published',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'facilities' => 'nullable|array',
            'facilities.*' => 'string'
        ]);
        
        $mosque = \App\Models\Mosque::firstOrCreate(
            ['name' => $request->mosque_name],
            [
                'address' => $request->address,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]
        );
        
        $isFree = $request->boolean('is_free');
        $data = array_merge($validated, [
            'mosque_id' => $mosque->id,
            'is_family_friendly' => $request->has('is_family_friendly'),
            'is_free' => $isFree,
            'price' => $isFree ? 0 : ($request->price ?? 0),
            'start_at' => $request->tanggal . ' ' . $request->start_time . ':00',
            'end_at' => $request->tanggal . ' ' . $request->end_time . ':00',
            'google_maps_url' => $request->google_maps_url,
            'facilities' => $request->has('facilities') ? json_encode($request->facilities) : null,
            'is_verified' => true, 
        ]);
        
        unset($data['tanggal'], $data['start_time'], $data['end_time'], $data['mosque_name']);
        
        if ($request->hasFile('poster')) {
            $data['poster'] = $request->file('poster')->store('posters', 'public');
        } else {
            $data['poster'] = null;
        }
        
        Kajian::create($data);
        return redirect()->route('admin.kajian.index')->with('success', 'Kajian created successfully.');
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
        
        $kajian->update([
            'is_verified' => false,
            'status' => 'cancelled'
        ]);
        return redirect()->route('admin.kajian.index')->with('success', 'Kajian berhasil ditolak/dibatalkan.');
    }
}
