<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Speaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
class SpeakerController extends Controller
{
    public function index()
    {
        $speakers = Speaker::all();
        
        $speakers->map(function ($speaker) {
            $speaker->photo_url = $speaker->photo ? url(Storage::url($speaker->photo)) : null;
            return $speaker;
        });
        return response()->json([
            'success' => true,
            'message' => 'Daftar semua pemateri',
            'data'    => $speakers
        ], 200);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors()
            ], 422);
        }
        $validated = $validator->validated();
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('speakers', 'public');
            $validated['photo'] = $path;
        }
        $speaker = Speaker::create($validated);
        $speaker->photo_url = $speaker->photo ? url(Storage::url($speaker->photo)) : null;
        return response()->json([
            'success' => true,
            'message' => 'Pemateri berhasil ditambahkan',
            'data'    => $speaker
        ], 201);
    }
    public function show($id)
    {
        $speaker = Speaker::find($id);
        if (!$speaker) {
            return response()->json([
                'success' => false,
                'message' => 'Pemateri tidak ditemukan',
            ], 404);
        }
        $speaker->photo_url = $speaker->photo ? url(Storage::url($speaker->photo)) : null;
        return response()->json([
            'success' => true,
            'message' => 'Detail pemateri',
            'data'    => $speaker
        ], 200);
    }
    public function update(Request $request, $id)
    {
        $speaker = Speaker::find($id);
        if (!$speaker) {
            return response()->json([
                'success' => false,
                'message' => 'Pemateri tidak ditemukan',
            ], 404);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors()
            ], 422);
        }
        $validated = $validator->validated();
        if ($request->hasFile('photo')) {
            if ($speaker->photo && Storage::disk('public')->exists($speaker->photo)) {
                Storage::disk('public')->delete($speaker->photo);
            }
            $path = $request->file('photo')->store('speakers', 'public');
            $validated['photo'] = $path;
        }
        $speaker->update($validated);
        $speaker->photo_url = $speaker->photo ? url(Storage::url($speaker->photo)) : null;
        return response()->json([
            'success' => true,
            'message' => 'Pemateri berhasil diupdate',
            'data'    => $speaker
        ], 200);
    }
    public function destroy($id)
    {
        $speaker = Speaker::find($id);
        if (!$speaker) {
            return response()->json([
                'success' => false,
                'message' => 'Pemateri tidak ditemukan',
            ], 404);
        }
        if ($speaker->photo && Storage::disk('public')->exists($speaker->photo)) {
            Storage::disk('public')->delete($speaker->photo);
        }
        $speaker->delete();
        return response()->json([
            'success' => true,
            'message' => 'Pemateri berhasil dihapus',
        ], 200);
    }
}
