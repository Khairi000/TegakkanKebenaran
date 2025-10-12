<x-app-layout>
  <x-slot name="header">
    <div class="bg-gradient-to-r from-indigo-600 to-blue-500 text-white p-6 rounded-xl shadow-md">
      <h2 class="font-semibold text-2xl">💬 Diskusi: {{ $aspirasi->judul }}</h2>
      <p class="text-sm text-indigo-100 mt-1">Bergabunglah dalam percakapan dan bagikan pendapatmu</p>
    </div>
  </x-slot>

  <div class="max-w-3xl mx-auto py-10 space-y-8 px-4 sm:px-6 lg:px-8">

    {{-- 📄 Detail Aspirasi --}}
    <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100">
      <h3 class="text-2xl font-semibold text-gray-900">{{ $aspirasi->judul }}</h3>
      <p class="text-gray-500 text-sm mt-1">
        oleh <span class="font-medium text-gray-700">{{ $aspirasi->user->name ?? 'Anonim' }}</span> ·
        {{ $aspirasi->created_at->diffForHumans() }}
      </p>

      @if($aspirasi->foto)
        <div class="mt-4 mb-6">
          <img src="{{ asset('storage/'.$aspirasi->foto) }}"
               alt="{{ $aspirasi->judul }}"
               class="rounded-2xl w-full max-h-[400px] object-cover shadow-sm border border-gray-200">
        </div>
      @endif

      <p class="text-gray-800 leading-relaxed whitespace-pre-line">{{ $aspirasi->isi }}</p>
    </div>

    {{-- 💭 Kolom Diskusi --}}
    <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100">
      <h4 class="font-semibold text-lg mb-4 text-gray-800 flex items-center gap-2">
        💭 <span>Diskusi</span>
      </h4>

      {{-- Daftar chat --}}
      <div id="diskusi-list" class="space-y-3 max-h-[400px] overflow-y-auto border rounded-lg p-4 bg-gray-50">
        @forelse($diskusis as $d)
          <div class="flex {{ $d->user_id == Auth::id() ? 'justify-end' : 'justify-start' }}">
            <div class="{{ $d->user_id == Auth::id() ? 'bg-indigo-100 text-indigo-900' : 'bg-white text-gray-800' }}
                        p-3 rounded-2xl shadow-sm max-w-[80%] animate-fadeIn border border-gray-100">
              <p class="text-sm font-medium">{{ $d->user->name }}</p>
              <p class="text-sm mt-1">{{ $d->isi }}</p>
              <p class="text-xs text-gray-400 mt-1">{{ $d->created_at->diffForHumans() }}</p>
            </div>
          </div>
        @empty
          <p class="text-center text-gray-500 text-sm italic">Belum ada diskusi. Jadilah yang pertama!</p>
        @endforelse
      </div>

      {{-- Loading animasi --}}
      <div id="loading" class="hidden text-gray-500 text-sm mt-3 flex items-center justify-center gap-2">
        <span class="loader-dot"></span>
        <span class="loader-dot"></span>
        <span class="loader-dot"></span>
      </div>

      {{-- Form kirim diskusi --}}
      <form id="form-diskusi" class="mt-5 flex gap-3">
        @csrf
        <input type="text" id="isi" name="isi"
               placeholder="Tulis pesan diskusi..."
               class="flex-1 px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:outline-none shadow-sm">
        <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg shadow-md transition-all duration-200 transform hover:scale-105">
          Kirim
        </button>
      </form>
    </div>
  </div>

  @vite(['resources/js/app.js'])

  <script>
    const aspirasiId = {{ $aspirasi->id }};
    const userId = {{ Auth::id() }};
    const userName = "{{ Auth::user()->name }}";
    const diskusiList = document.getElementById('diskusi-list');
    const loading = document.getElementById('loading');

    document.getElementById('form-diskusi').addEventListener('submit', async (e) => {
      e.preventDefault();
      const isi = document.getElementById('isi').value.trim();
      if (!isi) return;

      loading.classList.remove('hidden');

      const response = await fetch(`/diskusi/${aspirasiId}`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        },
        body: JSON.stringify({ isi })
      });

      loading.classList.add('hidden');

      if (response.ok) {
        const data = await response.json();
        appendDiskusi(userName, data.isi, true);
        document.getElementById('isi').value = '';
      }
    });

    function appendDiskusi(nama, isi, isUser) {
      const div = document.createElement('div');
      div.classList = "flex " + (isUser ? "justify-end" : "justify-start");
      div.innerHTML = `
        <div class="${isUser ? 'bg-indigo-100 text-indigo-900' : 'bg-white text-gray-800'}
                    p-3 rounded-2xl shadow-sm max-w-[80%] border border-gray-100 animate-fadeIn">
          <p class="text-sm font-medium">${nama}</p>
          <p class="text-sm mt-1">${isi}</p>
          <p class="text-xs text-gray-400 mt-1">baru saja</p>
        </div>`;
      diskusiList.appendChild(div);
      diskusiList.scrollTop = diskusiList.scrollHeight;
    }
  </script>

  <style>
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .animate-fadeIn { animation: fadeIn 0.3s ease-out; }

    .loader-dot {
      width: 8px; height: 8px;
      background-color: #6366f1;
      border-radius: 50%;
      display: inline-block;
      animation: loading-dots 1.4s infinite;
    }
    .loader-dot:nth-child(2) { animation-delay: 0.2s; }
    .loader-dot:nth-child(3) { animation-delay: 0.4s; }
    @keyframes loading-dots {
      0%, 80%, 100% { transform: scale(0); }
      40% { transform: scale(1); }
    }
  </style>
</x-app-layout>
