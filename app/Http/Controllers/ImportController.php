<?php

namespace App\Http\Controllers;

use App\Imports\SshImport;
use App\Jobs\ImportDataJob;
use App\Models\Ssh;
use App\Models\RiwayatImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function index()
    {
        $importHistory = RiwayatImport::orderBy('created_at', 'desc')->get();

        return view('superadmin.import.index', compact('importHistory'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls|max:10240',
        ]);

        $file = $request->file('file');

        $filePath = $file->storeAs(
            'imports',
            'import_' . now()->format('Ymd_His') . '.' . $file->getClientOriginalExtension()
        );

        // Create record in riwayat_imports table
        $riwayatImport = RiwayatImport::create([
            'nama_file' => $file->getClientOriginalName(),
            'status' => 'di proses',
            'keterangan' => 'Import sedang diproses...'
        ]);

        ImportDataJob::dispatch($filePath, $riwayatImport->id);

        return back()->with('success', 'Import sedang diproses di belakang layar');
    }

    public function ssh()
    {
        $sshData = Ssh::orderBy('tahun', 'desc')
            ->orderBy('jenis')
            ->orderBy('kode_kelompok')
            ->orderBy('kode_barang')
            ->get();

        return view('superadmin.import.ssh', compact('sshData'));
    }

    public function sshStore(Request $request)
    {
        $request->validate([
            'tahun' => 'required|integer|min:2020|max:2030',
            'jenis' => 'required|in:SSH,ASB,HSPK',
            'file' => 'required|file|mimes:xlsx,xls|max:10240',
        ]);

        // Delete old data based on jenis and tahun
        Ssh::where('jenis', $request->jenis)
            ->where('tahun', $request->tahun)
            ->delete();

        Excel::import(new SshImport($request->jenis, $request->tahun), $request->file('file'));

        return back()->with('success', 'Data berhasil diimport');
    }
}
