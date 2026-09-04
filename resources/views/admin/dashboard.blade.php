<x-admin-layout>
    <div class="space-y-6" x-data="dashboardRealtime()" x-init="initChart(); startPolling();">
        
        <!-- Top row: KPI Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
            <!-- Card 1 -->
            <a href="{{ route('admin.kajian.index') }}" class="block bg-white p-5 rounded-2xl border border-gray-100 shadow-sm col-span-1 hover:shadow-md hover:border-blue-200 transition-all cursor-pointer group">
                <p class="text-sm text-gray-500 font-medium mb-1 group-hover:text-blue-600 transition-colors">Total Kajian</p>
                <div class="flex items-end justify-between mt-4">
                    <h3 class="text-2xl font-bold text-gray-900" x-text="metrics.totalKajian">{{ $totalKajian ?? 0 }}</h3>
                    <div class="w-16 h-8">
                        <svg viewBox="0 0 50 20" class="w-full h-full stroke-emerald-500 fill-none" stroke-width="2">
                            <path d="M0,15 L10,10 L20,12 L30,5 L40,8 L50,2" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs font-medium flex items-center mt-2" :class="metrics.kajianGrowth >= 0 ? 'text-emerald-500' : 'text-red-500'">
                    <i :data-lucide="metrics.kajianGrowth >= 0 ? 'arrow-up' : 'arrow-down'" class="w-3 h-3 mr-1"></i> <span x-text="Math.abs(metrics.kajianGrowth)">{{ abs($kajianGrowth) }}</span>% <span class="text-gray-400 font-normal ml-1">Bulan Ini</span>
                </p>
            </a>

            <!-- Card 2 -->
            <a href="{{ route('admin.mosque.index') }}" class="block bg-white p-5 rounded-2xl border border-gray-100 shadow-sm col-span-1 hover:shadow-md hover:border-blue-200 transition-all cursor-pointer group">
                <p class="text-sm text-gray-500 font-medium mb-1 group-hover:text-blue-600 transition-colors">Total Masjid</p>
                <div class="flex items-end justify-between mt-4">
                    <h3 class="text-2xl font-bold text-gray-900" x-text="metrics.totalMosque">{{ $totalMosque ?? 0 }}</h3>
                </div>
                <p class="text-xs text-gray-400 font-medium mt-2">Lokasi pelaksanaan kajian</p>
            </a>

            <!-- Card 3 -->
            <a href="{{ route('admin.kajian.index') }}" class="block bg-white p-5 rounded-2xl border border-gray-100 shadow-sm col-span-1 hover:shadow-md hover:border-blue-200 transition-all cursor-pointer group">
                <p class="text-sm text-gray-500 font-medium mb-1 group-hover:text-blue-600 transition-colors">Kajian Terdekat</p>
                <div class="flex items-end justify-between mt-4">
                    <h3 class="text-2xl font-bold text-gray-900" x-text="metrics.kajianTerdekat">{{ $kajianTerdekat ?? 0 }}</h3>
                </div>
                <p class="text-xs text-gray-400 font-medium mt-2">Dalam 7 Hari Kedepan</p>
            </a>

            <!-- Card 4 -->
            <a href="{{ route('admin.user.index') }}" class="block bg-white p-5 rounded-2xl border border-gray-100 shadow-sm col-span-1 hover:shadow-md hover:border-blue-200 transition-all cursor-pointer group">
                <p class="text-sm text-gray-500 font-medium mb-1 group-hover:text-blue-600 transition-colors">User Aktif</p>
                <div class="flex items-end justify-between mt-4">
                    <h3 class="text-2xl font-bold text-gray-900" x-text="metrics.totalUser">{{ $totalUser ?? 0 }}</h3>
                    <div class="w-16 h-8">
                        <svg viewBox="0 0 50 20" class="w-full h-full stroke-emerald-500 fill-none" stroke-width="2">
                            <path d="M0,18 L10,12 L20,15 L30,8 L40,10 L50,4" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-emerald-500 font-medium flex items-center mt-2">
                    <i data-lucide="arrow-up" class="w-3 h-3 mr-1"></i> <span x-text="metrics.userMingguIni">{{ $userMingguIni ?? 0 }}</span> <span class="text-gray-400 font-normal ml-1">Minggu Ini</span>
                </p>
            </a>

            <!-- Card 5: Total Organizer -->
            <a href="{{ route('admin.organizer.index') }}" class="block bg-white p-5 rounded-2xl border border-gray-100 shadow-sm col-span-1 hover:shadow-md hover:border-blue-200 transition-all cursor-pointer group">
                <p class="text-sm text-gray-500 font-medium mb-1 group-hover:text-blue-600 transition-colors">Total Organizer</p>
                <div class="flex items-end justify-between mt-4">
                    <h3 class="text-2xl font-bold text-gray-900" x-text="metrics.totalOrganizer">{{ $totalOrganizer ?? 0 }}</h3>
                    <div class="w-10 h-10 bg-indigo-50 rounded-lg flex items-center justify-center text-indigo-600">
                        <i data-lucide="users" class="w-5 h-5"></i>
                    </div>
                </div>
                <p class="text-xs text-indigo-500 font-medium mt-2">Terdaftar di sistem</p>
            </a>
        </div>

        <!-- Middle row: Chart and To-Do List -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Line Chart (Pertumbuhan) -->
            <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm p-6 relative">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-lg font-bold text-gray-900">Pertumbuhan Pendaftar Kajian</h3>
                    <select x-model="chartType" class="px-3 py-1.5 pr-10 w-32 border border-gray-200 rounded-lg text-sm text-gray-600 outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer bg-white">
                        <option value="harian">Harian</option>
                        <option value="mingguan">Mingguan</option>
                        <option value="bulanan">Bulanan</option>
                    </select>
                </div>

                <div class="flex items-center space-x-6 mb-6 border-b border-gray-100">
                    <button @click="changeStyle('line')" :class="chartStyle === 'line' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-400 hover:text-gray-600 border-b-2 border-transparent'" class="text-sm font-bold pb-3 flex items-center transition-colors">
                        <i data-lucide="line-chart" class="w-4 h-4 mr-2"></i> Line Chart
                    </button>
                    <button @click="changeStyle('bar')" :class="chartStyle === 'bar' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-400 hover:text-gray-600 border-b-2 border-transparent'" class="text-sm font-bold pb-3 flex items-center transition-colors">
                        <i data-lucide="bar-chart" class="w-4 h-4 mr-2"></i> Bar Chart
                    </button>
                </div>

                <!-- Chart.js Canvas -->
                <div class="w-full h-64 relative mt-4">
                    <canvas id="pendaftarChart"></canvas>
                </div>
            </div>

            <!-- To-Do & Alerts -->
            <div class="lg:col-span-1 bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-gray-900">Tugas & Peringatan</h3>
                    <a href="{{ route('admin.kajian.index') }}" class="px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg text-sm font-medium hover:bg-blue-100">View All</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left whitespace-nowrap">
                        <thead>
                            <tr class="text-xs font-bold text-gray-400 border-b border-gray-100">
                                <th class="pb-3 px-4 whitespace-nowrap font-medium">Tipe</th>
                                <th class="pb-3 px-4 whitespace-nowrap font-medium">Judul</th>
                                <th class="pb-3 px-4 whitespace-nowrap font-medium text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-sm">
                            <template x-if="metrics.unverifiedKajianCount > 0">
                                <tr>
                                    <td class="py-4 px-4 whitespace-nowrap flex items-center text-gray-700 font-medium">
                                        <div class="w-2 h-2 rounded-full bg-gray-300 mr-2 border border-gray-400"></div> Menunggu
                                    </td>
                                    <td class="py-4 px-4 whitespace-nowrap text-gray-900 font-bold">
                                        <a href="{{ route('admin.kajian.index') }}" class="hover:text-blue-600 transition-colors">
                                            Review <span x-text="metrics.unverifiedKajianCount"></span> Kajian Baru
                                        </a>
                                    </td>
                                    <td class="py-4 px-4 whitespace-nowrap flex justify-end">
                                        <span class="text-xs font-bold text-emerald-500 bg-emerald-50 px-2 py-1 rounded-md flex items-center w-max">
                                            <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></div> Awaiting
                                        </span>
                                    </td>
                                </tr>
                            </template>

                            <template x-if="metrics.unverifiedOrganizerCount > 0">
                                <tr>
                                    <td class="py-4 px-4 whitespace-nowrap flex items-center text-gray-700 font-medium">
                                        <div class="w-2 h-2 rounded-full bg-gray-300 mr-2 border border-gray-400"></div> Pendaftaran
                                    </td>
                                    <td class="py-4 px-4 whitespace-nowrap text-gray-900 font-bold">
                                        <a href="{{ route('admin.organizer.index') }}" class="hover:text-blue-600 transition-colors">
                                            Verifikasi <span x-text="metrics.unverifiedOrganizerCount"></span> Organizer
                                        </a>
                                    </td>
                                    <td class="py-4 px-4 whitespace-nowrap flex justify-end">
                                        <span class="text-xs font-bold text-red-500 bg-red-50 px-2 py-1 rounded-md flex items-center w-max">
                                            <div class="w-1.5 h-1.5 rounded-full bg-red-500 mr-1.5"></div> Pending
                                        </span>
                                    </td>
                                </tr>
                            </template>

                            <template x-if="metrics.unverifiedKajianCount == 0 && metrics.unverifiedOrganizerCount == 0">
                                <tr>
                                    <td colspan="3" class="py-6 px-4 whitespace-nowrap text-center text-gray-500 flex flex-col items-center">
                                        <i data-lucide="check-circle" class="w-8 h-8 text-emerald-400 mb-2"></i>
                                        Semua tugas sudah diselesaikan!
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Bottom row: Event List Table -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4">
                <h3 class="text-lg font-bold text-gray-900" x-text="activeTab === 'kajian' ? 'Daftar Kajian' : (activeTab === 'organizer' ? 'Daftar Penyelenggara' : 'Daftar Masjid')">Daftar Kajian</h3>
                
                <div class="flex items-center space-x-2 text-sm text-gray-500 bg-gray-50 rounded-lg p-1">
                    <button type="button" @click="activeTab = 'kajian'" :class="activeTab === 'kajian' ? 'bg-white text-blue-600 shadow-sm border-gray-200' : 'hover:text-gray-700 border-transparent'" class="px-4 py-1.5 font-medium rounded-md transition-colors flex items-center border">
                        <i data-lucide="calendar" class="w-4 h-4 mr-2"></i> Kajian
                    </button>
                    <button type="button" @click="activeTab = 'organizer'" :class="activeTab === 'organizer' ? 'bg-white text-blue-600 shadow-sm border-gray-200' : 'hover:text-gray-700 border-transparent'" class="px-4 py-1.5 font-medium rounded-md transition-colors flex items-center border">
                        <i data-lucide="users" class="w-4 h-4 mr-2"></i> Penyelenggara
                    </button>
                    <button type="button" @click="activeTab = 'mosque'" :class="activeTab === 'mosque' ? 'bg-white text-blue-600 shadow-sm border-gray-200' : 'hover:text-gray-700 border-transparent'" class="px-4 py-1.5 font-medium rounded-md transition-colors flex items-center border">
                        <i data-lucide="map-pin" class="w-4 h-4 mr-2"></i> Lokasi
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <!-- Table Kajian -->
                <table class="w-full text-left whitespace-nowrap" x-show="activeTab === 'kajian'" style="display: none;" x-transition>
                    <thead>
                        <tr class="text-xs font-bold text-gray-400 border-b border-gray-100 uppercase tracking-wider">
                            <th class="pb-3 px-4 whitespace-nowrap font-medium">Nama Kajian</th>
                            <th class="pb-3 px-4 whitespace-nowrap font-medium">Tanggal & Waktu</th>
                            <th class="pb-3 px-4 whitespace-nowrap font-medium">Lokasi</th>
                            <th class="pb-3 px-4 whitespace-nowrap font-medium">Status</th>
                            <th class="pb-3 px-4 whitespace-nowrap font-medium">Kategori</th>
                            <th class="pb-3 px-4 whitespace-nowrap font-medium text-right">Pendaftar</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-sm">
                        <template x-for="k in lists.recentKajians" :key="k.title">
                            <tr>
                                <td class="py-4 px-4 whitespace-nowrap text-gray-900 font-bold" x-text="k.title"></td>
                                <td class="py-4 px-4 whitespace-nowrap text-gray-600 font-medium" x-text="k.start_at"></td>
                                <td class="py-4 px-4 whitespace-nowrap text-gray-600 font-medium" x-text="k.mosque_name"></td>
                                <td class="py-4 px-4 whitespace-nowrap">
                                    <span class="text-xs font-bold px-2 py-1 rounded-md flex items-center w-max"
                                          :class="getStatusColorClass(k.status_label)">
                                        <div class="w-1.5 h-1.5 rounded-full mr-1.5" :class="getStatusDotClass(k.status_label)"></div> <span x-text="k.status_label"></span>
                                    </span>
                                </td>
                                <td class="py-4 px-4 whitespace-nowrap text-gray-600 font-medium" x-text="k.category_name"></td>
                                <td class="py-4 px-4 whitespace-nowrap text-gray-900 font-bold text-right" x-text="k.attendees_count"></td>
                            </tr>
                        </template>
                        <template x-if="lists.recentKajians.length === 0">
                            <tr>
                                <td colspan="6" class="py-4 px-4 whitespace-nowrap text-center text-gray-500 font-medium">Belum ada kajian</td>
                            </tr>
                        </template>
                    </tbody>
                </table>

                <!-- Table Organizer -->
                <table class="w-full text-left whitespace-nowrap" x-show="activeTab === 'organizer'" style="display: none;" x-transition>
                    <thead>
                        <tr class="text-xs font-bold text-gray-400 border-b border-gray-100 uppercase tracking-wider">
                            <th class="pb-3 px-4 whitespace-nowrap font-medium">Nama Penyelenggara</th>
                            <th class="pb-3 px-4 whitespace-nowrap font-medium">Telepon</th>
                            <th class="pb-3 px-4 whitespace-nowrap font-medium">Alamat</th>
                            <th class="pb-3 px-4 whitespace-nowrap font-medium">Status Verifikasi</th>
                            <th class="pb-3 px-4 whitespace-nowrap font-medium text-right">Total Kajian</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-sm">
                        <template x-for="org in lists.recentOrganizers" :key="org.name">
                            <tr>
                                <td class="py-4 px-4 whitespace-nowrap text-gray-900 font-bold" x-text="org.name"></td>
                                <td class="py-4 px-4 whitespace-nowrap text-gray-600 font-medium" x-text="org.phone"></td>
                                <td class="py-4 px-4 whitespace-nowrap text-gray-600 font-medium truncate max-w-[200px]" x-text="org.address"></td>
                                <td class="py-4 px-4 whitespace-nowrap">
                                    <template x-if="org.is_verified">
                                        <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-md">Terverifikasi</span>
                                    </template>
                                    <template x-if="!org.is_verified">
                                        <span class="text-xs font-bold text-orange-600 bg-orange-50 px-2 py-1 rounded-md">Belum Verifikasi</span>
                                    </template>
                                </td>
                                <td class="py-4 px-4 whitespace-nowrap text-gray-900 font-bold text-right" x-text="org.kajians_count"></td>
                            </tr>
                        </template>
                        <template x-if="lists.recentOrganizers.length === 0">
                            <tr>
                                <td colspan="5" class="py-4 px-4 whitespace-nowrap text-center text-gray-500 font-medium">Belum ada penyelenggara</td>
                            </tr>
                        </template>
                    </tbody>
                </table>

                <!-- Table Mosque -->
                <table class="w-full text-left whitespace-nowrap" x-show="activeTab === 'mosque'" style="display: none;" x-transition>
                    <thead>
                        <tr class="text-xs font-bold text-gray-400 border-b border-gray-100 uppercase tracking-wider">
                            <th class="pb-3 px-4 whitespace-nowrap font-medium">Nama Masjid</th>
                            <th class="pb-3 px-4 whitespace-nowrap font-medium">Fasilitas</th>
                            <th class="pb-3 px-4 whitespace-nowrap font-medium">Alamat</th>
                            <th class="pb-3 px-4 whitespace-nowrap font-medium text-center">Link Maps</th>
                            <th class="pb-3 px-4 whitespace-nowrap font-medium text-right">Total Kajian</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-sm">
                        <template x-for="mosque in lists.recentMosques" :key="mosque.name">
                            <tr>
                                <td class="py-4 px-4 whitespace-nowrap text-gray-900 font-bold" x-text="mosque.name"></td>
                                <td class="py-4 px-4 whitespace-nowrap">
                                    <template x-if="mosque.facilities_display.length > 0">
                                        <div class="flex flex-wrap gap-1 max-w-[250px]">
                                            <template x-for="facility in mosque.facilities_display">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-gray-100 text-gray-800 border border-gray-200 whitespace-nowrap" x-text="facility"></span>
                                            </template>
                                            <template x-if="mosque.facilities_remaining > 0">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-blue-50 text-blue-700 border border-blue-100 whitespace-nowrap" :title="mosque.facilities_remaining_tooltip">
                                                    +<span x-text="mosque.facilities_remaining"></span> lainnya
                                                </span>
                                            </template>
                                        </div>
                                    </template>
                                    <template x-if="mosque.facilities_display.length === 0">
                                        <span class="text-gray-400 font-medium">-</span>
                                    </template>
                                </td>
                                <td class="py-4 px-4 whitespace-nowrap text-gray-600 font-medium truncate max-w-[200px]" x-text="mosque.address"></td>
                                <td class="py-4 px-4 whitespace-nowrap text-center">
                                    <template x-if="mosque.maps_link">
                                        <a :href="mosque.maps_link" target="_blank" class="inline-flex items-center justify-center text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors font-medium text-xs">
                                            <i data-lucide="map" class="w-4 h-4 mr-1.5"></i> Buka Maps
                                        </a>
                                    </template>
                                    <template x-if="!mosque.maps_link">
                                        <span class="text-gray-400 text-xs">-</span>
                                    </template>
                                </td>
                                <td class="py-4 px-4 whitespace-nowrap text-gray-900 font-bold text-right" x-text="mosque.kajians_count"></td>
                            </tr>
                        </template>
                        <template x-if="lists.recentMosques.length === 0">
                            <tr>
                                <td colspan="5" class="py-4 px-4 whitespace-nowrap text-center text-gray-500 font-medium">Belum ada masjid</td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
            
        </div>

    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js" data-turbo-eval="false"></script>
    <script>
        window.dashboardRealtime = function() {
            return {
                activeTab: 'kajian',
                chartType: 'mingguan',
                chartStyle: 'line',
                chartInstance: null,
                pollingInterval: null,
                
                // State initialized with server-rendered data
                metrics: {
                    totalKajian: {{ $totalKajian ?? 0 }},
                    totalMosque: {{ $totalMosque ?? 0 }},
                    kajianTerdekat: {{ $kajianTerdekat ?? 0 }},
                    totalUser: {{ $totalUser ?? 0 }},
                    totalOrganizer: {{ $totalOrganizer ?? 0 }},
                    kajianGrowth: {{ $kajianGrowth ?? 0 }},
                    userMingguIni: {{ $userMingguIni ?? 0 }},
                    unverifiedKajianCount: {{ $unverifiedKajianCount ?? 0 }},
                    unverifiedOrganizerCount: {{ $unverifiedOrganizerCount ?? 0 }}
                },
                
                lists: {
                    recentKajians: [
                        @foreach($recentKajians as $k)
                        {
                            title: "{{ $k->title }}",
                            start_at: "{{ $k->start_at ? $k->start_at->format('M d, Y - H:i') : '-' }}",
                            mosque_name: "{{ $k->mosque->name ?? '-' }}",
                            status_label: "{{ $k->status_label }}",
                            category_name: "{{ $k->category->name ?? '-' }}",
                            attendees_count: {{ $k->attendees_count }}
                        },
                        @endforeach
                    ],
                    recentOrganizers: [
                        @foreach($recentOrganizers as $org)
                        {
                            name: "{{ $org->name }}",
                            phone: "{{ $org->phone ?? '-' }}",
                            address: "{{ $org->address ?? '-' }}",
                            is_verified: {{ $org->is_verified ? 'true' : 'false' }},
                            kajians_count: {{ $org->kajians_count }}
                        },
                        @endforeach
                    ],
                    recentMosques: [
                        @foreach($recentMosques as $mosque)
                        @php
                            $facs = $mosque->facilities ? explode(', ', $mosque->facilities) : [];
                            $disp = array_slice($facs, 0, 2);
                            $rem = count($facs) - 2;
                            $link = $mosque->google_maps_url ?: ($mosque->latitude ? "https://www.google.com/maps/search/?api=1&query={$mosque->latitude},{$mosque->longitude}" : null);
                        @endphp
                        {
                            name: "{{ $mosque->name }}",
                            facilities_display: @json($disp),
                            facilities_remaining: {{ $rem > 0 ? $rem : 0 }},
                            facilities_remaining_tooltip: "{{ implode(', ', array_slice($facs, 2)) }}",
                            address: "{{ $mosque->address ?? '-' }}",
                            maps_link: @json($link),
                            kajians_count: {{ $mosque->kajians_count }}
                        },
                        @endforeach
                    ]
                },
                
                chartDataStore: {
                    harian: {
                        labels: @json($chartDailyLabels),
                        data: @json($chartDailyData)
                    },
                    mingguan: {
                        labels: @json($chartWeeklyLabels),
                        data: @json($chartWeeklyData)
                    },
                    bulanan: {
                        labels: @json($chartMonthlyLabels),
                        data: @json($chartMonthlyData)
                    }
                },
                
                getStatusColorClass(label) {
                    if (label === 'Sedang Berlangsung') return 'text-emerald-600 bg-emerald-50';
                    if (label === 'Selesai') return 'text-gray-600 bg-gray-50';
                    if (label === 'Dibatalkan') return 'text-red-600 bg-red-50';
                    if (label === 'Akan Datang') return 'text-yellow-600 bg-yellow-50';
                    return 'text-orange-600 bg-orange-50';
                },
                
                getStatusDotClass(label) {
                    if (label === 'Sedang Berlangsung') return 'bg-emerald-500';
                    if (label === 'Selesai') return 'bg-gray-500';
                    if (label === 'Dibatalkan') return 'bg-red-500';
                    if (label === 'Akan Datang') return 'bg-yellow-500';
                    return 'bg-orange-500';
                },
                
                init() {
                    this.$watch('chartType', () => {
                        this.updateChart();
                    });
                },

                startPolling() {
                    this.pollingInterval = setInterval(() => {
                        fetch('{{ route("admin.dashboard.realtime") }}')
                            .then(response => response.json())
                            .then(data => {
                                // Update Metrics
                                this.metrics.totalKajian = data.totalKajian;
                                this.metrics.totalMosque = data.totalMosque;
                                this.metrics.kajianTerdekat = data.kajianTerdekat;
                                this.metrics.totalUser = data.totalUser;
                                this.metrics.totalOrganizer = data.totalOrganizer;
                                this.metrics.kajianGrowth = data.kajianGrowth;
                                this.metrics.userMingguIni = data.userMingguIni;
                                this.metrics.unverifiedKajianCount = data.unverifiedKajianCount;
                                this.metrics.unverifiedOrganizerCount = data.unverifiedOrganizerCount;
                                
                                // Update Lists
                                this.lists.recentKajians = data.recentKajians;
                                this.lists.recentOrganizers = data.recentOrganizers;
                                this.lists.recentMosques = data.recentMosques;
                                
                                // Update Chart Data
                                this.chartDataStore.harian.labels = data.chartDailyLabels;
                                this.chartDataStore.harian.data = data.chartDailyData;
                                this.chartDataStore.mingguan.labels = data.chartWeeklyLabels;
                                this.chartDataStore.mingguan.data = data.chartWeeklyData;
                                this.chartDataStore.bulanan.labels = data.chartMonthlyLabels;
                                this.chartDataStore.bulanan.data = data.chartMonthlyData;
                                
                                this.updateChart();
                                
                                // Reinitialize lucide icons for newly rendered elements
                                setTimeout(() => { if (typeof lucide !== 'undefined') lucide.createIcons(); }, 100);
                            })
                            .catch(error => console.error('Error fetching realtime data:', error));
                    }, 10000); // 10 seconds interval
                },
                
                initChart() {
                    const canvas = document.getElementById('pendaftarChart');
                    if (!canvas) return;
                    
                    if (this.chartInstance) {
                        this.chartInstance.destroy();
                    }

                    const ctx = canvas.getContext('2d');
                    let gradient = ctx.createLinearGradient(0, 0, 0, 400);
                    gradient.addColorStop(0, 'rgba(239, 68, 68, 0.2)');
                    gradient.addColorStop(1, 'rgba(239, 68, 68, 0)');

                    this.chartInstance = new Chart(ctx, {
                        type: this.chartStyle,
                        data: {
                            labels: this.chartDataStore[this.chartType].labels,
                            datasets: [{
                                label: 'Pendaftar Baru',
                                data: this.chartDataStore[this.chartType].data,
                                borderColor: '#ef4444',
                                backgroundColor: this.chartStyle === 'line' ? gradient : '#ef4444',
                                borderWidth: this.chartStyle === 'line' ? 3 : 0,
                                tension: 0.1, // Set to 0.1 for a more realistic point-to-point line
                                fill: true,
                                borderRadius: this.chartStyle === 'bar' ? 4 : 0,
                                pointBackgroundColor: '#ffffff',
                                pointBorderColor: '#ef4444',
                                pointBorderWidth: 2,
                                pointRadius: 4,
                                pointHoverRadius: 6
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: false },
                                tooltip: {
                                    backgroundColor: '#ffffff',
                                    titleColor: '#111827',
                                    bodyColor: '#4b5563',
                                    borderColor: '#e5e7eb',
                                    borderWidth: 1,
                                    padding: 12,
                                    boxPadding: 6,
                                    usePointStyle: true,
                                    callbacks: {
                                        label: function(context) { return context.parsed.y + ' Pendaftar'; }
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: { color: '#f3f4f6', drawBorder: false },
                                    ticks: { color: '#9ca3af', font: { size: 11 }, stepSize: 1 }
                                },
                                x: {
                                    grid: { display: false, drawBorder: false },
                                    ticks: { color: '#9ca3af', font: { size: 11 } }
                                }
                            }
                        }
                    });
                },
                updateChart() {
                    if (this.chartInstance) {
                        this.chartInstance.data.labels = this.chartDataStore[this.chartType].labels;
                        this.chartInstance.data.datasets[0].data = this.chartDataStore[this.chartType].data;
                        this.chartInstance.update();
                    }
                },
                changeStyle(style) {
                    this.chartStyle = style;
                    this.initChart();
                }
            }
        }
    </script>
    @endpush
</x-admin-layout>


