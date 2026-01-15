<?php

namespace App\Imports;

use App\Models\Ssh;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SshImport implements ToCollection, WithHeadingRow
{
    protected $jenis;
    protected $tahun;

    public function __construct($jenis, $tahun)
    {
        $this->jenis = $jenis;
        $this->tahun = $tahun;
    }

    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Pecah kode rekening berdasarkan koma
            $rekeningList = explode(',', $row['kode_rekening']);

            foreach ($rekeningList as $rekening) {
                Ssh::create([
                    'kode_kelompok'   => $row['kode_kelompok_barang'],
                    'uraian_kelompok' => $row['uraian_kelompok_barang'],
                    'kode_barang'            => $row['kode_barang'],
                    'uraian_barang'          => $row['uraian_barang'],
                    'spesifikasi'            => $row['spesifikasi'],
                    'satuan'                 => $row['satuan'],
                    'harga'                  => $row['harga_satuan'],
                    'kode_rekening'          => trim($rekening),
                    'jenis'                  => $this->jenis,
                    'tahun'                  => $this->tahun,
                ]);
            }
        }
    }
}
