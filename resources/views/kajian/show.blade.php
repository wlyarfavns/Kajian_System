@extends('layouts.landing')

@section('content')
<style>
    footer { display: none !important; }
</style>
<div style="background:var(--parchment); min-height:100vh; padding-bottom:120px;" class="md:pb-12">
    
    <!-- Container Wrapper -->
    <div class="max-w-md md:max-w-6xl mx-auto relative md:px-8 md:pt-8 pt-0">
        
        <div style="padding: 24px 20px;" class="md:px-0 md:pt-0 md:pb-6">
            <a href="{{ url()->previous() !== url()->current() ? url()->previous() : url('/kajian') }}" class="btn btn-outline" style="border-color:var(--line); padding:8px 16px; font-size:13px; background:var(--paper); border-radius: 99px;">
                <svg style="width:18px; height:18px; margin-right:6px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                Kembali
            </a>
        </div>

        <!-- Poster Section -->
        <div style="padding: 0 20px;" class="md:px-0">
            <div class="relative w-full aspect-[4/5] md:aspect-[21/9] max-h-[480px] md:max-h-[400px] rounded-[32px] overflow-hidden shadow-[0_20px_50px_rgba(10,43,32,0.2)] mb-8 md:mb-12">
                @php
                  $bgImage = $kajian->poster ? Storage::url($kajian->poster) : asset('images/about_mosque.jpg');
                @endphp
                <div style="position:absolute; inset:0; background: linear-gradient(to top, rgba(10,43,32,0.95) 0%, rgba(10,43,32,0.3) 50%, rgba(10,43,32,0.1) 100%), url('{{ $bgImage }}') center/cover;"></div>
                
                <div style="position:absolute; bottom:0; left:0; width:100%; padding:30px 24px;">
                    <div style="display:flex; gap:8px; margin-bottom:12px;">
                        <span style="display:inline-block; padding:6px 14px; background:var(--gold); color:var(--paper); font-size:11px; font-weight:700; border-radius:99px; text-transform:uppercase; letter-spacing:1px;">
                            {{ $kajian->category->name }}
                        </span>
                        <span style="display:inline-block; padding:6px 14px; background:rgba(255,255,255,0.2); backdrop-filter:blur(4px); color:#fff; border:1px solid rgba(255,255,255,0.4); font-size:11px; font-weight:700; border-radius:99px; text-transform:uppercase; letter-spacing:1px;">
                            {{ $kajian->status_label }}
                        </span>
                    </div>
                    <h1 class="text-[28px] md:text-[40px]" style="font-family:'Fraunces',serif; font-weight:700; color:#fff; line-height:1.25; margin:0;">{{ $kajian->title }}</h1>
                </div>
            </div>
        </div>

        <!-- Grid Layout for Desktop -->
        <div class="hidden md:grid md:grid-cols-12 md:gap-8 lg:gap-12 md:items-start"></div> <!-- Dummy just to force tailwind classes if needed -->
        <div class="md:grid md:grid-cols-12 md:gap-8 lg:gap-12 md:items-start">
            
            <!-- Left Column: Main Content -->
            <div class="md:col-span-7 lg:col-span-8">
                <div style="padding: 0 20px;" class="md:px-0">
            
            <!-- Status Alerts (For Admin) -->
            @if(Auth::check() && Auth::user()->role === 'admin')
                @if(!$kajian->is_verified && $kajian->status !== 'cancelled')
                    <div style="background:var(--gold-soft); border:1px solid var(--gold); border-radius:24px; padding:20px; margin-bottom:28px; display:flex; flex-direction:column; gap:12px;">
                        <div style="display:flex; align-items:center; gap:10px;">
                            <svg style="width:20px; height:20px; color:var(--gold-text);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            <h4 style="font-size:15px; font-weight:700; color:var(--ink); margin:0;">Menunggu Moderasi</h4>
                        </div>
                        <p style="font-size:13px; color:var(--ink-soft); margin:0 0 8px; line-height:1.5;">Kajian ini belum dipublikasikan ke Jamaah. Silakan tinjau dan berikan keputusan.</p>
                        <div style="display:flex; gap:10px;">
                            <form action="{{ route('admin.kajian.verify', $kajian->id) }}" method="POST" style="flex:1;">
                                @csrf
                                <button type="submit" class="btn btn-solid" style="width:100%; padding:10px; font-size:13px; justify-content:center;">Setujui</button>
                            </form>
                            <form action="{{ route('admin.kajian.reject', $kajian->id) }}" method="POST" style="flex:1;">
                                @csrf
                                <button type="submit" class="btn btn-outline" style="width:100%; padding:10px; font-size:13px; justify-content:center; border-color:var(--terracotta); color:var(--terracotta);">Tolak</button>
                            </form>
                        </div>
                    </div>
                @elseif($kajian->status === 'cancelled')
                    <div style="background:#FEE2E2; border:1px solid var(--terracotta); border-radius:20px; padding:16px; margin-bottom:28px; display:flex; align-items:center; gap:12px; color:var(--terracotta); font-size:13px; font-weight:600;">
                        <svg style="width:20px; height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Kajian dibatalkan / ditolak.
                    </div>
                @endif
            @endif

            <!-- Speaker Info -->
            <div style="background:var(--paper); border:1px solid var(--line); border-radius:24px; padding:20px; margin-bottom:28px; display:flex; align-items:center; gap:16px; box-shadow:0 10px 30px rgba(10,43,32,0.05);">
                <div style="width:56px; height:56px; border-radius:50%; overflow:hidden; background:var(--parchment-deep); border:2px solid var(--parchment); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    @if($kajian->speaker->photo)
                        <img src="{{ Storage::url($kajian->speaker->photo) }}" style="width:100%; height:100%; object-fit:cover;">
                    @else
                        <span style="font-size:20px; font-weight:700; color:var(--ink-soft); font-family:'Fraunces',serif;">
                            {{ substr($kajian->speaker->name, 0, 1) }}
                        </span>
                    @endif
                </div>
                <div>
                    <span class="eyebrow" style="margin-bottom:4px; font-size:10px;">Pemateri</span>
                    <p style="font-family:'Amiri',serif; font-size:22px; font-weight:700; color:var(--jade-950); margin:0;">{{ $kajian->speaker->name }}</p>
                </div>
            </div>

            <!-- Detail Grid -->
            <div style="display:flex; flex-direction:column; gap:16px; margin-bottom:32px;">
                
                <div class="flex flex-col md:flex-row gap-4">
                    <!-- Waktu -->
                    <div style="flex:1; background:var(--paper); border:1px solid var(--line); border-radius:24px; padding:20px; box-shadow:0 10px 30px rgba(10,43,32,0.05);">
                        <svg style="width:22px; height:22px; color:var(--jade-800); margin-bottom:12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        
                        <div style="margin-bottom:10px;">
                            <span class="eyebrow" style="display:block; font-size:9px; color:var(--ink-soft); margin-bottom:2px;">Tanggal</span>
                            <p style="font-size:15px; font-weight:700; color:var(--ink); margin:0;">{{ $kajian->start_at->translatedFormat('d M Y') }}</p>
                        </div>
                        <div style="display:flex; gap:16px;">
                            <div>
                                <span class="eyebrow" style="display:block; font-size:9px; color:var(--ink-soft); margin-bottom:2px;">Jam Mulai</span>
                                <p style="font-size:14px; font-weight:700; color:var(--ink); margin:0;">{{ $kajian->start_at->format('H:i') }}</p>
                            </div>
                            <div>
                                <span class="eyebrow" style="display:block; font-size:9px; color:var(--ink-soft); margin-bottom:2px;">Jam Selesai</span>
                                <p style="font-size:14px; font-weight:700; color:var(--ink); margin:0;">{{ $kajian->end_at->format('H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Peserta -->
                    <div style="flex:1; background:var(--paper); border:1px solid var(--line); border-radius:24px; padding:20px; box-shadow:0 10px 30px rgba(10,43,32,0.05);">
                        <svg style="width:22px; height:22px; color:var(--jade-800); margin-bottom:12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        
                        <span class="eyebrow" style="display:block; font-size:9px; color:var(--ink-soft); margin-bottom:4px;">Jumlah Calon Peserta</span>
                        <div style="font-size:24px; font-family:'Fraunces',serif; font-weight:700; color:var(--jade-950); margin:0 0 4px;">{{ $attendeesCount }}</div>
                        <p style="font-size:12px; color:var(--ink-soft); font-weight:500; margin:0;">Orang telah mendaftar</p>
                    </div>
                </div>

                <!-- Biaya (Mobile Only, moved to Sidebar on Desktop) -->
                <div class="md:hidden" style="background:var(--paper); border:1px solid var(--line); border-radius:24px; padding:20px; box-shadow:0 10px 30px rgba(10,43,32,0.05); display:flex; align-items:center; justify-content:space-between; margin-bottom:32px;">
                    <div>
                        <span class="eyebrow" style="margin-bottom:4px; font-size:10px;">Biaya Pendaftaran</span>
                        @if($kajian->is_free)
                            <p style="font-size:16px; font-weight:800; color:var(--jade-700); margin:0;">Gratis (Free)</p>
                        @else
                            <p style="font-size:16px; font-weight:800; color:var(--ink); margin:0;">Rp {{ number_format($kajian->price, 0, ',', '.') }}</p>
                        @endif
                    </div>
                    <svg style="width:28px; height:28px; color:var(--gold);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>

            <!-- Lokasi -->
            <div style="margin-bottom:32px;">
                <h3 style="font-family:'Fraunces',serif; font-size:20px; font-weight:700; color:var(--jade-950); margin:0 0 16px;">Lokasi Pelaksanaan</h3>
                <div style="background:var(--paper); border:1px solid var(--line); border-radius:24px; padding:20px; box-shadow:0 10px 30px rgba(10,43,32,0.05); display:flex; align-items:flex-start; gap:16px;">
                    <div style="width:40px; height:40px; border-radius:50%; background:var(--parchment-deep); display:flex; align-items:center; justify-content:center; color:var(--jade-800); flex-shrink:0;">
                        <svg style="width:20px; height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <div style="flex:1;">
                        <p style="font-size:16px; font-weight:700; color:var(--ink); margin:0 0 4px;">{{ $kajian->mosque->name }}</p>
                        <p style="font-size:14px; color:var(--ink-soft); line-height:1.5; margin:0;">{{ $kajian->address }}</p>
                    </div>
                    @if(isset($distance))
                    <div style="flex-shrink:0; text-align:right;">
                        @if($distance < 1)
                            <span style="font-size:16px; font-weight:800; color:var(--jade-700);">{{ number_format($distance * 1000, 0) }}</span>
                            <span style="font-size:12px; font-weight:600; color:var(--ink-soft); display:block;">M</span>
                        @else
                            <span style="font-size:16px; font-weight:800; color:var(--jade-700);">{{ number_format($distance, 1) }}</span>
                            <span style="font-size:12px; font-weight:600; color:var(--ink-soft); display:block;">KM</span>
                        @endif
                    </div>
                    @endif
                </div>
            </div>

            <!-- Fasilitas -->
            @php
                $facilities = is_string($kajian->facilities) ? json_decode($kajian->facilities, true) : (is_array($kajian->facilities) ? $kajian->facilities : []);
            @endphp
            <div style="margin-bottom:40px;">
                <h3 style="font-family:'Fraunces',serif; font-size:20px; font-weight:700; color:var(--jade-950); margin:0 0 16px;">Fasilitas</h3>
                <div style="display:flex; flex-wrap:wrap; gap:10px;">
                    @if(!empty($facilities))
                        @foreach($facilities as $facility)
                        <div style="background:var(--paper); border:1px solid var(--line); border-radius:99px; padding:8px 16px; font-size:13px; font-weight:600; color:var(--jade-800); display:inline-flex; align-items:center; gap:6px; box-shadow:0 4px 10px rgba(10,43,32,0.03);">
                            <svg style="width:16px; height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            {{ $facility }}
                        </div>
                        @endforeach
                    @else
                        <p style="font-size:14px; color:var(--ink-soft);">Belum ada informasi fasilitas.</p>
                    @endif
                </div>
            </div>

            <!-- Deskripsi -->
            <div style="margin-bottom:40px;">
                <h3 style="font-family:'Fraunces',serif; font-size:20px; font-weight:700; color:var(--jade-950); margin:0 0 16px;">Deskripsi Kajian</h3>
                <div style="font-size:15px; color:var(--ink-soft); line-height:1.7;">
                    {!! nl2br(e($kajian->description ?: 'Tidak ada deskripsi tambahan untuk kajian ini.')) !!}
                </div>
            </div>

            <!-- Penyelenggara Info -->
            <div style="background:var(--parchment-deep); border-radius:24px; padding:20px; display:flex; align-items:center; gap:16px;">
                <div style="width:48px; height:48px; background:var(--paper); border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0; box-shadow:var(--shadow);">
                    <svg style="width:24px; height:24px; color:var(--jade-800);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
                <div>
                    <span class="eyebrow" style="margin-bottom:4px; font-size:10px;">Penyelenggara</span>
                    <p style="font-size:16px; font-weight:700; color:var(--ink); margin:0;">{{ $kajian->organizer->name }}</p>
                </div>
            </div>
        </div> <!-- End md:px-0 -->
        </div> <!-- End md:col-span-7 -->
        
        <!-- Right Column: Sticky Action Card (Desktop Only) -->
        <div class="hidden md:block md:col-span-5 lg:col-span-4 md:sticky md:top-8">
            <div style="background:var(--paper); border:1px solid var(--line); border-radius:24px; padding:28px; box-shadow:0 20px 50px rgba(10,43,32,0.05);">
                <!-- Price Desktop -->
                <div style="margin-bottom:24px;">
                    <span style="font-size:13px; font-weight:600; color:var(--ink-soft); text-transform:uppercase; letter-spacing:1px; display:block; margin-bottom:8px;">Biaya Pendaftaran</span>
                    @if($kajian->is_free)
                        <div style="font-size:32px; font-weight:800; color:var(--jade-700); line-height:1;">Gratis <span style="font-size:20px; font-weight:600; color:var(--jade-600);">(Free)</span></div>
                    @else
                        <div style="font-size:32px; font-weight:800; color:var(--ink); line-height:1;">Rp {{ number_format($kajian->price, 0, ',', '.') }}</div>
                    @endif
                </div>

                <!-- Desktop Actions -->
                <div style="display:flex; flex-direction:column; gap:12px;">
                    <!-- Arahkan & Favorite -->
                    <div style="display:flex; gap:12px;">
                        <a href="{{ $kajian->google_maps_url ?: 'https://www.google.com/maps/dir/?api=1&destination=' . $kajian->latitude . ',' . $kajian->longitude }}" target="_blank" style="flex:1; display:flex; align-items:center; justify-content:center; height:52px; border-radius:18px; background:var(--parchment); border:1px solid var(--line); color:var(--jade-900); font-size:14px; font-weight:700; text-decoration:none; gap:6px; transition:all 0.2s;" onmouseover="this.style.background='var(--parchment-deep)';" onmouseout="this.style.background='var(--parchment)';">
                            <svg style="width:18px; height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                            Arahkan
                        </a>
                        <form action="{{ url('/kajian/'.$kajian->slug.'/favorite') }}" method="POST" style="flex-shrink:0;">
                            @csrf
                            <button type="submit" style="width:52px; height:52px; border-radius:18px; background:{{ $isFavorited ? '#FEE2E2' : 'var(--parchment)' }}; border:1px solid {{ $isFavorited ? 'var(--terracotta)' : 'var(--line)' }}; display:flex; align-items:center; justify-content:center; color:{{ $isFavorited ? 'var(--terracotta)' : 'var(--ink)' }}; cursor:pointer; transition:all 0.2s;" onmouseover="this.style.color='var(--terracotta)'; this.style.borderColor='var(--terracotta)'; this.style.background='#FEE2E2';" onmouseout="this.style.color='{{ $isFavorited ? 'var(--terracotta)' : 'var(--ink)' }}'; this.style.borderColor='{{ $isFavorited ? 'var(--terracotta)' : 'var(--line)' }}'; this.style.background='{{ $isFavorited ? '#FEE2E2' : 'var(--parchment)' }}';">
                                <svg style="width:22px; height:22px;" fill="{{ $isFavorited ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                            </button>
                        </form>
                    </div>

                    <!-- Hadir -->
                    @if($isAttending)
                        <div style="display:flex; align-items:center; justify-content:center; height:52px; border-radius:18px; background:var(--jade-800); color:var(--paper); font-size:14px; font-weight:700; gap:6px;">
                            <svg style="width:18px; height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Anda Telah Terdaftar
                        </div>
                        <form action="{{ url('/kajian/'.$kajian->slug.'/join') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="width:100%; display:flex; align-items:center; justify-content:center; height:44px; border-radius:14px; background:transparent; color:var(--terracotta); font-size:13px; font-weight:700; border:1px solid var(--terracotta); cursor:pointer; transition:all 0.2s;" onmouseover="this.style.background='#FEE2E2';" onmouseout="this.style.background='transparent';">
                                Batal Hadir
                            </button>
                        </form>
                    @else
                        <form action="{{ url('/kajian/'.$kajian->slug.'/join') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-solid" style="width:100%; height:52px; border-radius:18px; font-size:14px; justify-content:center; padding:0;">
                                {{ isset($isCancelled) && $isCancelled ? 'Daftar Kembali' : 'Saya Mau Hadir' }}
                            </button>
                        </form>
                    @endif
                </div>
                
                <!-- Share (Optional) -->
                <div style="margin-top:20px; padding-top:20px; border-top:1px solid var(--line); text-align:center;">
                     <button onclick="navigator.clipboard.writeText(window.location.href); alert('Link kajian disalin ke clipboard!');" style="background:transparent; border:none; font-size:13px; font-weight:600; color:var(--ink-soft); display:inline-flex; align-items:center; gap:6px; cursor:pointer; hover:color:var(--jade-800);">
                         <svg style="width:16px; height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                         Bagikan Kajian
                     </button>
                </div>
            </div>
        </div>

    </div>

    <!-- Floating Action Bar (Mobile Only) -->
    <div class="md:hidden" style="position:fixed; bottom:0; left:0; width:100%; z-index:50; pointer-events:none;">
        <div style="max-width:480px; margin:0 auto; padding:16px 20px; pointer-events:auto;">
            <div style="background:rgba(244,238,220,0.95); backdrop-filter:blur(14px); border:1px solid var(--line); border-radius:28px; padding:12px; box-shadow:0 -10px 40px rgba(10,43,32,0.1); display:flex; gap:8px;">
                
                <form action="{{ url('/kajian/'.$kajian->slug.'/favorite') }}" method="POST" style="flex-shrink:0;">
                    @csrf
                    <button type="submit" style="width:52px; height:52px; border-radius:18px; background:{{ $isFavorited ? '#FEE2E2' : 'var(--paper)' }}; border:1px solid {{ $isFavorited ? 'var(--terracotta)' : 'var(--line)' }}; display:flex; align-items:center; justify-content:center; color:{{ $isFavorited ? 'var(--terracotta)' : 'var(--ink)' }}; cursor:pointer; transition:all 0.2s;" onmouseover="this.style.color='var(--terracotta)'; this.style.borderColor='var(--terracotta)'; this.style.background='#FEE2E2';" onmouseout="this.style.color='{{ $isFavorited ? 'var(--terracotta)' : 'var(--ink)' }}'; this.style.borderColor='{{ $isFavorited ? 'var(--terracotta)' : 'var(--line)' }}'; this.style.background='{{ $isFavorited ? '#FEE2E2' : 'var(--paper)' }}';">
                        <svg style="width:22px; height:22px;" fill="{{ $isFavorited ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </button>
                </form>
                
                <a href="{{ $kajian->google_maps_url ?: 'https://www.google.com/maps/dir/?api=1&destination=' . $kajian->latitude . ',' . $kajian->longitude }}" target="_blank" style="flex:1; display:flex; align-items:center; justify-content:center; height:52px; border-radius:18px; background:var(--paper); border:1px solid var(--line); color:var(--jade-900); font-size:14px; font-weight:700; text-decoration:none; gap:6px; transition:all 0.2s;" onmouseover="this.style.background='var(--parchment-deep)';" onmouseout="this.style.background='var(--paper)';">
                    <svg style="width:18px; height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                    Arahkan
                </a>
                
                @if($isAttending)
                    <div style="flex:1.5; display:flex; gap:6px;">
                        <div style="flex:1.2; display:flex; align-items:center; justify-content:center; height:52px; border-radius:18px; background:var(--jade-800); color:var(--paper); font-size:13px; font-weight:700; gap:4px;">
                            <svg style="width:16px; height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Terdaftar
                        </div>
                        <form action="{{ url('/kajian/'.$kajian->slug.'/join') }}" method="POST" style="flex:1;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="width:100%; height:52px; display:flex; align-items:center; justify-content:center; border-radius:18px; background:#FEE2E2; color:var(--terracotta); border:1px solid var(--terracotta); font-size:13px; font-weight:700; cursor:pointer;">
                                Batal
                            </button>
                        </form>
                    </div>
                @else
                    <form action="{{ url('/kajian/'.$kajian->slug.'/join') }}" method="POST" style="flex:1.5;">
                        @csrf
                        <button type="submit" class="btn btn-solid" style="width:100%; height:52px; border-radius:18px; font-size:14px; justify-content:center; padding:0;">
                            {{ isset($isCancelled) && $isCancelled ? 'Daftar Kembali' : 'Saya Mau Hadir' }}
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

</div>
@endsection
