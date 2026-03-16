<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class BpkpadController extends Controller
{
    /**
     * Display BPKPAD dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        // Get all pengajuan from all SKPDs with any status_bpkpad
        // status : 1 = di proses, 2 = direvisi, 3 = disetuji, 4 = ditolak
        $pengajuan = Pengajuan::with(['user', 'skpd', 'program', 'kegiatan', 'subkegiatan'])
            ->whereIn('status', [1, 2, 3, 4]) // Show all BPKPAD statuses
            ->orderBy('created_at', 'desc')
            ->get();

        return view('bpkpad.dashboard', compact('pengajuan'));
    }

    /**
     * Display the profile page.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        $user = Auth::user();

        return view('bpkpad.profile', compact('user'));
    }

    /**
     * Update profile information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect()->route('bpkpad.profile')->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Update password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        // Check if current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->route('bpkpad.profile')
                ->with('error', 'Password saat ini salah.');
        }

        // Update password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('bpkpad.profile')->with('success', 'Password berhasil diubah!');
    }

    /**
     * Show pergeseran details for review.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showPergeseran($id)
    {
        // Get pengajuan details with any BPKPAD status (1, 2, or 3)
        $pengajuan = Pengajuan::with(['user', 'skpd', 'program', 'kegiatan', 'subkegiatan'])
            ->where('id', $id)
            ->whereIn('status', [1, 2, 3, 4]) // Show pengajuan with any BPKPAD status
            ->firstOrFail();

        // Get Sebelum data for this pengajuan
        $sebelumData = \App\Models\Sebelum::where('pengajuan_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Get Sesudah data for this pengajuan
        $sesudahData = \App\Models\Sesudah::where('pengajuan_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('bpkpad.pergeseran', compact('pengajuan', 'sebelumData', 'sesudahData'));
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

            // Find pengajuan and verify it has status_bpkpad == 1
            $pengajuan = Pengajuan::where('id', $request->pengajuan_id)
                ->where('status', 1)
                ->firstOrFail();

            // Update status
            $pengajuan->status = 3; // Approved by BPKPAD
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

            // Find pengajuan and verify it has status_bpkpad == 1
            $pengajuan = Pengajuan::where('id', $request->pengajuan_id)
                ->where('status', 1)
                ->firstOrFail();

            // Update status
            $pengajuan->status = 4; // Rejected by BPKPAD
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

    /**
     * Generate PDF for Surat Pergeseran.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cetakSuratPergeseran($id)
    {
        try {
            // Get pengajuan data (BPKPAD can view all pengajuan)
            $pengajuan = Pengajuan::with(['user', 'skpd', 'program', 'kegiatan', 'subkegiatan'])
                ->where('id', $id)
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
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('surat.pergeseran', compact('pengajuan', 'sebelumData', 'sesudahData'));

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
            // Get pengajuan data (BPKPAD can view all pengajuan)
            $pengajuan = Pengajuan::with(['user', 'skpd', 'program', 'kegiatan', 'subkegiatan'])
                ->where('id', $id)
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
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('surat.pernyataan', compact('pengajuan', 'sebelumData', 'sesudahData'));

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
            // Get pengajuan data (BPKPAD can view all pengajuan)
            $pengajuan = Pengajuan::with(['user', 'skpd', 'program', 'kegiatan', 'subkegiatan'])
                ->where('id', $id)
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
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('surat.keterangan', compact('pengajuan', 'sebelumData', 'sesudahData'));

            // Sanitize nomor_surat for filename (replace / and \ with -)
            $safeNomorSurat = str_replace(['/', '\\'], '-', $pengajuan->nomor_surat);

            // Download PDF
            return $pdf->stream('surat-keterangan-' . $safeNomorSurat . '.pdf');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mencetak surat: ' . $e->getMessage());
        }
    }
}
