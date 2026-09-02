<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('admin.mosque.index') }}" class="mr-4 text-gray-400 hover:text-gray-600">
                <i data-lucide="arrow-left" class="w-6 h-6"></i>
            </a>
            Tambah Lokasi Masjid
        </div>
    </x-slot>

    <div class="bg-white border border-gray-200 rounded-xl shadow-sm max-w-3xl mx-auto">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-bold text-brand-ink">Form Lokasi Baru</h2>
            <p class="text-sm text-brand-ink-soft">Tambahkan masjid baru untuk tempat kajian Anda.</p>
        </div>

        <form action="{{ route('admin.mosque.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6" x-data="{
            imageUrl: null,
            errorMsg: '',
            fileChosen(event) {
                if (! event.target.files.length) return;
                let file = event.target.files[0];
                if (file.size > 2 * 1024 * 1024) {
                    this.errorMsg = 'Ukuran foto maksimal adalah 2MB.';
                    this.imageUrl = null;
                    event.target.value = '';
                    return;
                }
                this.errorMsg = '';
                let reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = e => this.imageUrl = e.target.result;
            }
        }">
            @csrf
            
            <div>
                <label for="organizer_id" class="block text-sm font-medium text-brand-ink">Penyelenggara Pemilik Masjid</label>
                <select name="organizer_id" id="organizer_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-emerald-900 focus:ring-brand-emerald-900 sm:text-sm">
                    <option value="">Pilih Penyelenggara...</option>
                    @foreach($organizers as $org)
                        <option value="{{ $org->id }}" {{ old('organizer_id') == $org->id ? 'selected' : '' }}>{{ $org->name }}</option>
                    @endforeach
                </select>
                @error('organizer_id') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="name" class="block text-sm font-medium text-brand-ink">Nama Masjid</label>
                <input type="text" name="name" id="name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-emerald-900 focus:ring-brand-emerald-900 sm:text-sm" placeholder="Contoh: Masjid Istiqlal">
                @error('name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>

            <!-- Foto Masjid -->
            <div>
                <label class="block text-sm font-medium text-brand-ink mb-2">Foto Masjid</label>
                <div class="flex items-center space-x-6">
                    <div class="flex-shrink-0 w-32 h-24 rounded-lg bg-brand-cream border border-brand-border-light flex items-center justify-center overflow-hidden">
                        <img x-show="imageUrl" :src="imageUrl" class="w-full h-full object-cover" alt="Preview" style="display: none;" />
                        <i x-show="!imageUrl" data-lucide="image" class="w-8 h-8 text-brand-nav-inactive"></i>
                    </div>
                    <div>
                        <input type="file" name="photo" id="photo" accept="image/*" class="sr-only" @change="fileChosen">
                        <label for="photo" class="cursor-pointer inline-flex items-center px-4 py-2 border border-brand-border-light rounded-md shadow-sm text-sm font-medium text-brand-ink bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-emerald-900 transition">
                            <i data-lucide="upload" class="w-4 h-4 mr-2"></i> Pilih Foto
                        </label>
                        <p class="mt-2 text-xs text-brand-ink-soft">JPG, PNG atau GIF (Maks. 2MB)</p>
                        <template x-if="errorMsg">
                            <p class="mt-1 text-sm text-brand-danger" x-text="errorMsg"></p>
                        </template>
                        @error('photo')
                            <p class="mt-1 text-sm text-brand-danger" x-show="!errorMsg">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Alamat Lengkap -->
            <div>
                <label for="address" class="block text-sm font-medium text-brand-ink mb-1">Alamat Lengkap</label>
                <textarea name="address" id="address" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-emerald-900 focus:ring-brand-emerald-900 sm:text-sm" placeholder="Tuliskan alamat lengkap masjid...">{{ old('address') }}</textarea>
                @error('address')
                    <span class="text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <!-- Koordinat Lokasi -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="latitude" class="block text-sm font-medium text-brand-ink">Latitude</label>
                    <input type="text" name="latitude" id="latitude" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-emerald-900 focus:ring-brand-emerald-900 sm:text-sm" placeholder="-6.200000" value="{{ old('latitude') }}">
                    @error('latitude') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label for="longitude" class="block text-sm font-medium text-brand-ink">Longitude</label>
                    <input type="text" name="longitude" id="longitude" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-emerald-900 focus:ring-brand-emerald-900 sm:text-sm" placeholder="106.816666" value="{{ old('longitude') }}">
                    @error('longitude') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Link Google Maps -->
            <div>
                <label for="google_maps_url" class="block text-sm font-medium text-brand-ink mb-1">Link Google Maps (Opsional)</label>
                <input type="url" name="google_maps_url" id="google_maps_url" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-emerald-900 focus:ring-brand-emerald-900 sm:text-sm" placeholder="https://maps.app.goo.gl/..." value="{{ old('google_maps_url') }}">
                @error('google_maps_url')
                    <span class="text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="pt-5 border-t border-gray-200 flex justify-end">
                <a href="{{ route('admin.mosque.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 mr-3">Batal</a>
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-brand-emerald-900 hover:bg-brand-emerald-950 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-emerald-900">
                    Simpan Masjid
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
