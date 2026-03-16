<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\KodeRekening;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportKodeRekening extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:kode-rekening';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import data kode rekening dari file Excel';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai import data kode rekening...');
        
        try {
            $filePath = public_path('excel/kode_rekening.xlsx');
            
            if (!file_exists($filePath)) {
                $this->error('File tidak ditemukan: ' . $filePath);
                return Command::FAILURE;
            }
            
            $spreadsheet = IOFactory::load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();
            
            $count = 0;
            $skip = 0;
            
            foreach ($rows as $index => $row) {
                // Skip header row (baris pertama)
                if ($index === 0) {
                    continue;
                }
                
                $kode = trim($row[0] ?? '');
                $nama = trim($row[1] ?? '');
                
                // Skip jika kolom kosong
                if (empty($kode) && empty($nama)) {
                    $skip++;
                    continue;
                }
                
                // Cek apakah kode sudah ada
                $existing = KodeRekening::where('kode', $kode)->first();
                if ($existing) {
                    // Update jika ada
                    $existing->nama = $nama;
                    $existing->save();
                    $this->line("Update: $kode - $nama");
                } else {
                    // Insert baru
                    KodeRekening::create([
                        'kode' => $kode,
                        'nama' => $nama,
                    ]);
                    $this->line("Insert: $kode - $nama");
                }
                
                $count++;
            }
            
            $this->newLine();
            $this->info('Import berhasil!');
            $this->info("Total data diproses: $count");
            if ($skip > 0) {
                $this->info("Data dilewati (kosong): $skip");
            }
            
            return Command::SUCCESS;
            
        } catch (\Exception $e) {
            $this->error('Terjadi kesalahan: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}