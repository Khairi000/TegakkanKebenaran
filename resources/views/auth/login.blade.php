<x-guest-layout>
  <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-100 to-indigo-200 px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white/40 backdrop-blur-xl rounded-2xl shadow-2xl p-6 sm:p-8 md:p-10 w-full max-w-md border border-white/50 transition-all duration-300 hover:shadow-2xl">

      <!-- Logo dan Header -->
      <div class="flex flex-col items-center mb-6 sm:mb-8">
        <div class="logo mb-4">
          <img src="{{ asset('images/logo.ico') }}" alt="SAPTA Logo"
               class="w-16 h-16 sm:w-20 sm:h-20 rounded-full shadow-lg">
        </div>
        <h2 class="text-xl sm:text-2xl font-bold text-gray-800 text-center">Login</h2>
      </div>

      <!-- Session Status -->
      @if (session('status'))
        <div class="mb-4 p-3 rounded-lg bg-green-50 border border-green-200 text-green-700 text-sm font-medium text-center">
          {{ session('status') }}
        </div>
      @endif

      <!-- Error Message -->
      @if ($errors->any())
        <div class="mb-4 p-3 rounded-lg bg-red-50 border border-red-200 text-red-600 text-sm font-medium text-center">
          Email atau password salah.
        </div>
      @endif

      <!-- Form Login -->
      <form method="POST" action="{{ route('login') }}" class="space-y-4 sm:space-y-6">
        @csrf

        <!-- Email Input -->
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
          <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
            class="w-full px-4 py-3 text-sm sm:text-base rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none transition duration-200 placeholder-gray-400"
            placeholder="Masukkan email anda">
          <x-input-error :messages="$errors->get('email')" class="mt-1 text-red-500 text-xs sm:text-sm" />
        </div>

        <!-- Password Input -->
        <div>
          <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
          <input id="password" type="password" name="password" required
            class="w-full px-4 py-3 text-sm sm:text-base rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none transition duration-200 placeholder-gray-400"
            placeholder="Masukkan password anda">
          <x-input-error :messages="$errors->get('password')" class="mt-1 text-red-500 text-xs sm:text-sm" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between space-y-3 sm:space-y-0">
          <label for="remember_me" class="flex items-center space-x-2 text-sm text-gray-600 cursor-pointer">
            <input id="remember_me" type="checkbox" name="remember"
              class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 w-4 h-4">
            <span class="text-xs sm:text-sm">Ingat saya</span>
          </label>
          @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}"
               class="text-xs sm:text-sm text-indigo-600 hover:text-indigo-800 transition duration-200 font-medium">
              Lupa password?
            </a>
          @endif
        </div>

        <!-- Submit Button -->
        <button type="submit"
          class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-4 rounded-xl shadow-lg transition duration-300 transform hover:-translate-y-0.5 active:translate-y-0 text-sm sm:text-base">
          Masuk
        </button>

        <!-- Register Link -->
        <div class="text-center pt-4 border-t border-gray-200">
          <p class="text-xs sm:text-sm text-gray-600">
            Belum punya akun?
            <a href="{{ route('register') }}"
               class="text-indigo-600 hover:text-indigo-800 font-medium transition duration-200">
              Daftar di sini
            </a>
          </p>
        </div>
      </form>

      <!-- Mobile Additional Info -->
      <div class="mt-6 sm:hidden text-center">
        <p class="text-xs text-gray-500">
          SAPTA - Sistem Aspirasi Publik Transparan dan Akuntabel
        </p>
      </div>
    </div>
  </div>
</x-guest-layout>
