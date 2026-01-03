<?php

namespace App\Exports;

use App\Models\Major;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MajorsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $batchId;

    public function __construct(?int $batchId = null)
    {
        $this->batchId = $batchId;
    }

    /**
     * Query data jurusan dengan statistik
     */
    public function collection()
    {
        return Major::withCount([
            'registrations' => function ($query) {
                if ($this->batchId) {
                    $query->where('batch_id', $this->batchId);
                }
            },
            'registrations as pending_count' => function ($query) {
                $query->whereNotIn('status', ['accepted', 'rejected']);
                if ($this->batchId) {
                    $query->where('batch_id', $this->batchId);
                }
            },
            'registrations as accepted_count' => function ($query) {
                $query->where('status', 'accepted');
                if ($this->batchId) {
                    $query->where('batch_id', $this->batchId);
                }
            },
            'registrations as rejected_count' => function ($query) {
                $query->where('status', 'rejected');
                if ($this->batchId) {
                    $query->where('batch_id', $this->batchId);
                }
            },
        ])->get();
    }

    /**
     * Header kolom Excel
     */
    public function headings(): array
    {
        return [
            'No',
            'Nama Jurusan',
            'Deskripsi',
            'Kuota',
            'Total Pendaftar',
            'Dalam Proses',
            'Diterima',
            'Ditolak',
            'Sisa Kuota',
            'Persentase Terisi',
            'Status',
        ];
    }

    /**
     * Mapping data ke kolom
     */
    public function map($major): array
    {
        static $no = 0;
        $no++;

        $remainingQuota = $major->quota - $major->accepted_count;
        $percentage = $major->quota > 0
            ? round(($major->accepted_count / $major->quota) * 100, 1)
            : 0;

        return [
            $no,
            $major->name,
            $major->description ?? '-',
            $major->quota,
            $major->registrations_count,
            $major->pending_count,
            $major->accepted_count,
            $major->rejected_count,
            max(0, $remainingQuota),
            $percentage . '%',
            $major->is_active ? 'Aktif' : 'Nonaktif',
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
