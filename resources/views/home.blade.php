@extends('layouts.landing')

@section('content')
<header class="hero">
  <svg class="hero-lattice" viewBox="0 0 1180 700" preserveAspectRatio="xMidYMid slice">
    <defs>
      <pattern id="star8" width="86" height="86" patternUnits="userSpaceOnUse" patternTransform="rotate(15)">
        <g stroke="#E7C77E" stroke-width="1" fill="none">
          <path d="M43 4 L57 22 L79 22 L64 40 L79 58 L57 58 L43 78 L29 58 L7 58 L22 40 L7 22 L29 22 Z"/>
        </g>
      </pattern>
    </defs>
    <rect width="100%" height="100%" fill="url(#star8)"/>
  </svg>

  <div class="container hero-grid">
    <div>
      <p class="ayat arabic">بِسْمِ اللَّهِ الرَّحْمَنِ الرَّحِيم</p>
      <h2>Menuntun Langkah<span class="accent">menuju majelis ilmu.</span></h2>
      <p class="lede">KajianKu menghubungkan Anda dengan kajian, ustadz, dan masjid terdekat — dirawat dengan data yang akurat, bukan sekadar daftar alamat.</p>
      <div class="hero-actions">
        <a href="{{ route('register') }}" class="btn btn-solid">Daftar Sekarang</a>
        <a href="{{ url('/kajian') }}" class="btn btn-ghost-light">Cari Kajian →</a>
      </div>
      
    </div>

    <div class="hero-visual-wrap">
      <div class="hero-visual-bg" style="background-image: url('{{ asset('images/hero_reading.jpg') }}');"></div>
    </div>
  </div>
</header>


<section id="about" style="padding: 60px 0;">
  <div class="container about-grid" style="align-items: center;">
    <div class="about-visual" style="position:relative;">
      <div class="about-frame" style="background-image: url('{{ asset('images/about_mosque.jpg') }}'); border-radius: 32px; aspect-ratio: 4/5; width: 100%; max-width: 450px; background-size: cover; background-position: center; box-shadow: 0 40px 80px rgba(6,26,19,0.3); border: 1px solid rgba(231,199,126,0.3);"></div>
      
    </div>
    
    <div class="about-content">
      <span class="eyebrow">Tentang KajianKu</span>
      <h3 style="font-family:'Amiri',serif; font-size: 44px; line-height: 1.3; margin-bottom: 20px;">Membangun generasi rabbani lewat <em style="color:var(--gold-deep)">akses ilmu yang mudah.</em></h3>
      <p style="color: var(--ink-soft); line-height: 1.8; margin-bottom: 40px; font-size: 16px;">Misi kami menggabungkan pencarian ilmu syar'i yang otentik dengan kemudahan teknologi modern — menghubungkan jamaah dan penyelenggara agar tetap terhubung, dengan data yang valid dan jadwal yang akurat.</p>
      
      
      <div class="feature-boxes" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
        <div style="background: var(--paper); box-shadow: 0 15px 40px rgba(6,26,19,0.08); border: none; border-radius: 20px; padding: 40px; min-height: 280px; display: flex; flex-direction: column; justify-content: flex-start; transition: transform 0.3s, box-shadow 0.3s; cursor: default; position: relative; overflow: hidden;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 25px 50px rgba(6,26,19,0.15)'" onmouseout="this.style.transform='none'; this.style.boxShadow='0 15px 40px rgba(6,26,19,0.08)'">
          <div style="position: absolute; top:0; left:0; right:0; height:4px; background: linear-gradient(90deg, var(--gold-pale), var(--gold-deep));"></div>
          <img src="{{ asset('images/feat_1.png') }}" alt="Kajian Terdekat" style="width:75px; height:75px; object-fit:contain; margin-bottom:20px; filter:drop-shadow(0 10px 15px rgba(184,134,59,0.15));">
          <h4 style="margin:0 0 12px; font-family:'Amiri',serif; font-size:26px; color:var(--jade-950);">Kajian Terdekat</h4>
          <p style="margin:0; font-size:14.5px; color:var(--ink-soft); line-height:1.7;">Temukan jadwal kajian di sekitar lokasi Anda secara real-time. Dilengkapi dengan deteksi lokasi otomatis, Anda tidak perlu bingung mencari majelis ilmu terdekat saat sedang bepergian atau berada di luar kota.</p>
        </div>

        <div style="background: var(--paper); box-shadow: 0 15px 40px rgba(6,26,19,0.08); border: none; border-radius: 20px; padding: 40px; min-height: 280px; display: flex; flex-direction: column; justify-content: flex-start; transition: transform 0.3s, box-shadow 0.3s; cursor: default; position: relative; overflow: hidden;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 25px 50px rgba(6,26,19,0.15)'" onmouseout="this.style.transform='none'; this.style.boxShadow='0 15px 40px rgba(6,26,19,0.08)'">
          <div style="position: absolute; top:0; left:0; right:0; height:4px; background: linear-gradient(90deg, var(--gold-pale), var(--gold-deep));"></div>
          <img src="{{ asset('images/feat_2.png') }}" alt="Kajian Rutin" style="width:75px; height:75px; object-fit:contain; margin-bottom:20px; filter:drop-shadow(0 10px 15px rgba(184,134,59,0.15));">
          <h4 style="margin:0 0 12px; font-family:'Amiri',serif; font-size:26px; color:var(--jade-950);">Kajian Rutin</h4>
          <p style="margin:0; font-size:14.5px; color:var(--ink-soft); line-height:1.7;">Info kajian harian, mingguan, dan bulanan yang selalu terupdate. Kami menyajikan jadwal dari berbagai masjid mitra yang terverifikasi, sehingga Anda bisa merencanakan waktu luang untuk memperdalam ilmu secara konsisten.</p>
        </div>

        <div style="background: var(--paper); box-shadow: 0 15px 40px rgba(6,26,19,0.08); border: none; border-radius: 20px; padding: 40px; min-height: 280px; display: flex; flex-direction: column; justify-content: flex-start; transition: transform 0.3s, box-shadow 0.3s; cursor: default; position: relative; overflow: hidden;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 25px 50px rgba(6,26,19,0.15)'" onmouseout="this.style.transform='none'; this.style.boxShadow='0 15px 40px rgba(6,26,19,0.08)'">
          <div style="position: absolute; top:0; left:0; right:0; height:4px; background: linear-gradient(90deg, var(--gold-pale), var(--gold-deep));"></div>
          <img src="{{ asset('images/feat_3.png') }}" alt="Tabligh Akbar" style="width:75px; height:75px; object-fit:contain; margin-bottom:20px; filter:drop-shadow(0 10px 15px rgba(184,134,59,0.15));">
          <h4 style="margin:0 0 12px; font-family:'Amiri',serif; font-size:26px; color:var(--jade-950);">Tabligh Akbar</h4>
          <p style="margin:0; font-size:14.5px; color:var(--ink-soft); line-height:1.7;">Dapatkan informasi eksklusif mengenai kajian skala besar dan kehadiran ustadz nasional favorit Anda. Kami memastikan Anda mendapat notifikasi sejak jauh hari agar dapat menyiapkan waktu untuk hadir.</p>
        </div>

        <div style="background: var(--paper); box-shadow: 0 15px 40px rgba(6,26,19,0.08); border: none; border-radius: 20px; padding: 40px; min-height: 280px; display: flex; flex-direction: column; justify-content: flex-start; transition: transform 0.3s, box-shadow 0.3s; cursor: default; position: relative; overflow: hidden;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 25px 50px rgba(6,26,19,0.15)'" onmouseout="this.style.transform='none'; this.style.boxShadow='0 15px 40px rgba(6,26,19,0.08)'">
          <div style="position: absolute; top:0; left:0; right:0; height:4px; background: linear-gradient(90deg, var(--gold-pale), var(--gold-deep));"></div>
          <img src="{{ asset('images/feat_4.png') }}" alt="Fitur Simpan" style="width:75px; height:75px; object-fit:contain; margin-bottom:20px; filter:drop-shadow(0 10px 15px rgba(184,134,59,0.15));">
          <h4 style="margin:0 0 12px; font-family:'Amiri',serif; font-size:26px; color:var(--jade-950);">Fitur Simpan</h4>
          <p style="margin:0; font-size:14.5px; color:var(--ink-soft); line-height:1.7;">Tandai dan jadwalkan kajian favorit Anda ke dalam daftar personal agar tidak terlewat. Aplikasi akan menyimpannya dengan rapi, lengkap dengan catatan khusus yang bisa Anda akses kapan saja.</p>
        </div>
      </div>

    </div>
  </div>
</section>


<section id="cara-kerja" style="background:var(--parchment-deep); padding: 60px 0 40px;">
  <div class="container">
    <div style="text-align:center; margin-bottom:60px;">
      <span style="color:var(--gold-deep); letter-spacing:3px; font-weight:800; font-size:15px; text-transform:uppercase; display:block; margin-bottom:8px;">CARA KERJA</span>
      <h3 style="font-family:'Amiri',serif; font-size:clamp(32px, 5vw, 48px); color:var(--jade-950); margin-top:0; line-height:1.1;">3 Langkah mudah mengikuti kajian terdekat.</h3>
    </div>
    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(300px, 1fr)); gap:30px;">
      
      <!-- Box 1 -->
      <div style="background:var(--paper); border-radius:24px; box-shadow: 0 20px 50px rgba(6,26,19,0.06); padding:40px; transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-10px)'" onmouseout="this.style.transform='none'">
        <img src="{{ asset('images/icon_cari.png') }}" alt="Cari Kajian" style="width:100px; height:100px; object-fit:contain; margin-bottom:24px; filter:drop-shadow(0 10px 15px rgba(184,134,59,0.2));">
        <h4 style="font-family:'Amiri',serif; font-size:28px; color:var(--jade-950); margin-bottom:16px; font-weight:700;">Cari Kajian</h4>
        <p style="color:var(--ink); font-size:16px; line-height:1.7; margin:0; font-weight:500;">Gunakan fitur pencarian atau deteksi lokasi saat ini untuk menemukan jadwal kajian terdekat dengan sangat akurat.</p>
      </div>

      <!-- Box 2 -->
      <div style="background:var(--paper); border-radius:24px; box-shadow: 0 20px 50px rgba(6,26,19,0.06); padding:40px; transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-10px)'" onmouseout="this.style.transform='none'">
        <img src="{{ asset('images/icon_simpan.png') }}" alt="Cek & Simpan" style="width:100px; height:100px; object-fit:contain; margin-bottom:24px; filter:drop-shadow(0 10px 15px rgba(184,134,59,0.2));">
        <h4 style="font-family:'Amiri',serif; font-size:28px; color:var(--jade-950); margin-bottom:16px; font-weight:700;">Cek & Simpan</h4>
        <p style="color:var(--ink); font-size:16px; line-height:1.7; margin:0; font-weight:500;">Lihat detail ustadz, waktu, dan rute lokasi masjid. Anda juga bisa menyimpan jadwal agar mendapat pengingat dari sistem.</p>
      </div>

      <!-- Box 3 -->
      <div style="background:var(--paper); border-radius:24px; box-shadow: 0 20px 50px rgba(6,26,19,0.06); padding:40px; transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-10px)'" onmouseout="this.style.transform='none'">
        <img src="{{ asset('images/icon_hadir.png') }}" alt="Hadir di Majelis" style="width:100px; height:100px; object-fit:contain; margin-bottom:24px; filter:drop-shadow(0 10px 15px rgba(184,134,59,0.2));">
        <h4 style="font-family:'Amiri',serif; font-size:28px; color:var(--jade-950); margin-bottom:16px; font-weight:700;">Hadir di Majelis</h4>
        <p style="color:var(--ink); font-size:16px; line-height:1.7; margin:0; font-weight:500;">Gunakan fitur peta panduan rute navigasi dari dalam aplikasi untuk tiba di lokasi majelis dengan tenang tanpa kebingungan.</p>
      </div>

    </div>
  </div>
</section>

<div class="stats">
  <div class="container stats-grid">
    <div><div class="stat-value">5.000+</div><div class="stat-label">Jamaah Terdaftar</div></div>
    <div><div class="stat-value">200+</div><div class="stat-label">Masjid Mitra</div></div>
    <div><div class="stat-value">15+</div><div class="stat-label">Kota Terjangkau</div></div>
    <div><div class="stat-value">100%</div><div class="stat-label">Gratis untuk Jamaah</div></div>
  </div>
</div>

<section id="jadwal" style="padding: 60px 0;">
  <div class="container">
    <div class="schedule-head" style="display:flex; flex-direction:column; align-items:center; text-align:center; margin-bottom:50px; gap:24px;">
      <div class="section-head" style="margin-bottom:0">
        <span class="eyebrow" style="justify-content:center; color:var(--gold-deep); letter-spacing:2px; font-weight:800; font-size:15px; text-transform:uppercase; margin-bottom:12px;">JADWAL TERKINI</span>
        <h3 class="arabic" style="font-size:clamp(32px, 5vw, 46px); color:var(--jade-950); margin-top:0; line-height:1.2;">Kajian yang <em style="color:var(--gold-deep); font-style:italic;">tersedia minggu ini.</em></h3>
      </div>
      <a href="{{ url('/kajian') }}" class="btn btn-outline" style="border-width:2px; font-weight:700; font-size:16px; padding:12px 28px;">Lihat Semua Kajian</a>
    </div>

    <div class="kajian-grid">
      @forelse($kajians as $kajian)
      <div class="kcard" style="background:var(--paper);border-radius:20px;overflow:hidden;border:none;box-shadow:0 15px 40px rgba(6,26,19,0.08);transition:transform 0.3s, box-shadow 0.3s; display:flex; flex-direction:column;" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 25px 50px rgba(6,26,19,0.15)'" onmouseout="this.style.transform='none'; this.style.boxShadow='0 15px 40px rgba(6,26,19,0.08)'">
        
        <div class="kcard-media" style="height:150px; background: linear-gradient(rgba(15, 81, 55, 0.7), rgba(15, 81, 55, 0.9)), url('{{ asset('images/about_mosque.jpg') }}') center/cover; position:relative; display:flex; align-items:flex-end; padding:16px;">
          <span class="ribbon" style="background:var(--gold); color:var(--paper); padding:4px 12px; border-radius:8px; font-size:12px; font-weight:700; position:absolute; top:16px; left:16px; letter-spacing:1px; text-transform:uppercase;">{{ $kajian->category->name ?? 'Kajian' }}</span>
          <div class="kcard-save" style="position:absolute; top:16px; right:16px; width:32px; height:32px; background:rgba(255,255,255,0.2); backdrop-filter:blur(4px); border-radius:50%; display:flex; align-items:center; justify-content:center; color:#fff; cursor:pointer;">♥</div>
        </div>
        
        <div class="kcard-body" style="padding: 24px; display: flex; flex-direction: column; flex-grow: 1;">
          <h4 style="margin:0 0 8px; font-family:'Amiri',serif; font-size:24px; color:var(--jade-950); line-height:1.3;">{{ Str::limit($kajian->title, 40) }}</h4>
          <div class="ustadz" style="font-family:'Amiri',serif; font-size:16px; color:var(--jade-800); font-weight:700; margin-bottom:16px;">
              {{ $kajian->speaker->name ?? 'Ustadz' }}
          </div>
          
          <div class="kcard-meta" style="display:flex; flex-direction: column; gap:10px; font-size:14px; font-weight:600; color:var(--ink-soft); border-top:1px dashed var(--line); padding-top:16px; margin-bottom: 24px; margin-top: auto;">
              @php
                $cDate = \Carbon\Carbon::parse($kajian->start_at);
                $hari = ['Sunday'=>'Ahad','Monday'=>'Senin','Tuesday'=>'Selasa','Wednesday'=>'Rabu','Thursday'=>'Kamis','Friday'=>'Jumat','Saturday'=>'Sabtu'];
                $bulan = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
                $strHari = $hari[$cDate->format('l')];
                $strBulan = $bulan[$cDate->format('n') - 1];
                $tglIndo = $strHari . ', ' . $cDate->format('d') . ' ' . $strBulan;
              @endphp
              <div style="display: flex; gap: 8px; align-items: center;">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                  <span style="color:var(--jade-950);">{{ $tglIndo }}</span>
              </div>
              <div style="display: flex; gap: 8px; align-items: center;">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                  <span style="color:var(--jade-950);">{{ \Carbon\Carbon::parse($kajian->start_at)->format('H:i') }} WIB</span>
              </div>
              <div style="display: flex; gap: 8px; align-items: flex-start; margin-top: 2px;">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0; margin-top: 2px;"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                  <span style="line-height: 1.4; color:var(--jade-950);">{{ $kajian->mosque->name ?? 'Masjid' }}<br><span style="font-size: 13px; font-weight: 500; color:var(--ink-soft);">{{ Str::limit($kajian->mosque->address ?? '', 40) }}</span></span>
              </div>
          </div>
          
          <a href="{{ route('kajian.show', $kajian->slug) }}" style="display: block; text-align: center; background: var(--gold-pale); color: var(--gold-deep); padding: 12px; border-radius: 12px; text-decoration: none; font-weight: 700; font-size: 15px; transition: background 0.2s;" onmouseover="this.style.background='var(--gold)'; this.style.color='white';" onmouseout="this.style.background='var(--gold-pale)'; this.style.color='var(--gold-deep)';">Lihat Detail</a>
        </div>
      </div>
      @empty
      <div class="kcard" style="grid-column: 1 / -1; padding: 40px; text-align: center; background:var(--paper); border-radius:20px;">
          <p style="font-family:'Amiri',serif; font-size:20px; color:var(--jade-950);">Belum ada kajian minggu ini.</p>
      </div>
      @endforelse
    </div>
  </div>
</section>


<section style="padding-top:0">
  <div class="container">
    <div class="cta-band">
      <div>
        <h4>Mulai langkahmu mengikuti kajian.</h4>
        <p>Pendaftaran gratis. Mulai tingkatkan keimanan Anda hari ini.</p>
      </div>
      <div style="display:flex;gap:12px">
        <a href="{{ route('register') }}" class="btn btn-solid" style="color:var(--gold-pale)">Daftar Sekarang</a>
        <a href="{{ url('/kajian') }}" class="btn btn-outline">Cari Kajian</a>
      </div>
  </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    // Don't auto-request if we already have lat/lng or if user explicitly declined (we can use sessionStorage)
    if (!urlParams.has('lat') && !urlParams.has('lng') && !sessionStorage.getItem('location_declined')) {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                window.location.href = `/?lat=${lat}&lng=${lng}`;
            }, function(error) {
                console.log("Geolocation error:", error);
                sessionStorage.setItem('location_declined', 'true');
            });
        }
    }
});
</script>
@endsection
