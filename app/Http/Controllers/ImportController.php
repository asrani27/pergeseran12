<?php

namespace App\Http\Controllers;

use App\Jobs\ImportDataJob;
use App\Models\RiwayatImport;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

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

}
