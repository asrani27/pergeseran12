<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class SkpdDashboardController extends Controller
{
    /**
     * Display the SKPD dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Get SKPD ID from user
        $skpdId = $user->skpdAsUser->id ?? $user->skpdAsKepala->id ?? null;
        
        if (!$skpdId) {
            // If no SKPD found, show empty statistics
            $totalPengajuan = 0;
            $sedangProses = 0;
            $selesai = 0;
            $suratAktif = 0;
            $recentActivities = collect();
        } else {
            // Get statistics from database for this SKPD
            $totalPengajuan = \App\Models\Pengajuan::where('skpd_id', $skpdId)->count();
            $sedangProses = \App\Models\Pengajuan::where('skpd_id', $skpdId)
                ->where('status_bpkpad', 1)
                ->count();
            $selesai = \App\Models\Pengajuan::where('skpd_id', $skpdId)
                ->where('status_bpkpad', 2)
                ->count();
            $suratAktif = \App\Models\Pengajuan::where('skpd_id', $skpdId)
                ->where('status_operator', 2)
                ->where('status_kepala_skpd', 2)
                ->count();

            // Get recent activities (last 10 pengajuan)
            $recentActivities = \App\Models\Pengajuan::with(['user'])
                ->where('skpd_id', $skpdId)
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();
        }

        return view('skpd.dashboard', compact(
            'totalPengajuan',
            'sedangProses',
            'selesai',
            'suratAktif',
            'recentActivities'
        ));
    }

    /**
     * Display the profile page.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        return view('skpd.profile');
    }

    /**
     * Display the pengajuan page.
     *
     * @return \Illuminate\Http\Response
     */
    public function pengajuan()
    {
        $pengajuan = \App\Models\Pengajuan::with(['user', 'skpd', 'program', 'kegiatan', 'subkegiatan'])
            ->where('user_id', Auth::user()->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('skpd.pengajuan.index', compact('pengajuan'));
    }

    /**
     * Display the specified pengajuan.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showPengajuan($id)
    {
        $pengajuan = \App\Models\Pengajuan::with(['user', 'skpd', 'program', 'kegiatan', 'subkegiatan'])
            ->where('id', $id)
            ->where('user_id', Auth::user()->id)
            ->firstOrFail();

        return view('skpd.pengajuan.show', compact('pengajuan'));
    }

    /**
     * Display the create pengajuan page.
     *
     * @return \Illuminate\Http\Response
     */
    public function createPengajuan()
    {
        // Get programs based on the logged-in SKPD
        $user = Auth::user();

        // Check if user is the operator/user of SKPD or the kepala/head of SKPD
        $skpd = $user->skpdAsUser ?? $user->skpdAsKepala ?? null;

        if (!$skpd) {
            return redirect()->route('skpd.pengajuan')
                ->with('error', 'SKPD tidak ditemukan untuk user ini.');
        }

        // Get programs based on kode_skpd (trim to remove any whitespace/newline characters)
        $program = \App\Models\Program::where('tahun', Carbon::now()->year)->where('kode_skpd', trim($skpd->kode_skpd))->get();

        return view('skpd.pengajuan.create', compact('program'));
    }

    /**
     * Store pengajuan.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storePengajuan(Request $request)
    {
        try {
            Log::info('Store pengajuan request data:', $request->all());

            $request->validate([
                'nomor_surat' => 'required|string|max:255',
                'tanggal' => 'required|date',
                'tipe_pengajuan' => 'required|integer',
                'hal' => 'nullable|string',
                'pengantar' => 'nullable|string',
                'lampiran' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:2048',
                'program' => 'required|integer|exists:program,id',
                'kegiatan' => 'required|integer|exists:kegiatan,id',
                'subkegiatan' => 'required|integer|exists:subkegiatan,id',
            ]);

            Log::info('Validation passed');

            // Get program, kegiatan, and subkegiatan details
            $program = \App\Models\Program::find($request->program);
            $kegiatan = \App\Models\Kegiatan::find($request->kegiatan);
            $subkegiatan = \App\Models\Subkegiatan::find($request->subkegiatan);

            // Handle file upload
            $lampiranPath = null;
            if ($request->hasFile('lampiran')) {
                $lampiranPath = $request->file('lampiran')->store('lampiran', 'public');
            }

            // Get SKPD ID from user
            $skpdId = Auth::user()->skpdAsUser->id ?? Auth::user()->skpdAsKepala->id ?? null;

            Log::info('Creating pengajuan with data:', [
                'skpd_id' => $skpdId,
                'user_id' => Auth::user()->id,
                'program_id' => $request->program,
                'kegiatan_id' => $request->kegiatan,
                'subkegiatan_id' => $request->subkegiatan
            ]);

            $n = new \App\Models\Pengajuan;
            $n->nomor_surat = $request->nomor_surat;
            $n->skpd_id = $skpdId;
            $n->user_id = Auth::user()->id;
            $n->tanggal = $request->tanggal;
            $n->tipe_pengajuan = $request->tipe_pengajuan;
            $n->hal = $request->hal;
            $n->pengantar = $request->pengantar;
            $n->lampiran = $lampiranPath;
            $n->program_id = $request->program;
            $n->kegiatan_id = $request->kegiatan;
            $n->subkegiatan_id = $request->subkegiatan;
            $n->kode_program = $program->kode ?? '';
            $n->nama_program = $program->nama ?? '';
            $n->kode_kegiatan = $kegiatan->kode ?? '';
            $n->nama_kegiatan = $kegiatan->nama ?? '';
            $n->kode_subkegiatan = $subkegiatan->kode ?? '';
            $n->nama_subkegiatan = $subkegiatan->nama ?? '';
            $n->tahun = date('Y');
            $n->status_operator = 1;
            $n->status_kepala_skpd = 0;
            $n->save();

            Log::info('Pengajuan saved successfully with ID: ' . $n->id);

            return redirect()->route('skpd.pengajuan')->with('success', 'Pengajuan berhasil dibuat!');
        } catch (\Exception $e) {
            Log::error('Error storing pengajuan: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Update pengajuan.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePengajuan(Request $request, $id)
    {
        try {
            Log::info('Update pengajuan request data:', $request->all());

            $pengajuan = \App\Models\Pengajuan::where('id', $id)
                ->where('user_id', Auth::user()->id)
                ->firstOrFail();

            $request->validate([
                'nomor_surat' => 'required|string|max:255',
                'tanggal' => 'required|date',
                'tipe_pengajuan' => 'required|integer',
                'hal' => 'nullable|string',
                'pengantar' => 'nullable|string',
                'lampiran' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:2048',
                'program' => 'required|integer|exists:program,id',
                'kegiatan' => 'required|integer|exists:kegiatan,id',
                'subkegiatan' => 'required|integer|exists:subkegiatan,id',
            ]);

            Log::info('Validation passed');

            // Get program, kegiatan, and subkegiatan details
            $program = \App\Models\Program::find($request->program);
            $kegiatan = \App\Models\Kegiatan::find($request->kegiatan);
            $subkegiatan = \App\Models\Subkegiatan::find($request->subkegiatan);

            // Handle file upload
            if ($request->hasFile('lampiran')) {
                // Delete old file if exists
                if ($pengajuan->lampiran) {
                    $oldFilePath = storage_path('app/public/' . $pengajuan->lampiran);
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }
                // Store new file
                $lampiranPath = $request->file('lampiran')->store('lampiran', 'public');
                $pengajuan->lampiran = $lampiranPath;
            }

            // Get SKPD ID from user
            $skpdId = Auth::user()->skpdAsUser->id ?? Auth::user()->skpdAsKepala->id ?? null;

            Log::info('Updating pengajuan with data:', [
                'pengajuan_id' => $pengajuan->id,
                'skpd_id' => $skpdId,
                'program_id' => $request->program,
                'kegiatan_id' => $request->kegiatan,
                'subkegiatan_id' => $request->subkegiatan
            ]);

            $pengajuan->nomor_surat = $request->nomor_surat;
            $pengajuan->skpd_id = $skpdId;
            $pengajuan->tanggal = $request->tanggal;
            $pengajuan->tipe_pengajuan = $request->tipe_pengajuan;
            $pengajuan->hal = $request->hal;
            $pengajuan->pengantar = $request->pengantar;
            $pengajuan->program_id = $request->program;
            $pengajuan->kegiatan_id = $request->kegiatan;
            $pengajuan->subkegiatan_id = $request->subkegiatan;
            $pengajuan->kode_program = $program->kode ?? '';
            $pengajuan->nama_program = $program->nama ?? '';
            $pengajuan->kode_kegiatan = $kegiatan->kode ?? '';
            $pengajuan->nama_kegiatan = $kegiatan->nama ?? '';
            $pengajuan->kode_subkegiatan = $subkegiatan->kode ?? '';
            $pengajuan->nama_subkegiatan = $subkegiatan->nama ?? '';
            $pengajuan->tahun = date('Y');
            $pengajuan->save();

            Log::info('Pengajuan updated successfully with ID: ' . $pengajuan->id);

            return redirect()->route('skpd.pengajuan')->with('success', 'Pengajuan berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('Error updating pengajuan: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the surat page.
     *
     * @return \Illuminate\Http\Response
     */
    public function surat()
    {
        return view('skpd.surat.index');
    }

    /**
     * Generate PDF for Surat Pergeseran.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cetakSuratPergeseran($id)
    {
        try {
            // Get pengajuan data
            $pengajuan = \App\Models\Pengajuan::with(['user', 'skpd', 'program', 'kegiatan', 'subkegiatan'])
                ->where('id', $id)
                ->where('user_id', Auth::user()->id)
                ->firstOrFail();

            // Get Sebelum data for this pengajuan
            $sebelumData = \App\Models\Sebelum::where('pengajuan_id', $id)
                ->orderBy('created_at', 'desc')
                ->get();

            // Get Sesudah data for this pengajuan
            $sesudahData = \App\Models\Sesudah::where('pengajuan_id', $id)
                ->orderBy('created_at', 'desc')
                ->get();

            // Generate PDF from view
            $pdf = Pdf::loadView('surat.pergeseran', compact('pengajuan', 'sebelumData', 'sesudahData'));

            // Sanitize nomor_surat for filename (replace / and \ with -)
            $safeNomorSurat = str_replace(['/', '\\'], '-', $pengajuan->nomor_surat);

            // Download PDF
            return $pdf->stream('surat-pergeseran-' . $safeNomorSurat . '.pdf');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mencetak surat: ' . $e->getMessage());
        }
    }

    /**
     * Generate PDF for Surat Pernyataan.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cetakSuratPernyataan($id)
    {
        try {
            // Get pengajuan data
            $pengajuan = \App\Models\Pengajuan::with(['user', 'skpd', 'program', 'kegiatan', 'subkegiatan'])
                ->where('id', $id)
                ->where('user_id', Auth::user()->id)
                ->firstOrFail();

            // Get Sebelum data for this pengajuan
            $sebelumData = \App\Models\Sebelum::where('pengajuan_id', $id)
                ->orderBy('created_at', 'desc')
                ->get();

            // Get Sesudah data for this pengajuan
            $sesudahData = \App\Models\Sesudah::where('pengajuan_id', $id)
                ->orderBy('created_at', 'desc')
                ->get();

            // Generate PDF from view
            $pdf = Pdf::loadView('surat.pernyataan', compact('pengajuan', 'sebelumData', 'sesudahData'));

            // Sanitize nomor_surat for filename (replace / and \ with -)
            $safeNomorSurat = str_replace(['/', '\\'], '-', $pengajuan->nomor_surat);

            // Download PDF
            return $pdf->stream('surat-pernyataan-' . $safeNomorSurat . '.pdf');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mencetak surat: ' . $e->getMessage());
        }
    }

    /**
     * Generate PDF for Surat Keterangan.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cetakSuratKeterangan($id)
    {
        try {
            // Get pengajuan data
            $pengajuan = \App\Models\Pengajuan::with(['user', 'skpd', 'program', 'kegiatan', 'subkegiatan'])
                ->where('id', $id)
                ->where('user_id', Auth::user()->id)
                ->firstOrFail();

            // Get Sebelum data for this pengajuan
            $sebelumData = \App\Models\Sebelum::where('pengajuan_id', $id)
                ->orderBy('created_at', 'desc')
                ->get();

            // Get Sesudah data for this pengajuan
            $sesudahData = \App\Models\Sesudah::where('pengajuan_id', $id)
                ->orderBy('created_at', 'desc')
                ->get();

            // Generate PDF from view
            $pdf = Pdf::loadView('surat.keterangan', compact('pengajuan', 'sebelumData', 'sesudahData'));

            // Sanitize nomor_surat for filename (replace / and \ with -)
            $safeNomorSurat = str_replace(['/', '\\'], '-', $pengajuan->nomor_surat);

            // Download PDF
            return $pdf->stream('surat-keterangan-' . $safeNomorSurat . '.pdf');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mencetak surat: ' . $e->getMessage());
        }
    }

    /**
     * Get kegiatan by program ID for AJAX request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $programId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getKegiatan(Request $request, $programId)
    {
        try {
            // Get query parameters
            $kodeSkpd = $request->query('kode_skpd');
            $kodeProgram = $request->query('kode_program');
            $tahun = $request->query('tahun');

            // Filter kegiatan by joining with program table to get kegiatan based on tahun, kode_skpd, and kode_program
            $kegiatans = \App\Models\Kegiatan::where('kode_skpd', trim($kodeSkpd))
                ->where('kode_program', $kodeProgram)
                ->where('tahun', $tahun)
                ->select('id', 'kode', 'nama')
                ->get();

            return response()->json($kegiatans);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Data tidak ditemukan: ' . $e->getMessage()], 404);
        }
    }

    /**
     * Get subkegiatan by kegiatan ID for AJAX request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $kegiatanId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSubkegiatan(Request $request, $kegiatanId)
    {
        try {
            // Get query parameters
            $kodeSkpd = $request->query('kode_skpd');
            $kodeProgram = $request->query('kode_program');
            $kodeKegiatan = $request->query('kode_kegiatan');
            $tahun = $request->query('tahun');

            // Filter subkegiatan by joining with kegiatan and program tables
            $subkegiatans = \App\Models\Subkegiatan::where('kode_skpd', trim($kodeSkpd))
                ->where('tahun', $tahun)
                ->where('kode_program', $kodeProgram)
                ->where('kode_kegiatan', $kodeKegiatan)
                ->select('id', 'kode', 'nama')
                ->get();

            return response()->json($subkegiatans);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Data tidak ditemukan: ' . $e->getMessage()], 404);
        }
    }

    /**
     * Display pergeseran page for specified pengajuan.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function pergeseran($id)
    {
        $pengajuan = \App\Models\Pengajuan::with(['user', 'skpd', 'program', 'kegiatan', 'subkegiatan'])
            ->where('id', $id)
            ->where('user_id', Auth::user()->id)
            ->firstOrFail();

        // Get unique kode_rekening and jenis from SSH model
        $rekeningOptions = \App\Models\Ssh::select('kode_rekening', 'jenis')
            ->distinct()
            ->orderBy('kode_rekening')
            ->get();

        // Get Sebelum data for this pengajuan
        $sebelumData = \App\Models\Sebelum::where('pengajuan_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Get Sesudah data for this pengajuan
        $sesudahData = \App\Models\Sesudah::where('pengajuan_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('skpd.pengajuan.pergeseran', compact('pengajuan', 'rekeningOptions', 'sebelumData', 'sesudahData'));
    }

    /**
     * Get kode_barang based on kode_rekening for AJAX request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getKodeBarang(Request $request)
    {
        try {
            $kodeRekening = $request->query('kode_rekening');

            if (!$kodeRekening) {
                return response()->json([], 200);
            }

            $kodeBarangList = \App\Models\Ssh::where('kode_rekening', $kodeRekening)
                ->select('kode_barang', 'uraian_barang', 'spesifikasi', 'satuan', 'harga')
                ->distinct()
                ->orderBy('kode_barang')
                ->get();

            return response()->json($kodeBarangList);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Data tidak ditemukan: ' . $e->getMessage()], 404);
        }
    }

    /**
     * Show form for editing the specified pengajuan.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editPengajuan($id)
    {
        $pengajuan = \App\Models\Pengajuan::with(['user', 'skpd', 'program', 'kegiatan', 'subkegiatan'])
            ->where('id', $id)
            ->where('user_id', Auth::user()->id)
            ->firstOrFail();

        $user = Auth::user();

        // Check if user is the operator/user of SKPD or the kepala/head of SKPD
        $skpd = $user->skpdAsUser ?? $user->skpdAsKepala ?? null;

        if (!$skpd) {
            return redirect()->route('skpd.pengajuan')
                ->with('error', 'SKPD tidak ditemukan untuk user ini.');
        }

        // Get programs based on kode_skpd (trim to remove any whitespace/newline characters)
        $program = \App\Models\Program::where('kode_skpd', trim($skpd->kode_skpd))->get();

        return view('skpd.pengajuan.edit', compact('pengajuan', 'program'));
    }

    /**
     * Remove the specified pengajuan from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyPengajuan($id)
    {
        try {
            $pengajuan = \App\Models\Pengajuan::where('id', $id)
                ->where('user_id', Auth::user()->id)
                ->firstOrFail();

            // Delete file if exists
            if ($pengajuan->lampiran) {
                $filePath = storage_path('app/public/' . $pengajuan->lampiran);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            $pengajuan->delete();

            // Return JSON response for AJAX requests
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pengajuan berhasil dihapus!'
                ]);
            }

            return redirect()->route('skpd.pengajuan')
                ->with('success', 'Pengajuan berhasil dihapus!');
        } catch (\Exception $e) {
            // Return JSON response for AJAX requests
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus pengajuan: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('skpd.pengajuan')
                ->with('error', 'Gagal menghapus pengajuan: ' . $e->getMessage());
        }
    }

    /**
     * Store pergeseran data to Sebelum model.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeSebelum(Request $request)
    {
        try {
            $request->validate([
                'pengajuan_id' => 'required|exists:pengajuan,id',
                'kode_rekening' => 'required|string',
                'kode_barang' => 'required|string',
                'uraian_barang' => 'required|string',
                'spesifikasi' => 'required|string',
                'satuan' => 'required|string',
                'harga' => 'required|numeric',
                'koefisien1' => 'nullable|numeric',
                'koefisien2' => 'nullable|numeric',
                'koefisien3' => 'nullable|numeric',
                'satuan1' => 'nullable|string',
                'satuan2' => 'nullable|string',
                'satuan3' => 'nullable|string',
                'total' => 'required|numeric',
            ]);

            // Get pengajuan to verify ownership
            $pengajuan = \App\Models\Pengajuan::where('id', $request->pengajuan_id)
                ->where('user_id', Auth::user()->id)
                ->firstOrFail();

            // Get SKPD code from pengajuan's program
            $kodeSkpd = $pengajuan->program->kode_skpd ?? '';

            // Get jenis from SSH model based on kode_rekening
            $jenisSsh = '';
            $ssh = \App\Models\Ssh::where('kode_rekening', $request->kode_rekening)
                ->first();
            if ($ssh) {
                $jenisSsh = $ssh->jenis ?? '';
            }

            // Calculate total koefisien
            $totalKoefisien = 1;
            if ($request->koefisien1 > 0) {
                $totalKoefisien *= $request->koefisien1;
            }
            if ($request->koefisien2 > 0) {
                $totalKoefisien *= $request->koefisien2;
            }
            if ($request->koefisien3 > 0) {
                $totalKoefisien *= $request->koefisien3;
            }

            // Calculate total if not provided
            $calculatedTotal = $request->harga * $totalKoefisien;

            // Create new Sebelum record
            $sebelum = \App\Models\Sebelum::create([
                'pengajuan_id' => $request->pengajuan_id,
                'kode_skpd' => $kodeSkpd,
                'kode_rekening' => $request->kode_rekening,
                'jenis_ssh' => $jenisSsh,
                'kode_komponen' => $request->kode_barang,
                'satuan' => $request->satuan,
                'harga' => $request->harga,
                'koefisien1' => $request->koefisien1 ?? 0,
                'koefisien2' => $request->koefisien2 ?? 0,
                'koefisien3' => $request->koefisien3 ?? 0,
                'satuan1' => $request->satuan1,
                'satuan2' => $request->satuan2,
                'satuan3' => $request->satuan3,
                'total' => $request->total > 0 ? $request->total : $calculatedTotal,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan!',
                'data' => $sebelum
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error storing sebelum: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified Sebelum data from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroySebelum($id)
    {
        try {
            // Find Sebelum record
            $sebelum = \App\Models\Sebelum::findOrFail($id);

            // Verify that the user owns the pengajuan
            $pengajuan = \App\Models\Pengajuan::where('id', $sebelum->pengajuan_id)
                ->where('user_id', Auth::user()->id)
                ->firstOrFail();

            // Delete the record
            $sebelum->delete();

            // Return JSON response for AJAX requests
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Data berhasil dihapus!'
                ]);
            }

            return redirect()->back()
                ->with('success', 'Data berhasil dihapus!');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            return redirect()->back()
                ->with('error', 'Data tidak ditemukan');
        } catch (\Exception $e) {
            Log::error('Error deleting sebelum: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            // Return JSON response for AJAX requests
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus data: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    /**
     * Store pergeseran data to Sesudah model.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeSesudah(Request $request)
    {
        try {
            $request->validate([
                'pengajuan_id' => 'required|exists:pengajuan,id',
                'kode_rekening' => 'required|string',
                'kode_barang' => 'required|string',
                'uraian_barang' => 'required|string',
                'spesifikasi' => 'required|string',
                'satuan' => 'required|string',
                'harga' => 'required|numeric',
                'koefisien1' => 'nullable|numeric',
                'koefisien2' => 'nullable|numeric',
                'koefisien3' => 'nullable|numeric',
                'satuan1' => 'nullable|string',
                'satuan2' => 'nullable|string',
                'satuan3' => 'nullable|string',
                'total' => 'required|numeric',
            ]);

            // Get pengajuan to verify ownership
            $pengajuan = \App\Models\Pengajuan::where('id', $request->pengajuan_id)
                ->where('user_id', Auth::user()->id)
                ->firstOrFail();

            // Get SKPD code from pengajuan's program
            $kodeSkpd = $pengajuan->program->kode_skpd ?? '';

            // Get jenis from SSH model based on kode_rekening
            $jenisSsh = '';
            $ssh = \App\Models\Ssh::where('kode_rekening', $request->kode_rekening)
                ->first();
            if ($ssh) {
                $jenisSsh = $ssh->jenis ?? '';
            }

            // Calculate total koefisien
            $totalKoefisien = 1;
            if ($request->koefisien1 > 0) {
                $totalKoefisien *= $request->koefisien1;
            }
            if ($request->koefisien2 > 0) {
                $totalKoefisien *= $request->koefisien2;
            }
            if ($request->koefisien3 > 0) {
                $totalKoefisien *= $request->koefisien3;
            }

            // Calculate total if not provided
            $calculatedTotal = $request->harga * $totalKoefisien;

            // Create new Sesudah record
            $sesudah = \App\Models\Sesudah::create([
                'pengajuan_id' => $request->pengajuan_id,
                'kode_skpd' => $kodeSkpd,
                'kode_rekening' => $request->kode_rekening,
                'jenis_ssh' => $jenisSsh,
                'kode_komponen' => $request->kode_barang,
                'satuan' => $request->satuan,
                'harga' => $request->harga,
                'koefisien1' => $request->koefisien1 ?? 0,
                'koefisien2' => $request->koefisien2 ?? 0,
                'koefisien3' => $request->koefisien3 ?? 0,
                'satuan1' => $request->satuan1,
                'satuan2' => $request->satuan2,
                'satuan3' => $request->satuan3,
                'total' => $request->total > 0 ? $request->total : $calculatedTotal,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan!',
                'data' => $sesudah
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error storing sesudah: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Send pergeseran for approval.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function kirimPergeseran(Request $request)
    {
        try {
            $request->validate([
                'pengajuan_id' => 'required|exists:pengajuan,id',
            ]);

            // Find pengajuan and verify ownership
            $pengajuan = \App\Models\Pengajuan::where('id', $request->pengajuan_id)
                ->where('user_id', Auth::user()->id)
                ->firstOrFail();

            // Check if there's pergeseran data
            $hasSebelum = \App\Models\Sebelum::where('pengajuan_id', $request->pengajuan_id)->exists();
            $hasSesudah = \App\Models\Sesudah::where('pengajuan_id', $request->pengajuan_id)->exists();

            if (!$hasSebelum || !$hasSesudah) {
                return response()->json([
                    'success' => false,
                    'message' => 'Harap lengkapi data pergeseran sebelum dan sesudah terlebih dahulu.'
                ], 400);
            }

            // Update status
            $pengajuan->status_operator = 2;
            $pengajuan->status_kepala_skpd = 1;
            $pengajuan->save();

            Log::info('Pergeseran sent for approval:', [
                'pengajuan_id' => $pengajuan->id,
                'user_id' => Auth::user()->id,
                'status_operator' => 2,
                'status_kepala_skpd' => 1
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pergeseran berhasil dikirim untuk persetujuan!'
            ]);
        } catch (\Exception $e) {
            Log::error('Error sending pergeseran: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified Sesudah data from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroySesudah($id)
    {
        try {
            // Find Sesudah record
            $sesudah = \App\Models\Sesudah::findOrFail($id);

            // Verify that user owns pengajuan
            $pengajuan = \App\Models\Pengajuan::where('id', $sesudah->pengajuan_id)
                ->where('user_id', Auth::user()->id)
                ->firstOrFail();

            // Delete the record
            $sesudah->delete();

            // Return JSON response for AJAX requests
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Data berhasil dihapus!'
                ]);
            }

            return redirect()->back()
                ->with('success', 'Data berhasil dihapus!');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            return redirect()->back()
                ->with('error', 'Data tidak ditemukan');
        } catch (\Exception $e) {
            Log::error('Error deleting sesudah: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            // Return JSON response for AJAX requests
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus data: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
