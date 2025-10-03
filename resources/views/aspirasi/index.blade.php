<x-app-layout>
    <h2 class="text-xl font-bold mb-4">Daftar Aspirasi</h2>

    @foreach($aspirasis as $aspirasi)
        <div class="border p-3 mb-3 rounded">
            <h3 class="font-semibold text-lg">{{ $aspirasi->judul }}</h3>
            <p>{{ Str::limit($aspirasi->isi, 100) }}</p>
            <p class="text-sm text-gray-500">
                Status: <strong>{{ $aspirasi->status }}</strong> | 
                Oleh: {{ $aspirasi->user->name }}
            </p>
            <p class="text-sm text-gray-600">Votes: {{ $aspirasi->vote_count }}</p>
            <a href="{{ route('aspirasi.show', $aspirasi) }}" class="text-blue-600">Lihat Detail</a>
        </div>
    @endforeach
</x-app-layout>
