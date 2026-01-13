<?php

namespace Database\Seeders;

use App\Models\Skpd;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SkpdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skpds = [
            [
                'kode_skpd' => '01.01.01',
                'nama' => 'Dinas Pendidikan',
                'user_id' => null,
                'kepala_id' => null,
            ],
            [
                'kode_skpd' => '01.01.02',
                'nama' => 'Dinas Kesehatan',
                'user_id' => null,
                'kepala_id' => null,
            ],
            [
                'kode_skpd' => '01.01.03',
                'nama' => 'Dinas Pekerjaan Umum',
                'user_id' => null,
                'kepala_id' => null,
            ],
            [
                'kode_skpd' => '01.01.04',
                'nama' => 'Dinas Sosial',
                'user_id' => null,
                'kepala_id' => null,
            ],
            [
                'kode_skpd' => '01.01.05',
                'nama' => 'Dinas Perhubungan',
                'user_id' => null,
                'kepala_id' => null,
            ],
        ];

        foreach ($skpds as $skpd) {
            Skpd::create($skpd);
        }
    }
}
