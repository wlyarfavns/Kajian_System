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
            <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm p-6 relative">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-lg font-bold text-gray-900">Statistik Pendaftar</h3>
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

                <div class="w-full h-64 relative mt-4">
                    <div class="absolute inset-0 flex flex-col justify-between pointer-events-none">
                        <div class="border-b border-gray-50 w-full flex items-end pb-1"><span class="text-xs text-gray-400 w-12">500</span></div>
                        <div class="border-b border-gray-50 w-full flex items-end pb-1"><span class="text-xs text-gray-400 w-12">400</span></div>
                        <div class="border-b border-gray-50 w-full flex items-end pb-1"><span class="text-xs text-gray-400 w-12">300</span></div>
                        <div class="border-b border-gray-50 w-full flex items-end pb-1"><span class="text-xs text-gray-400 w-12">200</span></div>
                        <div class="border-b border-gray-50 w-full flex items-end pb-1"><span class="text-xs text-gray-400 w-12">0</span></div>
                    </div>
                    
                    <div class="ml-12 h-full relative">
                        <svg viewBox="0 0 800 200" class="w-full h-full" preserveAspectRatio="none">
                            <path d="M0,150 Q50,120 100,140 T200,90 T300,100 T400,60 T500,80 T600,60 T700,40 T800,20" fill="none" stroke="#10b981" stroke-width="4" stroke-linecap="round"/>
                            <path d="M0,150 Q50,120 100,140 T200,90 T300,100 T400,60 T500,80 T600,60 T700,40 T800,20 L800,200 L0,200 Z" fill="url(#gradEmerald)" opacity="0.1"/>
                            
                            <defs>
                                <linearGradient id="gradEmerald" x1="0" y1="0" x2="0" y2="1">
                                    <stop offset="0%" stop-color="#10b981" />
                                    <stop offset="100%" stop-color="rgba(16, 185, 129, 0)" />
                                </linearGradient>
                            </defs>
                        </svg>
                        
                        <div class="absolute top-[20%] left-[60%] -translate-x-1/2 bg-white p-4 rounded-xl shadow-xl text-sm border border-gray-100 z-10 w-48">
                            <div class="flex justify-between items-center mb-1"><span class="text-gray-500">Pendaftar</span><span class="font-bold text-gray-900">450</span></div>
                            <div class="flex justify-between items-center mb-2"><span class="text-gray-500">Kajian</span><span class="font-bold text-gray-900">12</span></div>
                            <div class="text-xs text-emerald-500 font-medium">+15% vs Minggu Lalu</div>
                        </div>
                        <div class="absolute top-[35%] left-[60%] w-4 h-4 bg-emerald-500 border-4 border-white rounded-full z-10 shadow-sm -translate-x-1/2 -translate-y-1/2"></div>
                    </div>
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
                            <tr>
                                <td class="py-4 flex items-center text-gray-700 font-medium">
                                    <div class="w-2 h-2 rounded-full bg-gray-300 mr-2 border border-gray-400"></div> Pendaftaran
                                </td>
                                <td class="py-4 text-gray-900 font-bold">Kajian Fiqih Anak...</td>
                                <td class="py-4"><span class="text-xs font-bold text-emerald-500 bg-emerald-50 px-2 py-1 rounded-md flex items-center w-max"><div class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></div> Terjadwal</span></td>
                            </tr>
                            <tr>
                                <td class="py-4 flex items-center text-gray-700 font-medium">
                                    <div class="w-2 h-2 rounded-full bg-gray-300 mr-2 border border-gray-400"></div> Approval
                                </td>
                                <td class="py-4 text-gray-900 font-bold">Kajian Spesial...</td>
                                <td class="py-4"><span class="text-xs font-bold text-red-500 bg-red-50 px-2 py-1 rounded-md flex items-center w-max"><div class="w-1.5 h-1.5 rounded-full bg-red-500 mr-1.5"></div> Pending</span></td>
                            </tr>
                            <tr>
                                <td class="py-4 flex items-center text-gray-700 font-medium">
                                    <div class="w-2 h-2 rounded-full bg-gray-300 mr-2 border border-gray-400"></div> Lokasi
                                </td>
                                <td class="py-4 text-gray-900 font-bold">Lengkapi data M...</td>
                                <td class="py-4"><span class="text-xs font-bold text-blue-500 bg-blue-50 px-2 py-1 rounded-md flex items-center w-max"><div class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-1.5"></div> New</span></td>
                            </tr>
                            <tr>
                                <td class="py-4 flex items-center text-gray-700 font-medium">
                                    <div class="w-2 h-2 rounded-full bg-gray-300 mr-2 border border-gray-400"></div> Sistem
                                </td>
                                <td class="py-4 text-gray-900 font-bold">Update Profil P...</td>
                                <td class="py-4"><span class="text-xs font-bold text-gray-500 bg-gray-100 px-2 py-1 rounded-md flex items-center w-max"><div class="w-1.5 h-1.5 rounded-full bg-gray-500 mr-1.5"></div> Not Done</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4">
                <h3 class="text-lg font-bold text-gray-900">Jadwal Kajian (Event List)</h3>
                
                <div class="flex items-center space-x-2 text-sm text-gray-500 bg-gray-50 rounded-lg p-1">
                    <button class="px-4 py-1.5 bg-white text-blue-600 font-medium rounded-md shadow-sm border border-gray-200 flex items-center">
                        <i data-lucide="calendar" class="w-4 h-4 mr-2"></i> Events
                    </button>
                    <button class="px-4 py-1.5 hover:text-gray-700 font-medium rounded-md transition-colors flex items-center">
                        <i data-lucide="ticket" class="w-4 h-4 mr-2"></i> Pendaftar
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
                            <th class="pb-3 font-medium text-right">Peserta</th>
                            <th class="pb-3 font-medium text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-sm">
                        @forelse($recentKajians as $k)
                        <tr>
                            <td class="py-4 text-gray-900 font-bold">
                                <a href="{{ route('organizer.kajian.edit', $k->slug) }}" class="hover:text-blue-600 transition-colors">{{ $k->title }}</a>
                            </td>
                            <td class="py-4 text-gray-600 font-medium">{{ $k->start_at ? $k->start_at->format('M d, Y - h:i A') : '-' }}</td>
                            <td class="py-4 text-gray-600 font-medium">
                                {{ $k->mosque ? $k->mosque->name : '-' }}
                            </td>
                            <td class="py-4">
                                @if($k->status === 'published')
                                    <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-md flex items-center w-max"><div class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></div> Published</span>
                                @else
                                    <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded-md flex items-center w-max"><div class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-1.5"></div> Draft</span>
                                @endif
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

    </div>
</x-organizer-layout>
