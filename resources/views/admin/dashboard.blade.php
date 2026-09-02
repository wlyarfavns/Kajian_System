<x-admin-layout>
    <div class="space-y-6">
        
        <!-- Top row: KPI Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Card 1 -->
            <a href="{{ route('admin.kajian.index') }}" class="block bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow hover:border-emerald-200 group">
                <p class="text-sm text-gray-500 font-medium mb-1 group-hover:text-emerald-600 transition-colors">Total Kajian</p>
                <div class="flex items-end justify-between mt-4">
                    <h3 class="text-2xl font-bold text-gray-900">{{ $totalKajian ?? 120 }}</h3>
                    <div class="w-16 h-8">
                        <!-- Mini sparkline mockup -->
                        <svg viewBox="0 0 50 20" class="w-full h-full stroke-emerald-500 fill-none group-hover:stroke-emerald-600" stroke-width="2">
                            <path d="M0,15 L10,10 L20,12 L30,5 L40,8 L50,2" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-gray-400 font-medium mt-2">Bulan Ini</p>
            </a>

            <!-- Card 2 -->
            <a href="{{ route('admin.mosque.index') }}" class="block bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow hover:border-emerald-200 group">
                <p class="text-sm text-gray-500 font-medium mb-1 group-hover:text-emerald-600 transition-colors">Total Masjid</p>
                <div class="flex items-end justify-between mt-4">
                    <h3 class="text-2xl font-bold text-gray-900">{{ $totalMosque ?? 0 }}</h3>
                    <div class="w-10 h-10 bg-emerald-50 rounded-lg flex items-center justify-center text-emerald-600 group-hover:bg-emerald-100 transition-colors">
                        <i data-lucide="map-pin" class="w-5 h-5"></i>
                    </div>
                </div>
                <p class="text-xs text-gray-400 font-medium mt-2">Lokasi pelaksanaan kajian</p>
            </a>

            <!-- Card 3 -->
            <a href="{{ route('admin.user.index') }}" class="block bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow hover:border-emerald-200 group">
                <p class="text-sm text-gray-500 font-medium mb-1 group-hover:text-emerald-600 transition-colors">User Aktif</p>
                <div class="flex items-end justify-between mt-4">
                    <h3 class="text-2xl font-bold text-gray-900">{{ $totalUser ?? '1,867' }}</h3>
                    <div class="w-16 h-8">
                        <svg viewBox="0 0 50 20" class="w-full h-full stroke-emerald-500 fill-none group-hover:stroke-emerald-600" stroke-width="2">
                            <path d="M0,18 L10,12 L20,15 L30,8 L40,10 L50,4" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-gray-400 font-medium mt-2">Minggu Ini</p>
            </a>

            <!-- Card 4: Total Organizer -->
            <a href="{{ route('admin.organizer.index') }}" class="block bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow hover:border-indigo-200 group">
                <p class="text-sm text-gray-500 font-medium mb-1 group-hover:text-indigo-600 transition-colors">Total Organizer</p>
                <div class="flex items-end justify-between mt-4">
                    <h3 class="text-2xl font-bold text-gray-900">{{ $totalOrganizer ?? 0 }}</h3>
                    <div class="w-10 h-10 bg-indigo-50 rounded-lg flex items-center justify-center text-indigo-600 group-hover:bg-indigo-100 transition-colors">
                        <i data-lucide="users" class="w-5 h-5"></i>
                    </div>
                </div>
                <p class="text-xs text-gray-400 font-medium mt-2">Terdaftar di sistem</p>
            </a>
        </div>

        <!-- Middle row: Pending Organizers -->
        <div class="grid grid-cols-1 gap-6">
            <!-- Pending Organizers Alert -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-gray-900">Verifikasi Tertunda</h3>
                    <a href="{{ route('admin.organizer.index') }}" class="px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg text-sm font-medium hover:bg-blue-100">Lihat Semua</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-xs font-bold text-gray-400 border-b border-gray-100">
                                <th class="pb-3 font-medium">Tipe</th>
                                <th class="pb-3 font-medium">Nama Organizer</th>
                                <th class="pb-3 font-medium">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-sm">
                            @forelse($pendingOrganizers as $org)
                            <tr class="whitespace-nowrap">
                                <td class="py-4 flex items-center text-gray-700 font-medium">
                                    <div class="w-2 h-2 rounded-full bg-orange-400 mr-2 border border-orange-500"></div> Verifikasi
                                </td>
                                <td class="py-4 text-gray-900 font-bold">{{ $org->name }}</td>
                                <td class="py-4"><span class="text-xs font-bold text-orange-600 bg-orange-50 px-2 py-1 rounded-md flex items-center w-max"><div class="w-1.5 h-1.5 rounded-full bg-orange-500 mr-1.5"></div> Menunggu</span></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="py-4 text-center text-gray-500 font-medium">Tidak ada penyelenggara yang perlu diverifikasi</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Bottom row: Event List Table -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4">
                <h3 class="text-lg font-bold text-gray-900">Kajian Terbaru</h3>
                <a href="{{ route('admin.kajian.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">Detail Kajian &rarr;</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-xs font-bold text-gray-400 border-b border-gray-100 uppercase tracking-wider">
                            <th class="pb-3 font-medium">Nama Kajian</th>
                            <th class="pb-3 font-medium">Tanggal & Waktu</th>
                            <th class="pb-3 font-medium">Status</th>
                            <th class="pb-3 font-medium">Kategori</th>
                            <th class="pb-3 font-medium text-right">Pendaftar</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-sm">
                        @forelse($recentKajians as $k)
                        <tr class="whitespace-nowrap">
                            <td class="py-4 text-gray-900 font-bold">{{ $k->title }}</td>
                            <td class="py-4 text-gray-600 font-medium">{{ $k->start_at ? $k->start_at->format('M d, Y - H:i') : '-' }}</td>
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
                            <td colspan="5" class="py-4 text-center text-gray-500 font-medium">Belum ada kajian</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-admin-layout>
