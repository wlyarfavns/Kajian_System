<?php
namespace App\Http\Controllers\Organizer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mosque;
use Illuminate\Support\Facades\Auth;
class MosqueController extends Controller
{
    public function index(Request $request)
    {
        $organizer = Auth::user()->organizer;
        
        $query = Mosque::where('organizer_id', $organizer->id)->latest();
        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }
        
        $mosques = $query->paginate(10)->withQueryString();
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
