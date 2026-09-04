<x-organizer-layout>
    <div class="space-y-6 relative" x-data="organizerDashboardRealtime()" x-init="initChart(); startPolling();">
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
            <a href="{{ route('organizer.mosque.index') }}" class="block bg-white p-5 rounded-2xl border border-gray-100 shadow-sm col-span-1 hover:shadow-md transition-all duration-200 cursor-pointer hover:border-emerald-200 group">
                <p class="text-sm text-gray-500 font-medium mb-1 group-hover:text-emerald-600 transition-colors">Total Lokasi Masjid</p>
                <div class="flex items-end justify-between mt-4">
                    <h3 class="text-2xl font-bold text-gray-900 group-hover:text-emerald-700 transition-colors" x-text="metrics.totalMasjid">{{ $totalMasjid ?? 0 }}</h3>
                    <div class="w-16 h-8">
                        <svg viewBox="0 0 50 20" class="w-full h-full stroke-emerald-500 fill-none" stroke-width="2">
                            <path d="M0,15 L10,10 L20,12 L30,5 L40,8 L50,2" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-emerald-500 font-medium flex items-center mt-2">
                    Masjid terdaftar
                </p>
            </a>

            <a href="{{ route('organizer.kajian.index') }}" class="block bg-white p-5 rounded-2xl border border-gray-100 shadow-sm col-span-1 hover:shadow-md transition-all duration-200 cursor-pointer hover:border-emerald-200 group">
                <p class="text-sm text-gray-500 font-medium mb-1 group-hover:text-emerald-600 transition-colors">Kajian Aktif</p>
                <div class="flex items-end justify-between mt-4">
                    <h3 class="text-2xl font-bold text-gray-900 group-hover:text-emerald-700 transition-colors" x-text="metrics.kajianAktif">{{ $kajianAktif ?? 0 }}</h3>
                </div>
                <p class="text-xs text-gray-400 font-medium mt-2">Sedang berlangsung / Publish</p>
            </a>

            <a href="{{ route('organizer.peserta.global') }}" class="block bg-white p-5 rounded-2xl border border-gray-100 shadow-sm col-span-1 hover:shadow-md transition-all duration-200 cursor-pointer hover:border-emerald-200 group">
                <p class="text-sm text-gray-500 font-medium mb-1 group-hover:text-emerald-600 transition-colors">Total Hadir</p>
                <div class="flex items-end justify-between mt-4">
                    <h3 class="text-2xl font-bold text-gray-900 group-hover:text-emerald-700 transition-colors" x-text="metrics.pesertaHadir">{{ $pesertaHadir ?? 0 }}</h3>
                </div>
                <p class="text-xs text-gray-400 font-medium mt-2">All-time record</p>
            </a>

            <a href="{{ route('organizer.kajian.index') }}" class="block bg-white p-5 rounded-2xl border border-gray-100 shadow-sm col-span-1 hover:shadow-md transition-all duration-200 cursor-pointer hover:border-emerald-200 group">
                <p class="text-sm text-gray-500 font-medium mb-1 group-hover:text-emerald-600 transition-colors">Kajian Selesai</p>
                <div class="flex items-end justify-between mt-4">
                    <h3 class="text-2xl font-bold text-gray-900 group-hover:text-emerald-700 transition-colors" x-text="metrics.kajianSelesai">{{ $kajianSelesai ?? 0 }}</h3>
                    <div class="w-16 h-8">
                        <svg viewBox="0 0 50 20" class="w-full h-full stroke-emerald-500 fill-none" stroke-width="2">
                            <path d="M0,18 L10,12 L20,15 L30,8 L40,10 L50,4" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-emerald-500 font-medium flex items-center mt-2">
                    Telah berlalu
                </p>
            </a>

            <a href="{{ route('organizer.peserta.global') }}" class="block bg-white p-5 rounded-2xl border border-gray-100 shadow-sm col-span-1 hover:shadow-md transition-all duration-200 cursor-pointer hover:border-emerald-200 group">
                <p class="text-sm text-gray-500 font-medium mb-1 group-hover:text-emerald-600 transition-colors">Calon Peserta</p>
                <div class="flex items-end justify-between mt-4">
                    <h3 class="text-2xl font-bold text-gray-900 group-hover:text-emerald-700 transition-colors" x-text="metrics.calonPeserta">{{ $calonPeserta ?? 0 }}</h3>
                    <div class="w-16 h-8">
                        <svg viewBox="0 0 50 20" class="w-full h-full stroke-emerald-500 fill-none" stroke-width="2">
                            <path d="M0,15 L10,10 L20,12 L30,5 L40,8 L50,2" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-emerald-500 font-medium flex items-center mt-2">
                    <i data-lucide="users" class="w-3 h-3 mr-1"></i> Total Pendaftar
                </p>
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm p-6 relative">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-lg font-bold text-gray-900">Statistik Pendaftar</h3>
                    <select x-model="chartType" class="w-32 pl-3 pr-10 py-1.5 border border-gray-200 rounded-lg text-sm text-gray-600 outline-none focus:ring-2 focus:ring-emerald-500 cursor-pointer bg-white appearance-none" style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23111827%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 0.7rem top 50%; background-size: 0.65rem auto;">
                        <option value="harian">Harian</option>
                        <option value="mingguan">Mingguan</option>
                        <option value="bulanan">Bulanan</option>
                    </select>
                </div>

                <div class="flex items-center space-x-6 mb-6 border-b border-gray-100">
                    <button @click="changeStyle('line')" :class="chartStyle === 'line' ? 'text-emerald-600 border-b-2 border-emerald-600' : 'text-gray-400 hover:text-gray-600 border-b-2 border-transparent'" class="text-sm font-bold pb-3 flex items-center transition-colors">
                        <i data-lucide="line-chart" class="w-4 h-4 mr-2"></i> Line Chart
                    </button>
                    <button @click="changeStyle('bar')" :class="chartStyle === 'bar' ? 'text-emerald-600 border-b-2 border-emerald-600' : 'text-gray-400 hover:text-gray-600 border-b-2 border-transparent'" class="text-sm font-bold pb-3 flex items-center transition-colors">
                        <i data-lucide="bar-chart" class="w-4 h-4 mr-2"></i> Bar Chart
                    </button>
                </div>

                <div class="w-full h-64 relative mt-4">
                    <canvas id="pendaftarChart"></canvas>
                </div>
            </div>

            <div class="lg:col-span-1 bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-gray-900">Tugas & Peringatan</h3>
                    <a href="{{ route('organizer.kajian.create') }}" class="px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg text-sm font-medium hover:bg-blue-100">Buat Kajian</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left whitespace-nowrap">
                        <thead>
                            <tr class="text-xs font-bold text-gray-400 border-b border-gray-100">
                                <th class="pb-3 px-4 font-medium">Tipe</th>
                                <th class="pb-3 px-4 font-medium">Judul</th>
                                <th class="pb-3 px-4 font-medium">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-sm">
                            <template x-if="metrics.unverifiedKajianCount > 0">
                                <tr>
                                    <td class="py-4 px-4 flex items-center text-gray-700 font-medium">
                                        <div class="w-2 h-2 rounded-full bg-gray-300 mr-2 border border-gray-400"></div> Approval
                                    </td>
                                    <td class="py-4 px-4 text-gray-900 font-bold">
                                        <a href="{{ route('organizer.kajian.index') }}" class="hover:text-emerald-600 transition-colors">
                                            <span x-text="metrics.unverifiedKajianCount"></span> Kajian Menunggu Review Admin
                                        </a>
                                    </td>
                                    <td class="py-4 px-4 flex justify-end">
                                        <span class="text-xs font-bold text-orange-500 bg-orange-50 px-2 py-1 rounded-md flex items-center w-max">
                                            <div class="w-1.5 h-1.5 rounded-full bg-orange-500 mr-1.5"></div> Pending
                                        </span>
                                    </td>
                                </tr>
                            </template>

                            <template x-if="metrics.draftKajianCount > 0">
                                <tr>
                                    <td class="py-4 px-4 flex items-center text-gray-700 font-medium">
                                        <div class="w-2 h-2 rounded-full bg-gray-300 mr-2 border border-gray-400"></div> Draft
                                    </td>
                                    <td class="py-4 px-4 text-gray-900 font-bold">
                                        <a href="{{ route('organizer.kajian.index') }}" class="hover:text-emerald-600 transition-colors">
                                            Lanjutkan draft <span x-text="metrics.draftKajianCount"></span> Kajian
                                        </a>
                                    </td>
                                    <td class="py-4 px-4 flex justify-end">
                                        <span class="text-xs font-bold text-gray-500 bg-gray-100 px-2 py-1 rounded-md flex items-center w-max">
                                            <div class="w-1.5 h-1.5 rounded-full bg-gray-500 mr-1.5"></div> Draft
                                        </span>
                                    </td>
                                </tr>
                            </template>

                            <template x-if="metrics.unverifiedKajianCount == 0 && metrics.draftKajianCount == 0">
                                <tr>
                                    <td colspan="3" class="py-6 px-4 text-center text-gray-500 flex flex-col items-center">
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

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4">
                <h3 class="text-lg font-bold text-gray-900" x-text="activeTab === 'events' ? 'Jadwal Kajian' : (activeTab === 'pendaftar' ? 'Pendaftar Terbaru' : 'Masjid Digunakan')">Jadwal Kajian (Event List)</h3>
                
                <div class="flex items-center space-x-2 text-sm text-gray-500 bg-gray-50 rounded-lg p-1">
                    <button @click="activeTab = 'events'" :class="activeTab === 'events' ? 'bg-white text-emerald-600 shadow-sm border-gray-200' : 'hover:text-gray-700 border-transparent'" class="px-4 py-1.5 font-medium rounded-md transition-colors flex items-center border">
                        <i data-lucide="calendar" class="w-4 h-4 mr-2"></i> Events
                    </button>
                    <button @click="activeTab = 'pendaftar'" :class="activeTab === 'pendaftar' ? 'bg-white text-emerald-600 shadow-sm border-gray-200' : 'hover:text-gray-700 border-transparent'" class="px-4 py-1.5 font-medium rounded-md transition-colors flex items-center border">
                        <i data-lucide="ticket" class="w-4 h-4 mr-2"></i> Pendaftar
                    </button>
                    <button @click="activeTab = 'lokasi'" :class="activeTab === 'lokasi' ? 'bg-white text-emerald-600 shadow-sm border-gray-200' : 'hover:text-gray-700 border-transparent'" class="px-4 py-1.5 font-medium rounded-md transition-colors flex items-center border">
                        <i data-lucide="map-pin" class="w-4 h-4 mr-2"></i> Lokasi
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <!-- Events Table -->
                <table class="w-full text-left whitespace-nowrap" x-show="activeTab === 'events'" style="display: none;" x-transition>
                    <thead>
                        <tr class="text-xs font-bold text-gray-400 border-b border-gray-100 uppercase tracking-wider">
                            <th class="pb-3 px-4 font-medium">Nama Kajian</th>
                            <th class="pb-3 px-4 font-medium">Tanggal & Waktu</th>
                            <th class="pb-3 px-4 font-medium">Lokasi</th>
                            <th class="pb-3 px-4 font-medium">Status</th>
                            <th class="pb-3 px-4 font-medium">Kategori</th>
                            <th class="pb-3 px-4 font-medium text-right">Peserta</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-sm">
                        <template x-for="k in lists.recentKajians" :key="k.title">
                            <tr>
                                <td class="py-4 px-4 text-gray-900 font-bold">
                                    <span class="hover:text-emerald-600 transition-colors" x-text="k.title"></span>
                                </td>
                                <td class="py-4 px-4 text-gray-600 font-medium" x-text="k.start_at"></td>
                                <td class="py-4 px-4 text-gray-600 font-medium" x-text="k.mosque_name"></td>
                                <td class="py-4 px-4">
                                    <span class="text-xs font-bold px-2 py-1 rounded-md flex items-center w-max"
                                          :class="getStatusColorClass(k.status_label)">
                                        <div class="w-1.5 h-1.5 rounded-full mr-1.5" :class="getStatusDotClass(k.status_label)"></div> <span x-text="k.status_label"></span>
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-gray-600 font-medium" x-text="k.category_name"></td>
                                <td class="py-4 px-4 text-gray-900 font-bold text-right" x-text="k.attendees_count"></td>
                            </tr>
                        </template>
                        <template x-if="lists.recentKajians.length === 0">
                            <tr>
                                <td colspan="6" class="py-6 px-4 text-center text-gray-500 font-medium">Belum ada kajian yang dibuat.</td>
                            </tr>
                        </template>
                    </tbody>
                </table>

                <!-- Pendaftar Table -->
                <table class="w-full text-left whitespace-nowrap" x-show="activeTab === 'pendaftar'" style="display: none;" x-transition>
                    <thead>
                        <tr class="text-xs font-bold text-gray-400 border-b border-gray-100 uppercase tracking-wider">
                            <th class="pb-3 px-4 font-medium">Nama Peserta</th>
                            <th class="pb-3 px-4 font-medium">Kajian</th>
                            <th class="pb-3 px-4 font-medium">Waktu Daftar</th>
                            <th class="pb-3 px-4 font-medium text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-sm">
                        <template x-for="attendee in lists.recentAttendees" :key="attendee.user_name + attendee.kajian_title">
                            <tr>
                                <td class="py-4 px-4 text-gray-900 font-bold" x-text="attendee.user_name"></td>
                                <td class="py-4 px-4 text-gray-600 font-medium truncate max-w-[200px]" x-text="attendee.kajian_title"></td>
                                <td class="py-4 px-4 text-gray-600 font-medium" x-text="attendee.created_at"></td>
                                <td class="py-4 px-4 flex justify-end">
                                    <template x-if="attendee.status === 'attended'">
                                        <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-md">Hadir</span>
                                    </template>
                                    <template x-if="attendee.status !== 'attended'">
                                        <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded-md" x-text="attendee.status_label">Terdaftar</span>
                                    </template>
                                </td>
                            </tr>
                        </template>
                        <template x-if="lists.recentAttendees.length === 0">
                            <tr>
                                <td colspan="4" class="py-6 px-4 text-center text-gray-500 font-medium">Belum ada pendaftar terbaru.</td>
                            </tr>
                        </template>
                    </tbody>
                </table>

                <!-- Lokasi Table -->
                <table class="w-full text-left whitespace-nowrap" x-show="activeTab === 'lokasi'" style="display: none;" x-transition>
                    <thead>
                        <tr class="text-xs font-bold text-gray-400 border-b border-gray-100 uppercase tracking-wider">
                            <th class="pb-3 px-4 font-medium">Nama Masjid</th>
                            <th class="pb-3 px-4 font-medium">Alamat</th>
                            <th class="pb-3 px-4 font-medium text-right">Fasilitas</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-sm">
                        <template x-for="mosque in lists.recentMosques" :key="mosque.name">
                            <tr>
                                <td class="py-4 px-4 text-gray-900 font-bold" x-text="mosque.name"></td>
                                <td class="py-4 px-4 text-gray-600 font-medium truncate max-w-[300px]" x-text="mosque.address"></td>
                                <td class="py-4 px-4 text-right">
                                    <template x-if="mosque.facilities_display.length > 0">
                                        <div class="flex flex-wrap gap-1 justify-end max-w-[250px] ml-auto">
                                            <template x-for="facility in mosque.facilities_display">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-gray-100 text-gray-800 border border-gray-200 whitespace-nowrap" x-text="facility"></span>
                                            </template>
                                            <template x-if="mosque.facilities_remaining > 0">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-emerald-50 text-emerald-700 border border-emerald-100 whitespace-nowrap" :title="mosque.facilities_remaining_tooltip">
                                                    +<span x-text="mosque.facilities_remaining"></span> lainnya
                                                </span>
                                            </template>
                                        </div>
                                    </template>
                                    <template x-if="mosque.facilities_display.length === 0">
                                        <span class="text-gray-400 font-medium">-</span>
                                    </template>
                                </td>
                            </tr>
                        </template>
                        <template x-if="lists.recentMosques.length === 0">
                            <tr>
                                <td colspan="3" class="py-6 px-4 text-center text-gray-500 font-medium">Belum ada masjid yang digunakan.</td>
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
        window.organizerDashboardRealtime = function() {
            return {
                activeTab: 'events',
                chartType: 'mingguan',
                chartStyle: 'line',
                chartInstance: null,
                pollingInterval: null,
                
                // State initialized with server-rendered data
                metrics: {
                    totalMasjid: {{ $totalMasjid ?? 0 }},
                    kajianAktif: {{ $kajianAktif ?? 0 }},
                    pesertaHadir: {{ $pesertaHadir ?? 0 }},
                    kajianSelesai: {{ $kajianSelesai ?? 0 }},
                    calonPeserta: {{ $calonPeserta ?? 0 }},
                    unverifiedKajianCount: {{ $unverifiedKajianCount ?? 0 }},
                    draftKajianCount: {{ $draftKajianCount ?? 0 }}
                },
                
                lists: {
                    recentKajians: [
                        @foreach($recentKajians as $k)
                        {
                            title: "{{ $k->title }}",
                            start_at: "{{ $k->start_at ? $k->start_at->format('M d, Y - h:i A') : '-' }}",
                            mosque_name: "{{ $k->mosque->name ?? '-' }}",
                            status_label: "{{ $k->status_label }}",
                            category_name: "{{ $k->category->name ?? '-' }}",
                            attendees_count: {{ $k->attendees_count }}
                        },
                        @endforeach
                    ],
                    recentAttendees: [
                        @foreach($recentAttendees as $a)
                        {
                            user_name: "{{ $a->user->name ?? '-' }}",
                            kajian_title: "{{ $a->kajian->title ?? '-' }}",
                            created_at: "{{ $a->created_at ? $a->created_at->diffForHumans() : '-' }}",
                            status: "{{ $a->status }}",
                            status_label: "{{ $a->status === 'attended' ? 'Hadir' : 'Terdaftar' }}"
                        },
                        @endforeach
                    ],
                    recentMosques: [
                        @foreach($recentMosques as $mosque)
                        @php
                            $facs = $mosque->facilities ? explode(', ', $mosque->facilities) : [];
                            $disp = array_slice($facs, 0, 2);
                            $rem = count($facs) - 2;
                        @endphp
                        {
                            name: "{{ $mosque->name }}",
                            facilities_display: @json($disp),
                            facilities_remaining: {{ $rem > 0 ? $rem : 0 }},
                            facilities_remaining_tooltip: "{{ implode(', ', array_slice($facs, 2)) }}",
                            address: "{{ $mosque->address ?? '-' }}"
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
                    if (label === 'Draft') return 'text-gray-600 bg-gray-50';
                    return 'text-orange-600 bg-orange-50';
                },
                
                getStatusDotClass(label) {
                    if (label === 'Sedang Berlangsung') return 'bg-emerald-500';
                    if (label === 'Selesai') return 'bg-gray-500';
                    if (label === 'Dibatalkan') return 'bg-red-500';
                    if (label === 'Akan Datang') return 'bg-yellow-500';
                    if (label === 'Draft') return 'bg-gray-500';
                    return 'bg-orange-500';
                },
                
                init() {
                    this.$watch('chartType', () => {
                        this.updateChart();
                    });
                },
                
                destroy() {
                    if (this.pollingInterval) clearInterval(this.pollingInterval);
                    if (this.chartInstance) this.chartInstance.destroy();
                },

                startPolling() {
                    this.pollingInterval = setInterval(() => {
                        fetch('{{ route("organizer.dashboard.realtime") }}')
                            .then(response => response.json())
                            .then(data => {
                                // Update Metrics
                                this.metrics.totalMasjid = data.totalMasjid;
                                this.metrics.kajianAktif = data.kajianAktif;
                                this.metrics.pesertaHadir = data.pesertaHadir;
                                this.metrics.kajianSelesai = data.kajianSelesai;
                                this.metrics.calonPeserta = data.calonPeserta;
                                this.metrics.unverifiedKajianCount = data.unverifiedKajianCount;
                                this.metrics.draftKajianCount = data.draftKajianCount;
                                
                                // Update Lists
                                this.lists.recentKajians = data.recentKajians;
                                this.lists.recentAttendees = data.recentAttendees;
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
                    gradient.addColorStop(0, 'rgba(16, 185, 129, 0.2)');
                    gradient.addColorStop(1, 'rgba(16, 185, 129, 0)');

                    this.chartInstance = new Chart(ctx, {
                        type: this.chartStyle,
                        data: {
                            labels: this.chartDataStore[this.chartType].labels,
                            datasets: [{
                                label: 'Pendaftar Baru',
                                data: this.chartDataStore[this.chartType].data,
                                borderColor: '#10b981',
                                backgroundColor: this.chartStyle === 'line' ? gradient : '#10b981',
                                borderWidth: this.chartStyle === 'line' ? 3 : 0,
                                tension: 0.1, // Set to 0.1 to make the line look more realistic (less artificially smooth)
                                fill: true,
                                borderRadius: this.chartStyle === 'bar' ? 4 : 0,
                                pointBackgroundColor: '#ffffff',
                                pointBorderColor: '#10b981',
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
</x-organizer-layout>

