<x-app-layout>
    <h2 class="text-xl font-bold mb-4">Kirim Aspirasi</h2>

    <form action="{{ route('aspirasi.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="block">Judul</label>
            <input type="text" name="judul" class="border w-full p-2 rounded" required>
        </div>
        <div class="mb-3">
            <label class="block">Isi Aspirasi</label>
            <textarea name="isi" class="border w-full p-2 rounded" rows="5" required></textarea>
        </div>
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Kirim</button>
    </form>
</x-app-layout>
