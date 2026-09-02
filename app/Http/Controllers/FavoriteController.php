<?php

namespace App\Http\Controllers;

use App\Models\Kajian;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Tampilkan daftar kajian yang disimpan (difavoritkan) oleh user.
     */
    public function index(Request $request)
    {
        $query = Favorite::with(['kajian.organizer', 'kajian.mosque', 'kajian.category', 'kajian.speaker'])
            ->where('user_id', Auth::id());

        if ($request->filled('q')) {
            $q = $request->q;
            $query->whereHas('kajian', function ($subQ) use ($q) {
                $subQ->where('title', 'like', "%{$q}%")
                     ->orWhere('description', 'like', "%{$q}%")
                     ->orWhereHas('speaker', function ($spQ) use ($q) {
                         $spQ->where('name', 'like', "%{$q}%");
                     })
                     ->orWhereHas('mosque', function ($mqQ) use ($q) {
                         $mqQ->where('name', 'like', "%{$q}%");
                     });
            });
        }

        $favorites = $query->latest()->paginate(10)->appends($request->query());

        return view('user.saved', compact('favorites'));
    }

    /**
     * Toggle simpan/hapus kajian dari favorit.
     */
    public function toggle(Kajian $kajian)
    {
        $favorite = Favorite::where('user_id', Auth::id())
            ->where('kajian_id', $kajian->id)
            ->first();

        if ($favorite) {
            $favorite->delete();
            return back()->with('status', 'Kajian dihapus dari daftar tersimpan.');
        } else {
            Favorite::create([
                'user_id' => Auth::id(),
                'kajian_id' => $kajian->id,
            ]);
            return back()->with('status', 'Kajian berhasil disimpan!');
        }
    }
}
