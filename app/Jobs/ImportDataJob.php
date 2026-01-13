<?php

namespace App\Jobs;

use App\Imports\DataImport;
use App\Models\RiwayatImport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;

class ImportDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 1;     // jangan retry
    public int $timeout = 0;   // jangan timeout
    public int $memory = 1024;

    protected string $filePath;
    protected int $riwayatImportId;

    public function __construct(string $filePath, int $riwayatImportId)
    {
        $this->filePath = $filePath;
        $this->riwayatImportId = $riwayatImportId;
    }

    public function handle(): void
    {
        ini_set('memory_limit', '512M');
        set_time_limit(0);

        try {
            $dataImport = new DataImport($this->riwayatImportId);

            Excel::import($dataImport, $this->filePath);

            // Get the results from the import
            $results = $dataImport->getResults();

            // Update riwayat_import record
            $keterangan = "Import berhasil. Program: {$results['program']['imported']}, Kegiatan: {$results['kegiatan']['imported']}, Sub Kegiatan: {$results['subkegiatan']['imported']}";

            RiwayatImport::find($this->riwayatImportId)->update([
                'status' => 'selesai',
                'keterangan' => $keterangan
            ]);
        } catch (\Exception $e) {
            // Update riwayat_import record with error

            RiwayatImport::find($this->riwayatImportId)->update([
                'status' => 'gagal',
                'keterangan' => 'Import gagal: ' . $e->getMessage()
            ]);
        }
    }
}
