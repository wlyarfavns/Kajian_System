@extends('layouts.app')

@section('content')
<div class="px-4 md:px-6 pt-6 pb-20 bg-brand-cream min-h-screen">
    
    <div class="mb-8 border-b border-brand-border-light pb-4">
        <h2 class="text-3xl font-serif text-brand-ink leading-tight mb-2">
            Kajian <span class="italic text-brand-gold-text">Saya</span>
        </h2>
        <p class="text-brand-ink-soft text-sm">Daftar kajian yang telah Anda daftar untuk dihadiri.</p>
    </div>

    <!-- Results List -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
        @forelse($kajians as $kajian)
            <x-kajian-card :kajian="$kajian" />
        @empty
            <div class="col-span-full bg-white border border-brand-border-light rounded-3xl p-8 text-center shadow-sm">
                <div class="w-16 h-16 bg-brand-cream rounded-full flex items-center justify-center mx-auto mb-4 text-brand-gold">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <h4 class="font-bold text-brand-emerald-950 mb-2">Belum Mendaftar Kajian</h4>
                <p class="text-brand-ink-soft text-sm mb-4">Anda belum mendaftar untuk menghadiri kajian manapun.</p>
                <a href="{{ url('/kajian') }}" class="inline-block bg-brand-emerald-900 text-white font-semibold text-sm px-5 py-2.5 rounded-full hover:bg-brand-emerald-950 transition">
                    Jelajahi Kajian
                </a>
            </div>
        @endforelse
    </div>
    
    @if(method_exists($kajians, 'links'))
    <!-- Pagination -->
    <div class="mt-4">
        {{ $kajians->links() }}
    </div>
    @endif

</div>
@endsection
