<x-organizer-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('organizer.kajian.index') }}" class="mr-4 text-gray-400 hover:text-gray-600">
                <i data-lucide="arrow-left" class="w-6 h-6"></i>
            </a>
            Tambah Kajian Baru
        </div>
    </x-slot>

    <div class="bg-white border border-gray-200 rounded-xl shadow-sm">
        <form action="{{ route('organizer.kajian.store') }}" method="POST" enctype="multipart/form-data" data-turbo="false" class="p-6 sm:p-8">
            @csrf

            <!-- Section 1: Informasi Dasar -->
            <div class="mb-8 border-b border-gray-200 pb-8">
                <h3 class="text-lg font-semibold text-brand-ink mb-4 flex items-center">
                    <i data-lucide="info" class="w-5 h-5 mr-2 text-brand-emerald-900"></i> Informasi Dasar
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="title" class="block text-sm font-medium text-brand-ink mb-1">Judul Kajian <span class="text-brand-danger">*</span></label>
                        <input type="text" name="title" id="title" class="w-full rounded-md border-gray-300 shadow-sm focus:border-brand-emerald-900 focus:ring focus:ring-brand-emerald-900 focus:ring-opacity-50" required placeholder="Contoh: Fiqih Muamalah Kontemporer" value="{{ old('title') }}">
                        @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="poster" class="block text-sm font-medium text-brand-ink mb-1">Poster Kajian</label>
                        <input type="file" name="poster" id="poster" accept="image/*" class="w-full rounded-md border-gray-300 shadow-sm focus:border-brand-emerald-900 focus:ring focus:ring-brand-emerald-900 focus:ring-opacity-50">
                        <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, WEBP. Maks 5MB.</p>
                        @error('poster') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="category_id" class="block text-sm font-medium text-brand-ink mb-1">Kategori <span class="text-brand-danger">*</span></label>
                        <select name="category_id" id="category_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-brand-emerald-900 focus:ring focus:ring-brand-emerald-900 focus:ring-opacity-50" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="speaker_id" class="block text-sm font-medium text-brand-ink mb-1">Pemateri <span class="text-brand-danger">*</span></label>
                        <select name="speaker_id" id="speaker_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-brand-emerald-900 focus:ring focus:ring-brand-emerald-900 focus:ring-opacity-50" required>
                            <option value="">-- Pilih Pemateri --</option>
                            @foreach($speakers as $speaker)
                                <option value="{{ $speaker->id }}" {{ old('speaker_id') == $speaker->id ? 'selected' : '' }}>{{ $speaker->name }}</option>
                            @endforeach
                        </select>
                        @error('speaker_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-brand-ink mb-1">Deskripsi / Detail Kajian</label>
                        <textarea name="description" id="description" rows="4" class="w-full rounded-md border-gray-300 shadow-sm focus:border-brand-emerald-900 focus:ring focus:ring-brand-emerald-900 focus:ring-opacity-50" placeholder="Jelaskan secara singkat materi yang akan dibahas...">{{ old('description') }}</textarea>
                        @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Section 2: Waktu & Lokasi -->
            <div class="mb-8 border-b border-gray-200 pb-8">
                <h3 class="text-lg font-semibold text-brand-ink mb-4 flex items-center">
                    <i data-lucide="map-pin" class="w-5 h-5 mr-2 text-brand-emerald-900"></i> Waktu & Lokasi
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="tanggal" class="block text-sm font-medium text-brand-ink mb-1">Tanggal <span class="text-brand-danger">*</span></label>
                            <input type="date" name="tanggal" id="tanggal" class="w-full rounded-md border-gray-300 shadow-sm focus:border-brand-emerald-900 focus:ring focus:ring-brand-emerald-900 focus:ring-opacity-50" required value="{{ old('tanggal') }}">
                            @error('tanggal') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="start_time" class="block text-sm font-medium text-brand-ink mb-1">Jam Mulai <span class="text-brand-danger">*</span></label>
                            <input type="time" name="start_time" id="start_time" class="w-full rounded-md border-gray-300 shadow-sm focus:border-brand-emerald-900 focus:ring focus:ring-brand-emerald-900 focus:ring-opacity-50" required value="{{ old('start_time') }}">
                            @error('start_time') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="end_time" class="block text-sm font-medium text-brand-ink mb-1">Jam Selesai <span class="text-brand-danger">*</span></label>
                            <input type="time" name="end_time" id="end_time" class="w-full rounded-md border-gray-300 shadow-sm focus:border-brand-emerald-900 focus:ring focus:ring-brand-emerald-900 focus:ring-opacity-50" required value="{{ old('end_time') }}">
                            @error('end_time') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label for="mosque_id" class="block text-sm font-medium text-brand-ink mb-1">Masjid <span class="text-brand-danger">*</span></label>
                        <select name="mosque_id" id="mosque_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-brand-emerald-900 focus:ring focus:ring-brand-emerald-900 focus:ring-opacity-50" required>
                            <option value="">-- Pilih Masjid --</option>
                            @foreach($mosques as $mosque)
                                <option value="{{ $mosque->id }}" {{ old('mosque_id') == $mosque->id ? 'selected' : '' }}>{{ $mosque->name }}</option>
                            @endforeach
                        </select>
                        @error('mosque_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="address" class="block text-sm font-medium text-brand-ink mb-1">Alamat Lengkap / Catatan Rute <span class="text-brand-danger">*</span></label>
                        <textarea name="address" id="address" rows="2" class="w-full rounded-md border-gray-300 shadow-sm focus:border-brand-emerald-900 focus:ring focus:ring-brand-emerald-900 focus:ring-opacity-50" required placeholder="Alamat lengkap menuju lokasi...">{{ old('address') }}</textarea>
                        @error('address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Latitude & Longitude -->
                    <div>
                        <label for="latitude" class="block text-sm font-medium text-brand-ink mb-1">Latitude</label>
                        <input type="text" name="latitude" id="latitude" class="w-full rounded-md border-gray-300 shadow-sm focus:border-brand-emerald-900 focus:ring focus:ring-brand-emerald-900 focus:ring-opacity-50" value="{{ old('latitude', '-6.200000') }}" required>
                        @error('latitude') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="longitude" class="block text-sm font-medium text-brand-ink mb-1">Longitude</label>
                        <input type="text" name="longitude" id="longitude" class="w-full rounded-md border-gray-300 shadow-sm focus:border-brand-emerald-900 focus:ring focus:ring-brand-emerald-900 focus:ring-opacity-50" value="{{ old('longitude', '106.816666') }}" required>
                        @error('longitude') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Section 3: Detail Audien & Lainnya -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-brand-ink mb-4 flex items-center">
                    <i data-lucide="users" class="w-5 h-5 mr-2 text-brand-emerald-900"></i> Audien & Tiket
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="audience" class="block text-sm font-medium text-brand-ink mb-1">Tipe Peserta <span class="text-brand-danger">*</span></label>
                        <select name="audience" id="audience" class="w-full rounded-md border-gray-300 shadow-sm focus:border-brand-emerald-900 focus:ring focus:ring-brand-emerald-900 focus:ring-opacity-50" required>
                            <option value="umum" {{ old('audience') == 'umum' ? 'selected' : '' }}>Umum (Ikhwan & Akhwat)</option>
                            <option value="ikhwan" {{ old('audience') == 'ikhwan' ? 'selected' : '' }}>Khusus Ikhwan</option>
                            <option value="akhwat" {{ old('audience') == 'akhwat' ? 'selected' : '' }}>Khusus Akhwat</option>
                        </select>
                        @error('audience') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="quota" class="block text-sm font-medium text-brand-ink mb-1">Kuota</label>
                        <input type="number" name="quota" id="quota" min="1" class="w-full rounded-md border-gray-300 shadow-sm focus:border-brand-emerald-900 focus:ring focus:ring-brand-emerald-900 focus:ring-opacity-50" placeholder="Kosongkan jika tidak terbatas" value="{{ old('quota') }}">
                        @error('quota') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="flex flex-col space-y-4">
                        <label class="inline-flex items-center mt-6">
                            <input type="checkbox" name="is_family_friendly" value="1" class="rounded border-gray-300 text-brand-emerald-900 shadow-sm focus:border-brand-emerald-900 focus:ring focus:ring-brand-emerald-900 focus:ring-opacity-50" {{ old('is_family_friendly') ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-brand-ink">Ramah Keluarga: Ya</span>
                        </label>
                    </div>

                    <div>
                        <label for="is_free" class="block text-sm font-medium text-brand-ink mb-1">Biaya <span class="text-brand-danger">*</span></label>
                        <select name="is_free" id="is_free" class="w-full rounded-md border-gray-300 shadow-sm focus:border-brand-emerald-900 focus:ring focus:ring-brand-emerald-900 focus:ring-opacity-50" required>
                            <option value="1" {{ old('is_free', true) == true ? 'selected' : '' }}>Gratis</option>
                            <option value="0" {{ old('is_free', true) == false ? 'selected' : '' }}>Berbayar</option>
                        </select>
                    </div>

                    <div id="price_container" style="display: none;">
                        <label for="price" class="block text-sm font-medium text-brand-ink mb-1">Harga</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <span class="text-gray-500 sm:text-sm">Rp</span>
                            </div>
                            <input type="number" name="price" id="price" class="block w-full rounded-md border-gray-300 pl-10 focus:border-brand-emerald-900 focus:ring focus:ring-brand-emerald-900 focus:ring-opacity-50" placeholder="0" value="{{ old('price') }}">
                        </div>
                        @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Fasilitas -->
                    <div class="md:col-span-3 mt-4 pt-4 border-t border-gray-100">
                        <label class="block text-sm font-medium text-brand-ink mb-3">Fasilitas <span class="text-gray-400 text-xs font-normal">(Opsional)</span></label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                            @php
                                $facilityOptions = ['Area Parkir', 'Tempat Wudhu', 'Toilet Bersih', 'Ruang Full AC', 'Bazar/Camilan', 'Area Bermain Anak'];
                            @endphp
                            @foreach($facilityOptions as $facility)
                                <label class="inline-flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                                    <input type="checkbox" name="facilities[]" value="{{ $facility }}" class="rounded border-gray-300 text-brand-emerald-900 shadow-sm focus:border-brand-emerald-900" 
                                    {{ is_array(old('facilities')) && in_array($facility, old('facilities')) ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm text-brand-ink">{{ $facility }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('facilities') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-4 pt-4 border-t border-gray-200 mt-6">
                <a href="{{ route('organizer.kajian.index') }}" class="mt-3 sm:mt-0 px-6 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-brand-ink bg-white hover:bg-gray-50 focus:outline-none text-center">
                    Batal
                </a>
                <button type="submit" name="status" value="draft" class="mt-3 sm:mt-0 px-6 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none text-center">
                    Simpan Draft
                </button>
                <button type="submit" name="status" value="published" class="px-6 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-brand-emerald-900 hover:bg-brand-emerald-950 focus:outline-none text-center">
                    Publikasikan
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const isFreeSelect = document.getElementById('is_free');
            const priceContainer = document.getElementById('price_container');

            function togglePrice() {
                if (isFreeSelect.value === '1') {
                    priceContainer.style.display = 'none';
                } else {
                    priceContainer.style.display = 'block';
                }
            }

            isFreeSelect.addEventListener('change', togglePrice);
            // Run once on load
            togglePrice();
        });
    </script>
</x-organizer-layout>
