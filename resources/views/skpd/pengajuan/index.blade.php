@extends('layouts.app')

@section('title', 'Pengajuan Pergeseran')

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

<!--====== PENGAJUAN CONTENT ======-->
<div class="transition-all duration-300">

    <!-- Header -->
    <div class="mb-6">
        <div class="bg-gradient-to-r from-green-600 to-teal-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold mb-2">Pengajuan Pergeseran</h1>
                    <p class="text-green-100">Kelola pengajuan pergeseran anggaran</p>
                </div>
                <a href="{{ route('skpd.pengajuan.create') }}"
                    class="bg-white text-green-600 hover:bg-green-50 px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Buat Pengajuan</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Daftar Pengajuan</h3>
                <div class="flex items-center space-x-3">
                    <select
                        class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option>Semua Status</option>
                        <option>Menunggu</option>
                        <option>Sedang Proses</option>
                        <option>Selesai</option>
                        <option>Ditolak</option>
                    </select>
                    <button
                        class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-2 rounded-lg text-sm transition-colors">
                        <i class="fas fa-filter mr-2"></i> Filter
                    </button>
                </div>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            No
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tanggal
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nomor Surat
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status Operator
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status Kepala SKPD
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status BPKPAD
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @if($pengajuan->count() > 0)
                        @foreach($pengajuan as $index => $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $index + 1 }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $item->nomor_surat }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @switch($item->status_operator)
                                    @case(1)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Di Proses
                                        </span>
                                        @break
                                    @case(2)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Selesai
                                        </span>
                                        @break
                                    @default
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            Unknown
                                        </span>
                                @endswitch
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @switch($item->status_kepala_skpd)
                                    @case(0)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            Menunggu
                                        </span>
                                        @break
                                    @case(1)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Di Proses
                                        </span>
                                        @break
                                    @case(2)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Selesai
                                        </span>
                                        @break
                                    @case(3)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Ditolak
                                        </span>
                                        @break
                                    @default
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            Unknown
                                        </span>
                                @endswitch
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @switch($item->status_bpkpad)
                                    @case(0)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            Menunggu
                                        </span>
                                        @break
                                    @case(1)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Di Proses
                                        </span>
                                        @break
                                    @case(2)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Selesai
                                        </span>
                                        @break
                                    @case(3)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Ditolak
                                        </span>
                                        @break
                                    @default
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            Unknown
                                        </span>
                                @endswitch
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('skpd.pengajuan.show', $item->id) }}" 
                                       class="text-blue-600 hover:text-blue-900" title="Lihat Detail">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    <a href="{{ route('skpd.pengajuan.edit', $item->id) }}" 
                                       class="text-yellow-600 hover:text-yellow-900" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <button onclick="deletePengajuan({{ $item->id }})" 
                                            class="text-red-600 hover:text-red-900" title="Hapus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                <p class="mt-2 text-sm">Belum ada data pengajuan</p>
                                <p class="text-xs text-gray-400 mt-1">Klik tombol "Buat Pengajuan" untuk menambahkan data
                                </p>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Pagination (hidden when no data) -->
        <div class="px-6 py-4 border-t border-gray-200 hidden">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Menampilkan <span class="font-medium">1</span> hingga <span class="font-medium">10</span> dari <span
                        class="font-medium">0</span> hasil
                </div>
                <div class="flex items-center space-x-2">
                    <button
                        class="px-3 py-1 text-sm border border-gray-300 rounded-lg hover:bg-gray-50 disabled:opacity-50"
                        disabled>
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="px-3 py-1 text-sm bg-blue-600 text-white rounded-lg">1</button>
                    <button class="px-3 py-1 text-sm border border-gray-300 rounded-lg hover:bg-gray-50" disabled>
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function deletePengajuan(id) {
    if (confirm('Apakah Anda yakin ingin menghapus pengajuan ini?')) {
        // Get CSRF token
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // Create form data for Laravel to recognize as AJAX
        const formData = new FormData();
        formData.append('_method', 'DELETE');
        formData.append('_token', token);

        fetch(`/skpd/pengajuan/${id}`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            console.log('Response status:', response.status);
            return response.json().catch(() => {
                // If response is not JSON, check if it's a redirect
                if (response.ok) {
                    return { success: true, message: 'Pengajuan berhasil dihapus!' };
                }
                throw new Error('Response is not valid JSON');
            });
        })
        .then(result => {
            console.log('Response data:', result);
            if (result.success) {
                // Show success message at top right
                const successDiv = document.createElement('div');
                successDiv.className = 'fixed top-4 right-4 z-50 p-4 bg-green-50 border border-green-200 rounded-lg shadow-lg flex items-center';
                successDiv.style.minWidth = '300px';
                successDiv.innerHTML = `
                    <svg class="w-5 h-5 text-green-600 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-green-800 text-sm font-medium">${result.message || 'Pengajuan berhasil dihapus!'}</p>
                `;
                
                // Insert success message at top right of body
                document.body.appendChild(successDiv);
                
                // Remove the deleted row from table with animation
                const row = document.querySelector(`button[onclick="deletePengajuan(${id})"]`).closest('tr');
                row.style.transition = 'opacity 0.3s, transform 0.3s';
                row.style.opacity = '0.5';
                row.style.transform = 'scale(0.95)';
                
                setTimeout(() => {
                    row.remove();
                    // Check if table is empty and show empty state
                    const tbody = row.closest('tbody');
                    if (tbody && tbody.children.length === 0) {
                        tbody.innerHTML = `
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    <p class="mt-2 text-sm">Belum ada data pengajuan</p>
                                    <p class="text-xs text-gray-400 mt-1">Klik tombol "Buat Pengajuan" untuk menambahkan data</p>
                                </td>
                            </tr>
                        `;
                    }
                }, 300);
                
                // Add initial animation
                successDiv.style.transform = 'translateX(100%)';
                successDiv.style.opacity = '0';
                successDiv.style.transition = 'transform 0.3s ease-out, opacity 0.3s ease-out';
                
                // Trigger animation
                setTimeout(() => {
                    successDiv.style.transform = 'translateX(0)';
                    successDiv.style.opacity = '1';
                }, 10);
                
                // Hide success message after 3 seconds
                setTimeout(() => {
                    successDiv.style.transform = 'translateX(100%)';
                    successDiv.style.opacity = '0';
                    setTimeout(() => successDiv.remove(), 300);
                }, 3000);
            } else {
                alert('Gagal menghapus pengajuan: ' + (result.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menghapus pengajuan. Silakan refresh halaman dan coba lagi.');
        });
    }
}
</script>
@endpush
@endsection
