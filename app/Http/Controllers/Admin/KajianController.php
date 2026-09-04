<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kajian;
class KajianController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $kajians = Kajian::with('organizer')->where('status', '!=', 'draft')
            ->when($search, function ($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhereHas('organizer', function ($oq) use ($search) {
                          $oq->where('name', 'like', "%{$search}%");
                      });
                });
            })
            ->latest()
            ->paginate(10)
            ->appends(['search' => $search]);
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
