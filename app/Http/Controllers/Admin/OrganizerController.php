<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class OrganizerController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Organizer::with('user')->latest();
        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('email', 'like', "%{$search}%");
                  });
            });
        }
        
        $organizers = $query->paginate(10)->withQueryString();
        return view('admin.organizer.index', compact('organizers'));
    }
    public function verify(\App\Models\Organizer $organizer)
    {
        $organizer->update([
            'is_verified' => !$organizer->is_verified
        ]);
        return back()->with('success', 'Status verifikasi organizer berhasil diperbarui.');
    }
}
