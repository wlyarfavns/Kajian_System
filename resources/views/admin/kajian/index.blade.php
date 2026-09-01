<x-admin-layout>
    <x-slot name="header">
        Moderasi Kajian
    </x-slot>

    <div x-data="{
        modalOpen: false,
        activeKajian: null,
        
        openModal(kajian) {
            this.activeKajian = kajian;
            this.modalOpen = true;
        },
        closeModal() {
            this.modalOpen = false;
            setTimeout(() => { this.activeKajian = null; }, 300);
        }
    }">
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm mb-6">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-bold text-brand-ink">Moderasi Kajian Masuk</h2>
                <p class="text-sm text-brand-ink-soft">Tinjau dan verifikasi kajian baru yang dikirimkan oleh penyelenggara.</p>
            </div>

            @if(session('success'))
                <div class="bg-green-50 text-green-800 p-4 border-b border-green-200 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="px-6 py-4 text-xs font-semibold text-brand-ink-soft uppercase tracking-wider">Judul & Penyelenggara</th>
                            <th class="px-6 py-4 text-xs font-semibold text-brand-ink-soft uppercase tracking-wider">Waktu</th>
                            <th class="px-6 py-4 text-xs font-semibold text-brand-ink-soft uppercase tracking-wider">Status Verifikasi</th>
                            <th class="px-6 py-4 text-xs font-semibold text-brand-ink-soft uppercase tracking-wider text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($kajians as $kajian)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="font-medium text-brand-ink">{{ $kajian->title }}</div>
                                <div class="text-sm text-brand-ink-soft mt-1">Oleh: {{ $kajian->organizer->name ?? 'Penyelenggara Tidak Diketahui' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-brand-ink">{{ $kajian->start_at ? $kajian->start_at->format('d M Y') : '-' }}</div>
                                <div class="text-xs text-brand-ink-soft mt-1">
                                    {{ $kajian->start_at ? $kajian->start_at->format('H:i') : '-' }} 
                                    - 
                                    {{ $kajian->end_at ? $kajian->end_at->format('H:i') : '-' }} WIB
                                </div>
                                <div class="mt-2 text-[11px] font-bold px-2 py-0.5 rounded w-max bg-gray-100 text-gray-700">
                                    {{ $kajian->status_label }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($kajian->is_verified)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-brand-emerald-100 text-brand-emerald-900">Disetujui</span>
                                @elseif($kajian->status === 'cancelled')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Ditolak</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-brand-gold-soft text-brand-gold-text">Menunggu</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <button type="button" @click="openModal({{ json_encode([
                                    'id' => $kajian->id,
                                    'title' => $kajian->title,
                                    'organizer' => $kajian->organizer->name ?? '-',
                                    'speaker' => $kajian->speaker->name ?? '-',
                                    'mosque' => $kajian->mosque->name ?? '-',
                                    'address' => $kajian->address ?? '-',
                                    'date' => $kajian->start_at ? $kajian->start_at->translatedFormat('d F Y') : '-',
                                    'time' => $kajian->start_at ? $kajian->start_at->format('H:i') . ' - ' . $kajian->end_at->format('H:i') . ' WIB' : '-',
                                    'poster' => $kajian->poster ? Storage::url($kajian->poster) : null,
                                    'category' => $kajian->category->name ?? '-',
                                    'is_verified' => $kajian->is_verified,
                                    'status' => $kajian->status,
                                    'execution_status' => $kajian->status_label,
                                    'verify_url' => route('admin.kajian.verify', $kajian->id),
                                    'reject_url' => route('admin.kajian.reject', $kajian->id)
                                ]) }})" class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-sm font-medium rounded-md text-brand-ink bg-white hover:bg-gray-50 transition" title="Lihat Detail & Moderasi">
                                    <i data-lucide="eye" class="w-4 h-4 sm:mr-1.5"></i> <span class="hidden sm:inline">Tinjau Detail</span>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-brand-ink-soft">
                                Tidak ada kajian yang perlu dimoderasi.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Detail Modal -->
        <div x-show="modalOpen" class="relative z-50" style="display: none;" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <!-- Background overlay -->
            <div x-show="modalOpen" x-transition.opacity class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" @click="closeModal()"></div>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <!-- Modal panel -->
                    <div x-show="modalOpen" 
                         x-transition:enter="ease-out duration-300" 
                         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                         x-transition:leave="ease-in duration-200" 
                         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                         class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 w-full max-w-3xl border border-gray-100">
                    
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
                        <div class="flex items-center gap-3">
                            <h3 class="text-xl font-bold text-brand-ink" id="modal-title">Detail Kajian</h3>
                            
                            <!-- Status Badge -->
                            <template x-if="activeKajian && !activeKajian.is_verified && activeKajian.status !== 'cancelled'">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-brand-gold-soft text-brand-gold-text">
                                    <i data-lucide="hourglass" class="w-3 h-3 mr-1"></i> Menunggu Verifikasi
                                </span>
                            </template>
                            <template x-if="activeKajian && activeKajian.is_verified">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                    Disetujui
                                </span>
                            </template>
                            <template x-if="activeKajian && activeKajian.status === 'cancelled'">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800">
                                    Ditolak
                                </span>
                            </template>
                        </div>
                        <button type="button" @click="closeModal()" class="rounded-full p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 transition">
                            <i data-lucide="x" class="w-5 h-5"></i>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="px-6 py-5 bg-gray-50/50">
                        <p class="text-sm text-brand-ink-soft mb-6">Tinjau informasi dan poster kajian sebelum memberikan persetujuan.</p>
                        
                        <div class="mb-4 flex items-center font-bold text-brand-emerald-900">
                            <i data-lucide="book-open" class="w-5 h-5 mr-2"></i> Informasi Kajian
                        </div>

                        <div class="bg-white border border-gray-200 rounded-xl p-5 mb-6 flex flex-col md:flex-row gap-6">
                            <!-- Poster -->
                            <div class="w-full md:w-1/3 aspect-[3/4] bg-gray-100 rounded-lg overflow-hidden border border-gray-200 flex-shrink-0 relative flex items-center justify-center">
                                <template x-if="activeKajian && activeKajian.poster">
                                    <img :src="activeKajian.poster" class="w-full h-full object-cover">
                                </template>
                                <template x-if="activeKajian && !activeKajian.poster">
                                    <div class="text-center text-gray-400">
                                        <i data-lucide="image" class="w-12 h-12 mx-auto mb-2 opacity-50"></i>
                                        <span class="text-xs font-medium">Tidak ada poster</span>
                                    </div>
                                </template>
                            </div>
                            
                            <!-- Info Grid -->
                            <div class="flex-1 space-y-4">
                                <div>
                                    <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Judul Kajian</p>
                                    <p class="text-base font-bold text-brand-ink" x-text="activeKajian ? activeKajian.title : '-'"></p>
                                    <span class="inline-block mt-1 px-2 py-0.5 bg-gray-100 text-gray-700 text-xs font-bold rounded" x-text="activeKajian ? activeKajian.category : '-'"></span>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Pemateri</p>
                                        <p class="text-sm font-semibold text-brand-ink" x-text="activeKajian ? activeKajian.speaker : '-'"></p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Penyelenggara</p>
                                        <p class="text-sm font-semibold text-brand-ink" x-text="activeKajian ? activeKajian.organizer : '-'"></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Waktu & Lokasi -->
                        <div class="mb-4 flex items-center font-bold text-brand-emerald-900">
                            <i data-lucide="map-pin" class="w-5 h-5 mr-2"></i> Pelaksanaan
                        </div>

                        <div class="flex gap-4">
                            <div class="flex-1 bg-white border border-gray-200 rounded-xl p-4 flex items-start gap-3">
                                <div class="bg-red-50 text-red-600 p-2 rounded-lg"><i data-lucide="calendar" class="w-5 h-5"></i></div>
                                <div>
                                    <p class="text-xs text-gray-500 font-bold uppercase">Waktu</p>
                                    <p class="text-sm font-bold text-brand-ink mt-1" x-text="activeKajian ? activeKajian.date : '-'"></p>
                                    <p class="text-xs text-gray-600 mt-0.5" x-text="activeKajian ? activeKajian.time : '-'"></p>
                                    <p class="text-xs font-bold text-gray-700 mt-2" x-text="activeKajian ? activeKajian.execution_status : '-'"></p>
                                </div>
                            </div>
                            <div class="flex-[1.5] bg-white border border-gray-200 rounded-xl p-4 flex items-start gap-3">
                                <div class="bg-blue-50 text-blue-600 p-2 rounded-lg"><i data-lucide="building-2" class="w-5 h-5"></i></div>
                                <div>
                                    <p class="text-xs text-gray-500 font-bold uppercase">Lokasi / Masjid</p>
                                    <p class="text-sm font-bold text-brand-ink mt-1" x-text="activeKajian ? activeKajian.mosque : '-'"></p>
                                    <p class="text-xs text-gray-600 mt-0.5" x-text="activeKajian ? activeKajian.address : '-'"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <template x-if="activeKajian && !activeKajian.is_verified && activeKajian.status !== 'cancelled'">
                        <div class="bg-white px-6 py-4 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                            <div class="w-full sm:w-1/2">
                                <p class="text-xs font-bold text-gray-700 mb-1">Alasan (jika ditolak)</p>
                                <input type="text" placeholder="Contoh: Poster kurang jelas..." class="w-full border-gray-300 rounded-lg shadow-sm focus:border-brand-emerald-500 focus:ring-brand-emerald-500 text-sm">
                            </div>
                            <div class="flex gap-3 w-full sm:w-auto">
                                <form :action="activeKajian.reject_url" method="POST" data-turbo="false" class="flex-1 sm:flex-none">
                                    @csrf
                                    <button type="submit" class="w-full sm:w-auto px-5 py-2.5 bg-red-50 text-red-600 border border-red-200 font-bold rounded-lg hover:bg-red-100 transition text-sm flex items-center justify-center">
                                        <i data-lucide="ban" class="w-4 h-4 mr-2"></i> Tolak
                                    </button>
                                </form>
                                <form :action="activeKajian.verify_url" method="POST" data-turbo="false" class="flex-1 sm:flex-none">
                                    @csrf
                                    <button type="submit" class="w-full sm:w-auto px-5 py-2.5 bg-brand-emerald-900 text-white font-bold rounded-lg hover:bg-brand-emerald-950 shadow-sm transition text-sm flex items-center justify-center">
                                        <i data-lucide="check-circle" class="w-4 h-4 mr-2"></i> Verifikasi
                                    </button>
                                </form>
                            </div>
                        </div>
                    </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
