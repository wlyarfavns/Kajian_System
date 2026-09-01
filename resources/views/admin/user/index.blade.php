<x-admin-layout>
    <x-slot name="header">
        Kelola Pengguna
    </x-slot>

    <div x-data="{
        deleteModalOpen: false,
        activeUser: null,
        
        openDeleteModal(user) {
            this.activeUser = user;
            this.deleteModalOpen = true;
        },
        closeModal() {
            this.deleteModalOpen = false;
            setTimeout(() => { this.activeUser = null; }, 300);
        }
    }">
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm mb-6">
            <div class="p-6 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center">
                <div>
                    <h2 class="text-lg font-bold text-brand-ink">Daftar Pengguna</h2>
                    <p class="text-sm text-brand-ink-soft">Kelola akun dan profil pengguna sistem.</p>
                </div>
                <a href="{{ route('admin.user.create') }}" data-turbo="false" class="mt-4 sm:mt-0 inline-flex items-center px-4 py-2 bg-brand-emerald-900 text-white text-sm font-medium rounded-lg hover:bg-brand-emerald-950 transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-emerald-900">
                    <i data-lucide="plus-circle" class="w-4 h-4 mr-2"></i> Tambah Pengguna
                </a>
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
                                    <a href="{{ route('admin.user.edit', $user->id) }}" data-turbo="false" class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-sm font-medium rounded-md text-brand-ink bg-white hover:bg-gray-50 transition" title="Edit Akun">
                                        <i data-lucide="edit-2" class="w-4 h-4 sm:mr-1.5"></i> <span class="hidden sm:inline">Edit</span>
                                    </a>
                                    <button type="button" @click="openDeleteModal({{ json_encode([
                                        'id' => $user->id,
                                        'name' => $user->name,
                                        'delete_url' => route('admin.user.destroy', $user->id)
                                    ]) }})" class="inline-flex items-center px-3 py-1.5 border border-red-200 text-sm font-medium rounded-md text-red-600 bg-red-50 hover:bg-red-100 transition" title="Hapus Akun">
                                        <i data-lucide="trash-2" class="w-4 h-4 sm:mr-1.5"></i> <span class="hidden sm:inline">Hapus</span>
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

        <!-- Delete Confirmation Modal -->
        <div x-show="deleteModalOpen" class="relative z-50" style="display: none;" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <!-- Transparent Background overlay -->
            <div x-show="deleteModalOpen" class="fixed inset-0 bg-transparent" @click="closeModal()"></div>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <!-- Modal panel -->
                    <div x-show="deleteModalOpen" 
                         x-transition:enter="ease-out duration-300" 
                         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                         x-transition:leave="ease-in duration-200" 
                         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                         class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 w-full max-w-md border border-gray-100">
                        
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <i data-lucide="alert-triangle" class="h-6 w-6 text-red-600"></i>
                                </div>
                                <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                    <h3 class="text-lg font-bold leading-6 text-gray-900" id="modal-title">Hapus Akun Pengguna</h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500">
                                            Apakah Anda yakin ingin menghapus akun <span class="font-bold text-gray-700" x-text="activeUser ? activeUser.name : ''"></span> secara permanen? Semua data terkait mungkin akan ikut terhapus atau dibatalkan.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <template x-if="activeUser">
                            <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                <form :action="activeUser.delete_url" method="POST" data-turbo="false">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto transition">
                                        Ya, Hapus Akun
                                    </button>
                                </form>
                                <button type="button" @click="closeModal()" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto transition">
                                    Batal
                                </button>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
