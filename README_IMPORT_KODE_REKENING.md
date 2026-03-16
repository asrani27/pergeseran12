# Import Kode Rekening

## Deskripsi
Command untuk import data kode rekening dari file Excel ke database.

## Struktur Tabel
Tabel: `kode_rekening`

| Field | Tipe | Deskripsi |
|-------|------|-----------|
| id | bigint unsigned | Primary Key (Auto Increment) |
| kode | string (255) | Kode rekening (unique) |
| nama | text | Nama/Uraian rekening |
| created_at | timestamp | Waktu pembuatan |
| updated_at | timestamp | Waktu update terakhir |

## Format File Excel
File: `public/excel/kode_rekening.xlsx`

| Kolom | Keterangan |
|-------|------------|
| A | Kode rekening |
| B | Nama/Uraian rekening |

Baris pertama adalah header dan akan di-skip otomatis.

## Cara Menggunakan

### 1. Jalankan Migration
```bash
php artisan migrate --path=database/migrations/2026_03_16_051003_create_kode_rekening_table.php
```

### 2. Import Data
```bash
php artisan import:kode-rekening
```

## Fitur
- ✅ Membaca file Excel dari `public/excel/kode_rekening.xlsx`
- ✅ Melewatkan baris header (baris pertama)
- ✅ Melewatkan baris kosong
- ✅ Insert data baru
- ✅ Update data jika kode sudah ada
- ✅ Menampilkan progress saat import
- ✅ Menampilkan summary setelah import selesai

## Contoh Output
```
Memulai import data kode rekening...
Insert: 5.1.02.01.01.0001 - Belanja Gaji Pegawai Negeri Sipil
Insert: 5.1.02.01.01.0002 - Belanja Tunjangan Kinerja
Update: 5.1.02.01.01.0003 - Belanja Tunjangan Keluarga

Import berhasil!
Total data diproses: 2889
```

## Model
```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KodeRekening extends Model
{
    protected $table = 'kode_rekening';
    
    protected $fillable = [
        'kode',
        'nama',
    ];
}
```

## Contoh Penggunaan di Controller
```php
use App\Models\KodeRekening;

// Mengambil semua data
$kodeRekening = KodeRekening::all();

// Mencari berdasarkan kode
$rekening = KodeRekening::where('kode', '5.1.02.01.01.0001')->first();

// Pencarian
$results = KodeRekening::where('kode', 'like', '%5.1.02%')
                        ->orWhere('nama', 'like', '%gaji%')
                        ->get();
```

## Catatan
- Pastikan file Excel sudah ada di `public/excel/kode_rekening.xlsx`
- Pastikan library `phpoffice/phpspreadsheet` sudah terinstall
- Jika file tidak ditemukan, command akan menampilkan error
- Setiap kali command dijalankan, akan mengecek apakah kode sudah ada:
  - Jika ada: update data nama
  - Jika tidak ada: insert baru