<?php

namespace App\Exports;

use App\Models\ExamResult;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExamResultsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    /**
     * Query data hasil ujian
     */
    public function collection()
    {
        $query = ExamResult::with([
            'registration.user',
            'registration.major',
            'registration.batch',
            'registration.personalDetail',
            'interviewer',
            'schedule'
        ]);

        // Filter by status
        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }

        // Filter by schedule
        if (!empty($this->filters['schedule_id'])) {
            $query->where('schedule_id', $this->filters['schedule_id']);
        }

        // Filter by interviewer
        if (!empty($this->filters['interviewer_id'])) {
            $query->where('interviewer_id', $this->filters['interviewer_id']);
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
            'Nama Peserta',
            'Email',
            'Jurusan',
            'Gelombang',
            'Jenis Ujian',
            'Tanggal Ujian',
            'Lokasi',
            'Nilai',
            'Grade',
            'Status',
            'Penguji',
            'Catatan',
        ];
    }

    /**
     * Mapping data ke kolom
     */
    public function map($result): array
    {
        static $no = 0;
        $no++;

        $registration = $result->registration;
        $personal = $registration->personalDetail;
        $schedule = $result->schedule;

        return [
            $no,
            $registration->registration_code,
            $personal->full_name ?? $registration->user->name ?? '-',
            $registration->user->email ?? '-',
            $registration->major->name ?? '-',
            $registration->batch->batch_name ?? '-',
            $schedule ? $schedule->getTypeLabel() : '-',
            $schedule ? $schedule->date->format('d/m/Y') : '-',
            $schedule->location ?? '-',
            $result->score ?? '-',
            $result->score ? $result->getGrade() : '-',
            $result->getStatusBadge()['label'],
            $result->interviewer->name ?? '-',
            $result->notes ?? '-',
        ];
    }

    /**
     * Styling Excel
     */
    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
