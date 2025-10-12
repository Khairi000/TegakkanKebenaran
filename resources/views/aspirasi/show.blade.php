<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Aspirasi
            </h2>
            <div class="mt-2 sm:mt-0">
                <a href="{{ route('aspirasi.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition-all duration-300">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Daftar
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto sm:px-6 lg:px-8">
        {{-- Flash message --}}
        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm">
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

        {{-- Main Content Card --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6">
                {{-- Header dengan Judul dan Status --}}
                <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between mb-6">
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-4 lg:mb-0">{{ $aspirasi->judul }}</h1>
                    <div class="flex items-center space-x-3">
                        <span class="px-4 py-2 rounded-full text-sm font-semibold
                            @if($aspirasi->status === 'Dikirim') bg-gray-100 text-gray-800
                            @elseif($aspirasi->status === 'Diproses') bg-yellow-100 text-yellow-800
                            @else bg-green-100 text-green-800 @endif">
                            @if($aspirasi->status === 'Dikirim')
                                <i class="fas fa-paper-plane mr-2"></i>
                            @elseif($aspirasi->status === 'Diproses')
                                <i class="fas fa-cog mr-2"></i>
                            @else
                                <i class="fas fa-check-circle mr-2"></i>
                            @endif
                            {{ $aspirasi->status }}
                        </span>
                        <span class="flex items-center text-lg font-semibold text-gray-700">
                            <i class="fas fa-heart text-red-500 mr-2"></i>
                            {{ $aspirasi->votes }}
                        </span>
                    </div>
                </div>

                {{-- Foto Aspirasi --}}
                @if($aspirasi->foto && Storage::disk('public')->exists($aspirasi->foto))
                    <div class="mb-6">
                        <img src="{{ asset('storage/' . $aspirasi->foto) }}"
                             alt="Foto Aspirasi"
                             class="w-full max-h-96 object-cover rounded-lg shadow-md">
                    </div>
                @endif

                {{-- Isi Aspirasi --}}
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                        <i class="fas fa-align-left text-blue-500 mr-2"></i>
                        Isi Aspirasi
                    </h3>
                    <div class="bg-gray-50 rounded-lg p-6">
                        <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $aspirasi->isi }}</p>
                    </div>
                </div>

                {{-- Informasi dan Blockchain --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    {{-- Informasi Aspirasi --}}
                    <div class="bg-blue-50 rounded-lg p-6">
                        <h4 class="font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                            Informasi Aspirasi
                        </h4>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Dibuat oleh:</span>
                                <span class="font-medium text-gray-800">{{ $aspirasi->user->name }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Tanggal dibuat:</span>
                                <span class="font-medium text-gray-800">{{ $aspirasi->created_at->format('d M Y H:i') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Jumlah Komentar:</span>
                                <span class="font-medium text-gray-800 flex items-center">
                                    <i class="fas fa-comment text-blue-500 mr-1"></i>
                                    {{ $aspirasi->komentar->count() }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Blockchain Info --}}
                    <div class="bg-purple-50 rounded-lg p-6">
                        <h4 class="font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-link text-purple-500 mr-2"></i>
                            Verifikasi Blockchain
                        </h4>
                        <div class="text-sm">
                            @if($aspirasi->hash)
                                <p class="text-gray-600 mb-2">Hash transaksi:</p>
                                <div class="bg-white rounded p-3 mb-3 border">
                                    <code class="text-xs font-mono break-all">{{ $aspirasi->hash }}</code>
                                </div>
                                <a href="http://127.0.0.1:7545/#/transaction/{{ $aspirasi->hash }}"
                                   target="_blank"
                                   class="inline-flex items-center text-purple-600 hover:text-purple-800 text-sm transition-colors duration-300">
                                    <i class="fas fa-external-link-alt mr-2"></i>
                                    Verifikasi di Ganache
                                </a>
                            @else
                                <p class="text-gray-500 italic">Hash blockchain belum di-generate</p>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Dokumen Pendukung --}}
                @if($aspirasi->dokumen && Storage::disk('public')->exists($aspirasi->dokumen))
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                            <i class="fas fa-file-alt text-green-500 mr-2"></i>
                            Dokumen Pendukung
                        </h3>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center bg-gray-50 hover:bg-gray-100 transition-colors duration-300">
                            <i class="fas fa-file-pdf text-red-500 text-4xl mb-3"></i>
                            <p class="text-gray-700 mb-4">Dokumen tersedia untuk diunduh</p>
                            <a href="{{ asset('storage/' . $aspirasi->dokumen) }}"
                               target="_blank"
                               class="inline-flex items-center px-5 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-all duration-300">
                                <i class="fas fa-download mr-2"></i>
                                Unduh Dokumen
                            </a>
                        </div>
                    </div>
                @endif

                {{-- Action Buttons --}}
                <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                    {{-- Tombol Vote untuk User --}}
                    @if(auth()->check() && auth()->user()->isUser())
                        @php
                            $hasVoted = $aspirasi->voters->contains(auth()->id());
                        @endphp
                        <form action="{{ route('aspirasi.vote', $aspirasi) }}" method="POST" class="sm:mr-auto">
                            @csrf
                            <button type="submit"
                                    class="w-full sm:w-auto flex items-center justify-center px-6 py-3 rounded-lg font-semibold transition-all duration-300
                                           {{ $hasVoted ? 'bg-red-600 hover:bg-red-700 text-white' : 'bg-green-600 hover:bg-green-700 text-white' }}">
                                @if($hasVoted)
                                    <i class="fas fa-heart-broken mr-2"></i>
                                    Batalkan Vote
                                @else
                                    <i class="fas fa-heart mr-2"></i>
                                    Dukung Aspirasi
                                @endif
                            </button>
                        </form>
                    @endif

                    {{-- Admin Actions --}}
                    @if(auth()->check() && auth()->user()->isAdmin())
                        <form action="{{ route('aspirasi.updateStatus', $aspirasi) }}"
                              method="POST" enctype="multipart/form-data"
                              class="flex-1">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                <select name="status" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="Dikirim" @selected($aspirasi->status == 'Dikirim')>Dikirim</option>
                                    <option value="Diproses" @selected($aspirasi->status == 'Diproses')>Diproses</option>
                                    <option value="Selesai" @selected($aspirasi->status == 'Selesai')>Selesai</option>
                                </select>

                                <input type="file" name="dokumen"
                                       class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.png,.jpg,.jpeg">

                                <button type="submit"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300 flex items-center justify-center">
                                    <i class="fas fa-save mr-2"></i>
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        {{-- Komentar Section --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-comments text-blue-500 mr-2"></i>
                    Komentar ({{ $aspirasi->komentar->count() }})
                </h3>

                {{-- Form Tambah Komentar --}}
                @auth
                    <form action="{{ route('komentar.store', $aspirasi) }}" method="POST" class="mb-8">
                        @csrf
                        <div class="mb-4">
                            <label for="isi" class="block text-sm font-medium text-gray-700 mb-2">Tambah Komentar</label>
                            <textarea name="isi" id="isi" rows="4"
                                      class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('isi') border-red-500 @enderror"
                                      placeholder="Tulis komentar Anda di sini..." required>{{ old('isi') }}</textarea>

                            @error('isi')
                                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg text-sm font-medium transition-all duration-300 flex items-center">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Kirim Komentar
                        </button>
                    </form>
                @endauth

                {{-- Daftar Komentar --}}
                <div class="space-y-4">
                    @forelse($aspirasi->komentar as $komentar)
                        <div class="border-b border-gray-200 pb-4 last:border-b-0 last:pb-0">
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-gradient-to-r from-blue-400 to-purple-500 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                                        {{ substr($komentar->user->name, 0, 1) }}
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-2">
                                        <h4 class="font-semibold text-gray-800 text-sm">{{ $komentar->user->name }}</h4>
                                        <span class="text-gray-500 text-xs">{{ $komentar->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-gray-700 text-sm leading-relaxed">{{ $komentar->isi }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <i class="fas fa-comment-slash text-gray-400 text-4xl mb-3"></i>
                            <p class="text-gray-500">Belum ada komentar. Jadilah yang pertama berkomentar!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <style>
        .bg-blue-50 {
            background-color: #eff6ff;
        }

        .bg-purple-50 {
            background-color: #faf5ff;
        }

        .bg-green-50 {
            background-color: #f0fdf4;
        }

        .transition-all {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 300ms;
        }

        @media (max-width: 640px) {
            .grid-cols-1 {
                grid-template-columns: 1fr;
            }

            .md\:grid-cols-3 {
                grid-template-columns: 1fr;
            }
        }
    </style>
</x-app-layout>
