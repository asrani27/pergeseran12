<?php

namespace App\Imports;

use App\Models\RiwayatImport;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class DataImport implements ToCollection, WithChunkReading, WithStartRow
{
    protected int $totalRows = 0;
    protected int $processedRows = 0;
    protected int $riwayatImportId;
    protected array $results = [
        'program' => [
            'imported' => 0,
            'skipped' => 0,
            'errors' => []
        ],
        'kegiatan' => [
            'imported' => 0,
            'skipped' => 0,
            'errors' => []
        ],
        'subkegiatan' => [
            'imported' => 0,
            'skipped' => 0,
            'errors' => []
        ],
        'rekening_belanja' => [
            'imported' => 0,
            'skipped' => 0,
            'errors' => []
        ]
    ];

    public function __construct(int $riwayatImportId)
    {
        $this->riwayatImportId = $riwayatImportId;
    }

    public function startRow(): int
    {
        return 2;
    }

    public function chunkSize(): int
    {
        return 250; // aman untuk 100k+
    }

    public function collection(Collection $rows)
    {
        try {
            $programData = [];
            $kegiatanData = [];
            $subkegiatanData = [];
            $rekeningBelanjaData = [];
            $validRows = 0;

            foreach ($rows as $index => $row) {
                if (empty($row[1]) || empty($row[4]) || empty($row[10])) {
                    $this->results['program']['errors'][] = "Baris " . ($index + 2) . ": Data tidak lengkap";
                    continue;
                }

                // Data for programs table
                $programData[] = [
                    'tahun'      => $row[1],
                    'kode_skpd'  => $row[4],
                    'kode'       => $row[10],
                    'nama'       => $row[11] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // Data for kegiatan table
                if (!empty($row[12]) || !empty($row[13])) {
                    $kegiatanData[] = [
                        'tahun'       => $row[1],
                        'kode_skpd'   => $row[4],
                        'kode_program' => $row[10],
                        'kode'        => $row[12] ?? null,
                        'nama'        => $row[13] ?? null,
                        'created_at'  => now(),
                        'updated_at'  => now(),
                    ];
                }

                // Data for subkegiatan table
                if (!empty($row[14]) || !empty($row[15])) {
                    $subkegiatanData[] = [
                        'tahun'         => $row[1],
                        'kode_skpd'     => $row[4],
                        'kode_program'  => $row[10],
                        'kode_kegiatan' => $row[12] ?? null,
                        'kode'          => $row[14] ?? null,
                        'nama'          => $row[15] ?? null,
                        'created_at'    => now(),
                        'updated_at'    => now(),
                    ];
                }

                // Data for rekening_belanja table
                $rekeningBelanjaData[] = [
                    'tahun'             => $row[1],
                    'kode_skpd'         => $row[4],
                    'kode_program'      => $row[10],
                    'nama_program'      => $row[11] ?? null,
                    'kode_kegiatan'     => $row[12] ?? null,
                    'nama_kegiatan'     => $row[13] ?? null,
                    'kode_subkegiatan'  => $row[14] ?? null,
                    'nama_subkegiatan'  => $row[15] ?? null,
                    'kode_rekening'     => $row[18] ?? null,
                    'nama_rekening'     => $row[19] ?? null,
                    'kode_ssh'          => $row[20] ?? null,
                    'nama_ssh'          => $row[21] ?? null,
                    'pagu'              => $row[22] ?? null,
                    'created_at'        => now(),
                    'updated_at'        => now(),
                ];

                $validRows++;
            }

            // BULK INSERT for programs (IGNORE DUPLIKAT)
            $insertedPrograms = DB::table('program')->insertOrIgnore($programData);
            $skippedPrograms = count($programData) - $insertedPrograms;

            $this->results['program']['imported'] += $insertedPrograms;
            $this->results['program']['skipped'] += $skippedPrograms;

            // BULK INSERT for kegiatans (IGNORE DUPLIKAT)
            if (!empty($kegiatanData)) {
                $insertedKegiatans = DB::table('kegiatan')->insertOrIgnore($kegiatanData);
                $this->results['kegiatan']['imported'] += $insertedKegiatans;
            }

            // BULK INSERT for subkegiatans (IGNORE DUPLIKAT)
            if (!empty($subkegiatanData)) {
                $insertedSubkegiatans = DB::table('subkegiatan')->insertOrIgnore($subkegiatanData);
                $this->results['subkegiatan']['imported'] += $insertedSubkegiatans;
            }

            // BULK INSERT for rekening_belanja (IGNORE DUPLIKAT)
            if (!empty($rekeningBelanjaData)) {
                $insertedRekeningBelanja = DB::table('rekening_belanja')->insertOrIgnore($rekeningBelanjaData);
                $this->results['rekening_belanja']['imported'] += $insertedRekeningBelanja;
            }

            // Update progress tracking
            $this->processedRows += $rows->count();

            Log::info("Processed chunk: {$validRows} valid rows, {$insertedPrograms} programs inserted, {$skippedPrograms} programs skipped, " .
                (!empty($kegiatanData) ? $this->results['kegiatan']['imported'] . " kegiatan inserted" : "0 kegiatan") . ", " .
                (!empty($subkegiatanData) ? $this->results['subkegiatan']['imported'] . " subkegiatan inserted" : "0 subkegiatan") . ", " .
                (!empty($rekeningBelanjaData) ? $this->results['rekening_belanja']['imported'] . " rekening_belanja inserted" : "0 rekening_belanja"));
        } catch (\Exception $e) {
            // Update riwayat_import record with error
            RiwayatImport::find($this->riwayatImportId)->update([
                'status' => 'gagal',
                'keterangan' => 'Import gagal saat memproses chunk: ' . $e->getMessage()
            ]);

            // Re-throw the exception to stop the import process
            throw $e;
        }
    }

    public function getResults(): array
    {
        return $this->results;
    }
}
