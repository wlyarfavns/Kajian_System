<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="view-transition" content="same-origin" />
        <meta name="layout" content="app" data-turbo-track="reload">

        <title>{{ config('app.name', 'Cari Kajian Terdekat') }}</title>

        <!-- Scripts & Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-white text-brand-ink">
        
        <!-- Top Contact Bar (Dark) -->
        <div class="hidden md:block bg-brand-emerald-950 text-brand-gold-soft py-2 px-6 border-b border-brand-emerald-900 text-xs font-semibold">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <div class="flex items-center space-x-6">
                    <span class="flex items-center"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg> +62 800 1234 567</span>
                    <span class="flex items-center"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg> info@kajiansystem.com</span>
                </div>
                <div class="flex items-center space-x-3 text-brand-gold">
                    <a href="#" class="hover:text-white transition"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg></a>
                    <a href="#" class="hover:text-white transition"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>
                </div>
            </div>
        </div>

        <!-- Desktop Navbar -->
        <nav class="hidden md:flex bg-white shadow-sm border-b border-brand-border-light py-4 px-6 items-center justify-between sticky top-0 z-40">
            <div class="max-w-7xl mx-auto w-full flex items-center justify-between">
                <div class="flex items-center space-x-12">
                    <a href="{{ url('/') }}" class="flex items-center text-brand-emerald-950">
                        <svg class="w-8 h-8 mr-2 text-brand-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        <span class="font-serif font-bold text-2xl tracking-tight">Kajian<span class="text-brand-gold-text">System</span></span>
                    </a>
                    
                    <div class="hidden lg:flex items-center space-x-8 text-sm font-bold text-brand-ink-soft">
                        <a href="{{ url('/') }}" class="text-brand-gold-text">Beranda</a>
                        <a href="#about" class="hover:text-brand-emerald-700">Tentang Kami</a>
                        <a href="{{ url('/kajian') }}" class="hover:text-brand-emerald-700">Jadwal Kajian</a>
                        <a href="#how-it-works" class="hover:text-brand-emerald-700">Cara Kerja</a>
                        <a href="#testimonials" class="hover:text-brand-emerald-700">Testimoni</a>
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    @auth
                        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'organizer')
                            <a href="{{ url('/'.auth()->user()->role) }}" class="text-sm font-bold text-brand-emerald-700 hover:text-brand-emerald-900 mr-4">Dashboard</a>
                        @endif
                        <a href="{{ route('profile.edit') }}" class="text-sm font-bold text-brand-ink hover:text-brand-emerald-700 mr-4">Profil</a>
                    @else
                        <a href="{{ url('/admin') }}" class="text-xs font-semibold text-gray-400 hover:text-brand-emerald-700 mr-2">Admin</a>
                        <a href="{{ route('login') }}" class="text-sm font-bold text-brand-emerald-950 hover:text-brand-emerald-700 mr-4">Masuk</a>
                        <a href="{{ route('register') }}" class="bg-brand-emerald-700 text-white px-6 py-2.5 rounded-full font-bold shadow-sm hover:bg-brand-emerald-900 transition">Daftar Sekarang <span class="ml-1">></span></a>
                    @endauth
                </div>
            </div>
        </nav>

        <!-- Mobile Header Simpel -->
        <header class="md:hidden bg-brand-emerald-950 text-white px-4 py-4 flex items-center justify-between sticky top-0 z-40 shadow-md">
            <div>
                <a href="{{ url('/') }}" class="font-serif font-bold text-xl leading-tight tracking-tight flex items-center">
                    <svg class="w-5 h-5 mr-1 text-brand-gold-soft" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    Kajian<span class="text-brand-gold-soft">System</span>
                </a>
            </div>
            <div class="flex items-center space-x-3">
                @guest
                    <a href="{{ route('login') }}" class="text-xs font-semibold text-brand-emerald-300">Masuk</a>
                @endguest
                <a href="{{ route('profile.edit') }}" class="w-8 h-8 rounded-full bg-brand-emerald-700 flex items-center justify-center border-2 border-brand-emerald-500 overflow-hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-white">
                        <path d="M10 8a3 3 0 100-6 3 3 0 000 6zM3.465 14.493a1.23 1.23 0 00.41 1.412A9.957 9.957 0 0010 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 00-13.074.003z" />
                    </svg>
                </a>
            </div>
        </header>

        <!-- Main Content -->
        <main class="min-h-screen bg-white">
            @yield('content', $slot ?? '')
        </main>

        <!-- Bottom Navigation (Mobile) -->
        @include('components.bottom-navigation')

    </body>
</html>
