@extends('layouts.landing')

@section('content')
    <div class="min-h-screen bg-jade-950 flex flex-col items-center justify-center p-4">
        <div class="max-w-md w-full bg-parchment rounded-3xl p-8 shadow-2xl border border-gold/20 text-center">
            
            <div class="w-20 h-20 bg-jade-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-jade-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>

            <h1 class="font-fraunces text-2xl font-bold text-jade-950 mb-3">Akun Belum Diverifikasi</h1>
            
            <p class="text-ink-soft text-sm mb-6 leading-relaxed">
                Pendaftaran lembaga Anda telah kami terima. Saat ini, tim admin Pusat sedang meninjau dan memverifikasi data penyelenggara Anda. Proses ini mungkin memakan waktu 1-2 hari kerja.
            </p>

            <div class="bg-gold/10 rounded-xl p-4 mb-8 text-left border border-gold/20">
                <h3 class="font-bold text-jade-900 text-sm mb-1">Apa selanjutnya?</h3>
                <ul class="text-sm text-ink-soft list-disc list-inside space-y-1">
                    <li>Kami akan memeriksa keabsahan data lembaga.</li>
                    <li>Setelah diverifikasi, Anda akan mendapatkan akses penuh ke Pusat Penyelenggara.</li>
                    <li>Anda bisa keluar (logout) dan mencoba masuk kembali nanti.</li>
                </ul>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full bg-jade-900 text-parchment font-bold py-3 px-4 rounded-xl hover:bg-jade-800 transition shadow-lg" style="width: 100%; background: var(--jade-900); color: var(--parchment); font-weight: 700; padding: 12px 16px; border-radius: 12px; border: none; cursor: pointer;">
                    Keluar / Logout
                </button>
            </form>

        </div>
    </div>
@endsection
