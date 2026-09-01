<x-organizer-layout>
    <div x-data="{ deleteModalOpen: false, deleteFormAction: '' }" class="space-y-6 relative">
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
            <a href="{{ route('organizer.peserta.global') }}" class="block bg-white p-5 rounded-2xl border border-gray-100 shadow-sm col-span-1 hover:shadow-md transition-all duration-200 cursor-pointer hover:border-emerald-200 group">
                <p class="text-sm text-gray-500 font-medium mb-1 group-hover:text-emerald-600 transition-colors">Total Pendaftar</p>
                <div class="flex items-end justify-between mt-4">
                    <h3 class="text-2xl font-bold text-gray-900 group-hover:text-emerald-700 transition-colors">{{ $calonPeserta ?? 450 }}</h3>
                    <div class="w-16 h-8">
                        <svg viewBox="0 0 50 20" class="w-full h-full stroke-emerald-500 fill-none" stroke-width="2">
                            <path d="M0,15 L10,10 L20,12 L30,5 L40,8 L50,2" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-emerald-500 font-medium flex items-center mt-2">
                    <i data-lucide="arrow-up" class="w-3 h-3 mr-1"></i> 12.5% <span class="text-gray-400 font-normal ml-1">Bulan Ini</span>
                </p>
            </a>

            <a href="{{ route('organizer.kajian.index') }}" class="block bg-white p-5 rounded-2xl border border-gray-100 shadow-sm col-span-1 hover:shadow-md transition-all duration-200 cursor-pointer hover:border-emerald-200 group">
                <p class="text-sm text-gray-500 font-medium mb-1 group-hover:text-emerald-600 transition-colors">Kajian Aktif</p>
                <div class="flex items-end justify-between mt-4">
                    <h3 class="text-2xl font-bold text-gray-900 group-hover:text-emerald-700 transition-colors">{{ $kajianAktif ?? 12 }}</h3>
                </div>
                <p class="text-xs text-gray-400 font-medium mt-2">Tafsir, Fiqih, Sejarah</p>
            </a>

            <a href="{{ route('organizer.peserta.global') }}" class="block bg-white p-5 rounded-2xl border border-gray-100 shadow-sm col-span-1 hover:shadow-md transition-all duration-200 cursor-pointer hover:border-emerald-200 group">
                <p class="text-sm text-gray-500 font-medium mb-1 group-hover:text-emerald-600 transition-colors">Total Hadir</p>
                <div class="flex items-end justify-between mt-4">
                    <h3 class="text-2xl font-bold text-gray-900 group-hover:text-emerald-700 transition-colors">{{ $pesertaHadir ?? '2,100' }}</h3>
                </div>
                <p class="text-xs text-gray-400 font-medium mt-2">All-time record</p>
            </a>

            <a href="{{ route('organizer.kajian.index') }}" class="block bg-white p-5 rounded-2xl border border-gray-100 shadow-sm col-span-1 hover:shadow-md transition-all duration-200 cursor-pointer hover:border-emerald-200 group">
                <p class="text-sm text-gray-500 font-medium mb-1 group-hover:text-emerald-600 transition-colors">Kajian Selesai</p>
                <div class="flex items-end justify-between mt-4">
                    <h3 class="text-2xl font-bold text-gray-900 group-hover:text-emerald-700 transition-colors">45</h3>
                    <div class="w-16 h-8">
                        <svg viewBox="0 0 50 20" class="w-full h-full stroke-emerald-500 fill-none" stroke-width="2">
                            <path d="M0,18 L10,12 L20,15 L30,8 L40,10 L50,4" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-emerald-500 font-medium flex items-center mt-2">
                    <i data-lucide="arrow-up" class="w-3 h-3 mr-1"></i> 5 <span class="text-gray-400 font-normal ml-1">Bulan Ini</span>
                </p>
            </a>

            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm col-span-1 flex flex-col justify-center text-center">
                <p class="text-xs text-gray-500 font-bold tracking-wider mb-2 uppercase">Waktu Sistem</p>
                <h3 class="text-3xl font-bold text-gray-900 mb-1" x-data="{ time: new Date().toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit'}) }" x-init="setInterval(() => time = new Date().toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit'}), 60000)" x-text="time">
                    12:30
                </h3>
                <p class="text-sm font-medium text-gray-900">{{ now()->translatedFormat('d F Y') }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm p-6 relative" x-data="chartData()" x-init="initChart()">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-lg font-bold text-gray-900">Statistik Pendaftar</h3>
                    <select x-model="chartType" @change="updateChart()" class="px-3 py-1.5 border border-gray-200 rounded-lg text-sm text-gray-600 outline-none focus:ring-2 focus:ring-emerald-500 cursor-pointer bg-white">
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
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-xs font-bold text-gray-400 border-b border-gray-100">
                                <th class="pb-3 font-medium">Tipe</th>
                                <th class="pb-3 font-medium">Judul</th>
                                <th class="pb-3 font-medium">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-sm">
                            @if($unverifiedKajianCount > 0)
                            <tr>
                                <td class="py-4 flex items-center text-gray-700 font-medium">
                                    <div class="w-2 h-2 rounded-full bg-gray-300 mr-2 border border-gray-400"></div> Approval
                                </td>
                                <td class="py-4 text-gray-900 font-bold">
                                    <a href="{{ route('organizer.kajian.index') }}" class="hover:text-emerald-600 transition-colors">
                                        {{ $unverifiedKajianCount }} Kajian Menunggu Review Admin
                                    </a>
                                </td>
                                <td class="py-4 flex justify-end">
                                    <span class="text-xs font-bold text-orange-500 bg-orange-50 px-2 py-1 rounded-md flex items-center w-max">
                                        <div class="w-1.5 h-1.5 rounded-full bg-orange-500 mr-1.5"></div> Pending
                                    </span>
                                </td>
                            </tr>
                            @endif

                            @if($draftKajianCount > 0)
                            <tr>
                                <td class="py-4 flex items-center text-gray-700 font-medium">
                                    <div class="w-2 h-2 rounded-full bg-gray-300 mr-2 border border-gray-400"></div> Draft
                                </td>
                                <td class="py-4 text-gray-900 font-bold">
                                    <a href="{{ route('organizer.kajian.index') }}" class="hover:text-emerald-600 transition-colors">
                                        Lanjutkan draft {{ $draftKajianCount }} Kajian
                                    </a>
                                </td>
                                <td class="py-4 flex justify-end">
                                    <span class="text-xs font-bold text-gray-500 bg-gray-100 px-2 py-1 rounded-md flex items-center w-max">
                                        <div class="w-1.5 h-1.5 rounded-full bg-gray-500 mr-1.5"></div> Draft
                                    </span>
                                </td>
                            </tr>
                            @endif

                            @if($unverifiedKajianCount == 0 && $draftKajianCount == 0)
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

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6" x-data="{ activeTab: 'events' }">
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
                <table class="w-full text-left" x-show="activeTab === 'events'" style="display: none;" x-transition>
                    <thead>
                        <tr class="text-xs font-bold text-gray-400 border-b border-gray-100 uppercase tracking-wider">
                            <th class="pb-3 font-medium">Nama Kajian</th>
                            <th class="pb-3 font-medium">Tanggal & Waktu</th>
                            <th class="pb-3 font-medium">Lokasi</th>
                            <th class="pb-3 font-medium">Status</th>
                            <th class="pb-3 font-medium">Kategori</th>
                            <th class="pb-3 font-medium text-right">Peserta</th>
                            <th class="pb-3 font-medium text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-sm">
                        @forelse($recentKajians as $k)
                        <tr>
                            <td class="py-4 text-gray-900 font-bold">
                                <a href="{{ route('organizer.kajian.edit', $k->slug) }}" class="hover:text-emerald-600 transition-colors">{{ $k->title }}</a>
                            </td>
                            <td class="py-4 text-gray-600 font-medium">{{ $k->start_at ? $k->start_at->format('M d, Y - h:i A') : '-' }}</td>
                            <td class="py-4 text-gray-600 font-medium">
                                {{ $k->mosque ? $k->mosque->name : '-' }}
                            </td>
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
                                    } elseif ($label === 'Draft') {
                                        $colorClass = 'text-gray-600 bg-gray-50';
                                        $dotClass = 'bg-gray-500';
                                    }
                                @endphp
                                <span class="text-xs font-bold {{ $colorClass }} px-2 py-1 rounded-md flex items-center w-max">
                                    <div class="w-1.5 h-1.5 rounded-full {{ $dotClass }} mr-1.5"></div> {{ $label }}
                                </span>
                            </td>
                            <td class="py-4 text-gray-600 font-medium">{{ $k->category->name ?? '-' }}</td>
                            <td class="py-4 text-gray-900 font-bold text-right">{{ $k->attendees_count }}</td>
                            <td class="py-4 text-right">
                                <button type="button" @click="deleteModalOpen = true; deleteFormAction = '{{ route('organizer.kajian.destroy', $k->slug) }}'" class="text-red-500 hover:text-red-700 transition-colors p-1" title="Hapus Kajian">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-6 text-center text-gray-500 font-medium">Belum ada kajian yang dibuat.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pendaftar Table -->
                <table class="w-full text-left" x-show="activeTab === 'pendaftar'" style="display: none;" x-transition>
                    <thead>
                        <tr class="text-xs font-bold text-gray-400 border-b border-gray-100 uppercase tracking-wider">
                            <th class="pb-3 font-medium">Nama Peserta</th>
                            <th class="pb-3 font-medium">Kajian</th>
                            <th class="pb-3 font-medium">Waktu Daftar</th>
                            <th class="pb-3 font-medium text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-sm">
                        @forelse($recentAttendees as $attendee)
                        <tr>
                            <td class="py-4 text-gray-900 font-bold">{{ $attendee->user->name }}</td>
                            <td class="py-4 text-gray-600 font-medium truncate max-w-[200px]">{{ $attendee->kajian->title }}</td>
                            <td class="py-4 text-gray-600 font-medium">{{ $attendee->created_at->diffForHumans() }}</td>
                            <td class="py-4 flex justify-end">
                                @if($attendee->status === 'attended')
                                    <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-md">Hadir</span>
                                @else
                                    <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded-md">Terdaftar</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-6 text-center text-gray-500 font-medium">Belum ada pendaftar terbaru.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Lokasi Table -->
                <table class="w-full text-left" x-show="activeTab === 'lokasi'" style="display: none;" x-transition>
                    <thead>
                        <tr class="text-xs font-bold text-gray-400 border-b border-gray-100 uppercase tracking-wider">
                            <th class="pb-3 font-medium">Nama Masjid</th>
                            <th class="pb-3 font-medium">Alamat</th>
                            <th class="pb-3 font-medium text-right">Kajian Diadakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-sm">
                        @forelse($recentMosques as $mosque)
                        <tr>
                            <td class="py-4 text-gray-900 font-bold">{{ $mosque->name }}</td>
                            <td class="py-4 text-gray-600 font-medium truncate max-w-[300px]">{{ $mosque->address ?? '-' }}</td>
                            <td class="py-4 text-gray-900 font-bold text-right">{{ $mosque->kajians()->where('organizer_id', auth()->user()->organizer->id)->count() }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="py-6 text-center text-gray-500 font-medium">Belum ada masjid yang digunakan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div x-show="deleteModalOpen" style="display: none;" class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div x-show="deleteModalOpen" class="fixed inset-0 bg-transparent" @click="deleteModalOpen = false"></div>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto pointer-events-none">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div x-show="deleteModalOpen" 
                         x-transition:enter="ease-out duration-300" 
                         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                         x-transition:leave="ease-in duration-200" 
                         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                         class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg pointer-events-auto border border-gray-200">
                        
                        <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <i data-lucide="alert-triangle" class="h-6 w-6 text-red-600"></i>
                                </div>
                                <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                    <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Hapus Kajian</h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500">Apakah Anda yakin ingin menghapus kajian ini? Data yang sudah dihapus tidak dapat dikembalikan.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 border-t border-gray-100">
                            <form method="POST" :action="deleteFormAction" data-turbo="false" class="w-full sm:w-auto">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-700 sm:ml-3 sm:w-auto">Hapus Permanen</button>
                            </form>
                            <button type="button" @click="deleteModalOpen = false" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Batal</button>
                        </div>
                    </div>
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
                    gradient.addColorStop(0, 'rgba(16, 185, 129, 0.2)'); // emerald-500
                    gradient.addColorStop(1, 'rgba(16, 185, 129, 0)');

                    this.chartInstance = new Chart(ctx, {
                        type: this.chartStyle,
                        data: {
                            labels: this.data[this.chartType].labels,
                            datasets: [{
                                label: 'Pendaftar Baru',
                                data: this.data[this.chartType].data,
                                borderColor: '#10b981', // emerald-500
                                backgroundColor: this.chartStyle === 'line' ? gradient : '#10b981',
                                borderWidth: this.chartStyle === 'line' ? 3 : 0,
                                tension: 0.4,
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
</x-organizer-layout>
