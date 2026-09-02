<x-admin-layout>
    <x-slot name="header">
        Master Data: Kategori
    </x-slot>

    <div class="bg-white border border-gray-200 rounded-xl shadow-sm">
        
        <div class="p-6 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center">
            <div>
                <h2 class="text-lg font-bold text-brand-ink">Daftar Kategori</h2>
                <p class="text-sm text-brand-ink-soft">Kelola referensi kategori untuk kajian.</p>
            </div>
            <button type="button" onclick="openCreateModal()" class="mt-4 sm:mt-0 inline-flex items-center px-4 py-2 bg-brand-emerald-900 text-white text-sm font-medium rounded-lg hover:bg-brand-emerald-950 transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-emerald-900 shadow-sm">
                <i data-lucide="plus-circle" class="w-4 h-4 mr-2"></i> Tambah Kategori
            </button>
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
        @if($errors->any())
            <div class="bg-red-50 text-red-800 p-4 border-b border-red-200 text-sm">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-6 py-4 text-xs font-semibold text-brand-ink-soft uppercase tracking-wider">Nama Kategori</th>
                        <th class="px-6 py-4 text-xs font-semibold text-brand-ink-soft uppercase tracking-wider">Slug</th>
                        <th class="px-6 py-4 text-xs font-semibold text-brand-ink-soft uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($categories as $category)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-brand-ink">{{ $category->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $category->slug }}</td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <button type="button" onclick="openEditModal('{{ addslashes($category->name) }}', '{{ route('admin.category.update', $category->id) }}')" class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-sm font-medium rounded-md text-brand-ink bg-white hover:bg-gray-50 transition" title="Edit">
                                    <i data-lucide="edit" class="w-4 h-4 sm:mr-1.5"></i>
                                    <span class="hidden sm:inline">Edit</span>
                                </button>
                                <button type="button" onclick="openDeleteModal('{{ route('admin.category.destroy', $category->id) }}')" class="inline-flex items-center px-3 py-1.5 border border-red-200 text-sm font-medium rounded-md text-red-600 bg-red-50 hover:bg-red-100 transition" title="Hapus">
                                    <i data-lucide="trash-2" class="w-4 h-4 sm:mr-1.5"></i>
                                    <span class="hidden sm:inline">Hapus</span>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-brand-ink-soft">
                                Belum ada kategori.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($categories->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 flex justify-center">
                {{ $categories->links() }}
            </div>
        @endif

        <!-- Create/Edit Modal -->
        <div id="createEditModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" onclick="closeModals()"></div>

            <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
                <!-- Modal panel -->
                <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 w-full max-w-md border border-gray-100">
                    
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
                        <h3 class="text-lg font-bold text-brand-ink" id="createEditModalTitle">Tambah Kategori</h3>
                        <button type="button" onclick="closeModals()" class="rounded-full p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 transition">
                            <i data-lucide="x" class="w-5 h-5"></i>
                        </button>
                    </div>

                    <!-- Modal Body & Form -->
                    <form id="createEditForm" action="" method="POST">
                        @csrf
                        <input type="hidden" name="_method" value="PUT" id="putMethodInput" disabled>
                        
                        <div class="px-6 py-5 bg-gray-50/50">
                            <div>
                                <label for="categoryNameInput" class="block text-sm font-bold text-gray-700 mb-2">Nama Kategori <span class="text-red-500">*</span></label>
                                <input type="text" id="categoryNameInput" name="name" required placeholder="Contoh: Fiqih" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-brand-emerald-500 focus:ring-brand-emerald-500 sm:text-sm">
                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="bg-white px-6 py-4 border-t border-gray-100 flex justify-end gap-3">
                            <button type="button" onclick="closeModals()" class="px-4 py-2 bg-white text-gray-700 border border-gray-300 font-bold rounded-lg hover:bg-gray-50 transition text-sm">
                                Batal
                            </button>
                            <button type="submit" class="px-4 py-2 bg-brand-emerald-900 text-white font-bold rounded-lg hover:bg-brand-emerald-950 shadow-sm transition text-sm flex items-center">
                                <i data-lucide="save" class="w-4 h-4 mr-2"></i> <span id="createEditSubmitText">Tambah Kategori</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Modal -->
        <div id="deleteModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" onclick="closeModals()"></div>
            
            <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 w-full max-w-md border border-gray-100">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <i data-lucide="alert-triangle" class="h-6 w-6 text-red-600"></i>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">Hapus Kategori</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">Apakah Anda yakin ingin menghapus kategori ini? Tindakan ini tidak dapat dibatalkan.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-3">
                        <form id="deleteForm" method="POST" action="">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full inline-flex justify-center rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto transition">
                                Ya, Hapus
                            </button>
                        </form>
                        <button type="button" onclick="closeModals()" class="mt-3 w-full inline-flex justify-center rounded-md bg-white px-4 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto transition">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function openCreateModal() {
            document.getElementById('createEditModalTitle').innerText = 'Tambah Kategori';
            document.getElementById('createEditForm').action = '{{ route('admin.category.store') }}';
            document.getElementById('putMethodInput').disabled = true;
            document.getElementById('categoryNameInput').value = '';
            document.getElementById('createEditSubmitText').innerText = 'Tambah Kategori';
            document.getElementById('createEditModal').style.display = 'block';
        }

        function openEditModal(name, updateUrl) {
            document.getElementById('createEditModalTitle').innerText = 'Edit Kategori';
            document.getElementById('createEditForm').action = updateUrl;
            document.getElementById('putMethodInput').disabled = false;
            document.getElementById('categoryNameInput').value = name;
            document.getElementById('createEditSubmitText').innerText = 'Simpan Perubahan';
            document.getElementById('createEditModal').style.display = 'block';
        }

        function openDeleteModal(deleteUrl) {
            document.getElementById('deleteForm').action = deleteUrl;
            document.getElementById('deleteModal').style.display = 'block';
        }

        function closeModals() {
            document.getElementById('createEditModal').style.display = 'none';
            document.getElementById('deleteModal').style.display = 'none';
        }
    </script>
</x-admin-layout>
