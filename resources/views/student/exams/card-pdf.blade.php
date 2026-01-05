<!DOCTYPE html>
<html>
<head>
    <title>Kartu Peserta Ujian</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #000;
            /* Tambahkan ini untuk memastikan body tidak ada margin default */
            margin: 0;
            padding: 0;
        }
        /* --- PERBAIKAN DI SINI --- */
        .container {
            /* HAPUS BARIS INI: width: 100%; */
            /* HAPUS BARIS INI: max-width: 700px; */
            /* HAPUS BARIS INI: margin: 0 auto; */

            /* GANTI JADI INI: Beri margin agar tidak mepet pinggir kertas */
            margin: 30px;

            border: 1px solid #000;
            padding: 30px;
        }
        /* ------------------------- */

        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 25px;
        }
        /* ... (SISANYA KE BAWAH SAMA SEPERTI SEBELUMNYA) ... */
        .header h1 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .header p {
            margin: 5px 0 0;
            font-size: 12px;
        }
        .content-table {
            width: 100%;
            margin-bottom: 20px;
        }
        .content-table td {
            vertical-align: top;
            padding: 5px;
        }
        .photo-container {
            width: 3cm;
            height: 4cm;
            border: 1px solid #000;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            line-height: 4cm;
            font-size: 10px;
            color: #555;
            background-color: #fff;
        }
        .photo-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .label {
            font-weight: bold;
            width: 140px;
        }
        .sep {
            width: 10px;
            text-align: center;
        }
        .footer {
            margin-top: 40px;
            text-align: right;
            padding-right: 20px;
        }
        .signature-box {
            display: inline-block;
            text-align: center;
            width: 200px;
        }
        .signature-line {
            border-bottom: 1px solid #000;
            margin-top: 60px;
        }
        .notes {
            margin-top: 30px;
            font-size: 11px;
            font-style: italic;
        }
        .notes ul {
            padding-left: 20px;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>KARTU TANDA PESERTA UJIAN</h1>
            <p>SELEKSI PENERIMAAN MAHASISWA BARU TAHUN {{ date('Y') }}</p>
        </div>

        <table class="content-table">
            <tr>
                <td width="130">
                    <div class="photo-container">
                        @if(!empty($photoPath) && file_exists($photoPath))
                            <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($photoPath)) }}">
                        @else
                            FOTO 3x4
                        @endif
                    </div>
                </td>

                <td width="20"></td>

                <td>
                    <table style="width: 100%;">
                        <tr>
                            <td class="label">NO. PESERTA</td>
                            <td class="sep">:</td>
                            <td style="font-size: 14px; font-weight: bold;">{{ $registration->registration_code }}</td>
                        </tr>
                        <tr>
                            <td class="label">NAMA LENGKAP</td>
                            <td class="sep">:</td>
                            <td>{{ strtoupper($registration->personalDetail->full_name) }}</td>
                        </tr>
                        <tr>
                            <td class="label">JURUSAN</td>
                            <td class="sep">:</td>
                            <td>{{ $registration->major->name }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" style="padding-top: 15px;"></td> </tr>
                        <tr>
                            <td class="label">TANGGAL UJIAN</td>
                            <td class="sep">:</td>
                            <td>{{ \Carbon\Carbon::parse($schedule->date)->translatedFormat('l, d F Y') }}</td>
                        </tr>
                        <tr>
                            <td class="label">WAKTU</td>
                            <td class="sep">:</td>
                            <td>{{ \Carbon\Carbon::parse($schedule->time)->format('H:i') }} WIB - Selesai</td>
                        </tr>
                        <tr>
                            <td class="label">LOKASI</td>
                            <td class="sep">:</td>
                            <td>
                                {{ $schedule->location }}
                                @if($schedule->room) <br><small>(Ruangan: {{ $schedule->room }})</small> @endif
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <div class="footer">
            <div class="signature-box">
                <p>Rektorat Akademika,</p>
                <div class="signature-line"></div>
                <p style="margin-top: 5px; font-size: 11px;">( Tanda Tangan Rektor )</p>
            </div>
        </div>

        <div class="notes">
            <strong>CATATAN PENTING:</strong>
            <ul>
                <li>Kartu ini wajib dibawa saat pelaksanaan ujian.</li>
                <li>Peserta wajib membawa kartu identitas asli (KTP/Kartu Pelajar).</li>
                <li>Peserta diharapkan hadir 30 menit sebelum ujian dimulai.</li>
            </ul>
        </div>
    </div>
</body>
</html>
    