<x-organizer-layout>
    <div class="space-y-6">
        
        <!-- Top row: KPI Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Card 1 -->
            <a href="{{ route('organizer.kajian.index') }}" class="block bg-white p-5 rounded-2xl border border-gray-100 shadow-sm col-span-1 hover:border-brand-emerald-500 hover:shadow-md transition">
                <p class="text-sm text-gray-500 font-medium mb-1">Kajian Aktif</p>
                <div class="flex items-end justify-between mt-4">
                    <h3 class="text-2xl font-bold text-gray-900">{{ number_format($kajianAktif) }}</h3>
                    <div class="w-16 h-8 flex items-center justify-end">
                        <i data-lucide="mic" class="w-6 h-6 text-brand-gold-text"></i>
                    </div>
                </div>
            </a>

            <!-- Card 2 -->
            <a href="{{ route('organizer.kajian.index') }}" class="block bg-white p-5 rounded-2xl border border-gray-100 shadow-sm col-span-1 hover:border-brand-emerald-500 hover:shadow-md transition">
                <p class="text-sm text-gray-500 font-medium mb-1">Kajian Bulan Ini</p>
                <div class="flex items-end justify-between mt-4">
                    <h3 class="text-2xl font-bold text-gray-900">{{ number_format($kajianBulanIni) }}</h3>
                    <div class="w-16 h-8 flex items-center justify-end">
                        <i data-lucide="calendar" class="w-6 h-6 text-blue-500"></i>
                    </div>
                </div>
            </a>

            <!-- Card 3 -->
            <a href="{{ route('organizer.peserta.global') }}" class="block bg-white p-5 rounded-2xl border border-gray-100 shadow-sm col-span-1 hover:border-brand-emerald-500 hover:shadow-md transition">
                <p class="text-sm text-gray-500 font-medium mb-1">Calon Peserta</p>
                <div class="flex items-end justify-between mt-4">
                    <h3 class="text-2xl font-bold text-gray-900">{{ number_format($calonPeserta) }}</h3>
                    <div class="w-16 h-8 flex items-center justify-end">
                        <i data-lucide="users" class="w-6 h-6 text-emerald-500"></i>
                    </div>
                </div>
            </a>

            <!-- Card 4 -->
            <a href="{{ route('organizer.peserta.global') }}" class="block bg-white p-5 rounded-2xl border border-gray-100 shadow-sm col-span-1 hover:border-brand-emerald-500 hover:shadow-md transition">
                <p class="text-sm text-gray-500 font-medium mb-1">Peserta Hadir</p>
                <div class="flex items-end justify-between mt-4">
                    <h3 class="text-2xl font-bold text-gray-900">{{ number_format($pesertaHadir) }}</h3>
                    <div class="w-16 h-8 flex items-center justify-end">
                        <i data-lucide="check-circle-2" class="w-6 h-6 text-emerald-600"></i>
                    </div>
                </div>
            </a>
        </div>

        <!-- Bottom row: Event List Table -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4">
                <h3 class="text-lg font-bold text-gray-900">Kajian Terbaru</h3>
                <a href="{{ route('organizer.kajian.index') }}" class="text-sm font-medium text-brand-emerald-800 hover:text-brand-emerald-950 flex items-center">
                    Lihat Semua <i data-lucide="arrow-right" class="w-4 h-4 ml-1"></i>
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-xs font-bold text-gray-400 border-b border-gray-100 uppercase tracking-wider whitespace-nowrap">
                            <th class="pb-3 font-medium">Nama Kajian</th>
                            <th class="pb-3 font-medium">Tanggal & Waktu</th>
                            <th class="pb-3 font-medium">Kategori</th>
                            <th class="pb-3 font-medium">Status</th>
                            <th class="pb-3 font-medium text-right">Pendaftar</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-sm">
                        @forelse($recentKajians as $kajian)
                            <tr class="hover:bg-gray-50 transition whitespace-nowrap">
                                <td class="py-4 text-gray-900 font-bold">
                                    <a href="{{ route('organizer.kajian.show', $kajian->slug) }}" class="hover:text-brand-emerald-800 transition">
                                        {{ $kajian->title }}
                                    </a>
                                </td>
                                <td class="py-4 text-gray-600 font-medium">
                                    {{ \Carbon\Carbon::parse($kajian->start_at)->format('d M Y') }} - {{ \Carbon\Carbon::parse($kajian->start_at)->format('H:i') }}
                                </td>
                                <td class="py-4 text-gray-600 font-medium">{{ $kajian->category->name ?? '-' }}</td>
                                <td class="py-4">
                                    @if($kajian->status === 'draft')
                                        <span class="text-xs font-bold text-gray-800 bg-gray-100 px-2 py-1 rounded-md flex items-center w-max"><div class="w-1.5 h-1.5 rounded-full bg-gray-500 mr-1.5"></div> Draft</span>
                                    @elseif($kajian->status === 'published')
                                        <span class="text-xs font-bold text-emerald-800 bg-emerald-100 px-2 py-1 rounded-md flex items-center w-max"><div class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></div> Dipublikasikan</span>
                                    @elseif($kajian->status === 'ongoing')
                                        <span class="text-xs font-bold text-white bg-brand-badge-live px-2 py-1 rounded-md flex items-center w-max"><div class="w-1.5 h-1.5 rounded-full bg-white mr-1.5"></div> Berlangsung</span>
                                    @elseif($kajian->status === 'finished')
                                        <span class="text-xs font-bold text-gray-100 bg-gray-800 px-2 py-1 rounded-md flex items-center w-max"><div class="w-1.5 h-1.5 rounded-full bg-gray-100 mr-1.5"></div> Selesai</span>
                                    @elseif($kajian->status === 'cancelled')
                                        <span class="text-xs font-bold text-brand-danger bg-red-100 px-2 py-1 rounded-md flex items-center w-max"><div class="w-1.5 h-1.5 rounded-full bg-red-500 mr-1.5"></div> Dibatalkan</span>
                                    @endif
                                </td>
                                <td class="py-4 text-gray-900 font-bold text-right">{{ $kajian->attendees_count }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-6 text-center text-gray-500">Belum ada kajian yang dibuat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>


        </div>

    </div>
</x-organizer-layout>
