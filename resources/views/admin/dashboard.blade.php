<x-admin-layout>
    <div class="space-y-6">
        
        <!-- Top row: KPI Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
            <!-- Card 1 -->
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm col-span-1">
                <p class="text-sm text-gray-500 font-medium mb-1">Total Kajian</p>
                <div class="flex items-end justify-between mt-4">
                    <h3 class="text-2xl font-bold text-gray-900">{{ $totalKajian ?? 120 }}</h3>
                    <div class="w-16 h-8">
                        <!-- Mini sparkline mockup -->
                        <svg viewBox="0 0 50 20" class="w-full h-full stroke-emerald-500 fill-none" stroke-width="2">
                            <path d="M0,15 L10,10 L20,12 L30,5 L40,8 L50,2" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-emerald-500 font-medium flex items-center mt-2">
                    <i data-lucide="arrow-up" class="w-3 h-3 mr-1"></i> 8.2% <span class="text-gray-400 font-normal ml-1">Bulan Ini</span>
                </p>
            </div>

            <!-- Card 2 -->
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm col-span-1">
                <p class="text-sm text-gray-500 font-medium mb-1">Total Masjid</p>
                <div class="flex items-end justify-between mt-4">
                    <h3 class="text-2xl font-bold text-gray-900">{{ $totalMosque ?? 0 }}</h3>
                </div>
                <p class="text-xs text-gray-400 font-medium mt-2">Lokasi pelaksanaan kajian</p>
            </div>

            <!-- Card 3 -->
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm col-span-1">
                <p class="text-sm text-gray-500 font-medium mb-1">Kajian Terdekat</p>
                <div class="flex items-end justify-between mt-4">
                    <h3 class="text-2xl font-bold text-gray-900">{{ $kajianHariIni ?? 3 }}</h3>
                </div>
                <p class="text-xs text-gray-400 font-medium mt-2">Dalam 7 Hari Kedepan</p>
            </div>

            <!-- Card 4 -->
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm col-span-1">
                <p class="text-sm text-gray-500 font-medium mb-1">User Aktif</p>
                <div class="flex items-end justify-between mt-4">
                    <h3 class="text-2xl font-bold text-gray-900">{{ $totalUser ?? '1,867' }}</h3>
                    <div class="w-16 h-8">
                        <svg viewBox="0 0 50 20" class="w-full h-full stroke-emerald-500 fill-none" stroke-width="2">
                            <path d="M0,18 L10,12 L20,15 L30,8 L40,10 L50,4" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-emerald-500 font-medium flex items-center mt-2">
                    <i data-lucide="arrow-up" class="w-3 h-3 mr-1"></i> 52 <span class="text-gray-400 font-normal ml-1">Minggu Ini</span>
                </p>
            </div>

            <!-- Card 5: Total Organizer -->
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm col-span-1">
                <p class="text-sm text-gray-500 font-medium mb-1">Total Organizer</p>
                <div class="flex items-end justify-between mt-4">
                    <h3 class="text-2xl font-bold text-gray-900">{{ $totalOrganizer ?? 0 }}</h3>
                    <div class="w-10 h-10 bg-indigo-50 rounded-lg flex items-center justify-center text-indigo-600">
                        <i data-lucide="users" class="w-5 h-5"></i>
                    </div>
                </div>
                <p class="text-xs text-indigo-500 font-medium mt-2">Terdaftar di sistem</p>
            </div>
        </div>

        <!-- Middle row: Chart and To-Do List -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Line Chart (Pertumbuhan) -->
            <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm p-6 relative">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-lg font-bold text-gray-900">Pertumbuhan Pendaftar Kajian</h3>
                    <div class="px-3 py-1.5 border border-gray-200 rounded-lg text-sm text-gray-600 flex items-center cursor-pointer hover:bg-gray-50">
                        Mingguan <i data-lucide="chevron-down" class="w-4 h-4 ml-2 text-gray-400"></i>
                    </div>
                </div>

                <div class="flex items-center space-x-6 mb-6">
                    <button class="text-sm font-bold text-blue-600 border-b-2 border-blue-600 pb-2 flex items-center">
                        <i data-lucide="line-chart" class="w-4 h-4 mr-2"></i> Line Chart
                    </button>
                    <button class="text-sm font-medium text-gray-400 pb-2 flex items-center hover:text-gray-600">
                        <i data-lucide="bar-chart" class="w-4 h-4 mr-2"></i> Bar Chart
                    </button>
                </div>

                <!-- Chart Mockup (Matching Masjidhero style) -->
                <div class="w-full h-64 relative mt-4">
                    <!-- Grid Lines -->
                    <div class="absolute inset-0 flex flex-col justify-between pointer-events-none">
                        <div class="border-b border-gray-50 w-full flex items-end pb-1"><span class="text-xs text-gray-400 w-12">2000</span></div>
                        <div class="border-b border-gray-50 w-full flex items-end pb-1"><span class="text-xs text-gray-400 w-12">1500</span></div>
                        <div class="border-b border-gray-50 w-full flex items-end pb-1"><span class="text-xs text-gray-400 w-12">1000</span></div>
                        <div class="border-b border-gray-50 w-full flex items-end pb-1"><span class="text-xs text-gray-400 w-12">500</span></div>
                        <div class="border-b border-gray-50 w-full flex items-end pb-1"><span class="text-xs text-gray-400 w-12">0</span></div>
                    </div>
                    
                    <div class="ml-12 h-full relative">
                        <svg viewBox="0 0 800 200" class="w-full h-full" preserveAspectRatio="none">
                            <path d="M0,150 Q50,160 100,140 T200,150 T300,100 T400,120 T500,80 T600,60 T700,90 T800,40" fill="none" stroke="#ef4444" stroke-width="4" stroke-linecap="round"/>
                            <path d="M0,150 Q50,160 100,140 T200,150 T300,100 T400,120 T500,80 T600,60 T700,90 T800,40 L800,200 L0,200 Z" fill="url(#gradRed)" opacity="0.1"/>
                            
                            <defs>
                                <linearGradient id="gradRed" x1="0" y1="0" x2="0" y2="1">
                                    <stop offset="0%" stop-color="#ef4444" />
                                    <stop offset="100%" stop-color="rgba(239, 68, 68, 0)" />
                                </linearGradient>
                            </defs>
                        </svg>
                        
                        <!-- Tooltip Bubble -->
                        <div class="absolute top-[30%] left-[60%] -translate-x-1/2 bg-white p-4 rounded-xl shadow-xl text-sm border border-gray-100 z-10 w-48">
                            <div class="flex justify-between items-center mb-1"><span class="text-gray-500">Pendaftar</span><span class="font-bold text-gray-900">1,250</span></div>
                            <div class="flex justify-between items-center mb-2"><span class="text-gray-500">Total Kajian</span><span class="font-bold text-gray-900">45</span></div>
                            <div class="text-xs text-emerald-500 font-medium">+2.3% vs Minggu Lalu</div>
                        </div>
                        <div class="absolute top-[45%] left-[60%] w-4 h-4 bg-red-500 border-4 border-white rounded-full z-10 shadow-sm -translate-x-1/2 -translate-y-1/2"></div>
                    </div>
                </div>
            </div>

            <!-- To-Do & Alerts -->
            <div class="lg:col-span-1 bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-gray-900">Tugas & Peringatan</h3>
                    <a href="{{ route('admin.kajian.index') }}" class="px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg text-sm font-medium hover:bg-blue-100">View All</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-xs font-bold text-gray-400 border-b border-gray-100">
                                <th class="pb-3 font-medium">Tipe</th>
                                <th class="pb-3 font-medium">Judul</th>
                                <th class="pb-3 font-medium">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-sm">
                            <tr>
                                <td class="py-4 flex items-center text-gray-700 font-medium">
                                    <div class="w-2 h-2 rounded-full bg-gray-300 mr-2 border border-gray-400"></div> Menunggu
                                </td>
                                <td class="py-4 text-gray-900 font-bold">Review Kajian Fiqih...</td>
                                <td class="py-4"><span class="text-xs font-bold text-emerald-500 bg-emerald-50 px-2 py-1 rounded-md flex items-center w-max"><div class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></div> Awaiting</span></td>
                            </tr>
                            <tr>
                                <td class="py-4 flex items-center text-gray-700 font-medium">
                                    <div class="w-2 h-2 rounded-full bg-gray-300 mr-2 border border-gray-400"></div> Pendaftaran
                                </td>
                                <td class="py-4 text-gray-900 font-bold">Verifikasi Masjid A...</td>
                                <td class="py-4"><span class="text-xs font-bold text-red-500 bg-red-50 px-2 py-1 rounded-md flex items-center w-max"><div class="w-1.5 h-1.5 rounded-full bg-red-500 mr-1.5"></div> Pending</span></td>
                            </tr>
                            <tr>
                                <td class="py-4 flex items-center text-gray-700 font-medium">
                                    <div class="w-2 h-2 rounded-full bg-gray-300 mr-2 border border-gray-400"></div> Laporan
                                </td>
                                <td class="py-4 text-gray-900 font-bold">Komentar Spam...</td>
                                <td class="py-4"><span class="text-xs font-bold text-blue-500 bg-blue-50 px-2 py-1 rounded-md flex items-center w-max"><div class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-1.5"></div> New</span></td>
                            </tr>
                            <tr>
                                <td class="py-4 flex items-center text-gray-700 font-medium">
                                    <div class="w-2 h-2 rounded-full bg-gray-300 mr-2 border border-gray-400"></div> Sistem
                                </td>
                                <td class="py-4 text-gray-900 font-bold">Backup Database...</td>
                                <td class="py-4"><span class="text-xs font-bold text-gray-500 bg-gray-100 px-2 py-1 rounded-md flex items-center w-max"><div class="w-1.5 h-1.5 rounded-full bg-gray-500 mr-1.5"></div> Not Done</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Bottom row: Event List Table -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4">
                <h3 class="text-lg font-bold text-gray-900">Daftar Kajian</h3>
                
                <div class="flex items-center space-x-2 text-sm text-gray-500 bg-gray-50 rounded-lg p-1">
                    <button class="px-4 py-1.5 bg-white text-blue-600 font-medium rounded-md shadow-sm border border-gray-200 flex items-center">
                        <i data-lucide="calendar" class="w-4 h-4 mr-2"></i> Kajian
                    </button>
                    <button class="px-4 py-1.5 hover:text-gray-700 font-medium rounded-md transition-colors flex items-center">
                        <i data-lucide="users" class="w-4 h-4 mr-2"></i> Penyelenggara
                    </button>
                    <button class="px-4 py-1.5 hover:text-gray-700 font-medium rounded-md transition-colors flex items-center">
                        <i data-lucide="map-pin" class="w-4 h-4 mr-2"></i> Lokasi
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-xs font-bold text-gray-400 border-b border-gray-100 uppercase tracking-wider">
                            <th class="pb-3 font-medium">Nama Kajian</th>
                            <th class="pb-3 font-medium">Tanggal & Waktu</th>
                            <th class="pb-3 font-medium">Lokasi</th>
                            <th class="pb-3 font-medium">Status</th>
                            <th class="pb-3 font-medium">Kategori</th>
                            <th class="pb-3 font-medium text-right">Pendaftar</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-sm">
                        @forelse($recentKajians as $k)
                        <tr>
                            <td class="py-4 text-gray-900 font-bold">{{ $k->title }}</td>
                            <td class="py-4 text-gray-600 font-medium">{{ $k->start_at ? $k->start_at->format('M d, Y - H:i') : '-' }}</td>
                            <td class="py-4 text-gray-600 font-medium">{{ $k->mosque->name ?? '-' }}</td>
                            <td class="py-4">
                                @php
                                    $label = $k->status_label;
                                    $colorClass = 'text-orange-600 bg-orange-50';
                                    $dotClass = 'bg-orange-500';

                                    if ($label === 'Sedang Berlangsung') {
                                        $colorClass = 'text-emerald-600 bg-emerald-50';
                                        $dotClass = 'bg-emerald-500';
                                    } elseif ($label === 'Selesai') {
                                        $colorClass = 'text-gray-600 bg-gray-50';
                                        $dotClass = 'bg-gray-500';
                                    } elseif ($label === 'Dibatalkan') {
                                        $colorClass = 'text-red-600 bg-red-50';
                                        $dotClass = 'bg-red-500';
                                    } elseif ($label === 'Akan Datang') {
                                        $colorClass = 'text-blue-600 bg-blue-50';
                                        $dotClass = 'bg-blue-500';
                                    }
                                @endphp
                                <span class="text-xs font-bold {{ $colorClass }} px-2 py-1 rounded-md flex items-center w-max">
                                    <div class="w-1.5 h-1.5 rounded-full {{ $dotClass }} mr-1.5"></div> {{ $label }}
                                </span>
                            </td>
                            <td class="py-4 text-gray-600 font-medium">{{ $k->category->name ?? '-' }}</td>
                            <td class="py-4 text-gray-900 font-bold text-right">{{ $k->attendees_count }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-4 text-center text-gray-500 font-medium">Belum ada kajian</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4 flex justify-end">
                <!-- Float right action button similar to purple dot in Masjidhero -->
                <button class="w-10 h-10 bg-indigo-600 rounded-full flex items-center justify-center text-white shadow-lg hover:bg-indigo-700 transition-colors">
                    <i data-lucide="plus" class="w-5 h-5"></i>
                </button>
            </div>
        </div>

    </div>
</x-admin-layout>
