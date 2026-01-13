<?php

namespace App\Http\Controllers;

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
        return view('skpd.dashboard');
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
     * Show the form for editing the specified pengajuan.
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
}
