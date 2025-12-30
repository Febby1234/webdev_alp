@props(['status'])

@php
$configs = [
    'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'label' => 'Menunggu'],
    'approved' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'label' => 'Disetujui'],
    'rejected' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'label' => 'Ditolak'],
    'verified' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'label' => 'Terverifikasi'],
    'unverified' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'label' => 'Belum Verifikasi'],
    'pass' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'label' => 'Lulus'],
    'passed' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'label' => 'Lulus'],
    'fail' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'label' => 'Tidak Lulus'],
    'failed' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'label' => 'Tidak Lulus'],
    'documents_pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'label' => 'Menunggu Upload Dokumen'],
    'documents_verified' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'label' => 'Dokumen Terverifikasi'],
    'payment_pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'label' => 'Menunggu Pembayaran'],
    'paid' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'label' => 'Sudah Bayar'],
    'exam_scheduled' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'label' => 'Terjadwal Ujian'],
    'interview_scheduled' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'label' => 'Terjadwal Wawancara'],
    'finished' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-800', 'label' => 'Selesai'],
    'accepted' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'label' => 'Diterima'],
];
$config = $configs[$status] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'label' => ucfirst($status)];
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {$config['bg']} {$config['text']}"]) }}>
    {{ $config['label'] }}
</span>
