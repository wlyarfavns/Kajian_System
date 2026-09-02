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

        <form action="{{ route('admin.mosque.store') }}" method="POST" data-turbo="false" class="p-6 space-y-6">
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

            <div>
                <label for="address" class="block text-sm font-medium text-brand-ink">Alamat Lengkap</label>
                <textarea name="address" id="address" rows="3" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-emerald-900 focus:ring-brand-emerald-900 sm:text-sm"></textarea>
                @error('address') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="latitude" class="block text-sm font-medium text-brand-ink">Latitude</label>
                    <input type="text" name="latitude" id="latitude" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-emerald-900 focus:ring-brand-emerald-900 sm:text-sm" placeholder="-6.2088">
                    @error('latitude') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label for="longitude" class="block text-sm font-medium text-brand-ink">Longitude</label>
                    <input type="text" name="longitude" id="longitude" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-emerald-900 focus:ring-brand-emerald-900 sm:text-sm" placeholder="106.8456">
                    @error('longitude') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-brand-ink mb-2">Pilih Titik Lokasi di Peta</label>
                <div id="map" class="w-full h-[300px] rounded-lg border border-gray-300 z-10 relative"></div>
                <p class="text-xs text-gray-500 mt-1">Anda bisa menggeser pin atau klik pada peta untuk menentukan koordinat.</p>
            </div>

            <div>
                <label for="google_maps_url" class="block text-sm font-medium text-brand-ink">Link Google Maps (Opsional)</label>
                <input type="url" name="google_maps_url" id="google_maps_url" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-emerald-900 focus:ring-brand-emerald-900 sm:text-sm" placeholder="https://maps.google.com/...">
                @error('google_maps_url') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="pt-5 border-t border-gray-200 flex justify-end">
                <a href="{{ route('admin.mosque.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 mr-3">Batal</a>
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-brand-emerald-900 hover:bg-brand-emerald-950 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-emerald-900">
                    Simpan Masjid
                </button>
            </div>
        </form>
    </div>

    @push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    @endpush

    @push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var initialLat = -6.2088;
            var initialLng = 106.8456;
            
            var latInput = document.getElementById('latitude');
            var lngInput = document.getElementById('longitude');

            if (latInput.value && lngInput.value) {
                initialLat = parseFloat(latInput.value);
                initialLng = parseFloat(lngInput.value);
            } else {
                latInput.value = initialLat;
                lngInput.value = initialLng;
            }

            var map = L.map('map').setView([initialLat, initialLng], 13);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap'
            }).addTo(map);

            var marker = L.marker([initialLat, initialLng], {draggable: true}).addTo(map);

            marker.on('dragend', function (e) {
                var position = marker.getLatLng();
                latInput.value = position.lat;
                lngInput.value = position.lng;
            });

            map.on('click', function(e) {
                var position = e.latlng;
                marker.setLatLng(position);
                latInput.value = position.lat;
                lngInput.value = position.lng;
            });

            latInput.addEventListener('change', updateMarker);
            lngInput.addEventListener('change', updateMarker);

            function updateMarker() {
                var newLat = parseFloat(latInput.value);
                var newLng = parseFloat(lngInput.value);
                if(!isNaN(newLat) && !isNaN(newLng)) {
                    var newPos = new L.LatLng(newLat, newLng);
                    marker.setLatLng(newPos);
                    map.panTo(newPos);
                }
            }
            
            setTimeout(function() { map.invalidateSize(); }, 500);
        });
    </script>
    @endpush
</x-admin-layout>
