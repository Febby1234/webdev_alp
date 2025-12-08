@props(['status'])

@php
$configs = [
    'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'label' => 'Pending'],
    'approved' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'label' => 'Disetujui'],
    'rejected' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'label' => 'Ditolak'],
    'verified' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'label' => 'Terverifikasi'],
    'unverified' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'label' => 'Belum Verifikasi'],
    'passed' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'label' => 'Lulus'],
    'failed' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'label' => 'Tidak Lulus'],
];
$config = $configs[$status] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'label' => ucfirst($status)];
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {$config['bg']} {$config['text']}"]) }}>
    {{ $config['label'] }}
</span>
