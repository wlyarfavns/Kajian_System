@extends('layouts.landing')

@section('content')
<div class="container" style="padding-top:40px; padding-bottom:40px; min-height: 40vh;">
    
    <div style="margin-bottom:40px; text-align:center;">
        <h2 style="font-family:'Fraunces',serif; font-size:36px; font-weight:600; color:var(--jade-950); margin:0 0 10px;">
            Kajian <em style="color:var(--gold); font-style:italic;">Saya</em>
        </h2>
        <p style="color:var(--ink-soft); font-size:15px; margin:0;">Daftar kajian yang telah Anda daftar untuk dihadiri.</p>
    </div>

    <!-- Search Form -->
    <form action="{{ url('/kajian-saya') }}" method="GET" style="margin-bottom:40px;">
        <div style="display:flex; align-items:center; background:var(--paper); border:1px solid var(--line); border-radius:99px; padding:6px 6px 6px 20px; max-width:600px; margin:0 auto; box-shadow:0 10px 25px rgba(10,43,32,0.05);">
            <svg style="width:20px; height:20px; color:var(--ink-soft);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            <input type="search" id="searchInput" name="q" value="{{ request('q') }}" oninput="clearTimeout(this.delay); this.delay = setTimeout(() => this.form.requestSubmit(), 500);" style="flex:1; background:transparent; border:none; outline:none; padding:10px 14px; font-size:15px; color:var(--ink);" placeholder="Cari judul kajian Anda...">
            <button type="submit" class="btn btn-solid" style="padding:10px 24px;">Cari</button>
        </div>
    </form>

    <!-- Results List -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($attendances as $attendance)
            <x-kajian-card :kajian="$attendance->kajian" :attendanceStatus="$attendance->status" />
        @empty
            <div style="grid-column: 1 / -1; text-align:center; padding:60px 20px; background:var(--paper); border:1px solid var(--line); border-radius:24px; box-shadow:var(--shadow);">
                <div style="width:64px; height:64px; background:rgba(184,134,59,.1); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px; color:var(--gold);">
                    <svg style="width:32px; height:32px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <h4 style="font-family:'Fraunces',serif; font-size:22px; color:var(--jade-950); margin:0 0 10px;">Belum Mendaftar Kajian</h4>
                <p style="color:var(--ink-soft); font-size:14px; margin:0 0 24px;">Anda belum mendaftar untuk menghadiri kajian manapun.</p>
                <a href="{{ url('/kajian') }}" class="btn btn-solid">
                    Jelajahi Kajian
                </a>
            </div>
        @endforelse
    </div>
    
    <!-- Pagination -->
    <div style="margin-top:50px;">
        {{ $attendances->links() }}
    </div>

</div>
@endsection
