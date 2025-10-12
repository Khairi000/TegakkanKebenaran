<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="flex items-center">
                <!-- Logo SAPTA -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-[#4FA3E3] to-[#2EC4B6] rounded-xl flex items-center justify-center shadow-md">
                            <img src="{{ asset('images/logo.ico') }}" alt="SAPTA Logo" class="w-6 h-6">
                        </div>
                        <div class="hidden sm:block">
                            <span class="font-bold text-lg text-[#1E2A38]">SAPTA</span>
                            <span class="block text-xs text-gray-500 -mt-1">Aspirasi Publik</span>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            <span>{{ __('Dashboard') }}</span>
                        </div>
                    </x-nav-link>

                    <!-- Tambahan menu lainnya bisa ditambahkan di sini -->
                    <x-nav-link :href="route('aspirasi.index')" :active="request()->routeIs('aspirasi.*')">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <span>Aspirasi</span>
                        </div>
                    </x-nav-link>

                    <x-nav-link :href="route('diskusi.index')" :active="request()->routeIs('diskusi.*')">
                    <div class="flex items-center space-x-2">
                        <!-- Ikon Diskusi / Chat -->
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 10h8m-8 4h5m-6 8l-2.5-2.5A2 2 0 014 17V7a2 2 0 012-2h12a2 2 0 012 2v10a2 2 0 01-2 2H9l-2 3z" />
                        </svg>
                        <span>Diskusi</span>
                    </div>
                </x-nav-link>

                </div>
            </div>

            <!-- User Info + Logout -->
            <div class="hidden sm:flex sm:items-center gap-4">
                <!-- User Info -->
                <div class="flex items-center space-x-3 bg-gray-50 px-4 py-2 rounded-full border border-gray-200">
                    <div class="w-8 h-8 bg-gradient-to-r from-[#4FA3E3] to-[#2EC4B6] rounded-full flex items-center justify-center shadow-sm">
                        <span class="text-white text-xs font-semibold">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </span>
                    </div>
                    <div class="text-sm">
                        <div class="font-medium text-gray-800">{{ Auth::user()->name }}</div>
                        <div class="text-xs text-gray-500 capitalize">
                            @if(auth()->user()->isUser())
                                User
                            @elseif(auth()->user()->isAdmin())
                                Administrator
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Logout Button -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex items-center space-x-2 bg-red-500 hover:bg-red-600 text-white text-sm px-4 py-2 rounded-lg shadow transition duration-200 hover:shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>

            <!-- Hamburger (mobile) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:text-[#4FA3E3] hover:bg-gray-50
                               focus:outline-none focus:bg-gray-50 focus:text-[#4FA3E3] transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }"
                              class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }"
                              class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-t border-gray-200">
        <div class="pt-2 pb-3 space-y-1">
            <!-- Dashboard Mobile -->
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                <div class="flex items-center space-x-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>{{ __('Dashboard') }}</span>
                </div>
            </x-responsive-nav-link>

            <!-- Aspirasi Mobile -->
            <x-responsive-nav-link :href="route('aspirasi.index')" :active="request()->routeIs('aspirasi.*')">
                <div class="flex items-center space-x-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span>Aspirasi</span>
                </div>
            </x-responsive-nav-link>
        </div>

        <!-- Responsive User + Logout -->
        <div class="pt-4 pb-3 border-t border-gray-200 bg-gray-50">
            <div class="px-4 py-3">
                <!-- User Avatar & Info -->
                <div class="flex items-center space-x-3 mb-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-[#4FA3E3] to-[#2EC4B6] rounded-full flex items-center justify-center shadow-sm">
                        <span class="text-white text-sm font-semibold">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="font-medium text-gray-800 truncate">{{ Auth::user()->name }}</div>
                        <div class="text-sm text-gray-500 truncate">{{ Auth::user()->email }}</div>
                        <div class="text-xs text-gray-400 capitalize mt-1">
                            @if(auth()->user()->isUser())
                                Role: Masyarakat
                            @elseif(auth()->user()->isAdmin())
                                Role: Administrator
                            @else
                                Role: Pengguna
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-2 space-y-1">
                <!-- Profile Link -->
                <x-responsive-nav-link :href="route('profile.edit')">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span>{{ __('Profile') }}</span>
                    </div>
                </x-responsive-nav-link>

                <!-- Logout Form -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex items-center space-x-3 w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-red-50 border-t border-gray-200 transition duration-150">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span class="font-medium">{{ __('Keluar') }}</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
