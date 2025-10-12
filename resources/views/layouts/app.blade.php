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
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen sapta-gradient-bg">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow-lg border-b border-gray-200/50">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="flex-1">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 mt-auto">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <div class="flex items-center space-x-2 mb-4 md:mb-0">
                            <img src="{{ asset('images/logo.ico') }}" alt="SAPTA Logo" class="w-6 h-6">
                            <span class="text-sm font-semibold text-gray-700">SAPTA</span>
                        </div>
                        <div class="text-sm text-gray-600 text-center md:text-right">
                            <p>Sistem Aspirasi Publik Transparan dan Akuntabel &copy; {{ date('Y') }}</p>
                            <p class="text-xs text-gray-500 mt-1">Setiap Suara Anda Bernilai dan Berdampak</p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
