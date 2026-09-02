<x-admin-layout>
    <div class="space-y-6">
        
        <!-- Top row: KPI Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
            <!-- Card 1 -->
            <a href="{{ route('admin.kajian.index') }}" class="block bg-white p-5 rounded-2xl border border-gray-100 shadow-sm col-span-1 hover:shadow-md hover:border-blue-200 transition-all cursor-pointer group">
                <p class="text-sm text-gray-500 font-medium mb-1 group-hover:text-blue-600 transition-colors">Total Kajian</p>
                <div class="flex items-end justify-between mt-4">
                    <h3 class="text-2xl font-bold text-gray-900">{{ $totalKajian ?? 120 }}</h3>
                    <div class="w-16 h-8">
                        <!-- Mini sparkline mockup -->
                        <svg viewBox="0 0 50 20" class="w-full h-full stroke-emerald-500 fill-none" stroke-width="2">
                            <path d="M0,15 L10,10 L20,12 L30,5 L40,8 L50,2" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs {{ $kajianGrowth >= 0 ? 'text-emerald-500' : 'text-red-500' }} font-medium flex items-center mt-2">
                    <i data-lucide="{{ $kajianGrowth >= 0 ? 'arrow-up' : 'arrow-down' }}" class="w-3 h-3 mr-1"></i> {{ abs($kajianGrowth) }}% <span class="text-gray-400 font-normal ml-1">Bulan Ini</span>
                </p>
            </a>

            <!-- Card 2 -->
            <a href="{{ route('admin.mosque.index') }}" class="block bg-white p-5 rounded-2xl border border-gray-100 shadow-sm col-span-1 hover:shadow-md hover:border-blue-200 transition-all cursor-pointer group">
                <p class="text-sm text-gray-500 font-medium mb-1 group-hover:text-blue-600 transition-colors">Total Masjid</p>
                <div class="flex items-end justify-between mt-4">
                    <h3 class="text-2xl font-bold text-gray-900">{{ $totalMosque ?? 0 }}</h3>
                </div>
                <p class="text-xs text-gray-400 font-medium mt-2">Lokasi pelaksanaan kajian</p>
            </a>

            <!-- Card 3 -->
            <a href="{{ route('admin.kajian.index') }}" class="block bg-white p-5 rounded-2xl border border-gray-100 shadow-sm col-span-1 hover:shadow-md hover:border-blue-200 transition-all cursor-pointer group">
                <p class="text-sm text-gray-500 font-medium mb-1 group-hover:text-blue-600 transition-colors">Kajian Terdekat</p>
                <div class="flex items-end justify-between mt-4">
                    <h3 class="text-2xl font-bold text-gray-900">{{ $kajianTerdekat ?? 0 }}</h3>
                </div>
                <p class="text-xs text-gray-400 font-medium mt-2">Dalam 7 Hari Kedepan</p>
            </a>

            <!-- Card 4 -->
            <a href="{{ route('admin.user.index') }}" class="block bg-white p-5 rounded-2xl border border-gray-100 shadow-sm col-span-1 hover:shadow-md hover:border-blue-200 transition-all cursor-pointer group">
                <p class="text-sm text-gray-500 font-medium mb-1 group-hover:text-blue-600 transition-colors">User Aktif</p>
                <div class="flex items-end justify-between mt-4">
                    <h3 class="text-2xl font-bold text-gray-900">{{ $totalUser ?? '1,867' }}</h3>
                    <div class="w-16 h-8">
                        <svg viewBox="0 0 50 20" class="w-full h-full stroke-emerald-500 fill-none" stroke-width="2">
                            <path d="M0,18 L10,12 L20,15 L30,8 L40,10 L50,4" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-emerald-500 font-medium flex items-center mt-2">
                    <i data-lucide="arrow-up" class="w-3 h-3 mr-1"></i> {{ $userMingguIni ?? 0 }} <span class="text-gray-400 font-normal ml-1">Minggu Ini</span>
                </p>
            </a>

            <!-- Card 5: Total Organizer -->
            <a href="{{ route('admin.organizer.index') }}" class="block bg-white p-5 rounded-2xl border border-gray-100 shadow-sm col-span-1 hover:shadow-md hover:border-blue-200 transition-all cursor-pointer group">
                <p class="text-sm text-gray-500 font-medium mb-1 group-hover:text-blue-600 transition-colors">Total Organizer</p>
                <div class="flex items-end justify-between mt-4">
                    <h3 class="text-2xl font-bold text-gray-900">{{ $totalOrganizer ?? 0 }}</h3>
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
            <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm p-6 relative" x-data="chartData()" x-init="initChart()">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-lg font-bold text-gray-900">Pertumbuhan Pendaftar Kajian</h3>
                    <select x-model="chartType" @change="updateChart()" class="px-3 py-1.5 border border-gray-200 rounded-lg text-sm text-gray-600 outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer bg-white">
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
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-xs font-bold text-gray-400 border-b border-gray-100">
                                <th class="pb-3 font-medium">Tipe</th>
                                <th class="pb-3 font-medium">Judul</th>
                                <th class="pb-3 font-medium text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-sm">
                            @if($unverifiedKajianCount > 0)
                            <tr>
                                <td class="py-4 flex items-center text-gray-700 font-medium">
                                    <div class="w-2 h-2 rounded-full bg-gray-300 mr-2 border border-gray-400"></div> Menunggu
                                </td>
                                <td class="py-4 text-gray-900 font-bold">
                                    <a href="{{ route('admin.kajian.index') }}" class="hover:text-blue-600 transition-colors">
                                        Review {{ $unverifiedKajianCount }} Kajian Baru
                                    </a>
                                </td>
                                <td class="py-4 flex justify-end">
                                    <span class="text-xs font-bold text-emerald-500 bg-emerald-50 px-2 py-1 rounded-md flex items-center w-max">
                                        <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></div> Awaiting
                                    </span>
                                </td>
                            </tr>
                            @endif

                            @if($unverifiedOrganizerCount > 0)
                            <tr>
                                <td class="py-4 flex items-center text-gray-700 font-medium">
                                    <div class="w-2 h-2 rounded-full bg-gray-300 mr-2 border border-gray-400"></div> Pendaftaran
                                </td>
                                <td class="py-4 text-gray-900 font-bold">
                                    <a href="{{ route('admin.organizer.index') }}" class="hover:text-blue-600 transition-colors">
                                        Verifikasi {{ $unverifiedOrganizerCount }} Organizer
                                    </a>
                                </td>
                                <td class="py-4 flex justify-end">
                                    <span class="text-xs font-bold text-red-500 bg-red-50 px-2 py-1 rounded-md flex items-center w-max">
                                        <div class="w-1.5 h-1.5 rounded-full bg-red-500 mr-1.5"></div> Pending
                                    </span>
                                </td>
                            </tr>
                            @endif

                            @if($unverifiedKajianCount == 0 && $unverifiedOrganizerCount == 0)
                            <tr>
                                <td colspan="3" class="py-6 text-center text-gray-500 flex flex-col items-center">
                                    <i data-lucide="check-circle" class="w-8 h-8 text-emerald-400 mb-2"></i>
                                    Semua tugas sudah diselesaikan!
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Bottom row: Event List Table -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6" x-data="{ activeTab: 'kajian' }">
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
                <table class="w-full text-left" x-show="activeTab === 'kajian'" style="display: none;" x-transition>
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
                                        $colorClass = 'text-yellow-600 bg-yellow-50';
                                        $dotClass = 'bg-yellow-500';
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

                <!-- Table Organizer -->
                <table class="w-full text-left" x-show="activeTab === 'organizer'" style="display: none;" x-transition>
                    <thead>
                        <tr class="text-xs font-bold text-gray-400 border-b border-gray-100 uppercase tracking-wider">
                            <th class="pb-3 font-medium">Nama Penyelenggara</th>
                            <th class="pb-3 font-medium">Telepon</th>
                            <th class="pb-3 font-medium">Alamat</th>
                            <th class="pb-3 font-medium">Status Verifikasi</th>
                            <th class="pb-3 font-medium text-right">Total Kajian</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-sm">
                        @forelse($recentOrganizers as $org)
                        <tr>
                            <td class="py-4 text-gray-900 font-bold">{{ $org->name }}</td>
                            <td class="py-4 text-gray-600 font-medium">{{ $org->phone ?? '-' }}</td>
                            <td class="py-4 text-gray-600 font-medium truncate max-w-[200px]">{{ $org->address ?? '-' }}</td>
                            <td class="py-4">
                                @if($org->is_verified)
                                    <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-md">Terverifikasi</span>
                                @else
                                    <span class="text-xs font-bold text-orange-600 bg-orange-50 px-2 py-1 rounded-md">Belum Verifikasi</span>
                                @endif
                            </td>
                            <td class="py-4 text-gray-900 font-bold text-right">{{ $org->kajians_count }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-4 text-center text-gray-500 font-medium">Belum ada penyelenggara</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Table Mosque -->
                <table class="w-full text-left" x-show="activeTab === 'mosque'" style="display: none;" x-transition>
                    <thead>
                        <tr class="text-xs font-bold text-gray-400 border-b border-gray-100 uppercase tracking-wider">
                            <th class="pb-3 font-medium">Nama Masjid</th>
                            <th class="pb-3 font-medium">Fasilitas</th>
                            <th class="pb-3 font-medium">Alamat</th>
                            <th class="pb-3 font-medium text-center">Link Maps</th>
                            <th class="pb-3 font-medium text-right">Total Kajian</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-sm">
                        @forelse($recentMosques as $mosque)
                        <tr>
                            <td class="py-4 text-gray-900 font-bold">{{ $mosque->name }}</td>
                            <td class="py-4">
                                @if($mosque->facilities)
                                    <div class="flex flex-wrap gap-1 max-w-[250px]">
                                        @php
                                            $facilities = explode(', ', $mosque->facilities);
                                            $display = array_slice($facilities, 0, 2);
                                            $remaining = count($facilities) - 2;
                                        @endphp
                                        @foreach($display as $facility)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-gray-100 text-gray-800 border border-gray-200 whitespace-nowrap">
                                                {{ $facility }}
                                            </span>
                                        @endforeach
                                        @if($remaining > 0)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-blue-50 text-blue-700 border border-blue-100 whitespace-nowrap" title="{{ implode(', ', array_slice($facilities, 2)) }}">
                                                +{{ $remaining }} lainnya
                                            </span>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-gray-400 font-medium">-</span>
                                @endif
                            </td>
                            <td class="py-4 text-gray-600 font-medium truncate max-w-[200px]">{{ $mosque->address ?? '-' }}</td>
                            <td class="py-4 text-center">
                                @if($mosque->google_maps_url)
                                    <a href="{{ $mosque->google_maps_url }}" target="_blank" class="inline-flex items-center justify-center text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors font-medium text-xs">
                                        <i data-lucide="map" class="w-4 h-4 mr-1.5"></i> Buka Maps
                                    </a>
                                @else
                                    <span class="text-gray-400 text-xs">-</span>
                                @endif
                            </td>
                            <td class="py-4 text-gray-900 font-bold text-right">{{ $mosque->kajians_count }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-4 text-center text-gray-500 font-medium">Belum ada masjid</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            

        </div>

    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js" data-turbo-eval="false"></script>
    <script>
        window.chartData = function() {
            return {
                chartType: 'mingguan',
                chartStyle: 'line',
                chartInstance: null,
                data: {
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
                            labels: this.data[this.chartType].labels,
                            datasets: [{
                                label: 'Pendaftar Baru',
                                data: this.data[this.chartType].data,
                                borderColor: '#ef4444',
                                backgroundColor: this.chartStyle === 'line' ? gradient : '#ef4444',
                                borderWidth: this.chartStyle === 'line' ? 3 : 0,
                                tension: 0.4,
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
                        this.chartInstance.data.labels = this.data[this.chartType].labels;
                        this.chartInstance.data.datasets[0].data = this.data[this.chartType].data;
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
