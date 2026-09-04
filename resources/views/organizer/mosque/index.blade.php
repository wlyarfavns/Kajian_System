<x-organizer-layout>
    <x-slot name="header">
        Kelola Lokasi Masjid
    </x-slot>

    <div x-data="{ showModal: false, selectedMosque: null }" class="bg-white border border-gray-200 rounded-xl shadow-sm">
        <div class="p-6 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center">
            <div>
                <h2 class="text-lg font-bold text-brand-ink">Daftar Lokasi Masjid</h2>
                <p class="text-sm text-brand-ink-soft">Kelola data lokasi masjid tempat Anda menyelenggarakan kajian.</p>
            </div>
            <div class="mt-4 sm:mt-0 flex flex-col sm:flex-row gap-3">
                <form method="GET" action="{{ route('organizer.mosque.index') }}" class="flex w-full sm:w-auto" data-turbo-frame="data-table" x-data>
                    <div class="relative w-full sm:w-64">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i data-lucide="search" class="h-4 w-4 text-gray-400"></i>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" @input.debounce.500ms="$el.form.requestSubmit()" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:border-brand-emerald-500 focus:ring-1 focus:ring-brand-emerald-500 sm:text-sm transition duration-150 ease-in-out" placeholder="Cari nama masjid atau alamat...">
                    </div>
                </form>
                <a href="{{ route('organizer.mosque.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-brand-emerald-900 text-white text-sm font-medium rounded-lg hover:bg-brand-emerald-950 transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-emerald-900 shadow-sm">
                    <i data-lucide="plus-circle" class="w-4 h-4 mr-2 shrink-0"></i> Tambah Masjid
                </a>
            </div>

        <turbo-frame id="data-table">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-6 py-4 text-xs font-semibold text-brand-ink-soft uppercase tracking-wider w-16">No</th>
                        <th class="px-6 py-4 text-xs font-semibold text-brand-ink-soft uppercase tracking-wider">Nama Masjid</th>
                        <th class="px-6 py-4 text-xs font-semibold text-brand-ink-soft uppercase tracking-wider">Alamat</th>
                        <th class="px-6 py-4 text-xs font-semibold text-brand-ink-soft uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($mosques as $mosque)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm text-brand-ink font-medium">
                                {{ $mosques->firstItem() + $loop->index }}
                            </td>
                            <td class="px-6 py-4 font-medium text-brand-ink">
                                {{ $mosque->name }}
                                @if($mosque->google_maps_url)
                                    <a href="{{ $mosque->google_maps_url }}" target="_blank" class="text-xs text-blue-500 ml-2 hover:underline">
                                        <i data-lucide="external-link" class="w-3 h-3 inline"></i> Maps
                                    </a>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ Str::limit($mosque->address, 50) }}</td>
                            <td class="px-6 py-4 text-right space-x-2">
                                @php
                                    $mosqueData = [
                                        'name' => $mosque->name,
                                        'organizer' => $mosque->organizer->name ?? '-',
                                        'photo' => $mosque->photo ? asset('storage/' . $mosque->photo) : null,
                                        'address' => $mosque->address,
                                        'created_at' => $mosque->created_at ? $mosque->created_at->format('d M Y') : '-',
                                        'latitude' => $mosque->latitude,
                                        'longitude' => $mosque->longitude,
                                        'google_maps_url' => $mosque->google_maps_url
                                    ];
                                @endphp
                                <button type="button" @click="showModal = true; selectedMosque = {{ json_encode($mosqueData) }}" class="inline-flex items-center px-3 py-1.5 border border-brand-emerald-900 text-sm font-medium rounded-md text-brand-emerald-900 bg-white hover:bg-brand-emerald-50 transition" title="Detail">
                                    <i data-lucide="eye" class="w-4 h-4 sm:mr-1.5"></i> <span class="hidden sm:inline">Detail</span>
                                </button>
                                <a href="{{ route('organizer.mosque.edit', $mosque->id) }}" class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-sm font-medium rounded-md text-brand-ink bg-white hover:bg-gray-50 transition" title="Edit" data-turbo-frame="_top">
                                    <i data-lucide="edit-2" class="w-4 h-4 sm:mr-1.5"></i> <span class="hidden sm:inline">Edit</span>
                                </a>
                                <form action="{{ route('organizer.mosque.destroy', $mosque->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus masjid ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-brand-danger text-sm font-medium rounded-md text-white bg-brand-danger hover:bg-red-700 transition shadow-sm" title="Hapus">
                                        <i data-lucide="trash-2" class="w-4 h-4 sm:mr-1.5"></i> <span class="hidden sm:inline">Hapus</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-brand-ink-soft">
                                Belum ada data lokasi masjid.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($mosques->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 flex justify-center">
                {{ $mosques->links() }}
            </div>
        @endif
        </turbo-frame>

        <!-- Detail Modal -->
        <div x-show="showModal" class="fixed inset-0 z-[100] overflow-y-auto" style="display: none;" x-cloak>
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <div x-show="showModal" 
                     x-transition:enter="ease-out duration-300" 
                     x-transition:enter-start="opacity-0" 
                     x-transition:enter-end="opacity-100" 
                     x-transition:leave="ease-in duration-200" 
                     x-transition:leave-start="opacity-100" 
                     x-transition:leave-end="opacity-0" 
                     class="fixed inset-0 transition-opacity bg-gray-500/75" aria-hidden="true" @click="showModal = false"></div>
                
                <div x-show="showModal" 
                     x-transition:enter="ease-out duration-300" 
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave="ease-in duration-200" 
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     class="relative inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-2xl shadow-2xl sm:my-8 sm:align-middle w-full max-w-3xl" 
                     role="dialog" aria-modal="true">
                    
                    <div class="flex flex-col md:flex-row w-full bg-white">
                        <!-- Kiri: Foto Masjid -->
                        <div class="w-full md:w-2/5 lg:w-1/3 h-64 md:h-auto relative bg-brand-emerald-50 shrink-0 border-b md:border-b-0 md:border-r border-gray-200">
                            <template x-if="selectedMosque && selectedMosque.photo">
                                <img :src="selectedMosque.photo" :alt="selectedMosque.name" class="absolute inset-0 w-full h-full object-cover">
                            </template>
                            <template x-if="!selectedMosque || !selectedMosque.photo">
                                <div class="absolute inset-0 w-full h-full flex items-center justify-center">
                                    <svg class="w-24 h-24 text-brand-emerald-700 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                                </div>
                            </template>
                        </div>

                        <!-- Kanan: Detail Text -->
                        <div class="relative w-full md:w-3/5 lg:w-2/3 p-6 md:p-8 bg-white flex flex-col">
                            <button type="button" @click="showModal = false" class="absolute top-4 right-4 text-gray-400 hover:text-red-500 bg-gray-50 hover:bg-red-50 rounded-full p-2 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>

                            <!-- Header Info -->
                            <div class="mb-6 pr-10">
                                <h2 class="text-2xl font-bold text-brand-ink mb-1" x-text="selectedMosque ? selectedMosque.name : ''"></h2>
                                <p class="text-sm text-brand-ink-soft">Penyelenggara: <span class="font-medium text-brand-emerald-700" x-text="selectedMosque ? selectedMosque.organizer : ''"></span></p>
                            </div>

                            <h3 class="text-lg font-bold text-brand-ink mb-3 border-b border-gray-100 pb-2">Alamat Lengkap</h3>
                            
                            <div class="prose prose-sm max-w-none text-brand-ink-soft overflow-y-auto max-h-48 mb-6" style="white-space: pre-line;">
                                <template x-if="selectedMosque && selectedMosque.address">
                                    <span x-text="selectedMosque.address"></span>
                                </template>
                                <template x-if="!selectedMosque || !selectedMosque.address">
                                    <p class="italic text-gray-400">Belum ada alamat untuk masjid ini.</p>
                                </template>
                            </div>

                            <div x-show="selectedMosque && selectedMosque.latitude && selectedMosque.longitude" class="mb-6">
                                <h3 class="text-sm font-bold text-brand-ink mb-2">Koordinat</h3>
                                <p class="text-sm text-gray-900 mb-1"><span x-text="selectedMosque ? selectedMosque.latitude : ''"></span>, <span x-text="selectedMosque ? selectedMosque.longitude : ''"></span></p>
                                <div x-show="selectedMosque && selectedMosque.google_maps_url">
                                    <a :href="selectedMosque ? selectedMosque.google_maps_url : '#'" target="_blank" class="inline-flex items-center text-sm text-blue-600 hover:underline mt-1">
                                        <i data-lucide="external-link" class="w-4 h-4 mr-1"></i> Buka di Google Maps
                                    </a>
                                </div>
                            </div>

                            <!-- Footer Section -->
                            <div class="mt-auto pt-6 border-t border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <p class="text-xs text-gray-500">Ditambahkan pada: <span x-text="selectedMosque ? selectedMosque.created_at : ''"></span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-organizer-layout>
