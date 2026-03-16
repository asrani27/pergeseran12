@extends('layouts.app')

@section('title', 'Buat Pengajuan Pergeseran')

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

<!--====== CREATE PENGAJUAN CONTENT ======-->
<div class="transition-all duration-300">

    <!-- Header -->
    <div class="mb-6">
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl p-6 text-white shadow-lg">
            <div class="text-center">
                <h1 class="text-3xl font-bold mb-2">Buat Pengajuan Baru</h1>
                <p class="text-blue-100">Silahkan isi form di bawah ini untuk membuat pengajuan baru</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <form role="form" method="post" action="{{ route('skpd.pengajuan.store') }}">
            @csrf
            <div class="p-6">
                <!-- Form Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- No Surat -->
                    <div>
                        <label for="nomor_surat" class="block text-sm font-medium text-gray-700 mb-2">
                            No Surat <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nomor_surat" name="nomor_surat" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Masukkan nomor surat" value="{{ old('nomor_surat') }}">
                    </div>

                    <!-- Tanggal -->
                    <div>
                        <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="tanggal" name="tanggal" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            value="{{ old('tanggal', \Carbon\Carbon::today()->format('Y-m-d')) }}">
                    </div>
                </div>

                <!-- Dari (SKPD) -->
                <div class="mt-6">
                    <label for="dari" class="block text-sm font-medium text-gray-700 mb-2">
                        Dari
                    </label>
                    <input type="text" id="dari" readonly
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-700"
                        value="{{Auth::user()->skpdAsUser->nama ?? Auth::user()->skpdAsKepala->nama ?? 'SKPD'}}">
                    <input type="hidden" name="skpd_id" value="{{Auth::user()->skpdAsUser->id ?? Auth::user()->skpdAsKepala->id ?? ''}}">
                </div>

                <!-- Tipe Pengajuan -->
                <div class="mt-6">
                    <label for="tipe_pengajuan" class="block text-sm font-medium text-gray-700 mb-2">
                        Tipe Pengajuan Perubahan <span class="text-red-500">*</span>
                    </label>
                    <select id="tipe_pengajuan" name="tipe_pengajuan" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Pilih Tipe Pengajuan Perubahan</option>
                        <option value="1" {{ old('tipe_pengajuan') == '1' ? 'selected' : '' }}>Antar Objek</option>
                        <option value="2" {{ old('tipe_pengajuan') == '2' ? 'selected' : '' }}>Antar Rincian Objek</option>
                        <option value="3" {{ old('tipe_pengajuan') == '3' ? 'selected' : '' }}>Antar Sub Rincian Objek</option>
                        <option value="4" {{ old('tipe_pengajuan') == '4' ? 'selected' : '' }}>Perubahan Uraian</option>
                    </select>
                </div>

                <!-- Hal -->
                <div class="mt-6">
                    <label for="hal" class="block text-sm font-medium text-gray-700 mb-2">
                        Hal
                    </label>
                    <input type="text" id="hal" name="hal"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Masukkan hal" value="{{ old('hal') }}">
                </div>

                <!-- Kalimat Pengantar -->
                <div class="mt-6">
                    <label for="pengantar" class="block text-sm font-medium text-gray-700 mb-2">
                        Kalimat Pengantar
                    </label>
                    <textarea id="pengantar" name="pengantar" rows="4"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Masukkan kalimat pengantar">{{ old('pengantar') }}</textarea>
                </div>

                <!-- Lampiran -->
                <div class="mt-6">
                    <label for="lampiran" class="block text-sm font-medium text-gray-700 mb-2">
                        Lampiran
                    </label>
                    <input type="file" id="lampiran" name="lampiran"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        accept=".pdf,.doc,.docx,.xls,.xlsx"
                        value="{{ old('lampiran') }}">
                </div>

                <!-- Program, Kegiatan, Sub Kegiatan -->
                <div class="space-y-6 mt-6">
                    <!-- Program -->
                    <div>
                        <label for="program" class="block text-sm font-medium text-gray-700 mb-2">
                            Program <span class="text-red-500">*</span>
                        </label>
                        <select id="program" name="program" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Pilih Program</option>
                            @if(isset($program))
                            @foreach ($program as $item)
                            <option value="{{$item->id}}" 
                                data-kode-skpd="{{$item->kode_skpd}}" 
                                data-kode-program="{{$item->kode}}" 
                                data-tahun="{{$item->tahun}}"
                                {{ old('program') == $item->id ? 'selected' : '' }}>
                                {{$item->kode}} - {{$item->nama}}
                            </option>
                            @endforeach
                            @endif
                        </select>
                    </div>

                    <!-- Kegiatan -->
                    <div>
                        <label for="kegiatan" class="block text-sm font-medium text-gray-700 mb-2">
                            Kegiatan <span class="text-red-500">*</span>
                        </label>
                        <select id="kegiatan" name="kegiatan" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Pilih Kegiatan</option>
                            @if(old('kegiatan'))
                            <option value="{{ old('kegiatan') }}" selected selected>Selected Kegiatan</option>
                            @endif
                        </select>
                    </div>

                    <!-- Sub Kegiatan -->
                    <div>
                        <label for="subkegiatan" class="block text-sm font-medium text-gray-700 mb-2">
                            Sub Kegiatan <span class="text-red-500">*</span>
                        </label>
                        <select id="subkegiatan" name="subkegiatan" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Pilih Sub Kegiatan</option>
                            @if(old('subkegiatan'))
                            <option value="{{ old('subkegiatan') }}" selected>Selected Sub Kegiatan</option>
                            @endif
                        </select>
                    </div>
                </div>
            </div>

            <!-- Form Footer -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 rounded-b-xl">
                <div class="flex justify-between items-center">
                    <a href="{{ route('skpd.pengajuan') }}"
                        class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors flex items-center space-x-2">
                        <i class="fas fa-save"></i>
                        <span>Simpan Pengajuan</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Program change handler
    document.getElementById('program').addEventListener('change', function() {
        const programId = this.value;
        const kegiatanSelect = document.getElementById('kegiatan');
        const subkegiatanSelect = document.getElementById('subkegiatan');
        
        // Get selected program data attributes
        const selectedOption = this.options[this.selectedIndex];
        const kodeSkpd = selectedOption.getAttribute('data-kode-skpd');
        const kodeProgram = selectedOption.getAttribute('data-kode-program');
        const tahun = selectedOption.getAttribute('data-tahun');
        
        // Reset kegiatan and subkegiatan
        kegiatanSelect.innerHTML = '<option value="">Pilih Kegiatan</option>';
        subkegiatanSelect.innerHTML = '<option value="">Pilih Sub Kegiatan</option>';
        
        if (programId) {
            // Pass kode_skpd, kode_program, and tahun as query parameters
            axios.get(`/kegiatan/${programId}`, {
                params: {
                    kode_skpd: kodeSkpd,
                    kode_program: kodeProgram,
                    tahun: tahun
                }
            })
                .then(function(response) {
                    response.data.forEach(function(item) {
                        const option = document.createElement('option');
                        option.value = item.id;
                        option.textContent = item.kode + ' - ' + item.nama;
                        option.setAttribute('data-kode-kegiatan', item.kode);
                        kegiatanSelect.appendChild(option);
                    });
                })
                .catch(function(error) {
                    console.error('Error fetching kegiatan:', error);
                });
        }
    });

    // Kegiatan change handler
    document.getElementById('kegiatan').addEventListener('change', function() {
        const kegiatanId = this.value;
        const subkegiatanSelect = document.getElementById('subkegiatan');
        
        // Get program data
        const programSelect = document.getElementById('program');
        const selectedProgramOption = programSelect.options[programSelect.selectedIndex];
        const kodeSkpd = selectedProgramOption.getAttribute('data-kode-skpd');
        const kodeProgram = selectedProgramOption.getAttribute('data-kode-program');
        const tahun = selectedProgramOption.getAttribute('data-tahun');
        
        // Get selected kegiatan data
        const selectedKegiatanOption = this.options[this.selectedIndex];
        const kodeKegiatan = selectedKegiatanOption.getAttribute('data-kode-kegiatan');
        
        // Reset subkegiatan
        subkegiatanSelect.innerHTML = '<option value="">Pilih Sub Kegiatan</option>';
        
        if (kegiatanId) {
            // Pass kode_skpd, kode_program, kode_kegiatan, and tahun as query parameters
            axios.get(`/subkegiatan/${kegiatanId}`, {
                params: {
                    kode_skpd: kodeSkpd,
                    kode_program: kodeProgram,
                    kode_kegiatan: kodeKegiatan,
                    tahun: tahun
                }
            })
                .then(function(response) {
                    response.data.forEach(function(item) {
                        const option = document.createElement('option');
                        option.value = item.id;
                        option.textContent = item.kode + ' - ' + item.nama;
                        subkegiatanSelect.appendChild(option);
                    });
                })
                .catch(function(error) {
                    console.error('Error fetching subkegiatan:', error);
                });
        }
    });
});
</script>
@endpush
