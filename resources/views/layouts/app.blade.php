<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SAPTA') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="{{ asset('images/logo.ico') }}">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- AlpineJS -->
        <script src="//unpkg.com/alpinejs" defer></script>

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <style>
            :root {
                --sapta-primary: #4FA3E3;
                --sapta-accent: #2EC4B6;
                --sapta-secondary: #F4A261;
                --sapta-dark: #1E2A38;
                --sapta-light: #F8FAFC;
            }

            .sapta-gradient-bg {
                background: linear-gradient(135deg, var(--sapta-light) 0%, #EFF6FF 100%);
            }

            .sapta-header-gradient {
                background: linear-gradient(135deg, var(--sapta-primary) 0%, var(--sapta-accent) 100%);
            }

            /* Fix untuk hamburger menu */
            .hamburger-button {
                position: relative;
                z-index: 1000;
                cursor: pointer;
            }

            .mobile-sidebar {
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                z-index: 999;
                background: white;
                box-shadow: 0 10px 25px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            }

            .mobile-overlay {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.3);
                z-index: 998;
                display: none;
            }

            .mobile-overlay.active {
                display: block;
            }

            /* Smooth transitions */
            .mobile-sidebar {
                transition: all 0.3s ease-in-out;
            }

            /* Pastikan link bisa diklik */
            .mobile-sidebar a, .mobile-sidebar button {
                cursor: pointer;
                pointer-events: auto;
            }

            /* Fix untuk AlpineJS */
            [x-cloak] {
                display: none !important;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen sapta-gradient-bg" x-data="{ mobileMenuOpen: false }">
            <!-- Mobile Overlay -->
            <div class="mobile-overlay"
                 x-show="mobileMenuOpen"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="mobileMenuOpen = false">
            </div>

            <!-- Navigation -->
            <nav class="bg-white border-b border-gray-200 shadow-sm relative z-40">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <!-- Logo Section -->
                        <div class="flex items-center">
                            <div class="shrink-0 flex items-center">
                                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                                    <img src="{{ asset('images/logo.ico') }}" alt="SAPTA Logo" class="w-8 h-8">
                                    <span class="text-xl font-bold text-gray-900 hidden sm:block">SAPTA</span>
                                </a>
                            </div>

                            <!-- Desktop Navigation -->
                            <div class="hidden sm:ml-10 sm:flex sm:space-x-8">
                                <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" class="text-gray-900 hover:text-blue-600">
                                    <i class="fas fa-home mr-2"></i>Dashboard
                                </x-nav-link>
                                <x-nav-link href="{{ route('aspirasi.index') }}" :active="request()->routeIs('aspirasi.*')" class="text-gray-900 hover:text-blue-600">
                              <i class="fas fa-paper-plane mr-2"></i>Aspirasi
                                </x-nav-link>
                                 <x-nav-link href="{{ route('diskusi.index') }}" :active="request()->routeIs('diskusi.*')" class="text-gray-900 hover:text-blue-600">
                                 <i class="fas fa-comments mr-2"></i>Diskusi
                                </x-nav-link>
                            </div>
                        </div>

                        <!-- Desktop User Menu -->
                        <div class="hidden sm:flex sm:items-center sm:space-x-4">
                            <!-- Notifications -->


                            <!-- User Dropdown -->
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="flex items-center space-x-2 text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors duration-200">
                                        <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white text-sm font-semibold">
                                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                        </div>
                                        <span class="hidden md:block">{{ Auth::user()->name }}</span>
                                        <i class="fas fa-chevron-down text-xs"></i>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <x-dropdown-link :href="route('profile.edit')" class="flex items-center space-x-2">
                                        <i class="fas fa-user text-gray-400 w-4"></i>
                                        <span>Profile</span>
                                    </x-dropdown-link>



                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <x-dropdown-link :href="route('logout')"
                                                onclick="event.preventDefault();
                                                            this.closest('form').submit();"
                                                class="flex items-center space-x-2 text-red-600 hover:text-red-700">
                                            <i class="fas fa-sign-out-alt text-red-400 w-4"></i>
                                            <span>Log Out</span>
                                        </x-dropdown-link>
                                    </form>
                                </x-slot>
                            </x-dropdown>
                        </div>

                        <!-- Mobile Menu Button -->
                        <div class="flex items-center sm:hidden">
                            <button @click="mobileMenuOpen = !mobileMenuOpen"
                                    class="hamburger-button inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:text-blue-600 hover:bg-gray-50 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                                    :class="{ 'bg-gray-50 text-blue-600': mobileMenuOpen }">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{'hidden': mobileMenuOpen, 'block': !mobileMenuOpen }"
                                          class="block"
                                          stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{'hidden': !mobileMenuOpen, 'block': mobileMenuOpen }"
                                          class="hidden"
                                          stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Mobile Navigation Menu -->
                <div x-show="mobileMenuOpen"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-2"
                     class="mobile-sidebar sm:hidden border-t border-gray-200"
                     @click.away="mobileMenuOpen = false">

                    <div class="px-2 pt-2 pb-3 space-y-1 bg-white">
                        <!-- Mobile Navigation Links -->
                        <x-responsive-nav-link href="{{ route('dashboard') }}"
                                               :active="request()->routeIs('dashboard')"
                                               class="flex items-center space-x-3 px-4 py-3 rounded-lg">
                            <i class="fas fa-home w-5 text-gray-400"></i>
                            <span>Dashboard</span>
                        </x-responsive-nav-link>

                         <x-responsive-nav-link href="{{ route('aspirasi.index') }}"
                           :active="request()->routeIs('aspirasi.*')"
                           class="flex items-center space-x-3 px-4 py-3 rounded-lg">
                        <i class="fas fa-paper-plane w-5 text-gray-400"></i>
                        <span>Aspirasi</span>
                    </x-responsive-nav-link>

                    <x-responsive-nav-link href="{{ route('diskusi.index') }}"
                                        :active="request()->routeIs('diskusi.*')"
                                        class="flex items-center space-x-3 px-4 py-3 rounded-lg">
                        <i class="fas fa-comments w-5 text-gray-400"></i>
                        <span>Diskusi</span>
                    </x-responsive-nav-link>
                    </div>

                    <!-- Mobile User Section -->
                    <div class="pt-4 pb-3 border-t border-gray-200">
                        <div class="px-4 space-y-3">
                            <!-- User Info -->
                            <div class="flex items-center space-x-3 px-2 py-2">
                                <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                                    <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                                </div>
                            </div>

                            <!-- Mobile User Links -->
                            <div class="space-y-1">
                                <x-responsive-nav-link :href="route('profile.edit')"
                                                       class="flex items-center space-x-3 px-4 py-3 rounded-lg">
                                    <i class="fas fa-user w-5 text-gray-400"></i>
                                    <span>Profile</span>
                                </x-responsive-nav-link>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                            class="flex items-center space-x-3 w-full px-4 py-3 text-left text-sm font-medium text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition-colors duration-200"
                                            onclick="event.preventDefault(); this.closest('form').submit();">
                                        <i class="fas fa-sign-out-alt w-5 text-red-400"></i>
                                        <span>Log Out</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            @isset($header)

            @endisset

            <!-- Page Content -->
            <main class="flex-1">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 mt-16">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                        <div class="flex items-center space-x-3">
                            <img src="{{ asset('images/logo.ico') }}" alt="SAPTA Logo" class="w-6 h-6">
                            <div>
                                <span class="text-sm font-semibold text-gray-800">SAPTA</span>
                                <p class="text-xs text-gray-600">Sistem Aspirasi Publik Transparan</p>
                            </div>
                        </div>
                        <div class="text-sm text-gray-600 text-center md:text-right">
                            <p>&copy; {{ date('Y') }} SAPTA </p>
                         <p class="text-xs text-[#2EC4B6] mt-1">Setiap Suara Anda Bernilai dan Berdampak</p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>

        <script>
            // Additional JavaScript untuk memastikan hamburger menu berfungsi
            document.addEventListener('DOMContentLoaded', function() {
                console.log('SAPTA Dashboard loaded successfully');

                // Close mobile menu when clicking on a link
                const mobileLinks = document.querySelectorAll('.mobile-sidebar a, .mobile-sidebar button');
                mobileLinks.forEach(link => {
                    link.addEventListener('click', function() {
                        const alpineData = Alpine.$data(document.querySelector('[x-data]'));
                        if (alpineData && alpineData.mobileMenuOpen) {
                            alpineData.mobileMenuOpen = false;
                        }
                    });
                });

                // Prevent body scroll when mobile menu is open
                const observer = new MutationObserver(function(mutations) {
                    mutations.forEach(function(mutation) {
                        if (mutation.attributeName === 'class') {
                            const target = mutation.target;
                            const isMenuOpen = target.classList.contains('mobileMenuOpen');
                            document.body.style.overflow = isMenuOpen ? 'hidden' : '';
                        }
                    });
                });

                const navElement = document.querySelector('nav');
                if (navElement) {
                    observer.observe(navElement, { attributes: true });
                }
            });
        </script>
    </body>
</html>
