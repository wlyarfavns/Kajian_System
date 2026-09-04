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
