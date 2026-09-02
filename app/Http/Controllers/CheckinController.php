<?php
namespace App\Http\Controllers;
use App\Models\Kajian;
use App\Models\KajianAttendee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class CheckinController extends Controller
{
    public function store($uuid)
    {
        $kajian = Kajian::where('uuid', $uuid)->firstOrFail();
        $attendee = KajianAttendee::where('user_id', Auth::id())
            ->where('kajian_id', $kajian->id)
            ->first();
        if ($attendee) {
            $attendee->update([
                'status' => 'attended',
                'checked_in_at' => now(),
            ]);
        } else {
            
            KajianAttendee::create([
                'user_id' => Auth::id(),
                'kajian_id' => $kajian->id,
                'status' => 'attended',
                'checked_in_at' => now(),
            ]);
        }
        return redirect()->route('kajian.show', $kajian->slug)
            ->with('status', 'Check-in berhasil! Selamat mengikuti kajian.');
    }
}
