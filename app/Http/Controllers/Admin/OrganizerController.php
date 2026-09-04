<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class OrganizerController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $organizers = \App\Models\Organizer::with('user')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                             ->orWhereHas('user', function ($q) use ($search) {
                                 $q->where('name', 'like', "%{$search}%")
                                   ->orWhere('email', 'like', "%{$search}%");
                             });
            })
            ->latest()
            ->paginate(10)
            ->appends(['search' => $search]);
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
