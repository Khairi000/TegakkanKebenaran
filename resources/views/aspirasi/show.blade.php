<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Aspirasi
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto sm:px-6 lg:px-8">
        {{-- Flash message --}}
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-200 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- Kartu detail aspirasi --}}
        <div class="bg-white p-6 rounded shadow">
            {{-- Judul --}}
            <h3 class="text-2xl font-bold mb-4">{{ $aspirasi->judul }}</h3>

            {{-- Foto aspirasi --}}
            @if($aspirasi->foto && Storage::disk('public')->exists($aspirasi->foto))
                <div class="mb-4">
                    <img src="{{ asset('storage/' . $aspirasi->foto) }}" 
                         alt="Foto Aspirasi" 
                         class="w-full max-h-96 object-cover rounded">
                </div>
            @endif

            {{-- Dokumen pendukung --}}
            @if($aspirasi->dokumen && Storage::disk('public')->exists($aspirasi->dokumen))
                <div class="mb-4">
                    <a href="{{ asset('storage/' . $aspirasi->dokumen) }}" 
                       target="_blank" 
                       class="text-blue-600 underline">
                        📄 Lihat Dokumen Pendukung
                    </a>
                </div>
            @endif

            {{-- Isi aspirasi --}}
            <p class="mb-4 text-gray-700 leading-relaxed">{{ $aspirasi->isi }}</p>

            {{-- Info tambahan --}}
            <div class="mb-3 text-sm text-gray-600 space-y-1">
                <p>Status: <strong>{{ $aspirasi->status }}</strong></p>
                <p>Votes: <strong>{{ $aspirasi->votes }}</strong></p>
                <p>Dibuat oleh: <strong>{{ $aspirasi->user->name }}</strong></p>

                {{-- Hash blockchain --}}
                <p>
                    Hash Blockchain: 
                    @if($aspirasi->hash)
                        <a href="http://127.0.0.1:7545/#/transaction/{{ $aspirasi->hash }}" 
                           target="_blank" 
                           class="text-blue-600 underline text-sm">
                            {{ $aspirasi->hash }}
                        </a>
                        <span class="text-gray-500 ml-2 text-xs">(Verifikasi di Ganache)</span>
                    @else
                        <span class="text-gray-500 italic">Belum di-generate</span>
                    @endif
                </p>
            </div>

            {{-- Tombol aksi utama --}}
            <div class="flex flex-col md:flex-row items-start md:items-center gap-4 mt-6">
                <a href="{{ route('aspirasi.index') }}" class="text-blue-600 hover:underline">
                    ← Kembali ke daftar
                </a>

                {{-- Tombol vote untuk user --}}
                @if(auth()->check() && auth()->user()->isUser())
                    @php
                        $hasVoted = $aspirasi->voters->contains(auth()->id());
                    @endphp
                    <form action="{{ route('aspirasi.vote', $aspirasi) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" 
                                class="{{ $hasVoted ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700' }} 
                                       text-white px-3 py-1 rounded text-sm transition">
                            {{ $hasVoted ? '❌ Batal Vote' : '👍 Vote' }}
                        </button>
                    </form>
                @endif

                {{-- Admin bisa update status & upload dokumen --}}
                @if(auth()->check() && auth()->user()->isAdmin())
                    <form action="{{ route('aspirasi.updateStatus', $aspirasi) }}" 
                          method="POST" enctype="multipart/form-data"
                          class="flex flex-wrap gap-2 items-center">
                        @csrf
                        @method('PUT')

                        <select name="status" class="border rounded px-2 py-1 text-sm">
                            <option value="Dikirim" @selected($aspirasi->status == 'Dikirim')>Dikirim</option>
                            <option value="Diproses" @selected($aspirasi->status == 'Diproses')>Diproses</option>
                            <option value="Selesai" @selected($aspirasi->status == 'Selesai')>Selesai</option>
                        </select>

                        <input type="file" name="dokumen" 
                               class="border rounded px-2 py-1 text-sm"
                               accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.png,.jpg,.jpeg">

                        <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm transition">
                            💾 Simpan
                        </button>
                    </form>
                @endif
            </div>
        </div>

        {{-- Komentar --}}
        <div class="bg-white p-6 rounded shadow mt-6">
            <h4 class="text-lg font-bold mb-4">Komentar</h4>

            {{-- Form tambah komentar --}}
            @auth
                <form action="{{ route('komentar.store', $aspirasi) }}" method="POST" class="mb-4">
                    @csrf
                    <textarea name="isi" rows="3" 
                              class="w-full border rounded px-3 py-2 text-sm mb-2 focus:ring focus:ring-blue-200 @error('isi') border-red-500 @enderror"
                              placeholder="Tulis komentar Anda..." required>{{ old('isi') }}</textarea>
                    
                    @error('isi')
                        <p class="text-red-600 text-sm mb-2">{{ $message }}</p>
                    @enderror

                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm transition">
                        Kirim Komentar
                    </button>
                </form>
            @endauth

            {{-- List komentar --}}
            @forelse($aspirasi->komentar as $komentar)
                <div class="border-b pb-2 mb-3">
                    <p class="text-sm text-gray-800">
                        <strong>{{ $komentar->user->name }}</strong> 
                        <span class="text-gray-500 text-xs">• {{ $komentar->created_at->diffForHumans() }}</span>
                    </p>
                    <p class="text-gray-700 text-sm">{{ $komentar->isi }}</p>
                </div>
            @empty
                <p class="text-gray-500 text-sm">Belum ada komentar.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
