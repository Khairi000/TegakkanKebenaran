<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 sm:gap-4 w-full">
            <!-- Bagian Kiri: Judul dan Deskripsi -->


            <!-- Bagian Kanan: User Info -->

        </div>
    </x-slot>

    <div class="py-4 sm:py-6 lg:py-8">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
            <!-- Welcome Card -->
            <div class="bg-gradient-to-r from-[#4FA3E3] to-[#2EC4B6] rounded-xl sm:rounded-2xl shadow-lg sm:shadow-xl mb-6 sm:mb-8 overflow-hidden">
                <div class="p-4 sm:p-6 md:p-8 text-white">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <div class="flex-1">
                            <h3 class="text-lg sm:text-xl md:text-2xl font-bold mb-2 sm:mb-3">Selamat datang, {{ Auth::user()->name }}! 👋</h3>
                            <p class="text-blue-50 text-sm sm:text-base mb-3 sm:mb-4 leading-relaxed">
                                Sistem Aspirasi Publik Transparan siap membantu suara Anda didengar
                            </p>
                            <div class="flex flex-wrap gap-1 sm:gap-2">
                                <span class="bg-white/20 px-2 sm:px-3 py-1 rounded-full text-xs sm:text-sm backdrop-blur-sm">🔒 Aman</span>
                                <span class="bg-white/20 px-2 sm:px-3 py-1 rounded-full text-xs sm:text-sm backdrop-blur-sm">📊 Transparan</span>
                                <span class="bg-white/20 px-2 sm:px-3 py-1 rounded-full text-xs sm:text-sm backdrop-blur-sm">⚡ Real-time</span>
                            </div>
                        </div>
                        <div>
                           <div class="mt-3 sm:mt-4 md:mt-0 self-center">
    <div class="w-16 h-16 sm:w-20 sm:h-20 md:w-24 md:h-24 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-full flex items-center justify-center backdrop-blur-sm shadow-lg">
        <svg class="w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                  d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
        </svg>
    </div>
</div>
                    </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4 lg:gap-6 mb-6 sm:mb-8">

    <!-- Total Aspirasi -->
    <div class="bg-white rounded-xl shadow-md p-4 sm:p-6 border-l-4 border-[#4FA3E3]">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Total Aspirasi</p>
                <p class="text-2xl font-bold text-[#1E2A38]">{{ $total }}</p>
            </div>
            <div class="bg-blue-50 p-3 rounded-full">
                <svg class="w-6 h-6 text-[#4FA3E3]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
        </div>
        <p class="mt-2 text-xs text-green-600 font-medium">↑ Data sinkron otomatis</p>
    </div>

    <!-- Dalam Proses -->
    <div class="bg-white rounded-xl shadow-md p-4 sm:p-6 border-l-4 border-[#2EC4B6]">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Dalam Proses</p>
                <p class="text-2xl font-bold text-[#1E2A38]">{{ $diproses }}</p>
            </div>
            <div class="bg-green-50 p-3 rounded-full">
                <svg class="w-6 h-6 text-[#2EC4B6]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2" />
                </svg>
            </div>
        </div>
        <p class="mt-2 text-xs text-blue-600 font-medium">{{ $dikirim }} menunggu verifikasi</p>
    </div>

    <!-- Selesai -->
    <div class="bg-white rounded-xl shadow-md p-4 sm:p-6 border-l-4 border-[#F4A261]">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Selesai</p>
                <p class="text-2xl font-bold text-[#1E2A38]">{{ $selesai }}</p>
            </div>
            <div class="bg-orange-50 p-3 rounded-full">
                <svg class="w-6 h-6 text-[#F4A261]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
        <p class="mt-2 text-xs text-green-600 font-medium">
            {{ $total > 0 ? round(($selesai / $total) * 100) : 0 }}% rate penyelesaian
        </p>
    </div>

</div>



            <!-- Main Actions -->
            <div class="bg-white rounded-xl sm:rounded-2xl shadow-md sm:shadow-lg overflow-hidden mb-6 sm:mb-8">
                <div class="p-4 sm:p-6 md:p-8">
                    <h3 class="text-lg sm:text-xl font-semibold text-[#1E2A38] mb-4 sm:mb-6">Kelola Aspirasi Anda</h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-3 sm:gap-4 lg:gap-6">
                        <!-- Daftar Aspirasi -->
                        <a href="{{ route('aspirasi.index') }}"
                           class="group bg-gradient-to-br from-blue-50 to-indigo-50 hover:from-blue-100 hover:to-indigo-100 border border-blue-200 rounded-xl sm:rounded-2xl p-4 sm:p-6 transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5 sm:hover:-translate-y-1">
                            <div class="flex items-center justify-between mb-3 sm:mb-4">
                                <div class="w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 bg-blue-100 rounded-lg sm:rounded-xl flex items-center justify-center group-hover:bg-blue-200 transition-colors flex-shrink-0">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 md:w-6 md:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <span class="text-blue-600 text-xs sm:text-sm font-medium ml-2">Lihat Semua →</span>
                            </div>
                            <h4 class="font-semibold text-gray-800 text-sm sm:text-base mb-1 sm:mb-2">📋 Daftar Aspirasi</h4>
                            <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">Lihat dan kelola semua aspirasi yang telah Anda kirim</p>
                        </a>

                        @if(auth()->user()->isUser())
                        <!-- Kirim Aspirasi -->
                        <a href="{{ route('aspirasi.create') }}"
                           class="group bg-gradient-to-br from-green-50 to-emerald-50 hover:from-green-100 hover:to-emerald-100 border border-green-200 rounded-xl sm:rounded-2xl p-4 sm:p-6 transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5 sm:hover:-translate-y-1">
                            <div class="flex items-center justify-between mb-3 sm:mb-4">
                                <div class="w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 bg-green-100 rounded-lg sm:rounded-xl flex items-center justify-center group-hover:bg-green-200 transition-colors flex-shrink-0">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 md:w-6 md:h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                </div>
                                <span class="text-green-600 text-xs sm:text-sm font-medium ml-2">Buat Baru →</span>
                            </div>
                            <h4 class="font-semibold text-gray-800 text-sm sm:text-base mb-1 sm:mb-2">✍️ Kirim Aspirasi</h4>
                            <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">Sampaikan aspirasi baru untuk pembangunan yang lebih baik</p>
                        </a>

                        <!-- Diskusi Aspirasi -->
                        <a href="{{ route('diskusi.index') }}"
                           class="group bg-gradient-to-br from-purple-50 to-violet-50 hover:from-purple-100 hover:to-violet-100 border border-purple-200 rounded-xl sm:rounded-2xl p-4 sm:p-6 transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5 sm:hover:-translate-y-1">
                            <div class="flex items-center justify-between mb-3 sm:mb-4">
                                <div class="w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 bg-purple-100 rounded-lg sm:rounded-xl flex items-center justify-center group-hover:bg-purple-200 transition-colors flex-shrink-0">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 md:w-6 md:h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                    </svg>
                                </div>
                                <span class="text-purple-600 text-xs sm:text-sm font-medium ml-2">Bergabung →</span>
                            </div>
                            <h4 class="font-semibold text-gray-800 text-sm sm:text-base mb-1 sm:mb-2">💬 Diskusi Aspirasi</h4>
                            <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">Berdiskusi dan dukung aspirasi bersama masyarakat</p>
                        </a>
                        @endif

                        <!-- Blockchain Tracking -->
                        <div class="group bg-gradient-to-br from-gray-50 to-slate-50 border border-gray-200 rounded-xl sm:rounded-2xl p-4 sm:p-6">
                            <div class="flex items-center justify-between mb-3 sm:mb-4">
                                <div class="w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 bg-gray-100 rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 md:w-6 md:h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                </div>
                                <span class="text-gray-600 text-xs sm:text-sm font-medium ml-2">Aktif</span>
                            </div>
                            <h4 class="font-semibold text-gray-800 text-sm sm:text-base mb-1 sm:mb-2">⛓️ Blockchain Tracking</h4>
                            <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">Semua aspirasi tercatat aman di blockchain</p>
                            <div class="mt-2 sm:mt-3 flex space-x-1">
                                <div class="w-1.5 h-1.5 sm:w-2 sm:h-2 bg-green-400 rounded-full animate-pulse"></div>
                                <div class="w-1.5 h-1.5 sm:w-2 sm:h-2 bg-green-400 rounded-full animate-pulse" style="animation-delay: 0.2s"></div>
                                <div class="w-1.5 h-1.5 sm:w-2 sm:h-2 bg-green-400 rounded-full animate-pulse" style="animation-delay: 0.4s"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <!-- Recent Activity -->
<div class="bg-white rounded-xl sm:rounded-2xl shadow-md sm:shadow-lg p-4 sm:p-6 md:p-8">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 sm:gap-0 mb-4 sm:mb-6">
        <h3 class="text-lg sm:text-xl font-semibold text-[#1E2A38]">Aktivitas Terbaru</h3>
        <a href="{{ route('aspirasi.index') }}" class="text-xs sm:text-sm text-[#4FA3E3] hover:text-[#2EC4B6] font-medium self-end sm:self-auto">
            Lihat Semua →
        </a>
    </div>

    <div class="space-y-3 sm:space-y-4">
        @forelse($aspirasiTerbaru as $aspirasi)
            @php
                $warnaBg = match($aspirasi->status) {
                    'Selesai' => 'bg-green-50',
                    'Diproses' => 'bg-yellow-50',
                    default => 'bg-blue-50',
                };

                $warnaLingkaran = match($aspirasi->status) {
                    'Selesai' => 'bg-green-100 text-green-600',
                    'Diproses' => 'bg-yellow-100 text-yellow-600',
                    default => 'bg-blue-100 text-blue-600',
                };

                $warnaBadge = match($aspirasi->status) {
                    'Selesai' => 'bg-green-100 text-green-800',
                    'Diproses' => 'bg-yellow-100 text-yellow-800',
                    default => 'bg-blue-100 text-blue-800',
                };
            @endphp

            <div class="flex items-center space-x-3 sm:space-x-4 p-3 sm:p-4 {{ $warnaBg }} rounded-lg sm:rounded-xl">
                <div class="w-8 h-8 sm:w-10 sm:h-10 {{ $warnaLingkaran }} rounded-full flex items-center justify-center flex-shrink-0">
                    @if($aspirasi->status === 'Selesai')
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    @elseif($aspirasi->status === 'Diproses')
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    @else
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6h6v6m2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h5l5 5v9a2 2 0 01-2 2z"/>
                        </svg>
                    @endif
                </div>

                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-800 truncate">
                        Aspirasi "{{ $aspirasi->judul }}"
                        @if($aspirasi->status === 'Selesai')
                            telah diselesaikan
                        @elseif($aspirasi->status === 'Diproses')
                            sedang diproses
                        @else
                            telah dikirim
                        @endif
                    </p>
                    <p class="text-xs text-gray-500 mt-0.5">
                        {{ $aspirasi->created_at->diffForHumans() }}
                    </p>
                </div>

                <span class="px-2 py-1 text-xs rounded-full font-medium flex-shrink-0 {{ $warnaBadge }}">
                    {{ $aspirasi->status }}
                </span>
            </div>
        @empty
            <p class="text-sm text-gray-500 text-center py-4">Belum ada aktivitas terbaru.</p>
        @endforelse
    </div>
</div>

        </div>
    </div>
</x-app-layout>
