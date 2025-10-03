<x-app-layout>
    <h2 class="text-2xl font-bold mb-2">{{ $aspirasi->judul }}</h2>
    <p class="mb-4">{{ $aspirasi->isi }}</p>
    
    <p>Status: <strong>{{ $aspirasi->status }}</strong></p>
    <p class="mt-3">Total Votes: <strong>{{ $aspirasi->vote_count }}</strong></p>
    <p>Hash (Blockchain-ready): <code>{{ $aspirasi->hash }}</code></p>

    @if(auth()->check() && !auth()->user()->isAdmin())
        <form action="{{ route('aspirasi.vote', $aspirasi) }}" method="POST" class="mt-2">
            @csrf
            <button class="bg-green-500 text-white px-3 py-1 rounded">Vote</button>
        </form>
    @endif

    @if(auth()->user()->isAdmin())
        <form action="{{ route('aspirasi.updateStatus', $aspirasi) }}" method="POST" class="mt-4">
            @csrf
            <label for="status" class="block font-semibold mb-1">Ubah Status</label>
            <select name="status" id="status" class="border p-2 rounded">
                <option value="Dikirim" {{ $aspirasi->status == 'Dikirim' ? 'selected' : '' }}>Dikirim</option>
                <option value="Diproses" {{ $aspirasi->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                <option value="Selesai" {{ $aspirasi->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="Ditolak" {{ $aspirasi->status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
            </select>
            <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded ml-2">Update</button>
        </form>
    @endif

    <hr class="my-4">

    <h3 class="text-lg font-bold mb-2">Diskusi</h3>

    {{-- Form komentar --}}
    @if(auth()->check())
        <form action="{{ route('aspirasi.comment', $aspirasi) }}" method="POST" class="mb-3">
            @csrf
            <textarea name="isi" class="border w-full p-2 rounded" rows="3" placeholder="Tulis komentar..." required></textarea>
            <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded mt-2">Kirim</button>
        </form>
    @endif

    {{-- List komentar --}}
    <div class="space-y-3">
        @forelse($aspirasi->comments as $comment)
            <div class="border p-2 rounded">
                <p>{{ $comment->isi }}</p>
                <p class="text-xs text-gray-500">Oleh: {{ $comment->user->name }} | {{ $comment->created_at->diffForHumans() }}</p>
            </div>
        @empty
            <p class="text-gray-500">Belum ada komentar.</p>
        @endforelse
    </div>
</x-app-layout>
