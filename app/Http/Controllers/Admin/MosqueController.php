<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class MosqueController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $mosques = \App\Models\Mosque::with('organizer')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                             ->orWhere('address', 'like', "%{$search}%")
                             ->orWhereHas('organizer', function ($oq) use ($search) {
                                 $oq->where('name', 'like', "%{$search}%");
                             });
            })
            ->latest()
            ->paginate(10)
            ->appends(['search' => $search]);
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
