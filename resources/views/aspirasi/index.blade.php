<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Daftar Aspirasi
            </h2>
            @if(auth()->check() && auth()->user()->isUser())
                <a href="{{ route('aspirasi.create') }}"
                   class="mt-2 md:mt-0 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow transition-all duration-300 flex items-center justify-center">
                    <i class="fas fa-plus-circle mr-2"></i>
                    Buat Aspirasi Baru
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        {{-- Flash message --}}
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-r-lg shadow-sm">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-500 mt-1"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        {{-- Search and Filter Section --}}
        <div class="mb-6 space-y-4">
            {{-- Search Box --}}
            <div class="relative max-w-md">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text"
                       id="searchInput"
                       placeholder="Cari aspirasi..."
                       class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-300">
            </div>

            {{-- Filter Tabs --}}
            <div class="flex space-x-2 overflow-x-auto pb-2">
                <button data-filter="all" class="filter-tab active px-4 py-2 rounded-full text-sm font-medium bg-green-600 text-white transition-all duration-300">
                    Semua
                </button>
                <button data-filter="dikirim" class="filter-tab px-4 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-700 hover:bg-gray-200 transition-all duration-300">
                    Dikirim
                </button>
                <button data-filter="diproses" class="filter-tab px-4 py-2 rounded-full text-sm font-medium bg-yellow-100 text-yellow-700 hover:bg-yellow-200 transition-all duration-300">
                    Diproses
                </button>
                <button data-filter="selesai" class="filter-tab px-4 py-2 rounded-full text-sm font-medium bg-green-100 text-green-700 hover:bg-green-200 transition-all duration-300">
                    Selesai
                </button>
                <button data-filter="populer" class="filter-tab px-4 py-2 rounded-full text-sm font-medium bg-red-100 text-red-700 hover:bg-red-200 transition-all duration-300">
                    Paling Populer
                </button>
            </div>
        </div>

        {{-- Aspirasi List --}}
        <div id="aspirasiList" class="space-y-6">
            @forelse($aspirasis as $aspirasi)
                <div class="aspirasi-card bg-white rounded-xl shadow-sm border-l-4 transition-all duration-300 hover:shadow-md
                    @if($aspirasi->status === 'Dikirim') border-gray-400 status-dikirim
                    @elseif($aspirasi->status === 'Diproses') border-yellow-400 status-diproses
                    @else border-green-400 status-selesai @endif"
                    data-status="{{ strtolower($aspirasi->status) }}"
                    data-votes="{{ $aspirasi->votes }}">

                    <div class="p-6">
                        <div class="flex flex-col lg:flex-row gap-6">
                            {{-- Foto Aspirasi --}}
                            @if($aspirasi->foto && Storage::disk('public')->exists($aspirasi->foto))
                                <div class="flex-shrink-0">
                                    <img src="{{ asset('storage/' . $aspirasi->foto) }}"
                                         alt="Foto Aspirasi"
                                         class="w-full lg:w-48 h-48 object-cover rounded-lg shadow">
                                </div>
                            @endif

                            {{-- Konten --}}
                            <div class="flex-1 min-w-0">
                                {{-- Header dengan Judul dan Status --}}
                                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between mb-4">
                                    <h3 class="text-xl font-bold text-gray-900 mb-2 sm:mb-0 pr-4">{{ $aspirasi->judul }}</h3>
                                    <div class="flex items-center space-x-2">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                                            @if($aspirasi->status === 'Dikirim') bg-gray-100 text-gray-800
                                            @elseif($aspirasi->status === 'Diproses') bg-yellow-100 text-yellow-800
                                            @else bg-green-100 text-green-800 @endif">
                                            @if($aspirasi->status === 'Dikirim')
                                                <i class="fas fa-paper-plane mr-1"></i>
                                            @elseif($aspirasi->status === 'Diproses')
                                                <i class="fas fa-cog mr-1"></i>
                                            @else
                                                <i class="fas fa-check-circle mr-1"></i>
                                            @endif
                                            {{ $aspirasi->status }}
                                        </span>
                                        <span class="flex items-center text-sm text-gray-500">
                                            <i class="fas fa-heart text-red-500 mr-1"></i>
                                            {{ $aspirasi->votes }}
                                        </span>
                                    </div>
                                </div>

                                {{-- Isi Aspirasi --}}
                                <p class="text-gray-600 mb-4 leading-relaxed line-clamp-3">{{ Str::limit($aspirasi->isi, 200) }}</p>

                                {{-- Metadata --}}
                                <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500 mb-4">
                                    <div class="flex items-center">
                                        <i class="fas fa-user mr-2"></i>
                                        <span>{{ $aspirasi->user->name }}</span>
                                    </div>

                                    <div class="flex items-center">
                                        <i class="fas fa-calendar mr-2"></i>
                                        <span>{{ $aspirasi->created_at->format('d M Y') }}</span>
                                    </div>

                                    <div class="flex items-center">
                                        <i class="fas fa-comment mr-2 text-blue-500"></i>
                                        <span>{{ $aspirasi->komentar->count() }} komentar</span>
                                    </div>
                                </div>

                                {{-- Hash Blockchain --}}
                                @if($aspirasi->hash)
                                    <div class="mb-4">
                                        <div class="flex items-center text-sm text-gray-600 mb-2">
                                            <i class="fas fa-link mr-2"></i>
                                            <span>Hash Blockchain:</span>
                                        </div>
                                        <code class="bg-gray-100 rounded px-3 py-1 text-xs font-mono break-all">{{ Str::limit($aspirasi->hash, 50) }}</code>
                                    </div>
                                @endif

                                {{-- Action Buttons --}}
                                <div class="flex flex-wrap gap-3 items-center">
                                    {{-- Tombol Lihat Detail --}}
                                    <a href="{{ route('aspirasi.show', $aspirasi) }}"
                                       class="group inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-medium rounded-lg transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                       <i class="fas fa-eye mr-2 transition-transform duration-300 group-hover:scale-110"></i>
                                       <span class="transition-all duration-300 group-hover:tracking-wide">Lihat Detail</span>
                                    </a>

                                    {{-- Tombol Vote untuk User Biasa --}}
                                    @if(auth()->check() && auth()->user()->isUser())
                                        @php
                                            $hasVoted = $aspirasi->voters->contains(auth()->id());
                                        @endphp
                                       <form action="{{ route('aspirasi.vote', $aspirasi) }}" method="POST" class="inline">
    @csrf
    <button type="submit"
            class="group inline-flex items-center px-4 py-2 font-medium rounded-lg transition-all duration-300 shadow-sm hover:shadow-md transform hover:-translate-y-0.5
                   {{ $hasVoted ? 'bg-red-500 hover:bg-red-600 text-white' : 'bg-purple-500 hover:bg-purple-600 text-white' }}">
        @if($hasVoted)
            <i class="fas fa-thumbs-down mr-2 transition-transform duration-300 group-hover:scale-110"></i>
            <span class="transition-all duration-300 group-hover:tracking-wide">Batal Dukung</span>
        @else
            <i class="fas fa-thumbs-up mr-2 transition-transform duration-300 group-hover:scale-110"></i>
            <span class="transition-all duration-300 group-hover:tracking-wide">Dukung</span>
        @endif
    </button>
</form>

                                        {{-- Komentar dengan Modal Overlay --}}

                                    @endif

                                    {{-- Admin Actions --}}
                                    @if(auth()->check() && auth()->user()->isAdmin())
                                        <a href="{{ route('aspirasi.show', $aspirasi) }}"
                                           class="group inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white font-medium rounded-lg transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                           <i class="fas fa-cog mr-2 transition-transform duration-300 group-hover:scale-110"></i>
                                           <span class="transition-all duration-300 group-hover:tracking-wide">Kelola</span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                {{-- Empty State --}}
                <div class="text-center py-12 bg-white rounded-xl shadow-sm">
                    <i class="fas fa-inbox text-gray-400 text-5xl mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">Belum ada aspirasi</h3>
                    <p class="text-gray-500 mb-6">Jadilah yang pertama mengajukan aspirasi!</p>
                    @if(auth()->check() && auth()->user()->isUser())
                        <a href="{{ route('aspirasi.create') }}"
                           class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg shadow transition-all duration-300">
                            <i class="fas fa-plus-circle mr-2"></i>
                            Buat Aspirasi Pertama
                        </a>
                    @endif
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if(method_exists($aspirasis, 'links'))
            <div class="mt-8">
                {{ $aspirasis->links() }}
            </div>
        @endif
    </div>

    <style>
        .aspirasi-card {
            transition: all 0.3s ease;
        }

        .aspirasi-card:hover {
            transform: translateY(-2px);
        }

        .filter-tab {
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .filter-tab.active {
            transform: scale(1.05);
        }

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 640px) {
            .aspirasi-card {
                margin-left: -1rem;
                margin-right: -1rem;
                border-radius: 0;
                border-left: none;
                border-top: 4px solid;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterTabs = document.querySelectorAll('.filter-tab');
            const aspirasiCards = document.querySelectorAll('.aspirasi-card');
            const searchInput = document.getElementById('searchInput');

            // Filter functionality
            filterTabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    // Update active tab
                    filterTabs.forEach(t => {
                        t.classList.remove('active', 'bg-green-600', 'text-white');
                        t.classList.add('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
                    });

                    this.classList.remove('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
                    this.classList.add('active', 'bg-green-600', 'text-white');

                    const filter = this.getAttribute('data-filter');

                    // Filter cards
                    aspirasiCards.forEach(card => {
                        if (filter === 'all') {
                            card.style.display = 'block';
                        } else if (filter === 'populer') {
                            const votes = parseInt(card.getAttribute('data-votes'));
                            if (votes >= 5) {
                                card.style.display = 'block';
                            } else {
                                card.style.display = 'none';
                            }
                        } else {
                            const status = card.getAttribute('data-status');
                            if (status === filter) {
                                card.style.display = 'block';
                            } else {
                                card.style.display = 'none';
                            }
                        }

                        // Add animation
                        if (card.style.display === 'block') {
                            card.style.animation = 'fadeIn 0.5s ease-in';
                        }
                    });
                });
            });

            // Search functionality
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();

                aspirasiCards.forEach(card => {
                    const title = card.querySelector('h3').textContent.toLowerCase();
                    const content = card.querySelector('p').textContent.toLowerCase();

                    if (title.includes(searchTerm) || content.includes(searchTerm)) {
                        card.style.display = 'block';
                        card.style.animation = 'fadeIn 0.3s ease-in';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    </script>
</x-app-layout>
