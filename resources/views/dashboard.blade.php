<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-xl font-semibold mb-2">Selamat datang, {{ Auth::user()->name }}!</h3>
                    <p class="mb-6 text-gray-700">Silakan gunakan menu di bawah untuk mengelola aspirasi Anda.</p>

                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('aspirasi.index') }}"
                           class="flex-1 text-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded shadow transition duration-200">
                            📋 Daftar Aspirasi
                        </a>

                        @if(auth()->user()->isUser())
                            <a href="{{ route('aspirasi.create') }}"
                               class="flex-1 text-center bg-green-600 hover:bg-green-700 text-white px-4 py-3 rounded shadow transition duration-200">
                                ✍️ Kirim Aspirasi
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
