<x-admin-layout>
    <x-slot name="header">
        Moderasi Penyelenggara
    </x-slot>

    <div x-data="{ detailModalOpen: false, selectedOrganizer: null }" class="bg-white border border-gray-200 rounded-xl shadow-sm mb-6">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-bold text-brand-ink">Daftar Akun Penyelenggara</h2>
            <p class="text-sm text-brand-ink-soft">Kelola status verifikasi akun organizer agar mereka bisa membuat kajian publik.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-6 py-4 text-xs font-semibold text-brand-ink-soft uppercase tracking-wider">Nama Organizer</th>
                        <th class="px-6 py-4 text-xs font-semibold text-brand-ink-soft uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-semibold text-brand-ink-soft uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($organizers as $organizer)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-brand-ink">{{ $organizer->name }}</td>
                            <td class="px-6 py-4">
                                @if($organizer->is_verified)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-brand-emerald-100 text-brand-emerald-950">Terverifikasi</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">Belum Diverifikasi</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                @php
                                    $orgData = [
                                        'name' => $organizer->name,
                                        'email' => $organizer->user->email ?? '-',
                                        'phone' => $organizer->phone ?? '-',
                                        'address' => $organizer->address ?? '-',
                                        'description' => $organizer->description,
                                        'logo' => $organizer->logo ? Storage::url($organizer->logo) : null,
                                        'is_verified' => $organizer->is_verified,
                                        'created_at' => $organizer->created_at ? $organizer->created_at->format('d M Y') : '-'
                                    ];
                                @endphp
                                <button type="button" @click="detailModalOpen = true; selectedOrganizer = {{ json_encode($orgData) }}" class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-sm font-medium rounded-md text-brand-ink bg-white hover:bg-gray-50 transition" title="Lihat Detail Profil">
                                    <i data-lucide="eye" class="w-4 h-4 sm:mr-1.5 text-brand-ink-soft"></i>
                                    <span class="hidden sm:inline">Detail</span>
                                </button>
                                
                                <form action="{{ route('admin.organizer.verify', $organizer->id) }}" method="POST" class="inline">
                                    @csrf
                                    @if($organizer->is_verified)
                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-red-200 text-sm font-medium rounded-md text-red-700 bg-red-50 hover:bg-red-100 transition" title="Cabut Verifikasi">
                                            <i data-lucide="shield-x" class="w-4 h-4 sm:mr-1.5 text-red-600"></i>
                                            <span class="hidden sm:inline">Cabut Verifikasi</span>
                                        </button>
                                    @else
                                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-brand-emerald-900 hover:bg-brand-emerald-950 transition shadow-sm">
                                            <i data-lucide="shield-check" class="w-4 h-4 mr-2"></i> Verifikasi
                                        </button>
                                    @endif
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-brand-ink-soft">Belum ada penyelenggara.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($organizers->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $organizers->links() }}
            </div>
        @endif

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
                     class="fixed inset-0 transition-opacity bg-gray-900/50 backdrop-blur-sm" aria-hidden="true" @click="detailModalOpen = false"></div>
                
                <div x-show="detailModalOpen" 
                     x-transition:enter="ease-out duration-300" 
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave="ease-in duration-200" 
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     class="relative inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-2xl shadow-xl sm:my-8 sm:align-middle w-full max-w-3xl" 
                     role="dialog" aria-modal="true">
                    
                    <div class="flex flex-col md:flex-row w-full bg-white">
                        <!-- Kiri: Logo -->
                        <div class="w-full md:w-2/5 lg:w-1/3 p-6 md:p-8 bg-brand-emerald-50 flex flex-col items-center justify-center border-b md:border-b-0 md:border-r border-gray-100">
                            <div class="w-32 h-32 md:w-40 md:h-40 rounded-full overflow-hidden bg-white shadow-sm border-4 border-white mb-4 flex items-center justify-center">
                                <template x-if="selectedOrganizer?.logo">
                                    <img :src="selectedOrganizer?.logo" :alt="selectedOrganizer?.name" class="w-full h-full object-cover">
                                </template>
                                <template x-if="!selectedOrganizer?.logo">
                                    <svg class="w-16 h-16 text-brand-emerald-700 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                </template>
                            </div>
                            <h3 class="text-xl font-bold text-brand-emerald-950 text-center leading-tight mb-2" x-text="selectedOrganizer?.name"></h3>
                            
                            <template x-if="selectedOrganizer?.is_verified">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-brand-emerald-100 text-brand-emerald-800 shadow-sm">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Terverifikasi
                                </span>
                            </template>
                            <template x-if="!selectedOrganizer?.is_verified">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 shadow-sm">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Menunggu Review
                                </span>
                            </template>
                        </div>

                        <!-- Kanan: Info Detail -->
                        <div class="relative w-full md:w-3/5 lg:w-2/3 p-6 md:p-8 bg-white flex flex-col">
                            <button type="button" @click="detailModalOpen = false" class="absolute top-4 right-4 text-gray-400 hover:text-red-500 bg-gray-50 hover:bg-red-50 rounded-full p-2 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>

                            <h3 class="text-lg font-bold text-brand-ink mb-4 border-b border-gray-100 pb-2">Informasi Kontak & Detail</h3>
                            
                            <div class="space-y-4 text-sm mb-6">
                                <div class="flex items-start">
                                    <div class="w-6 shrink-0 mt-0.5 text-gray-400"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg></div>
                                    <div>
                                        <p class="font-semibold text-gray-700">Email Akun</p>
                                        <p class="text-gray-600" x-text="selectedOrganizer?.email"></p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <div class="w-6 shrink-0 mt-0.5 text-gray-400"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg></div>
                                    <div>
                                        <p class="font-semibold text-gray-700">Nomor Telepon</p>
                                        <p class="text-gray-600" x-text="selectedOrganizer?.phone"></p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <div class="w-6 shrink-0 mt-0.5 text-gray-400"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg></div>
                                    <div>
                                        <p class="font-semibold text-gray-700">Alamat</p>
                                        <p class="text-gray-600 whitespace-pre-line" x-text="selectedOrganizer?.address"></p>
                                    </div>
                                </div>
                            </div>

                            <h3 class="text-sm font-bold text-brand-ink mb-2">Deskripsi Lembaga</h3>
                            <div class="prose prose-sm max-w-none text-gray-600 overflow-y-auto max-h-32 p-3 bg-gray-50 rounded-lg border border-gray-100" style="white-space: pre-line;">
                                <template x-if="selectedOrganizer?.description">
                                    <span x-text="selectedOrganizer.description"></span>
                                </template>
                                <template x-if="!selectedOrganizer?.description">
                                    <p class="italic text-gray-400">Penyelenggara belum melengkapi profil/deskripsi.</p>
                                </template>
                            </div>

                            <div class="mt-6 pt-4 border-t border-gray-100 text-xs text-gray-500 text-right">
                                Akun Didaftarkan Pada: <span x-text="selectedOrganizer?.created_at"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
