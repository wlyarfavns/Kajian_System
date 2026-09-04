<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('admin.mosque.index') }}" class="mr-4 text-gray-400 hover:text-gray-600">
                <i data-lucide="arrow-left" class="w-6 h-6"></i>
            </a>
            Edit Lokasi Masjid
        </div>
    </x-slot>

    <div class="bg-white border border-gray-200 rounded-xl shadow-sm max-w-3xl mx-auto">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-bold text-brand-ink">Form Edit Lokasi</h2>
            <p class="text-sm text-brand-ink-soft">Perbarui informasi masjid Anda.</p>
        </div>

        <form action="{{ route('admin.mosque.update', $mosque->id) }}" method="POST" data-turbo="false" class="p-6 space-y-6">
            @csrf
            @method('PUT')
            
            <div>
                <label for="organizer_id" class="block text-sm font-medium text-brand-ink">Penyelenggara Pemilik Masjid</label>
                <select name="organizer_id" id="organizer_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-emerald-900 focus:ring-brand-emerald-900 sm:text-sm">
                    <option value="">Pilih Penyelenggara...</option>
                    @foreach($organizers as $org)
                        <option value="{{ $org->id }}" {{ old('organizer_id', $mosque->organizer_id) == $org->id ? 'selected' : '' }}>{{ $org->name }}</option>
                    @endforeach
                </select>
                @error('organizer_id') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="name" class="block text-sm font-medium text-brand-ink">Nama Masjid</label>
                <input type="text" name="name" id="name" value="{{ old('name', $mosque->name) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-emerald-900 focus:ring-brand-emerald-900 sm:text-sm">
                @error('name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="address" class="block text-sm font-medium text-brand-ink">Alamat Lengkap</label>
                <textarea name="address" id="address" rows="3" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-emerald-900 focus:ring-brand-emerald-900 sm:text-sm">{{ old('address', $mosque->address) }}</textarea>
                @error('address') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="latitude" class="block text-sm font-medium text-brand-ink">Latitude</label>
                    <input type="text" name="latitude" id="latitude" value="{{ old('latitude', $mosque->latitude) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-emerald-900 focus:ring-brand-emerald-900 sm:text-sm">
                    @error('latitude') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label for="longitude" class="block text-sm font-medium text-brand-ink">Longitude</label>
                    <input type="text" name="longitude" id="longitude" value="{{ old('longitude', $mosque->longitude) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-emerald-900 focus:ring-brand-emerald-900 sm:text-sm">
                    @error('longitude') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>
            </div>

            <div>
                <label for="google_maps_url" class="block text-sm font-medium text-brand-ink">Link Google Maps (Opsional)</label>
                <input type="url" name="google_maps_url" id="google_maps_url" value="{{ old('google_maps_url', $mosque->google_maps_url) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-emerald-900 focus:ring-brand-emerald-900 sm:text-sm">
                @error('google_maps_url') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="pt-5 border-t border-gray-200 flex justify-end">
                <a href="{{ route('admin.mosque.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 mr-3">Batal</a>
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-brand-emerald-900 hover:bg-brand-emerald-950 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-emerald-900">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
