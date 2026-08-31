<x-organizer-layout>
    <x-slot name="header">
        Profil Penyelenggara
    </x-slot>

    <div class="bg-white border border-gray-200 rounded-xl shadow-sm max-w-4xl mx-auto">
        <div class="p-6 border-b border-gray-200 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-bold text-brand-ink">Informasi Profil</h2>
                <p class="text-sm text-brand-ink-soft">Perbarui detail profil penyelenggara Anda yang akan dilihat oleh jamaah.</p>
            </div>
        </div>

        <form action="{{ route('organizer.profile.update') }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8" x-data="photoPreview('{{ $organizer->logo ? \Illuminate\Support\Facades\Storage::url($organizer->logo) : '' }}')">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Logo -->
                <div>
                    <label class="block text-sm font-medium text-brand-ink mb-2">Logo Komunitas / Masjid</label>
                    <div class="flex items-center space-x-6">
                        <div class="flex-shrink-0 w-24 h-24 rounded-full bg-brand-cream border border-brand-border-light flex items-center justify-center overflow-hidden">
                            <template x-if="imageUrl">
                                <img :src="imageUrl" class="w-full h-full object-cover" alt="Preview" />
                            </template>
                            <template x-if="!imageUrl">
                                <i data-lucide="image" class="w-8 h-8 text-brand-nav-inactive"></i>
                            </template>
                        </div>
                        <div>
                            <input type="file" name="logo" id="logo" accept="image/*" class="sr-only" @change="fileChosen">
                            <label for="logo" class="cursor-pointer inline-flex items-center px-4 py-2 border border-brand-border-light rounded-md shadow-sm text-sm font-medium text-brand-ink bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-emerald-900 transition">
                                <i data-lucide="upload" class="w-4 h-4 mr-2"></i> Ubah Logo
                            </label>
                            <p class="mt-2 text-xs text-brand-ink-soft">JPG, PNG atau GIF (Maks. 2MB).</p>
                            @error('logo')
                                <p class="mt-1 text-sm text-brand-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-brand-ink mb-1">Nama Penyelenggara <span class="text-brand-danger">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name', $organizer->name) }}" class="w-full rounded-lg border-gray-300 focus:border-brand-emerald-500 focus:ring-brand-emerald-500 shadow-sm" required>
                        @error('name')
                            <p class="mt-1 text-sm text-brand-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kontak / Telepon -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-brand-ink mb-1">Nomor Telepon / WhatsApp</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $organizer->phone) }}" class="w-full rounded-lg border-gray-300 focus:border-brand-emerald-500 focus:ring-brand-emerald-500 shadow-sm" placeholder="Contoh: 081234567890">
                        @error('phone')
                            <p class="mt-1 text-sm text-brand-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Deskripsi -->
                <div>
                    <label for="description" class="block text-sm font-medium text-brand-ink mb-1">Deskripsi / Tentang Kami</label>
                    <textarea name="description" id="description" rows="4" class="w-full rounded-lg border-gray-300 focus:border-brand-emerald-500 focus:ring-brand-emerald-500 shadow-sm" placeholder="Ceritakan singkat mengenai komunitas atau DKM Anda...">{{ old('description', $organizer->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-brand-danger">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Alamat Pusat -->
                <div>
                    <label for="address" class="block text-sm font-medium text-brand-ink mb-1">Alamat Pusat / Sekretariat</label>
                    <textarea name="address" id="address" rows="2" class="w-full rounded-lg border-gray-300 focus:border-brand-emerald-500 focus:ring-brand-emerald-500 shadow-sm">{{ old('address', $organizer->address) }}</textarea>
                    @error('address')
                        <p class="mt-1 text-sm text-brand-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-200 flex justify-end">
                <button type="submit" class="inline-flex justify-center items-center px-6 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-brand-emerald-900 hover:bg-brand-emerald-950 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-emerald-900 transition shadow-sm">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <!-- Alpine Component for Image Preview -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('photoPreview', (initialUrl) => ({
                imageUrl: initialUrl,
                fileChosen(event) {
                    this.fileToDataUrl(event, src => this.imageUrl = src)
                },
                fileToDataUrl(event, callback) {
                    if (! event.target.files.length) return
                    let file = event.target.files[0],
                        reader = new FileReader()
                    reader.readAsDataURL(file)
                    reader.onload = e => callback(e.target.result)
                },
            }))
        })
    </script>
</x-organizer-layout>
