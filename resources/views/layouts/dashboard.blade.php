<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — Epoch</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        brand: { 50:'#eef2ff', 100:'#e0e7ff', 200:'#c7d2fe', 500:'#6366f1', 600:'#4f46e5', 700:'#4338ca', 800:'#3730a3', 900:'#312e81' }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .gradient-text { background: linear-gradient(135deg, #6366f1, #8b5cf6); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }

        /* Sidebar transition */
        .sidebar { transition: width 0.25s ease, transform 0.25s ease; }
        .sidebar-collapsed { width: 0 !important; overflow: hidden; }

        /* Sidebar links — shown when expanded */
        .sidebar-link {
            display: flex; align-items: center; gap: 0.75rem;
            padding: 0.625rem 1rem; border-radius: 0.75rem;
            font-size: 0.875rem; font-weight: 500; color: #4b5563;
            transition: all 0.15s ease; white-space: nowrap;
        }
        .sidebar-link:hover { background: #eef2ff; color: #4f46e5; }
        .sidebar-link.active { background: #eef2ff; color: #4f46e5; font-weight: 600; }

        /* Overlay for mobile */
        .sidebar-overlay { display: none; }
        @media (max-width: 767px) {
            .sidebar-overlay.active { display: block; }
        }

        [x-cloak] { display: none !important; }
    </style>
    @stack('head')
</head>
<body class="bg-gray-50 text-gray-900 antialiased" x-data="dashboardApp()" x-init="init()">

<!-- Mobile overlay -->
<div class="sidebar-overlay fixed inset-0 bg-black/40 z-30 backdrop-blur-sm"
     :class="{ 'active': sidebarOpen }"
     @click="closeSidebar()"
     x-show="sidebarOpen && isMobile"
     x-cloak>
</div>

<div class="flex h-screen overflow-hidden">

    {{-- ═══════════════════ SIDEBAR ═══════════════════ --}}
    <aside id="app-sidebar"
           class="sidebar fixed md:relative z-40 flex flex-col bg-white border-r border-gray-100 shadow-sm h-full flex-shrink-0 overflow-hidden"
           :style="sidebarOpen ? 'width: 256px' : (isMobile ? 'width: 0px' : 'width: 72px')"
           :class="{ 'shadow-2xl': sidebarOpen && isMobile }">

        {{-- Logo area --}}
        <div class="flex items-center border-b border-gray-100 flex-shrink-0 overflow-hidden"
             :class="sidebarOpen ? 'gap-3 px-5 py-4 justify-between' : 'px-0 py-4 justify-center'">

            {{-- Logo (always visible on desktop collapsed) --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2 min-w-0 flex-shrink-0">
                <img src="{{ asset('build/assets/logo.jpg') }}" alt="Epoch Logo" class="w-8 h-8 rounded-lg object-cover flex-shrink-0 shadow-sm">
                <span class="font-bold text-lg gradient-text whitespace-nowrap transition-all duration-200"
                      x-show="sidebarOpen" x-cloak>Epoch</span>
            </a>

            {{-- Close arrow (expanded only) --}}
            <button @click="toggleSidebar()"
                    class="p-1.5 rounded-lg text-gray-400 hover:bg-gray-100 hover:text-gray-700 transition-all flex-shrink-0"
                    x-show="sidebarOpen" x-cloak title="Collapse sidebar">
                <i data-lucide="chevron-left" class="w-4 h-4"></i>
            </button>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 py-4 space-y-1 overflow-y-auto overflow-x-hidden"
             :class="sidebarOpen ? 'px-3' : 'px-2'">

            {{-- When collapsed (desktop only): show icon-only buttons --}}
            <div x-show="!sidebarOpen && !isMobile" x-cloak class="space-y-1">
                @yield('sidebar_icons')
            </div>

            {{-- Full nav links (expanded) --}}
            <div x-show="sidebarOpen">
                @yield('sidebar')
            </div>
        </nav>

        {{-- User Profile + Logout --}}
        <div class="border-t border-gray-100 flex-shrink-0 overflow-hidden"
             :class="sidebarOpen ? 'p-3' : 'p-2'">

            {{-- EXPANDED: full profile card with logout --}}
            <div x-show="sidebarOpen" x-cloak>
                <div class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 border border-gray-100">
                    <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}"
                         class="w-9 h-9 rounded-full object-cover flex-shrink-0 ring-2 ring-white shadow-sm">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-800 truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500 capitalize">{{ auth()->user()->role }}</p>
                    </div>
                    {{-- Logout icon button inside card --}}
                    <form method="POST" action="{{ route('logout') }}" class="flex-shrink-0">
                        @csrf
                        <button type="submit"
                                class="p-1.5 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition-all"
                                title="Logout">
                            <i data-lucide="log-out" class="w-4 h-4"></i>
                        </button>
                    </form>
                </div>
            </div>

            {{-- COLLAPSED (desktop): avatar-only button that acts as a logout anchor --}}
            <div x-show="!sidebarOpen && !isMobile" x-cloak>
                <div class="flex flex-col items-center gap-2">
                    <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}"
                         class="w-8 h-8 rounded-full object-cover ring-2 ring-white shadow-sm cursor-pointer"
                         title="{{ auth()->user()->name }} ({{ auth()->user()->role }})">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="w-8 h-8 rounded-xl flex items-center justify-center text-gray-400 hover:text-red-600 hover:bg-red-50 transition-all"
                                title="Logout">
                            <i data-lucide="log-out" class="w-3.5 h-3.5"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </aside>

    {{-- ═══════════════════ MAIN CONTENT ═══════════════════ --}}
    <div class="flex-1 flex flex-col overflow-hidden min-w-0">

        {{-- Topbar --}}
        <header class="bg-white border-b border-gray-100 px-4 sm:px-6 py-3.5 flex items-center gap-4 z-20 relative flex-shrink-0">

            {{-- Hamburger / Toggle --}}
            <button @click="toggleSidebar()"
                    class="p-2 rounded-xl text-gray-500 hover:bg-gray-100 hover:text-gray-800 transition-all flex-shrink-0 focus:outline-none focus:ring-2 focus:ring-brand-500"
                    :title="sidebarOpen ? 'Collapse sidebar' : 'Expand sidebar'"
                    id="sidebar-toggle">
                <i data-lucide="menu" class="w-5 h-5" x-show="!sidebarOpen"></i>
                <i data-lucide="x" class="w-5 h-5" x-show="sidebarOpen" x-cloak></i>
            </button>

            <h1 class="text-lg font-bold text-gray-800 flex-1 truncate">@yield('page_title', 'Dashboard')</h1>

            <div class="flex items-center gap-3 flex-shrink-0">
                <span class="text-xs text-gray-400 hidden sm:block">{{ now()->format('D, d M Y') }}</span>

                {{-- Quick user chip (topbar) --}}
                <div class="flex items-center gap-2 bg-gray-50 border border-gray-100 rounded-xl px-3 py-1.5 cursor-default">
                    <img src="{{ auth()->user()->avatar_url }}" class="w-6 h-6 rounded-full object-cover" alt="">
                    <span class="text-xs font-semibold text-gray-700 hidden sm:block truncate max-w-[120px]">
                        {{ auth()->user()->name }}
                    </span>
                </div>
            </div>
        </header>

        {{-- Page content --}}
        <main class="flex-1 overflow-y-auto p-4 sm:p-6">
            @include('partials._flash')
            @yield('content')
        </main>
    </div>
</div>

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script>
function dashboardApp() {
    return {
        sidebarOpen: false,
        isMobile: false,

        init() {
            this.isMobile = window.innerWidth < 768;
            // Desktop: start expanded; Mobile: start collapsed
            this.sidebarOpen = !this.isMobile;

            // Restore user preference from localStorage
            const saved = localStorage.getItem('epoch_sidebar');
            if (saved !== null && !this.isMobile) {
                this.sidebarOpen = saved === 'true';
            }

            window.addEventListener('resize', () => {
                const wasMobile = this.isMobile;
                this.isMobile = window.innerWidth < 768;
                if (!wasMobile && this.isMobile) this.sidebarOpen = false;
                if (wasMobile && !this.isMobile) this.sidebarOpen = true;
            });

            this.$nextTick(() => lucide.createIcons());
        },

        toggleSidebar() {
            this.sidebarOpen = !this.sidebarOpen;
            if (!this.isMobile) {
                localStorage.setItem('epoch_sidebar', this.sidebarOpen);
            }
            this.$nextTick(() => lucide.createIcons());
        },

        closeSidebar() {
            this.sidebarOpen = false;
        }
    }
}
</script>
<script>lucide.createIcons();</script>
@stack('scripts')
</body>
</html>

