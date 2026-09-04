<?php
namespace App\Http\Controllers;
use App\Models\Kajian;
use App\Models\Category;
use Illuminate\Http\Request;
class HomeController extends Controller
{
    public function index(Request $request)
    {
        $lat = $request->query('lat');
        $lng = $request->query('lng');
        $categories = Category::orderBy('name')->get();
        $query = Kajian::with(['organizer', 'mosque', 'speaker', 'category', 'favoritedBy']);
        if ($lat && $lng) {
            $kajians = clone $query;
            $kajians = $kajians->nearby($lat, $lng, 5)->take(3)->get();
            if ($kajians->isEmpty()) {
                $fallbackQuery = clone $query;
                $kajians = $fallbackQuery->nearby($lat, $lng, 10)->take(3)->get();
            }
        } else {
            $kajians = $query->nearby(null, null)->take(3)->get();
        }
        return view('home', compact('kajians', 'categories', 'lat', 'lng'));
    }
}
