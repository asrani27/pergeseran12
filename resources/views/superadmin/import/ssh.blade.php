@extends('layouts.app')

@section('title', 'Import SSH')

@section('content')
<!--====== NOTIFICATIONS ======-->
@if(session('success'))
<div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-center">
    <svg class="w-5 h-5 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
    </svg>
    <p class="text-green-800 text-sm font-medium">{{ session('success') }}</p>
</div>
@endif

@if(session('error'))
<div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg flex items-center">
    <svg class="w-5 h-5 text-red-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
    </svg>
    <p class="text-red-800 text-sm font-medium">{{ session('error') }}</p>
</div>
@endif

<!--====== IMPORT SSH CONTENT ======-->
<div class="transition-all duration-300">

    <!-- Header -->
    <div class="mb-6">
        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold mb-2">Import SSH</h1>
                    <p class="text-purple-100">Import data Standar Satuan Harga dari file Excel</p>
                </div>
                <div class="bg-white/20 rounded-lg p-3">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Import Form Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 rounded-t-xl">
            <h3 class="text-lg font-semibold text-gray-900">Form Import SSH</h3>
            <p class="text-sm text-gray-500">Isi data di bawah ini untuk memulai proses import</p>
        </div>
        <div class="p-6">
            <form action="{{ route('import.ssh.store') }}" method="POST" enctype="multipart/form-data"
                class="space-y-6">
                @csrf

                <!-- Tahun -->
                <div>
                    <label for="tahun" class="block text-sm font-medium text-gray-700 mb-2">Tahun</label>
                    <select id="tahun" name="tahun" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        <option value="">Pilih Tahun</option>
                        <option value="2026">2026</option>
                        <option value="2027">2027</option>
                        <option value="2028">2028</option>
                    </select>
                </div>

                <!-- Jenis -->
                <div>
                    <label for="jenis" class="block text-sm font-medium text-gray-700 mb-2">Jenis</label>
                    <select id="jenis" name="jenis" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        <option value="">Pilih Jenis</option>
                        <option value="SSH">SSH (Standar Satuan Harga)</option>
                        <option value="ASB">ASB (Analisis Standar Belanja)</option>
                        <option value="HSPK">HSPK (Harga Satuan Pokok Kegiatan)</option>
                    </select>
                </div>

                <!-- File Upload -->
                <div>
                    <label for="file" class="block text-sm font-medium text-gray-700 mb-2">File Excel</label>
                    <div
                        class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-blue-500 transition-colors">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                viewBox="0 0 48 48">
                                <path
                                    d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="file"
                                    class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                    <span>Upload file</span>
                                    <input id="file" name="file" type="file" class="sr-only" accept=".xlsx,.xls"
                                        required>
                                </label>
                                <p class="pl-1">atau drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">XLSX, XLS hingga 10MB</p>
                            <p id="file-name" class="text-sm text-blue-600 font-medium mt-2"></p>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="window.location.href='{{ route('import.index') }}'"
                        class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors font-medium">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all font-medium flex items-center space-x-2 shadow-md hover:shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                            </path>
                        </svg>
                        <span>Import Data</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Info Card -->
    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-xl p-6">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800">Informasi Import</h3>
                <div class="mt-2 text-sm text-blue-700">
                    <ul class="list-disc list-inside space-y-1">
                        <li>Format file yang didukung: .xlsx dan .xls</li>
                        <li>Ukuran file maksimal: 10MB</li>
                        <li>Pastikan data pada file sudah sesuai format</li>
                        <li>Proses import akan memperbarui data yang sudah ada</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- SSH Data Table -->
    <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 rounded-t-xl">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Data SSH</h3>
                    <p class="text-sm text-gray-500">Tabel data Standar Satuan Harga yang telah diimport</p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" id="searchInput" placeholder="Cari data SSH..."
                            class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent w-full sm:w-80 transition-all">
                    </div>
                    <div class="text-sm text-gray-600 whitespace-nowrap">
                        Total: <span class="font-semibold text-blue-600" id="totalCount">{{ $sshData->count() }}</span> data
                        <span id="filteredCount" class="hidden">(<span id="filteredNumber">0</span> ditampilkan)</span>
                    </div>
                </div>
            </div>
        </div>
        
        @if($sshData->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tahun</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Kelompok</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Uraian Kelompok</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Barang</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Uraian Barang</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Spesifikasi</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Satuan</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Rekening</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($sshData as $ssh)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3 text-sm text-gray-900 whitespace-nowrap">{{ $ssh->tahun }}</td>
                        <td class="px-4 py-3 text-sm">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($ssh->jenis == 'SSH') bg-green-100 text-green-800
                                @elseif($ssh->jenis == 'ASB') bg-blue-100 text-blue-800
                                @elseif($ssh->jenis == 'HSPK') bg-purple-100 text-purple-800
                                @endif">
                                {{ $ssh->jenis }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $ssh->kode_kelompok }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $ssh->uraian_kelompok }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600 whitespace-nowrap">{{ $ssh->kode_barang }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $ssh->uraian_barang }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600 max-w-xs truncate">{{ $ssh->spesifikasi }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600 whitespace-nowrap">{{ $ssh->satuan }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900 font-medium whitespace-nowrap">
                            {{ number_format($ssh->harga, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600 whitespace-nowrap">{{ $ssh->kode_rekening }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="p-12 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                </path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada data SSH</h3>
            <p class="mt-1 text-sm text-gray-500">Silakan import data SSH menggunakan form di atas</p>
        </div>
        @endif
    </div>

</div>

<script>
    // Display selected file name
    document.getElementById('file').addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name;
        const fileNameElement = document.getElementById('file-name');
        if (fileName) {
            fileNameElement.textContent = 'File terpilih: ' + fileName;
        } else {
            fileNameElement.textContent = '';
        }
    });

    // Search functionality
    document.getElementById('searchInput').addEventListener('keyup', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const table = document.querySelector('.overflow-x-auto table');
        const tbody = table.querySelector('tbody');
        const rows = tbody.querySelectorAll('tr');
        let visibleCount = 0;

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            if (text.includes(searchTerm)) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        // Update filtered count display
        const filteredCountSpan = document.getElementById('filteredCount');
        const filteredNumber = document.getElementById('filteredNumber');
        
        if (searchTerm !== '') {
            filteredCountSpan.classList.remove('hidden');
            filteredNumber.textContent = visibleCount;
        } else {
            filteredCountSpan.classList.add('hidden');
        }
    });
</script>

@endsection
