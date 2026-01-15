<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PimpinanController extends Controller
{
    /**
     * Display the Pimpinan dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        // Get SKPD that this pimpinan leads
        $user = Auth::user();
        $skpd = $user->skpdAsKepala;

        if (!$skpd) {
            return redirect()->route('login')
                ->with('error', 'SKPD tidak ditemukan untuk pimpinan ini.');
        }

        // Get all pengajuan from SKPD users (status_operator = 2 means sent for approval)
        // Only show pengajuan from the SKPD that this pimpinan leads
        $pengajuan = Pengajuan::with(['user', 'skpd', 'program', 'kegiatan', 'subkegiatan'])
            ->where('skpd_id', $skpd->id)
            ->where('status_operator', 2) // Only show submitted pengajuan
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pimpinan.dashboard', compact('pengajuan', 'skpd'));
    }

    /**
     * Display the profile page.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        $user = Auth::user();
        $skpd = $user->skpdAsKepala;

        return view('pimpinan.profile', compact('user', 'skpd'));
    }

    /**
     * Show pergeseran details for approval.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showPergeseran($id)
    {
        // Get SKPD that this pimpinan leads
        $user = Auth::user();
        $skpd = $user->skpdAsKepala;

        if (!$skpd) {
            return redirect()->route('pimpinan.dashboard')
                ->with('error', 'SKPD tidak ditemukan untuk pimpinan ini.');
        }

        // Get pengajuan details
        $pengajuan = Pengajuan::with(['user', 'skpd', 'program', 'kegiatan', 'subkegiatan'])
            ->where('id', $id)
            ->where('skpd_id', $skpd->id)
            ->firstOrFail();

        // Get Sebelum data for this pengajuan
        $sebelumData = \App\Models\Sebelum::where('pengajuan_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Get Sesudah data for this pengajuan
        $sesudahData = \App\Models\Sesudah::where('pengajuan_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pimpinan.pergeseran', compact('pengajuan', 'sebelumData', 'sesudahData'));
    }

    /**
     * Approve pergeseran.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function approvePergeseran(Request $request)
    {
        try {
            $request->validate([
                'pengajuan_id' => 'required|exists:pengajuan,id',
            ]);

            // Get SKPD that this pimpinan leads
            $user = Auth::user();
            $skpd = $user->skpdAsKepala;

            if (!$skpd) {
                return response()->json([
                    'success' => false,
                    'message' => 'SKPD tidak ditemukan.'
                ], 404);
            }

            // Find pengajuan and verify it belongs to pimpinan's SKPD
            $pengajuan = Pengajuan::where('id', $request->pengajuan_id)
                ->where('skpd_id', $skpd->id)
                ->firstOrFail();

            // Update status
            $pengajuan->status_kepala_skpd = 2; // Approved
            $pengajuan->status_bpkpad = 1; // Approved
            $pengajuan->save();

            return response()->json([
                'success' => true,
                'message' => 'Pergeseran berhasil disetujui!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reject pergeseran.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function rejectPergeseran(Request $request)
    {
        try {
            $request->validate([
                'pengajuan_id' => 'required|exists:pengajuan,id',
            ]);

            // Get SKPD that this pimpinan leads
            $user = Auth::user();
            $skpd = $user->skpdAsKepala;

            if (!$skpd) {
                return response()->json([
                    'success' => false,
                    'message' => 'SKPD tidak ditemukan.'
                ], 404);
            }

            // Find pengajuan and verify it belongs to pimpinan's SKPD
            $pengajuan = Pengajuan::where('id', $request->pengajuan_id)
                ->where('skpd_id', $skpd->id)
                ->firstOrFail();

            // Update status
            $pengajuan->status_kepala_skpd = 3; // Rejected
            $pengajuan->save();

            return response()->json([
                'success' => true,
                'message' => 'Pergeseran berhasil ditolak!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
