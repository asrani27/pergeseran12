<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Pernyataan Tanggung Jawab Mutlak</title>

    <style>
        @page {
            size: 21.5cm 34cm;
        }

        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12pt;
            margin: 0cm 0.5cm 3cm 1.8cm;
            color: #000;
        }

        .kop {
            text-align: center;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
            margin-bottom: 2px;
        }

        .kop img {
            position: absolute;
            left: 1.5cm;
            top: 0cm;
            width: 80px;
        }

        .kop h1 {
            margin: 0;
            font-size: 16pt;
            font-weight: bold;
        }

        .kop h2 {
            margin: 3px 0;
            font-size: 14pt;
            font-weight: bold;
        }

        .kop p {
            margin: 2px 0;
            font-size: 11pt;
        }

        .title {
            text-align: center;
            font-weight: bold;
            font-size: 14pt;
            margin: 5px 0;
        }

        .red {
            color: red;
        }

        .underline {
            text-decoration: underline;
        }

        table.identitas {
            margin-top: 20px;
            margin-left: 40px;
        }

        table.identitas td {
            padding: 3px;
            vertical-align: top;
        }

        .justify {
            text-align: justify;
            margin-top: 10px;
        }

        ol {
            margin-left: 20px;
            margin-top: 10px;
        }

        .ttd {
            margin-top: 40px;
            text-align: left;
        }

        .ttd-left {
            text-align: left;
        }

        .ttd-wrapper {
            float: right;
            width: 250px;
        }

        .materai {
            border: 1px solid #000;
            display: inline-block;
            padding: 10px 20px;
            margin: 15px 0;
            font-size: 10pt;
        }
    </style>
</head>

<body>

    {{-- KOP SURAT --}}
    <div class="kop">
        <img src="{{ public_path('logo/pemko.png') }}" alt="Logo">
        <h1>PEMERINTAH KOTA BANJARMASIN</h1>
        <h2>{{ strtoupper($pengajuan->skpd->nama ?? '-') }}</h2>
        <p>{{ $pengajuan->skpd->alamat ?? '-' }}</p>
    </div>

    {{-- JUDUL --}}
    <div class="title">
        SURAT PERNYATAAN TANGGUNG JAWAB MUTLAK
    </div>

    <p>
        Saya yang bertanda tangan dibawah <span class="underline">ini :</span>
    </p>

    {{-- IDENTITAS --}}
    <table class="identitas">
        <tr>
            <td width="80">Nama</td>
            <td width="10">:</td>
            <td>{{ $pengajuan->nama_pa ?? '-' }}</td>
        </tr>
        <tr>
            <td>NIP</td>
            <td>:</td>
            <td>{{ $pengajuan->nip_pa ?? '-' }}</td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td>:</td>
            <td>Kepala Dinas {{ $pengajuan->skpd->nama ?? '-' }}</td>
        </tr>
    </table>

    <p class="justify">
        Dengan ini menyatakan <span class="underline">bahwa :</span>
    </p>

    {{-- ISI --}}
    <ol>
        <li class="justify">
            Bertanggung jawab penuh terhadap usulan pergeseran anggaran yang telah
            disampaikan sesuai dengan surat Dinas
            <span>{{ $pengajuan->skpd->nama ?? '-' }} Nomor
                {{ $pengajuan->nomor_surat ?? '-' }} Tanggal {{
                \Carbon\Carbon::parse($pengajuan->tanggal)->locale('id')->translatedFormat('d F Y') }}</span>,
            serta pelaksanaan anggaran setelah proses pergeseran disetujui oleh
            pejabat yang berwenang.
        </li>
        <li class="justify">
            Usulan Pergeseran Anggaran yang disampaikan telah sesuai dengan
            Peraturan Wali Kota Banjarmasin Nomor
            <span class="underline">18 Tahun 2023</span>
            tentang Tata Cara Pergeseran Anggaran Pendapatan dan Belanja Daerah.
        </li>
        <li class="justify">
            Usulan Pergeseran Anggaran telah diperhitungkan sampai dengan
            Objek/Rincian Objek/Sub Rincian Objek dan telah sesuai dengan kebutuhan
            pada <span>{{ $pengajuan->skpd->nama ?? '-' }}</span>
            dan dibuktikan dengan matrik pergeseran anggaran yang telah kami sampaikan.
        </li>
        <li class="justify">
            Penggunaan anggaran bertanggung jawab atas kebenaran formil dan materiil
            usulan pergeseran anggaran yang diajukan.
        </li>
        <li class="justify">
            Apabila dikemudian hari terbukti pernyataan ini tidak benar dan
            menimbulkan kerugian negara, saya bersedia menyetorkan kerugian negara
            tersebut di kas daerah.
        </li>
        <li class="justify">
            Dalam hal terjadi permasalahan hukum yang diakibatkan pergeseran
            anggaran ini menjadi tanggungjawab Pengguna Anggaran.
        </li>
    </ol>

    <p class="justify">
        Demikian pernyataan ini dibuat dengan sesungguhnya dan sebenar-benarnya
        untuk digunakan sebagaimana mestinya.
    </p>

    {{-- TANDA TANGAN --}}
    <div class="ttd-wrapper">
        <div class="ttd-left">
            <p>
                Banjarmasin, <span>{{ \Carbon\Carbon::parse($pengajuan->tanggal)->locale('id')->translatedFormat('d F
                    Y') }}</span>
            </p>

            <p>
                Kepala Dinas,<br>
                Selaku Pengguna Anggaran
            </p>

            <div class="materai">
                Materai<br>
                Rp10.000,-
            </div>

            <p style="font-weight: bold;">
                {{ $pengajuan->nama_pa ?? '-' }}<br>
                {{ $pengajuan->pangkat_pa ?? '-' }}<br>
                NIP. {{ $pengajuan->nip_pa ?? '-' }}
            </p>
        </div>
    </div>

</body>

</html>