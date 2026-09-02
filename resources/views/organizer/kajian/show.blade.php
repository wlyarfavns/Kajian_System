<x-organizer-layout>
    <x-slot name="header">
        Detail Kajian
    </x-slot>

    <div class="max-w-5xl mx-auto">
        <!-- Action Buttons -->
        <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <a href="{{ route('organizer.kajian.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-brand-emerald-800 transition">
                <i data-lucide="arrow-left" class="w-4 h-4 mr-1"></i> Kembali ke Daftar Kajian
            </a>
            
            <div class="flex gap-2 w-full sm:w-auto">
                <a href="{{ url('/organizer/kajian/'.$kajian->slug.'/peserta') }}" class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 bg-white border border-gray-300 text-brand-ink text-sm font-medium rounded-lg hover:bg-gray-50 transition shadow-sm">
                    <i data-lucide="users" class="w-4 h-4 mr-2"></i> Daftar Peserta
                </a>
                <a href="{{ route('organizer.kajian.edit', $kajian->slug) }}" class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 bg-brand-emerald-900 text-white text-sm font-medium rounded-lg hover:bg-brand-emerald-950 transition shadow-sm">
                    <i data-lucide="edit" class="w-4 h-4 mr-2"></i> Edit Kajian
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Kolom Info Kajian (Kiri & Tengah) -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Card Utama -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    @if($kajian->poster)
                        <img src="{{ asset('storage/' . $kajian->poster) }}" alt="{{ $kajian->title }}" class="w-full h-64 object-cover object-center">
                    @else
                        <div class="w-full h-32 bg-brand-emerald-900/10 flex items-center justify-center">
                            <i data-lucide="book-open" class="w-12 h-12 text-brand-emerald-900/30"></i>
                        </div>
                    @endif
                    
                    <div class="p-6">
                        <div class="flex flex-wrap gap-2 mb-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-brand-emerald-100 text-brand-emerald-950">
                                {{ $kajian->category->name ?? 'Tanpa Kategori' }}
                            </span>
                            @if($kajian->status === 'published' && $kajian->is_verified)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <i data-lucide="check-circle-2" class="w-3 h-3 mr-1"></i> Terverifikasi Publik
                                </span>
                            @elseif($kajian->status === 'published' && !$kajian->is_verified)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                    <i data-lucide="clock" class="w-3 h-3 mr-1"></i> Menunggu Verifikasi Admin
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    Draft
                                </span>
                            @endif
                        </div>

                        <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $kajian->title }}</h1>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                            <div class="flex items-start">
                                <i data-lucide="calendar" class="w-5 h-5 text-gray-400 mt-0.5 mr-3"></i>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Tanggal & Waktu</p>
                                    <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($kajian->start_at)->translatedFormat('l, d F Y') }}</p>
                                    <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($kajian->start_at)->format('H:i') }} - {{ \Carbon\Carbon::parse($kajian->end_at)->format('H:i') }} WIB</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <i data-lucide="mic" class="w-5 h-5 text-gray-400 mt-0.5 mr-3"></i>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Pemateri</p>
                                    <p class="text-sm text-gray-500">{{ $kajian->speaker->name ?? '-' }}</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <i data-lucide="map-pin" class="w-5 h-5 text-gray-400 mt-0.5 mr-3"></i>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Lokasi / Masjid</p>
                                    <p class="text-sm text-gray-500">{{ $kajian->mosque->name ?? '-' }}</p>
                                    <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ $kajian->address }}</p>
                                    @if($kajian->google_maps_url)
                                        <a href="{{ $kajian->google_maps_url }}" target="_blank" class="text-xs text-brand-emerald-600 hover:underline mt-1 inline-block">Buka di Google Maps</a>
                                    @endif
                                </div>
                            </div>

                            <div class="flex items-start">
                                <i data-lucide="users" class="w-5 h-5 text-gray-400 mt-0.5 mr-3"></i>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Audiens & Kuota</p>
                                    <p class="text-sm text-gray-500">Target: <span class="capitalize">{{ $kajian->audience }}</span></p>
                                    <p class="text-sm text-gray-500">Kuota: {{ $kajian->quota ? $kajian->quota . ' Orang' : 'Tidak Terbatas' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Deskripsi Lengkap -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Deskripsi Kajian</h3>
                    <div class="prose prose-sm max-w-none text-gray-600">
                        {!! nl2br(e($kajian->description ?: 'Belum ada deskripsi yang ditambahkan.')) !!}
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan (QR Code & Detail Tambahan) -->
            <div class="space-y-6">
                
                <!-- QR Code Card -->
                <div class="bg-white rounded-xl shadow-sm border border-brand-emerald-200 overflow-hidden relative">
                    <div class="absolute top-0 left-0 w-full h-2 bg-brand-emerald-500"></div>
                    <div class="p-6 text-center">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">QR Code Kehadiran</h3>
                        <p class="text-sm text-gray-500 mb-6">Tampilkan atau cetak QR Code ini agar peserta (jamaah) bisa melakukan check-in kehadiran di lokasi.</p>
                        
                        <div id="qrcode-container" class="inline-block bg-white p-4 rounded-xl border border-gray-200 shadow-sm mx-auto mb-4">
                            {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(200)->generate(url('/checkin/'.$kajian->uuid)) !!}
                        </div>
                        
                        <div>
                            <button onclick="downloadQRCode()" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 text-sm font-medium rounded-lg text-brand-ink hover:bg-gray-50 transition shadow-sm">
                                <i data-lucide="download" class="w-4 h-4 mr-2"></i> Download QR (.png)
                            </button>
                        </div>
                        
                        <p class="text-xs text-gray-400 mt-6 break-all px-4">
                            URL Alternatif: <br>
                            <a href="{{ url('/checkin/'.$kajian->uuid) }}" target="_blank" class="text-brand-emerald-600 hover:underline font-medium">{{ url('/checkin/'.$kajian->uuid) }}</a>
                        </p>
                    </div>
                </div>

                <!-- Statistik Kehadiran -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-sm font-bold text-gray-900 mb-4">Statistik Pendaftar</h3>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm text-gray-500">Total Pendaftar</span>
                        <span class="text-lg font-bold text-gray-900">{{ $kajian->attendees()->count() }}</span>
                    </div>
                    @if($kajian->quota)
                        <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                            @php
                                $percentage = min(100, ($kajian->attendees()->count() / $kajian->quota) * 100);
                            @endphp
                            <div class="bg-brand-emerald-500 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                        </div>
                        <p class="text-xs text-gray-500 mt-2 text-right">{{ $kajian->quota - $kajian->attendees()->count() }} kursi tersisa</p>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <!-- Script to download QR Code -->
    <script>
        function downloadQRCode() {
            const svgElement = document.querySelector('#qrcode-container svg');
            if (!svgElement) return;

            // Ensure XML namespace exists
            if (!svgElement.getAttribute('xmlns')) {
                svgElement.setAttribute('xmlns', 'http://www.w3.org/2000/svg');
            }

            const svgData = new XMLSerializer().serializeToString(svgElement);
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');
            const img = new Image();

            // Set size directly based on QR code size to ensure sharpness
            const size = 300; 
            canvas.width = size;
            canvas.height = size;

            img.onload = function() {
                // Fill with white background
                ctx.fillStyle = '#ffffff';
                ctx.fillRect(0, 0, canvas.width, canvas.height);
                
                // Add padding inside canvas
                const padding = 20;
                ctx.drawImage(img, padding, padding, size - (padding * 2), size - (padding * 2));

                const pngUrl = canvas.toDataURL('image/png');
                const downloadLink = document.createElement('a');
                downloadLink.download = 'QR-Code-{{ Str::slug($kajian->title) }}.png';
                downloadLink.href = pngUrl;
                downloadLink.click();
            };

            img.src = 'data:image/svg+xml;base64,' + btoa(unescape(encodeURIComponent(svgData)));
        }
    </script>
</x-organizer-layout>
