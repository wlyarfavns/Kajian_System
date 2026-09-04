<x-admin-layout>
    <x-slot name="header">
        Kelola Lokasi Masjid
    </x-slot>

    <div x-data="{ deleteModalOpen: false, deleteFormAction: '' }" class="bg-white border border-gray-200 rounded-xl shadow-sm">
        <div class="p-6 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center">
            <div>
                <h2 class="text-lg font-bold text-brand-ink">Daftar Lokasi Masjid</h2>
                <p class="text-sm text-brand-ink-soft">Kelola data lokasi masjid tempat Anda menyelenggarakan kajian.</p>
            </div>
            <div class="mt-4 sm:mt-0 flex flex-col sm:flex-row gap-3">
                <form method="GET" action="{{ route('admin.mosque.index') }}" class="flex w-full sm:w-auto" data-turbo-frame="data-table" x-data>
                    <div class="relative w-full sm:w-64">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i data-lucide="search" class="h-4 w-4 text-gray-400"></i>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" @input.debounce.500ms="$el.form.requestSubmit()" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:border-brand-emerald-500 focus:ring-1 focus:ring-brand-emerald-500 sm:text-sm transition duration-150 ease-in-out" placeholder="Cari masjid atau lokasi...">
                    </div>
                </form>
                <a href="{{ route('admin.mosque.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-brand-emerald-900 text-white text-sm font-medium rounded-lg hover:bg-brand-emerald-950 transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-emerald-900 shadow-sm">
                    <i data-lucide="plus-circle" class="w-4 h-4 mr-2 shrink-0"></i> Tambah Masjid
                </a>
            </div>
        </div>

        <turbo-frame id="data-table">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-6 py-4 text-xs font-semibold text-brand-ink-soft uppercase tracking-wider whitespace-nowrap w-16">No</th>
                        <th class="px-6 py-4 text-xs font-semibold text-brand-ink-soft uppercase tracking-wider whitespace-nowrap">Nama Masjid</th>
                        <th class="px-6 py-4 text-xs font-semibold text-brand-ink-soft uppercase tracking-wider whitespace-nowrap">Penyelenggara</th>
                        <th class="px-6 py-4 text-xs font-semibold text-brand-ink-soft uppercase tracking-wider whitespace-nowrap">Alamat</th>
                        <th class="px-6 py-4 text-xs font-semibold text-brand-ink-soft uppercase tracking-wider text-center whitespace-nowrap">Link Maps</th>
                        <th class="px-6 py-4 text-xs font-semibold text-brand-ink-soft uppercase tracking-wider text-right whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($mosques as $mosque)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm text-brand-ink font-medium whitespace-nowrap">
                                {{ $mosques->firstItem() + $loop->index }}
                            </td>
                            <td class="px-6 py-4 font-medium text-brand-ink whitespace-nowrap">
                                {{ $mosque->name }}
                            </td>
                            <td class="px-6 py-4 text-sm text-brand-ink whitespace-nowrap">{{ $mosque->organizer->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{ Str::limit($mosque->address, 50) }}</td>
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                @if($mosque->google_maps_url)
                                    <a href="{{ $mosque->google_maps_url }}" target="_blank" class="inline-flex items-center justify-center text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors font-medium text-xs">
                                        <i data-lucide="map-pin" class="w-3 h-3 mr-1"></i> Maps
                                    </a>
                                @else
                                    <span class="text-xs text-gray-400 italic">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap space-x-2">
                                <a href="{{ route('admin.mosque.edit', $mosque->id) }}" class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-sm font-medium rounded-md text-brand-ink bg-white hover:bg-gray-50 transition" title="Edit" data-turbo-frame="_top">
                                    <i data-lucide="edit" class="w-4 h-4 sm:mr-1.5"></i> <span class="hidden sm:inline">Edit</span>
                                </a>
                                <button type="button" @click="deleteModalOpen = true; deleteFormAction = '{{ route('admin.mosque.destroy', $mosque->id) }}'" class="inline-flex items-center px-3 py-1.5 border border-brand-danger text-sm font-medium rounded-md text-white bg-brand-danger hover:bg-red-700 transition shadow-sm" title="Hapus">
                                    <i data-lucide="trash-2" class="w-4 h-4 sm:mr-1.5"></i> <span class="hidden sm:inline">Hapus</span>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-brand-ink-soft">
                                Belum ada lokasi masjid yang ditambahkan.
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

        <!-- Delete Modal -->
        <div x-show="deleteModalOpen" class="relative z-50" style="display: none;" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div x-show="deleteModalOpen" class="fixed inset-0 bg-transparent" @click="deleteModalOpen = false"></div>
            
            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div x-show="deleteModalOpen" 
                         x-transition:enter="ease-out duration-300" 
                         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                         x-transition:leave="ease-in duration-200" 
                         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                         class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
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
        </div>
    </div>
</x-admin-layout>

