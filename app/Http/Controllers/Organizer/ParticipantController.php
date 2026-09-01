<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    public function index(\App\Models\Kajian $kajian)
    {
        // Ensure the kajian belongs to this organizer
        if ($kajian->organizer_id !== auth()->user()->organizer->id) {
            abort(403, 'Unauthorized action.');
        }

        // Get participants (attendees) for this kajian
        $participants = \App\Models\KajianAttendee::with('user')
            ->where('kajian_id', $kajian->id)
            ->latest()
            ->paginate(15);

        return view('organizer.participants', compact('kajian', 'participants'));
    }

    public function globalIndex()
    {
        // Get all kajians for this organizer
        $organizerId = auth()->user()->organizer->id;
        
        $participants = \App\Models\KajianAttendee::with(['user', 'kajian'])
            ->whereHas('kajian', function ($query) use ($organizerId) {
                $query->where('organizer_id', $organizerId);
            })
            ->latest()
            ->paginate(15);

        return view('organizer.participants_global', compact('participants'));
    }
    public function export()
    {
        $organizerId = auth()->user()->organizer->id;
        
        $participants = \App\Models\KajianAttendee::with(['user', 'kajian'])
            ->whereHas('kajian', function ($query) use ($organizerId) {
                $query->where('organizer_id', $organizerId);
            })
            ->latest()
            ->get();

        $filename = "data_peserta_kajian_" . date('Ymd_His') . ".xls";

        $html = $this->generateExcelHtml('Semua Kajian', $participants);

        return response($html)
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function exportKajian(\App\Models\Kajian $kajian)
    {
        // Ensure the kajian belongs to this organizer
        if ($kajian->organizer_id !== auth()->user()->organizer->id) {
            abort(403, 'Unauthorized action.');
        }

        $participants = \App\Models\KajianAttendee::with(['user', 'kajian'])
            ->where('kajian_id', $kajian->id)
            ->latest()
            ->get();

        $safeTitle = preg_replace('/[^a-zA-Z0-9_]/', '_', strtolower($kajian->title));
        $filename = "peserta_" . $safeTitle . "_" . date('Ymd_His') . ".xls";

        $html = $this->generateExcelHtml($kajian->title, $participants);

        return response($html)
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    private function generateExcelHtml($title, $participants)
    {
        $html = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
        $html .= '<head><meta charset="utf-8"></head>';
        $html .= '<body>';
        $html .= '<h3>Laporan Pendaftar: ' . htmlspecialchars($title) . '</h3>';
        $html .= '<table border="1" style="border-collapse: collapse;">';
        
        // Header
        $html .= '<thead>';
        $html .= '<tr style="background-color: #064e3b; color: #ffffff; font-weight: bold; text-align: center;">';
        $html .= '<th style="width: 50px; padding: 10px;">No</th>';
        $html .= '<th style="width: 200px; padding: 10px;">Nama Peserta</th>';
        $html .= '<th style="width: 250px; padding: 10px;">Email</th>';
        $html .= '<th style="width: 300px; padding: 10px;">Kajian</th>';
        $html .= '<th style="width: 150px; padding: 10px;">Tanggal Kajian</th>';
        $html .= '<th style="width: 150px; padding: 10px;">Waktu Daftar</th>';
        $html .= '<th style="width: 120px; padding: 10px;">Status</th>';
        $html .= '</tr>';
        $html .= '</thead>';

        // Body
        $html .= '<tbody>';
        $no = 1;
        foreach ($participants as $attendee) {
            $statusMap = [
                'registered' => 'Belum Hadir',
                'attended' => 'Hadir',
                'cancelled' => 'Dibatalkan',
            ];
            $status = $statusMap[$attendee->status] ?? $attendee->status;
            
            // Format dates neatly, use quotes or specific format to prevent Excel from converting it weirdly if needed
            $tanggalKajian = \Carbon\Carbon::parse($attendee->kajian->start_at)->format('d M Y, H:i');
            $waktuDaftar = $attendee->created_at->format('d M Y, H:i');

            $html .= '<tr>';
            $html .= '<td style="text-align: center; vertical-align: middle;">' . $no++ . '</td>';
            $html .= '<td style="vertical-align: middle;">' . htmlspecialchars($attendee->user->name) . '</td>';
            $html .= '<td style="vertical-align: middle;">' . htmlspecialchars($attendee->user->email) . '</td>';
            $html .= '<td style="vertical-align: middle;">' . htmlspecialchars($attendee->kajian->title) . '</td>';
            $html .= '<td style="text-align: center; vertical-align: middle;">' . $tanggalKajian . '</td>';
            $html .= '<td style="text-align: center; vertical-align: middle;">' . $waktuDaftar . '</td>';
            $html .= '<td style="text-align: center; vertical-align: middle; font-weight: bold;">' . $status . '</td>';
            $html .= '</tr>';
        }
        $html .= '</tbody>';
        $html .= '</table>';
        $html .= '</body></html>';

        return $html;
    }
}
