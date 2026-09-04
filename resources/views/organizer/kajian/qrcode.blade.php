<x-organizer-layout>
    <x-slot name="header">
        Kajian Berhasil Dipublikasikan
    </x-slot>

    <div class="max-w-2xl mx-auto bg-white rounded-2xl border border-gray-100 shadow-sm p-6 text-center mt-4">
        <div class="w-14 h-14 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4">
            <i data-lucide="check-circle" class="w-7 h-7"></i>
        </div>
        
        <h2 class="text-xl font-bold text-gray-900 mb-2">Kajian "{{ $kajian->title }}"</h2>
        <p class="text-sm text-gray-500 mb-6">Kajian berhasil dipublikasikan. Silakan unduh QR Code di bawah ini untuk dibagikan kepada jamaah agar mereka dapat melakukan pendaftaran dengan mudah.</p>

        <div class="flex flex-col items-center justify-center bg-gray-50 py-5 px-6 rounded-xl border border-gray-200 mb-6">
            <!-- QR Code Container -->
            <div id="qrcode" class="bg-white p-3 rounded-lg shadow-sm mb-3 inline-block"></div>
            
            <p class="text-sm font-medium text-gray-600">Scan untuk membuka halaman kajian</p>
        </div>

        <div class="flex items-center justify-center gap-4">
            <a href="{{ route('organizer.kajian.index') }}" class="px-5 py-2 bg-gray-100 text-gray-700 font-medium rounded-xl hover:bg-gray-200 transition-colors">
                Kembali ke Jadwal
            </a>
            <button type="button" id="downloadBtn" class="px-5 py-2 bg-brand-emerald-900 text-white font-medium rounded-xl hover:bg-brand-emerald-950 transition-colors shadow-sm flex items-center">
                <i data-lucide="download" class="w-4 h-4 mr-2"></i>
                Download QR Code
            </button>
        </div>
    </div>

    <!-- Pindahkan scripts load dari slot ke bagian bawah -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const url = "{{ route('kajian.show', $kajian->slug) }}";
            
            // Generate QR Code
            const qrcode = new QRCode(document.getElementById("qrcode"), {
                text: url,
                width: 200,
                height: 200,
                colorDark : "#0A2B20",
                colorLight : "#ffffff",
                correctLevel : QRCode.CorrectLevel.H
            });

            // Download Logic
            document.getElementById('downloadBtn').addEventListener('click', function() {
                const container = document.getElementById('qrcode');
                const canvas = container.querySelector('canvas');
                let imgData = null;
                
                if (canvas) {
                    imgData = canvas.toDataURL("image/png");
                } else {
                    const img = container.querySelector('img');
                    if (img) {
                        imgData = img.src;
                    }
                }

                if (imgData) {
                    const a = document.createElement("a");
                    a.href = imgData;
                    a.download = "QR-Code-{{ Str::slug($kajian->title) }}.png";
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                } else {
                    alert('Gagal mengunduh QR Code. Silakan klik kanan pada gambar dan pilih Simpan.');
                }
            });
        });
    </script>
</x-organizer-layout>
