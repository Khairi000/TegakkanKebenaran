<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Kirim Aspirasi
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto sm:px-6 lg:px-8">
        {{-- Tampilkan error validasi --}}
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <strong class="font-semibold">Terjadi kesalahan:</strong>
                <ul class="mt-2 list-disc pl-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form aspirasi --}}
        <form id="formAspirasi"
              action="{{ route('aspirasi.store') }}"
              method="POST"
              enctype="multipart/form-data"
              class="bg-white p-6 shadow rounded space-y-4">
            @csrf

            {{-- Judul --}}
            <div>
                <label for="judul" class="block font-semibold mb-1">Judul</label>
                <input type="text"
                       name="judul"
                       id="judul"
                       value="{{ old('judul') }}"
                       class="border w-full p-2 rounded focus:ring focus:ring-green-300"
                       required>
            </div>

            {{-- Isi Aspirasi --}}
            <div>
                <label for="isi" class="block font-semibold mb-1">Isi Aspirasi</label>
                <textarea name="isi"
                          id="isi"
                          rows="5"
                          class="border w-full p-2 rounded focus:ring focus:ring-green-300"
                          required>{{ old('isi') }}</textarea>
            </div>

            {{-- Foto --}}
            <div>
                <label for="foto" class="block font-semibold mb-1">Foto (opsional)</label>
                <input type="file"
                       name="foto"
                       id="foto"
                       class="border w-full p-2 rounded bg-gray-50"
                       accept="image/jpeg,image/png,image/jpg,image/gif,image/webp">
                <small class="text-gray-500 text-sm">Maks 2MB. Format: jpeg, png, jpg, gif, webp</small>
            </div>

            {{-- Tombol submit --}}
            <div>
                <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded shadow">
                    🚀 Kirim Aspirasi
                </button>
            </div>
        </form>
    </div>

    {{-- Integrasi Blockchain --}}
    <script type="module">
        import { simpanAspirasiBlockchain } from "/resources/js/blockchain/aspirasi.js";

        // Fungsi hashing SHA-256
        async function sha256(message) {
            const msgBuffer = new TextEncoder().encode(message);
            const hashBuffer = await crypto.subtle.digest('SHA-256', msgBuffer);
            const hashArray = Array.from(new Uint8Array(hashBuffer));
            return hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
        }

        document.getElementById('formAspirasi').addEventListener('submit', async (e) => {
            e.preventDefault();

            const judul = document.getElementById('judul').value;
            const isi = document.getElementById('isi').value;

            const hash = await sha256(judul + isi + Date.now());

            try {
                // Simpan ke blockchain
                await simpanAspirasiBlockchain(judul, hash);
                console.log("✅ Data aspirasi berhasil disimpan di blockchain");
            } catch (error) {
                console.error("❌ Gagal menyimpan ke blockchain:", error);
                alert("Terjadi kesalahan saat menyimpan ke blockchain!");
            }

            // Setelah berhasil, kirim form ke Laravel
            e.target.submit();
        });
    </script>
</x-app-layout>
