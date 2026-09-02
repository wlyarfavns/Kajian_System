<?php
namespace App\Http\Controllers;
use App\Models\Kajian;
use App\Models\KajianAttendee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = KajianAttendee::with(['kajian.organizer', 'kajian.mosque', 'kajian.category', 'kajian.speaker'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);
        return view('user.my-kajian', compact('attendances'));
    }
    public function store(Kajian $kajian)
    {
        $exists = KajianAttendee::where('user_id', Auth::id())
            ->where('kajian_id', $kajian->id)
            ->exists();
        if ($exists) {
            return back()->with('status', 'Anda sudah terdaftar di kajian ini.');
        }
        if ($kajian->quota !== null) {
            $registeredCount = KajianAttendee::where('kajian_id', $kajian->id)
                ->where('status', '!=', 'cancelled')
                ->count();
            if ($registeredCount >= $kajian->quota) {
                return back()->with('error', 'Mohon maaf, kuota pendaftaran sudah penuh.');
            }
        }
        KajianAttendee::create([
            'user_id' => Auth::id(),
            'kajian_id' => $kajian->id,
            'status' => 'registered', 
        ]);
        return back()->with('status', 'Berhasil mendaftar! Anda akan menghadiri kajian ini.');
    }
    public function destroy(Kajian $kajian)
    {
        $attendee = KajianAttendee::where('user_id', Auth::id())
            ->where('kajian_id', $kajian->id)
            ->first();
        if ($attendee) {
            $attendee->update(['status' => 'cancelled']);
            return back()->with('status', 'Pendaftaran berhasil dibatalkan.');
        }
        return back();
    }
}
