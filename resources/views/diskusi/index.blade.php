<x-app-layout>
  <x-slot name="header">
    <div class="bg-gradient-to-r from-indigo-600 to-blue-500 text-white p-6 rounded-xl shadow-md">
      <h2 class="font-semibold text-2xl">💬 Diskusi Aspirasi</h2>
      <p class="text-sm text-indigo-100 mt-1">Lihat dan ikuti aspirasi untuk berdiskusi bersama masyarakat</p>
    </div>
  </x-slot>

  <div class="py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach($aspirasis as $a)
        <a href="{{ route('diskusi.show', $a->id) }}"
          class="group bg-white shadow-sm hover:shadow-lg rounded-2xl overflow-hidden transition-all duration-300 hover:-translate-y-1 border border-gray-100">

          {{-- Gambar aspirasi --}}
          @if($a->foto)
            <div class="overflow-hidden">
              <img src="{{ asset('storage/' . $a->foto) }}"
                   alt="{{ $a->judul }}"
                   class="w-full h-52 object-cover transform group-hover:scale-110 transition duration-500 ease-in-out">
            </div>
          @else
            <div class="w-full h-52 bg-gradient-to-r from-indigo-300 to-blue-400 flex items-center justify-center text-white font-semibold">
              📷 Tidak ada gambar
            </div>
          @endif

          {{-- Konten aspirasi --}}
          <div class="p-5 space-y-2">
            <h3 class="text-lg font-semibold text-gray-800 group-hover:text-indigo-600 transition">
              {{ $a->judul }}
            </h3>
            <p class="text-gray-600 text-sm line-clamp-3">
              {{ Str::limit($a->isi, 100) }}
            </p>
            <div class="mt-3 flex items-center justify-between text-xs text-gray-500">
              <span>👤 {{ $a->user->name ?? 'Anonim' }}</span>
              <span>{{ $a->created_at->diffForHumans() }}</span>
            </div>
          </div>
        </a>
      @endforeach
    </div>

    {{-- Pesan jika kosong --}}
    @if($aspirasis->isEmpty())
      <div class="text-center text-gray-500 mt-12">
        <div class="text-5xl mb-2">😔</div>
        <p class="text-lg">Belum ada aspirasi untuk didiskusikan.</p>
      </div>
    @endif
  </div>
</x-app-layout>
