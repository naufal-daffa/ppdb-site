<?php

namespace App\Exports;

use App\Models\Staff;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ScheduleExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        Staff::withTrashed()->with(['user', 'applicant'])
            ->whereNotNull('applicant_id')
            ->pluck('applicant_id')
            ->toArray();
    }
    public function headings() : array {
        return [
            "Nama Staff",
            "Nama Pendaftar",
            "Tanggal Wawancara",
            "Waktu Wawancara",
            "Status Kehadiran"
        ];
    }
    private $row = 0;
        public function map($staff): array
    {
        return [
            ++$this->row,
            $staff->user->nama,
            $staff->applicant->nama_lengkap,
            $staff->tanggal_wawancara,
            $staff->waktu_wawancara,
            $staff->status_kehadiran
        ];
    }
}
