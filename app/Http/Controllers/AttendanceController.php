<?php

namespace App\Http\Controllers;

use App\Models\Kajian;
use App\Models\KajianAttendee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    /**
     * Tampilkan daftar kajian yang akan/sudah dihadiri user.
     */
    public function index(Request $request)
    {
        $query = KajianAttendee::with(['kajian.organizer', 'kajian.mosque', 'kajian.category', 'kajian.speaker'])
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

        $attendances = $query->latest()->paginate(10)->appends($request->query());

        return view('user.my-kajian', compact('attendances'));
    }

    /**
     * Daftar (Saya Mau Hadir) untuk sebuah kajian.
     */
    public function store(Kajian $kajian)
    {
        $attendee = KajianAttendee::where('user_id', Auth::id())
            ->where('kajian_id', $kajian->id)
            ->first();

        // Cek jika sudah terdaftar dan belum dibatalkan
        if ($attendee && $attendee->status !== 'cancelled') {
            return back()->with('status', 'Anda sudah terdaftar di kajian ini.');
        }

        // Cek kuota jika ada
        if ($kajian->quota !== null) {
            $registeredCount = KajianAttendee::where('kajian_id', $kajian->id)
                ->where('status', '!=', 'cancelled')
                ->count();
                
            if ($registeredCount >= $kajian->quota) {
                return back()->with('error', 'Mohon maaf, kuota pendaftaran sudah penuh.');
            }
        }

        if ($attendee && $attendee->status === 'cancelled') {
            $attendee->update(['status' => 'registered']);
        } else {
            $attendee = KajianAttendee::create([
                'user_id' => Auth::id(),
                'kajian_id' => $kajian->id,
                'status' => 'registered', // registered | attended | cancelled
            ]);
        }

        // Notify organizer
        if ($kajian->organizer && $kajian->organizer->user) {
            $kajian->organizer->user->notify(new \App\Notifications\UserRegisteredToKajian($kajian, Auth::user()));
        }

        return back()->with('status', 'Berhasil mendaftar! Anda akan menghadiri kajian ini.');
    }

    /**
     * Batalkan pendaftaran.
     */
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
