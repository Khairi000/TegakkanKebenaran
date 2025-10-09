<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Daftar Aspirasi
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        {{-- Flash message --}}
        @if(session('success'))
            <div class="bg-green-200 text-green-800 p-2 rounded mb-3">
                {{ session('success') }}
            </div>
        @endif

        {{-- Tombol buat aspirasi (hanya user biasa) --}}
        @if(auth()->check() && auth()->user()->isUser())
            <div class="mb-4">
                <a href="{{ route('aspirasi.create') }}" 
                   class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow">
                   ✍️ Buat Aspirasi
                </a>
            </div>
        @endif

        {{-- Loop aspirasi --}}
        @forelse($aspirasis as $aspirasi)
            <div class="border p-4 mb-4 rounded bg-white shadow flex flex-col md:flex-row gap-4">
                
                {{-- Foto aspirasi jika ada --}}
                @if($aspirasi->foto && Storage::disk('public')->exists($aspirasi->foto))
                    <div class="flex-shrink-0">
                        <img src="{{ asset('storage/' . $aspirasi->foto) }}" 
                             alt="Foto Aspirasi" 
                             class="w-32 h-32 object-cover rounded">
                    </div>
                @endif

                {{-- Konten aspirasi --}}
                <div class="flex-1">
                    <h3 class="font-semibold text-lg">{{ $aspirasi->judul }}</h3>
                    <p class="text-gray-700 mb-2">{{ Str::limit($aspirasi->isi, 120) }}</p>

                    <p class="text-sm text-gray-500">
                        Status:
                        <span class="px-2 py-1 rounded text-xs
                            {{ $aspirasi->status === 'Dikirim' ? 'bg-gray-200 text-gray-700' : '' }}
                            {{ $aspirasi->status === 'Diproses' ? 'bg-yellow-200 text-yellow-800' : '' }}
                            {{ $aspirasi->status === 'Selesai' ? 'bg-green-200 text-green-800' : '' }}">
                            {{ $aspirasi->status }}
                        </span>
                        | Votes: <strong>{{ $aspirasi->votes }}</strong>
                        | Oleh: {{ $aspirasi->user->name }}
                    </p>

                    {{-- Tambahkan informasi hash blockchain --}}
                    @if($aspirasi->hash)
                        <p class="text-sm text-gray-500 mt-1">
                            🔗 Hash: <code class="bg-gray-100 rounded px-2 py-0.5">{{ $aspirasi->hash }}</code>
                        </p>
                    @endif

                    <div class="mt-3 flex flex-wrap items-center gap-3">
                        {{-- Tombol lihat detail --}}
                        <a href="{{ route('aspirasi.show', $aspirasi) }}" 
                           class="text-blue-600 hover:underline">
                            🔎 Lihat Detail
                        </a>

                        {{-- Tombol vote untuk user biasa --}}
                        @if(auth()->check() && auth()->user()->isUser())
                            <form action="{{ route('aspirasi.vote', $aspirasi) }}" method="POST" class="inline">
                                @csrf
                                @php
                                    $hasVoted = $aspirasi->voters->contains(auth()->id());
                                @endphp
                                <button type="submit" 
                                    class="{{ $hasVoted ? 'text-red-600 hover:underline' : 'text-green-600 hover:underline' }}">
                                    {{ $hasVoted ? '❌ Batal Vote' : '👍 Vote' }}
                                </button>
                            </form>

                            {{-- Komentar (toggle pakai Alpine.js) --}}
                            <div x-data="{ open: false }">
                                <button @click="open = !open" class="text-purple-600 hover:underline">
                                    💬 Komentar
                                </button>
                                <div x-show="open" class="mt-3 transition-all duration-200">
                                    <form action="{{ route('komentar.store', $aspirasi->id) }}" method="POST">
                                        @csrf
                                        <textarea name="isi" rows="2" 
                                                  class="w-full border rounded p-2 text-sm mb-2" 
                                                  placeholder="Tulis komentar..."></textarea>
                                        <button type="submit" 
                                                class="bg-purple-600 hover:bg-purple-700 text-white px-3 py-1 rounded text-sm">
                                            Kirim
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endif

                        {{-- Jika admin → bisa update status --}}
                        @if(auth()->check() && auth()->user()->isAdmin())
                            <a href="{{ route('aspirasi.show', $aspirasi) }}" 
                               class="bg-blue-600 text-white px-3 py-1 rounded text-sm">
                                ⚙️ Update Status
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <p class="text-gray-500">Belum ada aspirasi.</p>
        @endforelse

        {{-- Pagination (opsional, jika pakai paginate di controller) --}}
        @if(method_exists($aspirasis, 'links'))
            <div class="mt-6">
                {{ $aspirasis->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
