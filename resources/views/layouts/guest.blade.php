<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
      <meta name="csrf-token" content="{{ csrf_token() }}">

      <title>{{ config('app.name', 'SAPTA') }}</title>

      <!-- Fonts -->
      <link rel="preconnect" href="https://fonts.bunny.net">
      <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

      <!-- Scripts -->
      @vite(['resources/css/app.css', 'resources/js/app.js'])

      <style>
        :root {
          --primary: #3487c7;
          --secondary: #FFFFFF;
          --accent: #2EC4B6;
          --text-dark: #1E2A38;
          --accent-secondary: #F4A261;
        }

        * {
          box-sizing: border-box;
        }

        body {
          background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
          min-height: 100vh;
          min-height: 100dvh; /* Dynamic viewport height for mobile */
          display: flex;
          align-items: center;
          justify-content: center;
          font-family: 'Figtree', sans-serif;
          padding: 1rem;
          margin: 0;
        }

        .login-card {
          background: rgba(255, 255, 255, 0.95);
          backdrop-filter: blur(10px);
          -webkit-backdrop-filter: blur(10px); /* Safari support */
          border-radius: 1.25rem;
          box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
          padding: 1.5rem;
          width: 100%;
          max-width: min(450px, 90vw);
          color: var(--text-dark);
          border: 1px solid rgba(255, 255, 255, 0.4);
          transition: all 0.3s ease;
        }

        /* Tablet */
        @media (min-width: 640px) {
          .login-card {
            padding: 2rem;
            border-radius: 1.5rem;
          }
        }

        /* Desktop */
        @media (min-width: 1024px) {
          .login-card {
            padding: 2.5rem;
            border-radius: 1.75rem;
          }

          .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
          }
        }

        /* Mobile Landscape */
        @media (max-height: 600px) and (orientation: landscape) {
          body {
            padding: 0.5rem;
            align-items: flex-start;
          }

          .login-card {
            margin: 1rem 0;
            max-width: min(400px, 95vw);
          }
        }

        .logo {
          text-align: center;
          margin-bottom: 1.25rem;
        }

        @media (min-width: 640px) {
          .logo {
            margin-bottom: 1.5rem;
          }
        }

        .logo img {
          width: 60px;
          height: 60px;
          border-radius: 50%;
          object-fit: cover;
          box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        @media (min-width: 640px) {
          .logo img {
            width: 80px;
            height: 80px;
          }
        }

        h2 {
          font-size: 1.375rem;
          font-weight: 600;
          text-align: center;
          margin-bottom: 0.5rem;
          color: var(--text-dark);
          line-height: 1.3;
        }

        @media (min-width: 640px) {
          h2 {
            font-size: 1.75rem;
          }
        }

        p {
          text-align: center;
          color: #6b7280;
          margin-bottom: 1rem;
          line-height: 1.5;
          font-size: 0.875rem;
        }

        @media (min-width: 640px) {
          p {
            font-size: 1rem;
            margin-bottom: 1.5rem;
          }
        }

        .sapta-tagline {
          text-align: center;
          margin-top: 0.75rem;
          font-size: 0.8rem;
          color: var(--primary);
          font-weight: 500;
        }

        @media (min-width: 640px) {
          .sapta-tagline {
            font-size: 0.9rem;
            margin-top: 1rem;
          }
        }

        /* Touch device improvements */
        @media (pointer: coarse) {
          .login-card {
            backdrop-filter: none; /* Improve performance on mobile */
          }

          input, button {
            font-size: 16px; /* Prevent zoom on iOS */
          }
        }

        /* High contrast support */
        @media (prefers-contrast: high) {
          .login-card {
            background: white;
            border: 2px solid var(--text-dark);
          }
        }

        /* Reduced motion support */
        @media (prefers-reduced-motion: reduce) {
          .login-card {
            transition: none;
          }
        }
      </style>
  </head>

  <body>
    <div class="login-card">
      <!-- Logo -->


      <!-- Header Content -->
      <h2>Selamat Datang di SAPTA</h2>
      <p>Sistem Aspirasi Publik Transparan dan Akuntabel</p>
      <p class="sapta-tagline">Setiap Suara Anda Bernilai dan Berdampak</p>

      <!-- Slot Content -->
      {{ $slot }}

      <!-- Mobile Footer -->
      <div class="mt-6 text-center sm:hidden">
        <p class="text-xs text-gray-500">
          Platform Aspirasi Digital Berbasis Blockchain
        </p>
      </div>
    </div>
  </body>
</html>
