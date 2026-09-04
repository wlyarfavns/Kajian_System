<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Speaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class SpeakerController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Speaker::withCount('kajians')->latest();
        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }
        
        $speakers = $query->paginate(10)->withQueryString();
        return view('admin.speaker.index', compact('speakers'));
    }
    public function create()
    {
        return view('admin.speaker.create');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('speakers', 'public');
            $validated['photo'] = $path;
        }
        Speaker::create($validated);
        return redirect()->route('admin.speaker.index')->with('success', 'Speaker created successfully.');
    }
    public function show(Speaker $speaker)
    {
        return view('admin.speaker.show', compact('speaker'));
    }
    public function edit(Speaker $speaker)
    {
        return view('admin.speaker.edit', compact('speaker'));
    }
    public function update(Request $request, Speaker $speaker)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($request->hasFile('photo')) {
            if ($speaker->photo && Storage::disk('public')->exists($speaker->photo)) {
                Storage::disk('public')->delete($speaker->photo);
            }
            $path = $request->file('photo')->store('speakers', 'public');
            $validated['photo'] = $path;
        }
        $speaker->update($validated);
        return redirect()->route('admin.speaker.index')->with('success', 'Speaker updated successfully.');
    }
    public function destroy(Speaker $speaker)
    {
        if ($speaker->photo && Storage::disk('public')->exists($speaker->photo)) {
            Storage::disk('public')->delete($speaker->photo);
        }
        $speaker->delete();
        return redirect()->route('admin.speaker.index')->with('success', 'Speaker deleted successfully.');
    }
}
