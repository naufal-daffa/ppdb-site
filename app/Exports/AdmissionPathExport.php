<?php

namespace App\Exports;

use App\Models\AdmissionPath;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AdmissionPathExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return AdmissionPath::all();
    }

    public function headings(): array
    {
        return [
            "No",
            "Nama Jalur Pendaftaran",
        ];
    }

    private $rowNumber = 0;

    public function map($admissionPath): array
    {
        return [
            ++$this->rowNumber,
            $admissionPath->prestasi,
        ];
    }
}
