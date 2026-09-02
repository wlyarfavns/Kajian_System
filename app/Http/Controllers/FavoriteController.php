<?php
namespace App\Http\Controllers;
use App\Models\Kajian;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = Favorite::with(['kajian.organizer', 'kajian.mosque', 'kajian.category', 'kajian.speaker'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);
        return view('user.saved', compact('favorites'));
    }
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
