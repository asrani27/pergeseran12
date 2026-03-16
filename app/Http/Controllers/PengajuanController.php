<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\Program;
use App\Models\Kegiatan;
use App\Models\Subkegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengajuanController extends Controller
{
    /**
     * Display a listing of the pengajuan.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pengajuan = Pengajuan::with(['user', 'skpd', 'program', 'kegiatan', 'subkegiatan'])
            ->where('user_id', Auth::user()->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('skpd.pengajuan.index', compact('pengajuan'));
    }

    /**
     * Show the form for creating a new pengajuan.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $program = Program::all();
        return view('skpd.pengajuan.create', compact('program'));
    }

    /**
     * Store a newly created pengajuan in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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

        // Get program, kegiatan, and subkegiatan details
        $program = Program::find($request->program);
        $kegiatan = Kegiatan::find($request->kegiatan);
        $subkegiatan = Subkegiatan::find($request->subkegiatan);

        // Handle file upload
        $lampiranPath = null;
        if ($request->hasFile('lampiran')) {
            $lampiranPath = $request->file('lampiran')->store('lampiran', 'public');
        }

        // Get SKPD ID from user
        $skpdId = Auth::user()->skpdAsUser->id ?? Auth::user()->skpdAsKepala->id ?? null;

        $n = new Pengajuan;
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
        $n->status = 0;
        $n->save();

        return redirect()->route('skpd.pengajuan')->with('success', 'Pengajuan berhasil dibuat!');
    }

    /**
     * Get kegiatan based on program ID
     *
     * @param  int  $programId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getKegiatan($programId)
    {
        $kegiatan = Kegiatan::where('program_id', $programId)->get();
        return response()->json($kegiatan);
    }

    /**
     * Get subkegiatan based on kegiatan ID
     *
     * @param  int  $kegiatanId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSubkegiatan($kegiatanId)
    {
        $subkegiatan = Subkegiatan::where('kegiatan_id', $kegiatanId)->get();
        return response()->json($subkegiatan);
    }
}
