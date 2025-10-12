<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Kirim Aspirasi
            </h2>
            <a href="{{ route('aspirasi.index') }}"
               class="mt-2 md:mt-0 inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition-all duration-300">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Daftar
            </a>
        </div>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto sm:px-6 lg:px-8">
        {{-- Error Messages --}}
        @if ($errors->any())
            <div id="errorContainer" class="error-message bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg shadow-sm">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-500 mt-1"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-semibold text-red-800">Terjadi kesalahan:</h3>
                        <ul class="mt-2 list-disc pl-5 text-sm text-red-700">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        {{-- Success Message --}}
        @if(session('success'))
            <div id="successMessage" class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-r-lg shadow-sm">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-500 mt-1"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-semibold text-green-800">Berhasil!</h3>
                        <p class="mt-1 text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        {{-- Form Container --}}
        <div class="card bg-white p-6 shadow-sm sm:rounded-lg">
            <form id="formAspirasi"
                  action="{{ route('aspirasi.store') }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="space-y-6">
                @csrf

                {{-- CSRF Token Hidden Field untuk JavaScript --}}
                <input type="hidden" id="csrf_token" name="_token" value="{{ csrf_token() }}">

                {{-- Judul --}}
                <div>
                    <label for="judul" class="block font-semibold text-gray-700 mb-2 flex items-center">
                        <i class="fas fa-heading text-green-500 mr-2"></i>
                        Judul Aspirasi
                    </label>
                    <input type="text"
                           name="judul"
                           id="judul"
                           value="{{ old('judul') }}"
                           maxlength="100"
                           class="form-input w-full p-3 rounded-lg border border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50"
                           placeholder="Masukkan judul aspirasi Anda..."
                           required>
                    <div class="char-counter" id="judulCounter">0/100</div>
                </div>

                {{-- Isi Aspirasi --}}
                <div>
                    <label for="isi" class="block font-semibold text-gray-700 mb-2 flex items-center">
                        <i class="fas fa-align-left text-green-500 mr-2"></i>
                        Isi Aspirasi
                    </label>
                    <textarea name="isi"
                              id="isi"
                              rows="6"
                              maxlength="1000"
                              class="form-input w-full p-3 rounded-lg border border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50 resize-none"
                              placeholder="Tuliskan aspirasi Anda secara detail..."
                              required>{{ old('isi') }}</textarea>
                    <div class="char-counter" id="isiCounter">0/1000</div>
                </div>

                {{-- Foto --}}
                <div>
    <label class="block font-semibold text-gray-700 mb-2 flex items-center">
        <i class="fas fa-camera text-green-500 mr-2"></i>
        Foto Pendukung (Opsional)
    </label>

    {{-- Upload Area dengan Drag & Drop --}}
    <div class="file-upload-area border-2 border-dashed border-gray-300 rounded-lg p-6 text-center transition-all duration-300 hover:border-green-400 hover:bg-green-50"
         id="uploadArea">
        <div id="uploadPlaceholder">
            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3"></i>
            <p class="text-gray-600 font-medium">Seret dan lepas foto di sini</p>
            <p class="text-gray-500 text-sm mt-1">atau</p>
            <button type="button"
                    class="mt-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300">
                Pilih File
            </button>
            <p class="text-gray-400 text-xs mt-2">Maks. 2MB (JPEG, PNG, JPG, GIF, WEBP)</p>
        </div>

        <div id="uploadPreview" class="hidden">
            <div class="flex items-center justify-between bg-white rounded-lg p-3 shadow-sm border">
                <div class="flex items-center space-x-3">
                    <img id="previewThumb" class="w-12 h-12 object-cover rounded" alt="Preview">
                    <div class="text-left">
                        <p id="previewName" class="text-sm font-medium text-gray-800"></p>
                        <p id="previewSize" class="text-xs text-gray-500"></p>
                    </div>
                </div>
                <button type="button"
                        id="removeUpload"
                        class="text-red-500 hover:text-red-700 transition-colors duration-300">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>

        <input type="file"
               name="foto"
               id="foto"
               class="hidden"
               accept="image/jpeg,image/png,image/jpg,image/gif,image/webp">
    </div>

    {{-- Full Size Preview --}}
    <div id="fullPreview" class="mt-4 hidden">
        <p class="text-sm text-gray-600 mb-2">Preview:</p>
        <div class="relative inline-block">
            <img id="fullPreviewImage"
                 class="max-w-full max-h-64 object-contain rounded-lg shadow-md border border-gray-200"
                 alt="Preview foto">
            <button type="button"
                    id="closePreview"
                    class="absolute -top-2 -right-2 bg-gray-600 hover:bg-gray-700 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs transition-all duration-300 shadow-md">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
</div>

<style>
    .file-upload-area {
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .file-upload-area.dragover {
        border-color: #10b981;
        background-color: #f0fdf4;
        transform: scale(1.02);
    }

    #previewThumb {
        transition: transform 0.3s ease;
    }

    #previewThumb:hover {
        transform: scale(1.1);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const uploadArea = document.getElementById('uploadArea');
        const uploadPlaceholder = document.getElementById('uploadPlaceholder');
        const uploadPreview = document.getElementById('uploadPreview');
        const fullPreview = document.getElementById('fullPreview');
        const fileInput = document.getElementById('foto');
        const previewThumb = document.getElementById('previewThumb');
        const previewName = document.getElementById('previewName');
        const previewSize = document.getElementById('previewSize');
        const fullPreviewImage = document.getElementById('fullPreviewImage');
        const removeUpload = document.getElementById('removeUpload');
        const closePreview = document.getElementById('closePreview');

        // Click to select file
        uploadArea.addEventListener('click', function() {
            fileInput.click();
        });

        // File input change
        fileInput.addEventListener('change', handleFileSelect);

        // Drag and drop events
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            uploadArea.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, unhighlight, false);
        });

        function highlight() {
            uploadArea.classList.add('dragover');
        }

        function unhighlight() {
            uploadArea.classList.remove('dragover');
        }

        uploadArea.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            fileInput.files = files;
            handleFileSelect();
        }

        function handleFileSelect() {
            const file = fileInput.files[0];

            if (file) {
                // Validations
                if (file.size > 2 * 1024 * 1024) {
                    alert('Ukuran file terlalu besar. Maksimal 2MB.');
                    resetUpload();
                    return;
                }

                const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];
                if (!validTypes.includes(file.type)) {
                    alert('Format file tidak didukung. Gunakan JPEG, PNG, JPG, GIF, atau WEBP.');
                    resetUpload();
                    return;
                }

                // Show preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewThumb.src = e.target.result;
                    fullPreviewImage.src = e.target.result;

                    previewName.textContent = file.name;
                    previewSize.textContent = formatFileSize(file.size);

                    uploadPlaceholder.classList.add('hidden');
                    uploadPreview.classList.remove('hidden');
                    fullPreview.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        }

        // Remove file
        removeUpload.addEventListener('click', function(e) {
            e.stopPropagation();
            resetUpload();
        });

        // Close full preview
        closePreview.addEventListener('click', function() {
            fullPreview.classList.add('hidden');
        });

        // Show full preview on thumb click
        previewThumb.addEventListener('click', function(e) {
            e.stopPropagation();
            fullPreview.classList.remove('hidden');
        });

        // Helper function to format file size
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        // Reset upload
        function resetUpload() {
            fileInput.value = '';
            uploadPlaceholder.classList.remove('hidden');
            uploadPreview.classList.add('hidden');
            fullPreview.classList.add('hidden');
        }
    });
</script>

                {{-- Submit Button --}}
                <div class="pt-4">
                    <button type="submit"
                            id="submitBtn"
                            class="btn-primary text-white font-semibold py-3 px-6 rounded-lg w-full flex items-center justify-center">
                        <i class="fas fa-paper-plane mr-2"></i>
                        <span>Kirim Aspirasi</span>
                    </button>

                    {{-- Loading Indicator --}}
                    <div id="loadingIndicator" class="loading mt-4 text-center">
                        <div class="inline-flex items-center">
                            <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-green-600 mr-3"></div>
                            <span class="text-gray-700">Menyimpan ke blockchain...</span>
                        </div>
                    </div>

                    {{-- Blockchain Status --}}
                    <div id="blockchainStatus" class="blockchain-status">
                        <i class="fas fa-link text-blue-500"></i>
                        <span class="text-blue-800">Data telah disimpan di blockchain</span>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <style>
        .card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        .form-input {
            transition: all 0.3s ease;
            border: 2px solid #e2e8f0;
        }

        .form-input:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }

        .btn-primary {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 7px 14px rgba(16, 185, 129, 0.4);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-primary::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 5px;
            height: 5px;
            background: rgba(255, 255, 255, 0.5);
            opacity: 0;
            border-radius: 100%;
            transform: scale(1, 1) translate(-50%);
            transform-origin: 50% 50%;
        }

        .btn-primary:focus:not(:active)::after {
            animation: ripple 1s ease-out;
        }

        @keyframes ripple {
            0% {
                transform: scale(0, 0);
                opacity: 0.5;
            }
            100% {
                transform: scale(20, 20);
                opacity: 0;
            }
        }

        .error-message {
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {
            0%, 100% {transform: translateX(0);}
            10%, 30%, 50%, 70%, 90% {transform: translateX(-5px);}
            20%, 40%, 60%, 80% {transform: translateX(5px);}
        }

        .loading {
            display: none;
        }

        .file-upload {
            position: relative;
            overflow: hidden;
            display: inline-block;
            width: 100%;
        }

        .file-upload-btn {
            background: #f8fafc;
            border: 2px dashed #cbd5e0;
            color: #4a5568;
            padding: 8px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 120px;
            flex-direction: column;
        }

        .file-upload-btn:hover {
            background: #edf2f7;
            border-color: #10b981;
        }

        .file-upload-input {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .blockchain-status {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 20px;
            padding: 15px;
            border-radius: 10px;
            background: #f0f9ff;
            border: 1px solid #bae6fd;
            display: none;
        }

        .blockchain-status i {
            margin-right: 10px;
            font-size: 20px;
        }

        .char-counter {
            text-align: right;
            font-size: 12px;
            color: #6b7280;
            margin-top: 5px;
        }

        .char-counter.warning {
            color: #f59e0b;
        }

        .char-counter.danger {
            color: #ef4444;
        }
    </style>

    <script>
        // Fungsi untuk menampilkan error
        function showErrors(errors) {
            const errorContainer = document.getElementById('errorContainer');
            const errorList = document.getElementById('errorList');

            if (errors.length > 0) {
                // Jika error container belum ada, buat yang baru
                if (!errorContainer) {
                    createErrorContainer();
                }

                errorList.innerHTML = '';
                errors.forEach(error => {
                    const errorItem = document.createElement('p');
                    errorItem.textContent = error;
                    errorList.appendChild(errorItem);
                });

                errorContainer.style.display = 'block';

                // Sembunyikan error setelah 5 detik
                setTimeout(() => {
                    errorContainer.style.display = 'none';
                }, 5000);
            } else if (errorContainer) {
                errorContainer.style.display = 'none';
            }
        }

        // Fungsi untuk membuat error container jika belum ada
        function createErrorContainer() {
            const container = document.createElement('div');
            container.id = 'errorContainer';
            container.className = 'error-message bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg shadow-sm';
            container.style.display = 'none';

            container.innerHTML = `
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-500 mt-1"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-semibold text-red-800">Terjadi kesalahan</h3>
                        <div id="errorList" class="mt-1 text-sm text-red-700"></div>
                    </div>
                </div>
            `;

            document.querySelector('.max-w-3xl').insertBefore(container, document.querySelector('.card'));
        }

        // Counter untuk judul dan isi
        document.getElementById('judul').addEventListener('input', function() {
            const counter = document.getElementById('judulCounter');
            const length = this.value.length;
            counter.textContent = `${length}/100`;

            if (length > 80) {
                counter.classList.add('warning');
                counter.classList.remove('danger');
            } else if (length > 95) {
                counter.classList.remove('warning');
                counter.classList.add('danger');
            } else {
                counter.classList.remove('warning', 'danger');
            }
        });

        document.getElementById('isi').addEventListener('input', function() {
            const counter = document.getElementById('isiCounter');
            const length = this.value.length;
            counter.textContent = `${length}/1000`;

            if (length > 800) {
                counter.classList.add('warning');
                counter.classList.remove('danger');
            } else if (length > 950) {
                counter.classList.remove('warning');
                counter.classList.add('danger');
            } else {
                counter.classList.remove('warning', 'danger');
            }
        });

        // Handler untuk upload file
        document.getElementById('foto').addEventListener('change', function() {
            const fileName = document.getElementById('fileName');
            const fileUploadBtn = document.getElementById('fileUploadBtn');

            if (this.files.length > 0) {
                const file = this.files[0];
                fileName.textContent = `File terpilih: ${file.name}`;

                // Update tampilan tombol upload
                fileUploadBtn.innerHTML = `
                    <i class="fas fa-file-image text-2xl text-green-500 mb-2"></i>
                    <span class="text-gray-700">${file.name}</span>
                    <span class="text-sm text-gray-500 mt-1">Klik untuk mengganti file</span>
                `;
            } else {
                fileName.textContent = '';
                fileUploadBtn.innerHTML = `
                    <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                    <span class="text-gray-600">Klik untuk mengunggah foto</span>
                    <span class="text-sm text-gray-500 mt-1">Maks. 2MB (JPEG, PNG, JPG, GIF, WEBP)</span>
                `;
            }
        });

        // Validasi file size
        document.getElementById('foto').addEventListener('change', function() {
            const file = this.files[0];
            if (file && file.size > 2 * 1024 * 1024) { // 2MB
                showErrors(['Ukuran file terlalu besar. Maksimal 2MB.']);
                this.value = '';
                document.getElementById('fileName').textContent = '';
                document.getElementById('fileUploadBtn').innerHTML = `
                    <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                    <span class="text-gray-600">Klik untuk mengunggah foto</span>
                    <span class="text-sm text-gray-500 mt-1">Maks. 2MB (JPEG, PNG, JPG, GIF, WEBP)</span>
                `;
            }
        });

        // Fungsi hashing SHA-256
        async function sha256(message) {
            const msgBuffer = new TextEncoder().encode(message);
            const hashBuffer = await crypto.subtle.digest('SHA-256', msgBuffer);
            const hashArray = Array.from(new Uint8Array(hashBuffer));
            return hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
        }

        // Handler form submission dengan blockchain
        document.getElementById('formAspirasi').addEventListener('submit', async (e) => {
            e.preventDefault();

            const submitBtn = document.getElementById('submitBtn');
            const loadingIndicator = document.getElementById('loadingIndicator');
            const blockchainStatus = document.getElementById('blockchainStatus');
            const form = e.target;

            // Validasi form
            const judul = document.getElementById('judul').value.trim();
            const isi = document.getElementById('isi').value.trim();

            const errors = [];

            if (!judul) {
                errors.push('Judul harus diisi');
            }

            if (!isi) {
                errors.push('Isi aspirasi harus diisi');
            }

            if (judul.length > 100) {
                errors.push('Judul terlalu panjang (maks. 100 karakter)');
            }

            if (isi.length > 1000) {
                errors.push('Isi aspirasi terlalu panjang (maks. 1000 karakter)');
            }

            if (errors.length > 0) {
                showErrors(errors);
                return;
            }

            // Tampilkan loading
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i><span>Mengirim...</span>';
            loadingIndicator.style.display = 'block';

            try {
                // Generate hash untuk blockchain
                const hash = await sha256(judul + isi + Date.now());

                console.log("Menyimpan ke blockchain dengan hash:", hash);

                // Simulasi delay jaringan
                await new Promise(resolve => setTimeout(resolve, 2000));

                // Tampilkan status blockchain
                blockchainStatus.style.display = 'flex';

                // Submit form asli ke Laravel setelah blockchain berhasil
                setTimeout(() => {
                    // Submit form secara normal
                    form.submit();
                }, 1000);

            } catch (error) {
                console.error("❌ Gagal menyimpan ke blockchain:", error);
                showErrors(['Terjadi kesalahan saat menyimpan ke blockchain!']);
                loadingIndicator.style.display = 'none';
                blockchainStatus.style.display = 'none';
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-paper-plane mr-2"></i><span>Kirim Aspirasi</span>';
            }
        });

        // Inisialisasi counter pada load
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('judulCounter').textContent = '0/100';
            document.getElementById('isiCounter').textContent = '0/1000';

            // Set nilai counter jika ada data old
            const judulValue = document.getElementById('judul').value;
            const isiValue = document.getElementById('isi').value;

            if (judulValue) {
                document.getElementById('judulCounter').textContent = `${judulValue.length}/100`;
            }

            if (isiValue) {
                document.getElementById('isiCounter').textContent = `${isiValue.length}/1000`;
            }
        });
    </script>
</x-app-layout>
