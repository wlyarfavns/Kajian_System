@extends('layouts.landing')

@section('content')
<div class="container" style="padding-top:40px; padding-bottom:40px; min-height: 40vh;">
    
    <div style="margin-bottom:40px; text-align:center;">
        <h2 style="font-family:'Fraunces',serif; font-size:36px; font-weight:600; color:var(--jade-950); margin:0 0 10px;">
            Jelajah <em style="color:var(--gold); font-style:italic;">Kajian</em>
        </h2>
        <p style="color:var(--ink-soft); font-size:15px; margin:0;">Temukan jadwal kajian yang sesuai dengan waktu dan lokasimu.</p>
    </div>

    <!-- Search Form -->
    <form action="{{ url('/kajian') }}" method="GET" style="margin-bottom:30px;">
        <!-- Preserve hidden filters -->
        @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
        @if(request('date')) <input type="hidden" name="date" value="{{ request('date') }}"> @endif
        @if(request('audience')) <input type="hidden" name="audience" value="{{ request('audience') }}"> @endif
        @if(request('lat')) <input type="hidden" name="lat" value="{{ request('lat') }}"> @endif
        @if(request('lng')) <input type="hidden" name="lng" value="{{ request('lng') }}"> @endif
        @if(request('nearby')) <input type="hidden" name="nearby" value="{{ request('nearby') }}"> @endif
        
        <div style="display:flex; align-items:center; background:var(--paper); border:1px solid var(--line); border-radius:99px; padding:6px 6px 6px 20px; max-width:600px; margin:0 auto; box-shadow:0 10px 25px rgba(10,43,32,0.05);">
            <svg style="width:20px; height:20px; color:var(--ink-soft);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            <input type="search" id="searchInput" name="q" value="{{ request('q') }}" oninput="clearTimeout(this.delay); this.delay = setTimeout(() => this.form.requestSubmit(), 500);" style="flex:1; background:transparent; border:none; outline:none; padding:10px 14px; font-size:15px; color:var(--ink);" placeholder="Cari ustadz, masjid, atau tema...">
            <button type="submit" class="btn btn-solid" style="padding:10px 24px;">Cari</button>
        </div>
    </form>

    <style>
        .filter-container {
            display: flex;
            gap: 10px;
            overflow-x: auto;
            flex-wrap: nowrap;
            scrollbar-width: none;
            -ms-overflow-style: none;
            -webkit-overflow-scrolling: touch;
        }
        .filter-container::-webkit-scrollbar {
            display: none;
        }
        .filter-btn {
            white-space: nowrap;
            flex-shrink: 0;
            padding: 8px 18px;
            font-size: 13px;
            border-color: var(--line-on-dark);
        }
    </style>

    <!-- Categories Filter -->
    <div class="filter-container" style="margin-bottom:20px; padding-bottom:8px;">
        <a href="{{ request()->fullUrlWithQuery(['category' => null]) }}" class="btn filter-btn {{ !request('category') ? 'btn-solid' : 'btn-outline' }}">Semua</a>
        @foreach($categories as $cat)
            <a href="{{ request()->fullUrlWithQuery(['category' => $cat->slug]) }}" class="btn filter-btn {{ request('category') === $cat->slug ? 'btn-solid' : 'btn-outline' }}">{{ $cat->name }}</a>
        @endforeach
    </div>

    <!-- Additional Filters: Date & Audience & Nearby -->
    <div class="filter-container" style="margin-bottom:40px; border-top:1px solid var(--line); padding-top:20px; padding-bottom:8px;">
        <!-- Nearby / Location Modal -->
        <div x-data="{
                open: false,
                loading: false,
                searching: false,
                customLoc: '',
                searchError: '',
                suggestions: [],
                searchTimeout: null,
                
                init() {
                    this.$watch('customLoc', value => {
                        if (value.length < 3) {
                            this.suggestions = [];
                            return;
                        }
                        clearTimeout(this.searchTimeout);
                        this.searchTimeout = setTimeout(() => {
                            this.fetchSuggestions(value);
                        }, 500);
                    });
                },
                
                visitWithLocation(lat, lng) {
                    let currentUrl = new URL(window.location.href);
                    currentUrl.searchParams.set('nearby', '1');
                    currentUrl.searchParams.set('lat', lat);
                    currentUrl.searchParams.set('lng', lng);
                    currentUrl.searchParams.set('page', '1');
                    
                    if (window.Turbo) {
                        window.Turbo.visit(currentUrl.toString());
                    } else {
                        window.location.href = currentUrl.toString();
                    }
                    this.open = false;
                },

                getCurrentLocation() {
                    this.loading = true;
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(
                            (position) => {
                                this.visitWithLocation(position.coords.latitude, position.coords.longitude);
                                this.loading = false;
                            },
                            (error) => {
                                alert('Gagal mendapatkan lokasi. Pastikan izin lokasi diaktifkan pada browser/device Anda.');
                                this.loading = false;
                            },
                            { enableHighAccuracy: true, timeout: 5000, maximumAge: 0 }
                        );
                    } else {
                        alert('Browser Anda tidak mendukung Geolocation.');
                        this.loading = false;
                    }
                },

                async fetchSuggestions(query) {
                    this.searching = true;
                    this.searchError = '';
                    try {
                        const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query + ', Indonesia')}&limit=5`);
                        const data = await response.json();
                        if(data && data.length > 0) {
                            this.suggestions = data;
                        } else {
                            this.suggestions = [];
                        }
                    } catch(e) {
                        this.searchError = 'Gagal mengambil data lokasi.';
                    }
                    this.searching = false;
                },

                resetLocation() {
                    let currentUrl = new URL(window.location.href);
                    currentUrl.searchParams.delete('nearby');
                    currentUrl.searchParams.delete('lat');
                    currentUrl.searchParams.delete('lng');
                    currentUrl.searchParams.set('page', '1');
                    
                    if (window.Turbo) {
                        window.Turbo.visit(currentUrl.toString());
                    } else {
                        window.location.href = currentUrl.toString();
                    }
                    this.open = false;
                }
            }" class="inline-block relative">
            
            <button type="button" @click="open = true" class="btn filter-btn {{ request('nearby') == 1 ? 'btn-solid' : 'btn-outline' }}">
                <svg style="width:16px; height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                Atur Lokasi {{ request('nearby') == 1 ? '(Aktif)' : '' }}
            </button>

            <!-- Modal Lokasi -->
            <div x-show="open" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; z-index:9999; display:flex; align-items:center; justify-content:center; padding:20px;">
                <!-- Overlay -->
                <div x-show="open" x-transition.opacity style="position:absolute; top:0; left:0; width:100%; height:100%; background:rgba(10,43,32,0.6); backdrop-filter:blur(4px);" @click="open = false"></div>
                
                <!-- Modal Box -->
                <div x-show="open" x-transition.scale style="position:relative; background:var(--paper); border:1px solid var(--line); width:100%; max-width:400px; border-radius:24px; padding:24px; box-shadow:0 20px 50px rgba(10,43,32,0.2);">
                    
                    <div style="display:flex; justify-content:space-between; items-center; margin-bottom:20px; border-bottom:1px solid var(--line); padding-bottom:16px;">
                        <h3 style="font-size:18px; font-weight:700; color:var(--jade-950); font-family:'Fraunces',serif; margin:0;">Atur Lokasi Anda</h3>
                        <button type="button" @click="open = false" style="background:transparent; border:none; color:var(--ink-soft); cursor:pointer; padding:4px;">
                            <svg style="width:24px; height:24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                    
                    <div style="display:flex; flex-direction:column; gap:20px;">
                        <!-- Button Current Location -->
                        <button type="button" @click="getCurrentLocation()" class="btn btn-solid" style="border-radius:14px; padding:14px; width:100%; justify-content:center;" :disabled="loading">
                            <svg x-show="!loading" style="width:20px; height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <svg x-show="loading" style="width:20px; height:20px; animation:spin 1s linear infinite;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                            <span x-text="loading ? 'Mendeteksi...' : 'Gunakan Lokasi Saat Ini'"></span>
                        </button>
                        
                        <div style="display:flex; align-items:center; gap:16px;">
                            <div style="flex-grow:1; border-top:1px solid var(--line);"></div>
                            <span style="font-size:13px; font-weight:600; color:var(--ink-soft);">Atau cari secara manual</span>
                            <div style="flex-grow:1; border-top:1px solid var(--line);"></div>
                        </div>
                        
                        <!-- Search Custom Location (Gojek Style) -->
                        <div style="position:relative;">
                            <div style="display:flex; align-items:center; background:var(--parchment); border:1px solid var(--line); border-radius:14px; padding:4px 16px; gap:8px;">
                                <svg style="width:18px; height:18px; color:var(--ink-soft); flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                <input type="text" x-model="customLoc" placeholder="Cari area, nama jalan, atau kota..." style="flex:1; border:none; background:transparent; padding:10px 0; font-size:14px; outline:none; color:var(--ink);" autocomplete="off">
                                <svg x-show="searching" style="width:16px; height:16px; animation:spin 1s linear infinite; color:var(--ink-soft); flex-shrink:0;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                            </div>
                            
                            <!-- Dropdown Suggestions -->
                            <div x-show="suggestions.length > 0" style="display:none; position:absolute; top:100%; left:0; width:100%; margin-top:8px; border:1px solid var(--line); border-radius:14px; background:var(--paper); max-height:240px; overflow-y:auto; box-shadow:0 10px 20px rgba(10,43,32,0.1); z-index:10;">
                                <template x-for="(place, index) in suggestions" :key="index">
                                    <button type="button" @click="visitWithLocation(place.lat, place.lon)" style="width:100%; text-align:left; padding:12px 16px; border-bottom:1px solid var(--line); background:transparent; border-left:none; border-right:none; border-top:none; cursor:pointer; display:flex; gap:12px; align-items:flex-start; transition:background 0.2s;" onmouseover="this.style.background='var(--parchment)'" onmouseout="this.style.background='transparent'">
                                        <div style="width:32px; height:32px; border-radius:50%; background:var(--parchment-deep); display:flex; align-items:center; justify-content:center; flex-shrink:0; color:var(--jade-800);">
                                            <svg style="width:16px; height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        </div>
                                        <div style="flex:1; overflow:hidden;">
                                            <h4 x-text="place.display_name.split(',')[0]" style="font-size:14px; font-weight:700; color:var(--jade-950); margin:0 0 2px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;"></h4>
                                            <p x-text="place.display_name" style="font-size:12px; color:var(--ink-soft); margin:0; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;"></p>
                                        </div>
                                    </button>
                                </template>
                            </div>
                        </div>
                        
                        <template x-if="searchError">
                            <p style="font-size:13px; color:var(--terracotta); margin:0;" x-text="searchError"></p>
                        </template>

                        @if(request('nearby') == 1)
                            <div style="padding-top:16px; border-top:1px solid var(--line); margin-top:8px;">
                                <button type="button" @click="resetLocation()" style="width:100%; background:transparent; border:none; color:var(--terracotta); font-size:14px; font-weight:700; cursor:pointer;">
                                    Hapus Filter Lokasi
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <style>
                @keyframes spin { 100% { transform: rotate(360deg); } }
            </style>
        </div>

        <!-- Date -->
        @php $dates = ['today' => 'Hari ini', 'besok' => 'Besok', 'malam-ini' => 'Malam ini']; @endphp
        @foreach($dates as $key => $label)
            <a href="{{ request('date') === $key ? request()->fullUrlWithQuery(['date' => null]) : request()->fullUrlWithQuery(['date' => $key]) }}" class="btn filter-btn {{ request('date') === $key ? 'btn-solid' : 'btn-outline' }}">
                {{ $label }}
            </a>
        @endforeach

        <!-- Audience -->
        @php $audiences = ['umum' => 'Umum', 'ikhwan' => 'Ikhwan', 'akhwat' => 'Akhwat']; @endphp
        @foreach($audiences as $key => $label)
            <a href="{{ request('audience') === $key ? request()->fullUrlWithQuery(['audience' => null]) : request()->fullUrlWithQuery(['audience' => $key]) }}" class="btn filter-btn {{ request('audience') === $key ? 'btn-solid' : 'btn-outline' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    <!-- Results List -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($kajians as $kajian)
            <x-kajian-card :kajian="$kajian" />
        @empty
            <div style="grid-column: 1 / -1; text-align:center; padding:60px 20px; background:var(--paper); border:1px solid var(--line); border-radius:24px; box-shadow:var(--shadow);">
                <div style="width:64px; height:64px; background:rgba(184,134,59,.1); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px; color:var(--gold);">
                    <svg style="width:32px; height:32px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                </div>
                <h4 style="font-family:'Fraunces',serif; font-size:22px; color:var(--jade-950); margin:0 0 10px;">Pencarian Tidak Ditemukan</h4>
                <p style="color:var(--ink-soft); font-size:14px; margin:0 0 24px;">Tidak ada kajian yang sesuai dengan kriteria filter Anda saat ini.</p>
                <a href="{{ url('/kajian' . (request('lat') && request('lng') ? '?lat='.request('lat').'&lng='.request('lng') : '')) }}" class="btn btn-solid">
                    Reset Filter
                </a>
            </div>
        @endforelse
    </div>
    
    <!-- Pagination -->
    <div style="margin-top:50px;">
        {{ $kajians->links() }}
    </div>

</div>
@endsection
