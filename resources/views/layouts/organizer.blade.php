<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="view-transition" content="same-origin" />
    <meta name="layout" content="organizer" data-turbo-track="reload">

    <title>KajianKu - Penyelenggara</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Tom Select for searchable dropdowns -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F8F9FA;
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        
        .sidebar-bg {
            background-color: #0A2B20;
            background-image: radial-gradient(400px 400px at 50% -10%, rgba(184,134,59,.20), transparent 60%),
                              linear-gradient(180deg, #0A2B20 0%, #0C3B2A 55%, #0F5137 100%);
            position: relative;
        }
        .sidebar-pattern {
            position: absolute;
            inset: 0;
            opacity: 0.15;
            pointer-events: none;
            width: 100%;
            height: 100%;
        }
    </style>
</head>
<body class="antialiased text-gray-800 bg-[#F8F9FA]" 
      x-data="{ 
          expanded: localStorage.getItem('sidebar_expanded') === null ? true : localStorage.getItem('sidebar_expanded') === 'true', 
          mobileOpen: false,
          isMobile: window.innerWidth < 1024,
          logoutModalOpen: false 
      }"
      @resize.window="isMobile = window.innerWidth < 1024; if(!isMobile) { mobileOpen = false; }">
    <div class="h-screen overflow-hidden flex w-full relative">
    
    <!-- Mobile Backdrop -->
    <div x-show="isMobile && mobileOpen" 
         x-transition.opacity
         class="fixed inset-0 bg-gray-900/60 z-30" 
         @click="mobileOpen = false" 
         style="display: none;"></div>

    <!-- Sidebar -->
    <aside :class="isMobile ? (mobileOpen ? 'w-20 fixed inset-y-0 left-0 z-40' : 'hidden') : (expanded ? 'w-64 relative' : 'w-20 relative')" 
           class="sidebar-bg text-white transition-all duration-300 ease-in-out flex flex-col h-full shrink-0 overflow-visible z-20">
        
        <!-- Pattern SVG -->
        <svg class="sidebar-pattern" viewBox="0 0 256 1000" preserveAspectRatio="xMidYMid slice">
            <defs>
                <pattern id="star8" width="86" height="86" patternUnits="userSpaceOnUse" patternTransform="rotate(15)">
                    <g stroke="#E7C77E" stroke-width="1.5" fill="none">
                        <path d="M43 4 L57 22 L79 22 L64 40 L79 58 L57 58 L43 78 L29 58 L7 58 L22 40 L7 22 L29 22 Z"/>
                    </g>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#star8)"/>
        </svg>

        <div class="relative z-10 flex flex-col h-full">
            <!-- Logo Area -->
            <div class="h-16 flex items-center border-b border-white/10 transition-all duration-300" :class="(expanded && !isMobile) ? 'px-6 justify-start' : 'px-0 justify-center'">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-white text-[#0A2B20] flex items-center justify-center font-bold text-xl shadow-md shrink-0">
                        K
                    </div>
                    <h1 x-show="expanded && !isMobile" class="text-xl font-bold tracking-tight text-[#E7C77E] whitespace-nowrap">KajianKu</h1>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 overflow-y-auto py-6 space-y-3" :class="(expanded && !isMobile) ? 'px-4' : 'px-2'">
                <a href="{{ url('/organizer') }}" class="flex items-center py-3.5 text-sm font-medium transition-all duration-200 rounded-xl {{ request()->is('organizer') ? 'bg-white/15 text-white shadow-[0_8px_30px_rgb(0,0,0,0.12)] border border-white/10 ring-1 ring-white/5' : 'text-[#B7C9BE] hover:text-white hover:bg-white/10 hover:shadow-lg' }}" :class="(expanded && !isMobile) ? 'px-4 justify-start' : 'px-0 justify-center'">
                    <i data-lucide="layout-dashboard" class="w-5 h-5 shrink-0 {{ request()->is('organizer') ? 'text-[#E7C77E]' : '' }}" :class="(expanded && !isMobile) ? 'mr-3' : 'mr-0'"></i> 
                    <span x-show="expanded && !isMobile" class="whitespace-nowrap">Dashboard</span>
                </a>
                
                <a href="{{ route('organizer.kajian.index') }}" class="flex items-center py-3.5 text-sm font-medium transition-all duration-200 rounded-xl {{ request()->routeIs('organizer.kajian.*') ? 'bg-white/15 text-white shadow-[0_8px_30px_rgb(0,0,0,0.12)] border border-white/10 ring-1 ring-white/5' : 'text-[#B7C9BE] hover:text-white hover:bg-white/10 hover:shadow-lg' }}" :class="(expanded && !isMobile) ? 'px-4 justify-start' : 'px-0 justify-center'">
                    <i data-lucide="calendar-check" class="w-5 h-5 shrink-0 {{ request()->routeIs('organizer.kajian.*') ? 'text-[#E7C77E]' : '' }}" :class="(expanded && !isMobile) ? 'mr-3' : 'mr-0'"></i> 
                    <span x-show="expanded && !isMobile" class="whitespace-nowrap">Kelola Kajian</span>
                </a>
                
                <a href="{{ route('organizer.mosque.index') }}" class="flex items-center py-3.5 text-sm font-medium transition-all duration-200 rounded-xl {{ request()->routeIs('organizer.mosque.*') ? 'bg-white/15 text-white shadow-[0_8px_30px_rgb(0,0,0,0.12)] border border-white/10 ring-1 ring-white/5' : 'text-[#B7C9BE] hover:text-white hover:bg-white/10 hover:shadow-lg' }}" :class="(expanded && !isMobile) ? 'px-4 justify-start' : 'px-0 justify-center'">
                    <i data-lucide="map-pin" class="w-5 h-5 shrink-0 {{ request()->routeIs('organizer.mosque.*') ? 'text-[#E7C77E]' : '' }}" :class="(expanded && !isMobile) ? 'mr-3' : 'mr-0'"></i> 
                    <span x-show="expanded && !isMobile" class="whitespace-nowrap">Data Masjid</span>
                </a>

                <a href="{{ route('organizer.peserta.global') }}" class="flex items-center py-3.5 text-sm font-medium transition-all duration-200 rounded-xl {{ request()->routeIs('organizer.peserta.*') ? 'bg-white/15 text-white shadow-[0_8px_30px_rgb(0,0,0,0.12)] border border-white/10 ring-1 ring-white/5' : 'text-[#B7C9BE] hover:text-white hover:bg-white/10 hover:shadow-lg' }}" :class="(expanded && !isMobile) ? 'px-4 justify-start' : 'px-0 justify-center'">
                    <i data-lucide="users" class="w-5 h-5 shrink-0 {{ request()->routeIs('organizer.peserta.*') ? 'text-[#E7C77E]' : '' }}" :class="(expanded && !isMobile) ? 'mr-3' : 'mr-0'"></i> 
                    <span x-show="expanded && !isMobile" class="whitespace-nowrap">Daftar Peserta</span>
                </a>
                
                <a href="{{ route('organizer.profile.edit') }}" class="flex items-center py-3.5 text-sm font-medium transition-all duration-200 rounded-xl {{ request()->routeIs('organizer.profile.*') ? 'bg-white/15 text-white shadow-[0_8px_30px_rgb(0,0,0,0.12)] border border-white/10 ring-1 ring-white/5' : 'text-[#B7C9BE] hover:text-white hover:bg-white/10 hover:shadow-lg' }}" :class="(expanded && !isMobile) ? 'px-4 justify-start' : 'px-0 justify-center'">
                    <i data-lucide="user" class="w-5 h-5 shrink-0 {{ request()->routeIs('organizer.profile.*') ? 'text-[#E7C77E]' : '' }}" :class="(expanded && !isMobile) ? 'mr-3' : 'mr-0'"></i> 
                    <span x-show="expanded && !isMobile" class="whitespace-nowrap">Profil Penyelenggara</span>
                </a>
            </nav>

            <!-- Settings / Logout Area -->
            <div class="p-4 border-t border-white/10">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center py-3 text-sm font-medium text-[#B7C9BE] hover:text-white hover:bg-red-500/20 hover:shadow-md transition-all rounded-xl" :class="(expanded && !isMobile) ? 'px-4 justify-start' : 'px-0 justify-center'">
                        <i data-lucide="log-out" class="w-5 h-5 shrink-0" :class="(expanded && !isMobile) ? 'mr-3' : 'mr-0'"></i> 
                        <span x-show="expanded && !isMobile" class="whitespace-nowrap">Keluar</span>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0 h-full overflow-hidden w-full relative">
        
        <!-- Topbar -->
        <header class="h-16 px-4 lg:px-6 flex items-center justify-between shrink-0 bg-white border-b border-gray-200 relative z-20">
            <div class="flex items-center">
                <!-- Menu Button -->
                <button @click="if(isMobile) { mobileOpen = !mobileOpen; } else { expanded = !expanded; localStorage.setItem('sidebar_expanded', expanded); }" class="mr-4 p-2 text-gray-500 rounded-lg hover:bg-gray-100 transition-colors">
                    <i data-lucide="menu" class="w-6 h-6"></i>
                </button>
            </div>
            
            <div class="flex items-center space-x-4">
                <!-- Notifications -->
                <div x-data="{ notifOpen: false }" class="relative">
                    @php
                        $unreadNotifications = Auth::user()->unreadNotifications;
                        $unreadCount = $unreadNotifications->count();
                    @endphp
                    <button @click="notifOpen = !notifOpen" @click.outside="notifOpen = false" class="relative p-2 text-gray-400 hover:text-gray-600 transition-colors rounded-full hover:bg-gray-100">
                        <i data-lucide="bell" class="w-5 h-5"></i>
                        @if($unreadCount > 0)
                            <span class="absolute top-1.5 right-1.5 flex h-2.5 w-2.5">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-red-500 border-2 border-white"></span>
                            </span>
                        @endif
                    </button>

                    <div x-show="notifOpen" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-50"
                         style="display: none;">
                        <div class="px-4 py-2 border-b border-gray-100 flex justify-between items-center">
                            <h3 class="font-bold text-gray-900">Notifikasi</h3>
                            @if($unreadCount > 0)
                                <form action="{{ route('notifications.readAll') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-xs text-brand-emerald-600 hover:text-brand-emerald-800 font-medium">Tandai semua dibaca</button>
                                </form>
                            @endif
                        </div>
                        
                        <div class="max-h-96 overflow-y-auto">
                            @forelse(Auth::user()->notifications()->take(10)->get() as $notification)
                                <div class="px-4 py-3 border-b border-gray-50 hover:bg-gray-50 transition-colors {{ $notification->read_at ? 'opacity-60' : 'bg-brand-emerald-50/30' }}">
                                    <p class="text-sm text-gray-800">{!! $notification->data['message'] !!}</p>
                                    <div class="flex justify-between items-center mt-2">
                                        <span class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>
                                        @if(!$notification->read_at)
                                            <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="text-xs text-brand-emerald-600 font-medium hover:underline">Tandai dibaca</button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="px-4 py-6 text-center text-gray-500 text-sm">
                                    Belum ada notifikasi
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
                
                <!-- Profile -->
                <div class="flex items-center gap-3">
                    @php
                        $organizer = Auth::user()->organizer;
                        $avatarUrl = ($organizer && $organizer->logo) 
                            ? asset('storage/' . $organizer->logo) 
                            : 'https://ui-avatars.com/api/?name=' . urlencode($organizer->name ?? Auth::user()->name) . '&background=f3f4f6&color=111827';
                    @endphp
                    <img src="{{ $avatarUrl }}" class="w-9 h-9 rounded-full border border-gray-200 object-cover">
                    <div class="hidden md:block text-right">
                        <p class="text-sm font-bold text-gray-900 leading-none">{{ $organizer->name ?? Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500 mt-1">Penyelenggara</p>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 overflow-y-auto p-6 lg:p-8 bg-[#F8F9FA] min-w-0">
            <div class="max-w-[1400px] mx-auto w-full min-w-0">
                @if(session('success'))
                    <div class="mb-6 p-4 bg-emerald-50 text-emerald-800 rounded-lg flex items-center border border-emerald-100 text-sm font-medium">
                        <i data-lucide="check-circle-2" class="w-5 h-5 mr-3 text-emerald-500"></i>
                        {{ session('success') }}
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-50 text-red-800 rounded-lg flex items-center border border-red-100 text-sm font-medium">
                        <i data-lucide="alert-circle" class="w-5 h-5 mr-3 text-red-500"></i>
                        {{ session('error') }}
                    </div>
                @endif

                @if (isset($header))
                    <header class="mb-6">
                        <div class="text-xl font-bold text-gray-900">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                {{ $slot }}
            </div>
        </main>
    </div>

    </div>

    <script>
        lucide.createIcons();
    </script>
    @stack('scripts')
</body>
</html>
