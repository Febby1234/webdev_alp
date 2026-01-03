<?php

namespace App\Exports;

use App\Models\Registration;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RegistrationsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    /**
     * Query data registrasi
     */
    public function collection()
    {
        $query = Registration::with([
            'user',
            'major',
            'batch',
            'personalDetail',
            'parents',
            'schoolOrigin',
            'payment'
        ]);

        // Filter by status
        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }

        // Filter by major
        if (!empty($this->filters['major_id'])) {
            $query->where('major_id', $this->filters['major_id']);
        }

        // Filter by batch
        if (!empty($this->filters['batch_id'])) {
            $query->where('batch_id', $this->filters['batch_id']);
        }

        return $query->latest()->get();
    }

    /**
     * Header kolom Excel
     */
    public function headings(): array
    {
        return [
            'No',
            'Kode Registrasi',
            'Email',
            'Nama Lengkap',
            'Jenis Kelamin',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Alamat',
            'No. Telepon',
            'Nama Ayah',
            'Pekerjaan Ayah',
            'Telepon Ayah',
            'Nama Ibu',
            'Pekerjaan Ibu',
            'Telepon Ibu',
            'Asal Sekolah',
            'Tahun Lulus',
            'Rata-rata Nilai',
            'Jurusan Pilihan',
            'Gelombang',
            'Status Pembayaran',
            'Status Registrasi',
            'Tanggal Daftar',
        ];
    }

    /**
     * Mapping data ke kolom
     */
    public function map($registration): array
    {
        static $no = 0;
        $no++;

        $personal = $registration->personalDetail;
        $parents = $registration->parents;
        $school = $registration->schoolOrigin;

        return [
            $no,
            $registration->registration_code,
            $registration->user->email ?? '-',
            $personal->full_name ?? '-',
            $personal->gender ?? '-',
            $personal->birth_place ?? '-',
            $personal->birth_date ? $personal->birth_date->format('d/m/Y') : '-',
            $personal->address ?? '-',
            $personal->phone ?? '-',
            $parents->father_name ?? '-',
            $parents->father_job ?? '-',
            $parents->father_phone ?? '-',
            $parents->mother_name ?? '-',
            $parents->mother_job ?? '-',
            $parents->mother_phone ?? '-',
            $school->school_origin_name ?? '-',
            $school->graduation_year ?? '-',
            $school->average_grade ?? '-',
            $registration->major->name ?? '-',
            $registration->batch->batch_name ?? '-',
            $registration->payment ? $registration->payment->getStatusBadge()['label'] : 'Belum Upload',
            $registration->getStatusLabel(),
            $registration->created_at->format('d/m/Y H:i'),
        ];
    }

    /**
     * Styling Excel
     */
    public function styles(Worksheet $sheet): array
    {
        return [
            // Header row bold
            1 => ['font' => ['bold' => true]],
        ];
    }
}
