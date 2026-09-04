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

            <!-- Profile & Settings / Logout Area -->
            <div class="p-4 border-t border-white/10 flex flex-col gap-2">
                <!-- Profile -->
                <div class="flex items-center gap-3 py-2" :class="(expanded && !isMobile) ? 'px-2 justify-start' : 'px-0 justify-center'">
                    @php
                        $organizer = Auth::user()->organizer;
                    @endphp
                    @if($organizer && $organizer->logo)
                        <img src="{{ asset('storage/' . $organizer->logo) }}" class="w-10 h-10 rounded-full border border-white/20 object-cover shrink-0">
                    @else
                        <div class="w-10 h-10 rounded-full border border-white/20 bg-white/10 flex items-center justify-center shrink-0">
                            <i data-lucide="user" class="w-5 h-5 text-[#E7C77E]"></i>
                        </div>
                    @endif
                    <div x-show="expanded && !isMobile" class="text-left overflow-hidden">
                        <p class="text-sm font-bold text-white leading-none truncate">{{ $organizer->name ?? Auth::user()->name }}</p>
                        <p class="text-xs text-[#B7C9BE] mt-1">Penyelenggara</p>
                    </div>
                </div>

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
