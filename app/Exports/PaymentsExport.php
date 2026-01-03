<?php

namespace App\Exports;

use App\Models\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PaymentsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    /**
     * Query data pembayaran
     */
    public function collection()
    {
        $query = Payment::with([
            'registration.user',
            'registration.major',
            'registration.batch',
            'registration.personalDetail',
            'verifiedBy'
        ]);

        // Filter by status
        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
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
            'Nama Pendaftar',
            'Email',
            'Jurusan',
            'Gelombang',
            'Jumlah Bayar',
            'Status',
            'Diverifikasi Oleh',
            'Tanggal Upload',
            'Tanggal Verifikasi',
        ];
    }

    /**
     * Mapping data ke kolom
     */
    public function map($payment): array
    {
        static $no = 0;
        $no++;

        $registration = $payment->registration;
        $personal = $registration->personalDetail;

        return [
            $no,
            $registration->registration_code,
            $personal->full_name ?? $registration->user->name ?? '-',
            $registration->user->email ?? '-',
            $registration->major->name ?? '-',
            $registration->batch->batch_name ?? '-',
            $payment->getFormattedAmount(),
            $payment->getStatusBadge()['label'],
            $payment->verifiedBy->name ?? '-',
            $payment->created_at->format('d/m/Y H:i'),
            $payment->status !== 'pending' ? $payment->updated_at->format('d/m/Y H:i') : '-',
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
