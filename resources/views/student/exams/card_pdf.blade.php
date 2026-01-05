<!DOCTYPE html>
<html>
<head>
    <title>Kartu Peserta Ujian</title>
    <style>
        body { font-family: sans-serif; font-size: 11pt; }
        .card {
            border: 2px solid #000;
            padding: 20px;
            width: 100%;
            max-width: 700px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h1 { margin: 0; font-size: 18pt; text-transform: uppercase; }
        .header p { margin: 2px 0; font-size: 10pt; }
        table { width: 100%; }
        td { vertical-align: top; padding: 4px; }
        .photo-box {
            width: 3cm;
            height: 4cm;
            border: 1px solid #000;
            text-align: center;
            line-height: 4cm;
            font-size: 9pt;
            color: #ccc;
        }
        .photo-img { width: 3cm; height: 4cm; object-fit: cover; }
        .label { width: 130px; font-weight: bold; }
        .separator { width: 10px; }
        .footer { margin-top: 30px; text-align: right; font-size: 10pt; }
        .signature-line { border-bottom: 1px solid #000; margin-top: 50px; width: 150px; display: inline-block;}
        .notes { margin-top: 20px; font-size: 9pt; border: 1px solid #666; padding: 10px; background-color: #f9f9f9; }
    </style>
</head>
<body>
    <div class="card">
        <div class="header">
            <h1>KARTU PESERTA UJIAN</h1>
            <p>PENERIMAAN MAHASISWA BARU TAHUN {{ date('Y') }}</p>
        </div>
        <table>
            <tr>
                <td width="130">
                    <div class="photo-box">
                        @if(!empty($photoPath) && file_exists($photoPath))
                            <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($photoPath)) }}" class="photo-img">
                        @else
                            FOTO 3x4
                        @endif
                    </div>
                </td>
                <td>
                    <table>
                        <tr><td class="label">No. Peserta</td><td class="separator">:</td><td><strong>{{ $registration->registration_code }}</strong></td></tr>
                        <tr><td class="label">Nama Lengkap</td><td class="separator">:</td><td>{{ strtoupper($registration->personalDetail->full_name) }}</td></tr>
                        <tr><td class="label">Jurusan</td><td class="separator">:</td><td>{{ $registration->major->name }}</td></tr>
                        <tr><td class="label">Jadwal</td><td class="separator">:</td><td>{{ \Carbon\Carbon::parse($schedule->date)->format('d F Y') }}</td></tr>
                        <tr><td class="label">Waktu</td><td class="separator">:</td><td>{{ \Carbon\Carbon::parse($schedule->time)->format('H:i') }} WIB</td></tr>
                        <tr><td class="label">Lokasi</td><td class="separator">:</td><td>{{ $schedule->location }}</td></tr>
                    </table>
                </td>
            </tr>
        </table>
        <div class="footer">
            <p>Panitia PMB,</p>
            <div class="signature-line"></div>
        </div>
        <div class="notes">
            <strong>TATA TERTIB:</strong>
            <ol style="margin-top: 5px; padding-left: 15px; margin-bottom: 0;">
                <li>Wajib membawa kartu ujian dan identitas asli.</li>
                <li>Hadir 30 menit sebelum ujian dimulai.</li>
                <li>Berpakaian rapi dan sopan.</li>
            </ol>
        </div>
    </div>
</body>
</html>
