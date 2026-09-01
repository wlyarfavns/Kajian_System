<x-organizer-layout>
    <x-slot name="header">
        Kajian Berhasil Dipublikasikan
    </x-slot>

    <div class="max-w-3xl mx-auto bg-white rounded-2xl border border-gray-100 shadow-sm p-8 text-center mt-6">
        <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-6">
            <i data-lucide="check-circle" class="w-8 h-8"></i>
        </div>
        
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Kajian "{{ $kajian->title }}"</h2>
        <p class="text-gray-500 mb-8">Kajian berhasil dipublikasikan. Silakan unduh QR Code di bawah ini untuk dibagikan kepada jamaah agar mereka dapat melakukan pendaftaran dengan mudah.</p>

        <div class="flex flex-col items-center justify-center bg-gray-50 p-8 rounded-xl border border-gray-200 mb-8">
            <!-- QR Code Container -->
            <div id="qrcode" class="bg-white p-4 rounded-lg shadow-sm mb-4 inline-block"></div>
            
            <p class="text-sm font-medium text-gray-600">Scan untuk membuka halaman kajian</p>
        </div>

        <div class="flex items-center justify-center gap-4">
            <a href="{{ route('organizer.kajian.index') }}" class="px-6 py-2.5 bg-gray-100 text-gray-700 font-medium rounded-xl hover:bg-gray-200 transition-colors">
                Kembali ke Jadwal
            </a>
            <button type="button" id="downloadBtn" class="px-6 py-2.5 bg-brand-emerald-900 text-white font-medium rounded-xl hover:bg-brand-emerald-950 transition-colors shadow-sm flex items-center">
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
                width: 256,
                height: 256,
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
