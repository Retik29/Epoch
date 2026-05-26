<nav class="bg-white/95 backdrop-blur-md sticky top-0 z-50 border-b border-gray-100 shadow-sm" x-data="{ open: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <img src="{{ asset('build/assets/logo.jpg') }}" alt="Epoch Logo" class="w-8 h-8 rounded-lg object-cover shadow-sm">
                <span class="text-xl font-bold gradient-text">Epoch</span>
            </a>

            <!-- Desktop Nav -->
            <div class="hidden md:flex items-center gap-1">
                <a href="{{ route('home') }}" class="px-4 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 transition-all duration-200 {{ request()->routeIs('home') ? 'text-indigo-600 bg-indigo-50' : '' }}">
                    {{ __('messages.home') }}
                </a>
                <a href="{{ route('professionals.index') }}" class="px-4 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 transition-all duration-200 {{ request()->routeIs('professionals.*') ? 'text-indigo-600 bg-indigo-50' : '' }}">
                    {{ __('messages.professionals') }}
                </a>
                <a href="{{ route('contact') }}" class="px-4 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 transition-all duration-200 {{ request()->routeIs('contact') ? 'text-indigo-600 bg-indigo-50' : '' }}">
                    {{ __('messages.contact') }}
                </a>

                @auth
                    @if(auth()->user()->role === 'user')
                        <a href="{{ route('appointments.index') }}" class="px-4 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 transition-all duration-200 {{ request()->routeIs('appointments.*') ? 'text-indigo-600 bg-indigo-50' : '' }}">
                            {{ __('messages.my_appointments') }}
                        </a>
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 transition-all duration-200">
                            {{ __('messages.dashboard') }}
                        </a>
                    @elseif(auth()->user()->role === 'professional')
                        <a href="{{ route('professional.dashboard') }}" class="px-4 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 transition-all duration-200">
                            {{ __('messages.dashboard') }}
                        </a>
                    @elseif(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 transition-all duration-200">
                            Admin Panel
                        </a>
                    @endif
                @endauth
            </div>

            <!-- Right Side -->
            <div class="hidden md:flex items-center gap-3">
                <!-- Locale switcher -->
                <div class="flex items-center gap-1 text-xs">
                    <a href="{{ route('locale.switch', 'en') }}" class="px-2 py-1 rounded {{ app()->getLocale() === 'en' ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'text-gray-500 hover:text-gray-700' }} transition-all">EN</a>
                    <span class="text-gray-300">|</span>
                    <a href="{{ route('locale.switch', 'hi') }}" class="px-2 py-1 rounded {{ app()->getLocale() === 'hi' ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'text-gray-500 hover:text-gray-700' }} transition-all">हि</a>
                </div>

                @guest
                    <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-indigo-600 transition-colors">{{ __('messages.login') }}</a>
                    <a href="{{ route('register') }}" class="px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-sm font-semibold rounded-lg hover:from-indigo-700 hover:to-purple-700 shadow-sm hover:shadow-md transition-all duration-200">
                        {{ __('messages.register') }}
                    </a>
                @else
                    <div class="relative" x-data="{ userMenu: false }">
                        <button @click="userMenu = !userMenu" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-gray-100 transition-all">
                            <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" class="w-8 h-8 rounded-full object-cover ring-2 ring-indigo-200">
                            <span class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</span>
                            <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400"></i>
                        </button>
                        <div x-show="userMenu" @click.outside="userMenu = false" x-transition
                             class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50">
                            <div class="px-4 py-2 border-b border-gray-100">
                                <p class="text-xs text-gray-500 capitalize">{{ auth()->user()->role }}</p>
                            </div>
                            @if(auth()->user()->role === 'professional')
                                <a href="{{ route('professional.dashboard') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600">
                                    <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Dashboard
                                </a>
                            @elseif(auth()->user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600">
                                    <i data-lucide="shield" class="w-4 h-4"></i> Admin Panel
                                </a>
                            @else
                                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600">
                                    <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Dashboard
                                </a>
                                <a href="{{ route('appointments.index') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600">
                                    <i data-lucide="calendar" class="w-4 h-4"></i> My Appointments
                                </a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}" class="border-t border-gray-100 mt-1 pt-1">
                                @csrf
                                <button class="flex items-center gap-2 w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                    <i data-lucide="log-out" class="w-4 h-4"></i> {{ __('messages.logout') }}
                                </button>
                            </form>
                        </div>
                    </div>
                @endguest
            </div>

            <!-- Mobile hamburger -->
            <button @click="open = !open" class="md:hidden p-2 rounded-lg hover:bg-gray-100">
                <i data-lucide="menu" class="w-5 h-5" x-show="!open"></i>
                <i data-lucide="x" class="w-5 h-5" x-show="open" x-cloak></i>
            </button>
        </div>

        <div x-show="open" x-transition x-cloak class="md:hidden pb-4 border-t border-gray-100 pt-4 space-y-1">
            <a href="{{ route('home') }}" class="block px-4 py-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-indigo-50">Home</a>
            <a href="{{ route('professionals.index') }}" class="block px-4 py-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-indigo-50">Professionals</a>
            <a href="{{ route('contact') }}" class="block px-4 py-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-indigo-50 {{ request()->routeIs('contact') ? 'text-indigo-600 bg-indigo-50' : '' }}">{{ __('messages.contact') }}</a>
            @auth
                @if(auth()->user()->role === 'user')
                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-indigo-50">Dashboard</a>
                    <a href="{{ route('appointments.index') }}" class="block px-4 py-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-indigo-50">My Appointments</a>
                @elseif(auth()->user()->role === 'professional')
                    <a href="{{ route('professional.dashboard') }}" class="block px-4 py-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-indigo-50">Dashboard</a>
                @elseif(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-indigo-50">Admin Panel</a>
                @endif
                <form method="POST" action="{{ route('logout') }}" class="px-4">
                    @csrf
                    <button class="w-full mt-2 px-4 py-2 bg-red-50 text-red-600 text-sm font-medium rounded-lg">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block px-4 py-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-indigo-50">Login</a>
                <a href="{{ route('register') }}" class="block px-4 py-2 text-sm font-semibold text-indigo-600 bg-indigo-50 rounded-lg">Register</a>
            @endguest
        </div>
    </div>
</nav>
