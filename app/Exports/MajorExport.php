<?php

namespace App\Exports;

use App\Models\Major;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MajorExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Major::all();
    }
    public function headings(): array
    {
        return [
            "No",
            "Bidang Keahlian",
            "Jurusan",
            "Deskripsi"
        ];
    }
    private $rowNumber = 0;
    public function map($major): array
    {
        return [
            ++$this->rowNumber,
            $major->skillField->nama,
            $major->nama,
            $major->deskripsi
        ];
    }
}
