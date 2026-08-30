<h1>Detail Kajian: {{ $kajian->title }}</h1>

<table border="1" cellpadding="5">
    <tr>
        <th>Kategori</th>
        <td>{{ $kajian->category->name ?? '-' }}</td>
    </tr>
    <tr>
        <th>Masjid</th>
        <td>{{ $kajian->mosque->name ?? '-' }}</td>
    </tr>
    <tr>
        <th>Pemateri</th>
        <td>{{ $kajian->speaker->name ?? '-' }}</td>
    </tr>
    <tr>
        <th>Waktu Mulai</th>
        <td>{{ $kajian->start_at }}</td>
    </tr>
    <tr>
        <th>Waktu Selesai</th>
        <td>{{ $kajian->end_at }}</td>
    </tr>
    <tr>
        <th>Audiens</th>
        <td>{{ $kajian->audience }}</td>
    </tr>
    <tr>
        <th>Alamat Lengkap</th>
        <td>{{ $kajian->address }}</td>
    </tr>
    <tr>
        <th>Koordinat (Lat, Lng)</th>
        <td>{{ $kajian->latitude }}, {{ $kajian->longitude }}</td>
    </tr>
</table>



<div style="margin-top: 30px; padding: 20px; border: 1px solid #ccc; border-radius: 8px; display: inline-block; text-align: center;">
    <h3 style="margin-top: 0;">QR Code Check-in</h3>
    <p style="font-size: 14px; color: #666; margin-bottom: 20px;">Tampilkan atau cetak QR ini agar jamaah bisa scan menggunakan kamera HP mereka.</p>
    
    <div id="qrcode" style="display: flex; justify-content: center; margin-bottom: 15px;"></div>
    
    <p style="font-size: 12px; color: #999;">URL Tujuan: {{ url('/checkin/'.$kajian->uuid) }}</p>
</div>

<br><br>
<a href="{{ route('organizer.kajian.edit', $kajian->slug) }}">Edit</a> |
<a href="{{ route('organizer.kajian.index') }}">Kembali ke Daftar</a>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var qrCodeContainer = document.getElementById("qrcode");
        var url = "{{ url('/checkin/'.$kajian->uuid) }}";
        
        new QRCode(qrCodeContainer, {
            text: url,
            width: 200,
            height: 200,
            colorDark : "#061A13",
            colorLight : "#ffffff",
            correctLevel : QRCode.CorrectLevel.H
        });
    });
</script>
