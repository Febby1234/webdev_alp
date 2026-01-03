<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Required Documents
    |--------------------------------------------------------------------------
    |
    | Daftar dokumen yang wajib diupload oleh pendaftar.
    | Key = type dokumen (untuk database)
    | Value = label untuk ditampilkan
    |
    */

    'required_documents' => [
        'ktp'         => 'KTP / Kartu Identitas',
        'ijazah'      => 'Ijazah / SKL',
        'foto'        => 'Pas Foto',
        'akta_lahir'  => 'Akta Kelahiran',
    ],

    /*
    |--------------------------------------------------------------------------
    | Registration Fee
    |--------------------------------------------------------------------------
    |
    | Biaya pendaftaran dalam Rupiah
    |
    */

    'registration_fee' => 500000,

    /*
    |--------------------------------------------------------------------------
    | Passing Score
    |--------------------------------------------------------------------------
    |
    | Nilai minimum untuk lulus ujian
    |
    */

    'passing_score' => 70,

    /*
    |--------------------------------------------------------------------------
    | Status Flow
    |--------------------------------------------------------------------------
    |
    | Urutan status registrasi
    |
    */

    'status_flow' => [
        'pending',
        'documents_pending',
        'documents_verified',
        'payment_pending',
        'paid',
        'exam_scheduled',
        'interview_scheduled',
        'finished',
        'accepted',
        'rejected',
    ],

    /*
    |--------------------------------------------------------------------------
    | Status Labels
    |--------------------------------------------------------------------------
    |
    | Label untuk setiap status (Bahasa Indonesia)
    |
    */

    'status_labels' => [
        'pending'              => 'Menunggu Pengisian Data',
        'documents_pending'    => 'Menunggu Upload Dokumen',
        'documents_verified'   => 'Dokumen Terverifikasi',
        'payment_pending'      => 'Menunggu Pembayaran',
        'paid'                 => 'Pembayaran Terverifikasi',
        'exam_scheduled'       => 'Terjadwal Ujian',
        'interview_scheduled'  => 'Terjadwal Wawancara',
        'finished'             => 'Proses Selesai',
        'accepted'             => 'Diterima',
        'rejected'             => 'Ditolak',
    ],

];
