<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Permohonan Pergeseran Anggaran</title>

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

        .content {
            margin-top: 10px;
        }

        .right {
            text-align: right;
        }

        .red {
            color: red;
        }

        table.info {
            width: 100%;
            margin-top: 20px;
        }

        table.info td {
            vertical-align: top;
            padding: 2px;
        }

        .justify {
            text-align: justify;
            line-height: 1.8;
            margin-top: 20px;
        }

        .list {
            margin-left: 30px;
            margin-top: 0px;
        }

        .signature {
            margin-top: 30px;
            text-align: right;
        }

        .signature .name {
            margin-top: 80px;
            font-weight: bold;
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

    <div class="content">

        <p class="right">
            Banjarmasin, <span>{{ \Carbon\Carbon::parse($pengajuan->tanggal)->format('d F Y') }}</span>
        </p>

        <table class="info">
            <tr>
                <td width="15%">Nomor</td>
                <td width="2%">:</td>
                <td>{{ $pengajuan->nomor_surat }}</td>

                <td width="10%"></td>

                <td>Kepada Yth:</td>
            </tr>
            <tr>
                <td>Sifat</td>
                <td>:</td>
                <td>Lampiran</td>

                <td></td>

                <td>Sekretaris Daerah</td>
            </tr>
            <tr>
                <td>Lampiran</td>
                <td>:</td>
                <td>1 (satu) berkas</td>

                <td></td>

                <td>di-</td>
            </tr>
            <tr>
                <td>Perihal</td>
                <td>:</td>
                <td>
                    Permohonan Persetujuan
                    <span>Pergeseran Anggaran</span>
                    pada APBD Tahun <span>{{ $pengajuan->tahun }}</span>
                </td>

                <td></td>

                <td><strong>Banjarmasin</strong></td>
            </tr>
        </table>

        <p class="justify">
            Dengan hormat,
        </p>

        <p class="justify">
            Dengan memperhatikan ketentuan pergeseran anggaran yang tercantum dalam
            Peraturan Wali Kota Banjarmasin Nomor 18 Tahun 2023 tentang Tata Cara
            Pergeseran Anggaran Pendapatan dan Belanja Daerah, dengan ini kami
            mengajukan permohonan pergeseran anggaran pada DPA-
            <span>{{ strtoupper($pengajuan->skpd->nama ?? 'Dinas Koperasi, Usaha Mikro dan Tenaga Kerja')
                }}</span>
            APBD TA <span>{{ $pengajuan->tahun }}</span>, dengan pertimbangan sebagai berikut:
        </p>

        <ol class="list">
            <li class="justify">
                <strong>{{ $pengajuan->nama_subkegiatan }}</strong> dilakukan pergeseran
                @if($pengajuan->hal)
                karena {{ $pengajuan->hal }}
                @else
                dengan pertimbangan sebagaimana mestinya
                @endif
            </li>
        </ol>

        <p class="justify">
            Bersama surat ini, kami melampirkan Rancangan DPA Perubahan dan
            Rincian Pergeseran Anggaran DPA-SKPD.
        </p>

        <p class="justify">
            Demikian surat permohonan ini diajukan, atas perhatiannya diucapkan
            terima kasih.
        </p>

        <div class="signature">
            <p>Pengguna Anggaran,</p>

            <p class="name red">
                {{ $pengajuan->nama_pa ?? '-' }}
                <br>
                {{ $pengajuan->pangkat_pa ?? '-' }}
                <br>
                NIP. {{ $pengajuan->nip_pa ?? '-' }}
            </p>
        </div>

    </div>

</body>

</html>
