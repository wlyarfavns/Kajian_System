<x-admin-layout>
    <x-slot name="header">
        Kelola Lokasi Masjid
    </x-slot>

    <div x-data="{ deleteModalOpen: false, deleteFormAction: '', detailModalOpen: false, selectedMosque: null }" class="bg-white border border-gray-200 rounded-xl shadow-sm mb-6">
        <div class="p-6 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center">
            <div>
                <h2 class="text-lg font-bold text-brand-ink">Daftar Lokasi Masjid</h2>
                <p class="text-sm text-brand-ink-soft">Kelola data lokasi masjid tempat Anda menyelenggarakan kajian.</p>
            </div>
            <a href="{{ route('admin.mosque.create') }}" class="mt-4 sm:mt-0 inline-flex items-center px-4 py-2 bg-brand-emerald-900 text-white text-sm font-medium rounded-lg hover:bg-brand-emerald-950 transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-emerald-900">
                <i data-lucide="plus-circle" class="w-4 h-4 mr-2"></i> Tambah Masjid
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-6 py-4 text-xs font-semibold text-brand-ink-soft uppercase tracking-wider">Nama Masjid</th>
                        <th class="px-6 py-4 text-xs font-semibold text-brand-ink-soft uppercase tracking-wider">Penyelenggara</th>
                        <th class="px-6 py-4 text-xs font-semibold text-brand-ink-soft uppercase tracking-wider">Alamat</th>
                        <th class="px-6 py-4 text-xs font-semibold text-brand-ink-soft uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($mosques as $mosque)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-brand-ink">
                                {{ $mosque->name }}
                                @if($mosque->google_maps_url)
                                    <a href="{{ $mosque->google_maps_url }}" target="_blank" class="text-xs text-blue-500 ml-2 hover:underline">
                                        <i data-lucide="external-link" class="w-3 h-3 inline"></i> Maps
                                    </a>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $mosque->organizer->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ Str::limit($mosque->address, 50) }}</td>
                            <td class="px-6 py-4 text-right space-x-2">
                                @php
                                    $mosqueData = [
                                        'name' => $mosque->name,
                                        'organizer' => $mosque->organizer->name ?? '-',
                                        'photo' => $mosque->photo ? Storage::url($mosque->photo) : null,
                                        'address' => $mosque->address,
                                        'created_at' => $mosque->created_at ? $mosque->created_at->format('d M Y') : '-',
                                        'edit_url' => route('admin.mosque.edit', $mosque->id)
                                    ];
                                @endphp
                                <button type="button" @click="detailModalOpen = true; selectedMosque = {{ json_encode($mosqueData) }}" class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-sm font-medium rounded-md text-brand-ink bg-white hover:bg-gray-50 transition" title="Detail">
                                    <i data-lucide="eye" class="w-4 h-4 sm:mr-1.5"></i> <span class="hidden sm:inline">Detail</span>
                                </button>
                                <a href="{{ route('admin.mosque.edit', $mosque->id) }}" class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-sm font-medium rounded-md text-brand-ink bg-white hover:bg-gray-50 transition" title="Edit">
                                    <i data-lucide="edit" class="w-4 h-4 sm:mr-1.5"></i> <span class="hidden sm:inline">Edit</span>
                                </a>
                                <button type="button" @click="deleteModalOpen = true; deleteFormAction = '{{ route('admin.mosque.destroy', $mosque->id) }}'" class="inline-flex items-center px-3 py-1.5 border border-brand-danger text-sm font-medium rounded-md text-white bg-brand-danger hover:bg-red-700 transition" title="Hapus">
                                    <i data-lucide="trash-2" class="w-4 h-4 sm:mr-1.5"></i> <span class="hidden sm:inline">Hapus</span>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-brand-ink-soft">
                                Belum ada data lokasi masjid.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($mosques->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $mosques->links() }}
            </div>
        @endif

        <!-- Delete Modal -->
        <div x-show="deleteModalOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-cloak>
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <!-- Background overlay -->
                <div x-show="deleteModalOpen" 
                     x-transition:enter="ease-out duration-300" 
                     x-transition:enter-start="opacity-0" 
                     x-transition:enter-end="opacity-100" 
                     x-transition:leave="ease-in duration-200" 
                     x-transition:leave-start="opacity-100" 
                     x-transition:leave-end="opacity-0" 
                     class="fixed inset-0 transition-opacity bg-gray-500/75" aria-hidden="true" @click="deleteModalOpen = false"></div>
                
                <!-- Modal panel -->
                <div x-show="deleteModalOpen" 
                     x-transition:enter="ease-out duration-300" 
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave="ease-in duration-200" 
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     class="relative inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" 
                     role="dialog" aria-modal="true">
                    
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <i data-lucide="alert-triangle" class="h-6 w-6 text-brand-danger"></i>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">Hapus Masjid</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">Yakin ingin menghapus masjid ini? Aksi ini tidak dapat dibatalkan.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <form method="POST" :action="deleteFormAction" data-turbo="false">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-brand-danger text-base font-medium text-white hover:bg-red-700 sm:ml-3 sm:w-auto sm:text-sm">Hapus Permanen</button>
                        </form>
                        <button type="button" @click="deleteModalOpen = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Batal</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Detail Modal -->
        <div x-show="detailModalOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-cloak>
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <div x-show="detailModalOpen" 
                     x-transition:enter="ease-out duration-300" 
                     x-transition:enter-start="opacity-0" 
                     x-transition:enter-end="opacity-100" 
                     x-transition:leave="ease-in duration-200" 
                     x-transition:leave-start="opacity-100" 
                     x-transition:leave-end="opacity-0" 
                     class="fixed inset-0 transition-opacity bg-gray-500/75" aria-hidden="true" @click="detailModalOpen = false"></div>
                
                <div x-show="detailModalOpen" 
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
                            <template x-if="selectedMosque?.photo">
                                <img :src="selectedMosque?.photo" :alt="selectedMosque?.name" class="absolute inset-0 w-full h-full object-cover">
                            </template>
                            <template x-if="!selectedMosque?.photo">
                                <div class="absolute inset-0 w-full h-full flex items-center justify-center">
                                    <svg class="w-24 h-24 text-brand-emerald-700 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                                </div>
                            </template>
                        </div>

                        <!-- Kanan: Detail Text -->
                        <div class="relative w-full md:w-3/5 lg:w-2/3 p-6 md:p-8 bg-white flex flex-col">
                            <button type="button" @click="detailModalOpen = false" class="absolute top-4 right-4 text-gray-400 hover:text-red-500 bg-gray-50 hover:bg-red-50 rounded-full p-2 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>

                            <!-- Header Info -->
                            <div class="mb-6 pr-10">
                                <h2 class="text-2xl font-bold text-brand-ink mb-1" x-text="selectedMosque?.name"></h2>
                                <p class="text-sm text-brand-ink-soft">Penyelenggara: <span class="font-medium text-brand-emerald-700" x-text="selectedMosque?.organizer"></span></p>
                            </div>

                            <h3 class="text-lg font-bold text-brand-ink mb-3 border-b border-gray-100 pb-2">Alamat Lengkap</h3>
                            
                            <div class="prose prose-sm max-w-none text-brand-ink-soft overflow-y-auto max-h-48 mb-6" style="white-space: pre-line;">
                                <template x-if="selectedMosque?.address">
                                    <span x-text="selectedMosque.address"></span>
                                </template>
                                <template x-if="!selectedMosque?.address">
                                    <p class="italic text-gray-400">Belum ada alamat untuk masjid ini.</p>
                                </template>
                            </div>

                            <!-- Footer Section -->
                            <div class="mt-auto pt-6 border-t border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <p class="text-xs text-gray-500">Ditambahkan pada: <span x-text="selectedMosque?.created_at"></span></p>
                                
                                <div class="w-full sm:w-auto flex justify-end">
                                    <a :href="selectedMosque?.edit_url" class="inline-flex justify-center items-center px-4 py-2 border border-brand-emerald-900 text-sm font-medium rounded-lg text-brand-emerald-900 bg-white hover:bg-brand-emerald-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-emerald-900 transition shadow-sm w-full sm:w-auto">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        Edit Masjid
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
