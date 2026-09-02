<x-admin-layout>
    <x-slot name="header">
        Kelola Pengguna
    </x-slot>

    <div x-data="{ detailModalOpen: false, selectedUser: null }" class="mb-6">
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm mb-6">
            <div class="p-6 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center">
                <div>
                    <h2 class="text-lg font-bold text-brand-ink">Daftar Pengguna</h2>
                    <p class="text-sm text-brand-ink-soft">Lihat detail akun dan profil pengguna sistem.</p>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-50 text-green-800 p-4 border-b border-green-200 text-sm">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-50 text-red-800 p-4 border-b border-red-200 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="px-6 py-4 text-xs font-semibold text-brand-ink-soft uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-4 text-xs font-semibold text-brand-ink-soft uppercase tracking-wider">Email</th>
                            <th class="px-6 py-4 text-xs font-semibold text-brand-ink-soft uppercase tracking-wider">Peran (Role)</th>
                            <th class="px-6 py-4 text-xs font-semibold text-brand-ink-soft uppercase tracking-wider text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($users as $user)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-medium text-brand-ink">{{ $user->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $user->email }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        @if($user->role === 'admin') bg-purple-100 text-purple-800
                                        @elseif($user->role === 'organizer') bg-brand-emerald-100 text-brand-emerald-950
                                        @else bg-gray-100 text-gray-800 @endif
                                    ">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    @php
                                        $userData = [
                                            'name' => $user->name,
                                            'email' => $user->email,
                                            'role' => ucfirst($user->role),
                                            'avatar' => $user->avatar,
                                            'created_at' => $user->created_at ? $user->created_at->format('d M Y') : '-'
                                        ];
                                    @endphp
                                    <button type="button" @click="detailModalOpen = true; selectedUser = {{ json_encode($userData) }}" class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-sm font-medium rounded-md text-brand-ink bg-white hover:bg-gray-50 transition" title="Lihat Detail Profil">
                                        <i data-lucide="eye" class="w-4 h-4 sm:mr-1.5 text-brand-ink-soft"></i>
                                        <span class="hidden sm:inline">Detail</span>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-brand-ink-soft">Belum ada pengguna.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
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
                                <template x-if="selectedUser?.avatar">
                                    <img :src="selectedUser?.avatar" :alt="selectedUser?.name" class="w-full h-full object-cover">
                                </template>
                                <template x-if="!selectedUser?.avatar">
                                    <svg class="w-16 h-16 text-brand-emerald-700 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </template>
                            </div>
                            <h3 class="text-xl font-bold text-brand-emerald-950 text-center leading-tight mb-2" x-text="selectedUser?.name"></h3>
                            
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-brand-emerald-100 text-brand-emerald-800 shadow-sm" x-text="selectedUser?.role"></span>
                        </div>

                        <!-- Kanan: Info Detail -->
                        <div class="relative w-full md:w-3/5 lg:w-2/3 p-6 md:p-8 bg-white flex flex-col">
                            <button type="button" @click="detailModalOpen = false" class="absolute top-4 right-4 text-gray-400 hover:text-red-500 bg-gray-50 hover:bg-red-50 rounded-full p-2 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>

                            <h3 class="text-lg font-bold text-brand-ink mb-4 border-b border-gray-100 pb-2">Informasi Akun</h3>
                            
                            <div class="space-y-4 text-sm mb-6">
                                <div class="flex items-start">
                                    <div class="w-6 shrink-0 mt-0.5 text-gray-400"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg></div>
                                    <div>
                                        <p class="font-semibold text-gray-700">Email Akun</p>
                                        <p class="text-gray-600" x-text="selectedUser?.email"></p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-auto pt-4 border-t border-gray-100 text-xs text-gray-500 text-right">
                                Akun Didaftarkan Pada: <span x-text="selectedUser?.created_at"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
