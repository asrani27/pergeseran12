<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan</title>

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

        .header {
            text-align: center;
            position: relative;
        }

        .logo {
            position: absolute;
            left: 0;
            top: 0;
            width: 90px;
        }

        .header h1 {
            margin: 0;
            font-size: 16pt;
            color: red;
            font-weight: bold;
        }

        .header h2 {
            margin: 2px 0;
            font-size: 15pt;
            color: red;
            font-weight: bold;
        }

        .header p {
            margin: 2px 0;
            font-size: 11pt;
            color: red;
        }

        .line {
            border-top: 3px solid #000;
            margin-top: 10px;
        }

        .title {
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            margin: 10px 0;
        }

        .content {
            text-align: justify;
            line-height: 1.6;
        }

        .identity {
            margin-left: 50px;
            margin-top: 15px;
        }

        .identity table {
            border-collapse: collapse;
        }

        .identity td {
            padding: 4px 6px;
            vertical-align: top;
        }

        .red {
            color: red;
        }

        .footer {
            margin-top: 40px;
            width: 100%;
        }

        .signature {
            float: right;
            text-align: center;
        }

        .signature p {
            margin: 5px 0;
        }

        .clear {
            clear: both;
        }
    </style>
</head>

<body>

    <div class="kop">
        <img src="{{ public_path('logo/pemko.png') }}" alt="Logo">
        <h1>PEMERINTAH KOTA BANJARMASIN</h1>
        <h2>{{ strtoupper($pengajuan->skpd->nama ?? '-') }}</h2>
        <p>{{ $pengajuan->skpd->alamat ?? '-' }}</p>
    </div>
    {{-- JUDUL --}}
    <div class="title">
        SURAT KETERANGAN
    </div>
    <div class="content">
        <p>
            Saya yang bertanda tangan dibawah ini :
        </p>

        <div class="identity">
            <table>
                <tr>
                    <td width="120">Nama</td>
                    <td width="10">:</td>
                    <td><strong>{{ $pengajuan->nama_pk ?? '-' }}</strong></td>
                </tr>
                <tr>
                    <td>NIP</td>
                    <td>:</td>
                    <td>{{ $pengajuan->nip_pk ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Jabatan</td>
                    <td>:</td>
                    <td>Sekretaris Dinas</td>
                </tr>
            </table>
        </div>

        <p>
            Menerangkan dengan sesungguhnya bahwa belanja yang diusulkan dalam surat
            permohonan persetujuan pergeseran anggaran Nomor
            <span>{{ $pengajuan->nomor_surat ?? '-' }}</span>
            Tanggal <span>{{ \Carbon\Carbon::parse($pengajuan->tanggal)->locale('id')->translatedFormat('d F
                Y') }}</span>, merupakan belanja yang belum dilakukan
            proses penerbitan Surat Perintah Pembayaran Langsung (SPP-LS) atau
            penggunaan Uang Persediaan/Uang Ganti Persediaan yang Bukti
            Pertanggungjawabannya telah dijurnal/dicatat dalam transaksi Buku Kas
            Umum (BKU).
        </p>

        <p>
            Demikian surat keterangan ini dibuat dengan sesungguhnya dan sebenar-benarnya
            untuk digunakan sebagaimana mestinya.
        </p>
    </div>

    <div class="footer">
        <div class="signature">
            <p><u>Banjarmasin</u>, <span>{{
                    \Carbon\Carbon::parse($pengajuan->tanggal)->locale('id')->translatedFormat('d F Y') }}</span></p>
            <p>Pejabat Penatausahaan Keuangan,</p>

            <br><br><br>

            <p><strong>{{ $pengajuan->nama_pk ?? '-' }}</strong></p>
            <p>NIP. {{ $pengajuan->nip_pk ?? '-' }}</p>
        </div>
        <div class="clear"></div>
    </div>

</body>

</html>