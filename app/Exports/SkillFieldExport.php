<?php

namespace App\Exports;

use App\Models\SkillField;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SkillFieldExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return SkillField::all();
    }
    public function headings(): array
    {
        return [
            "Nama",
            "Deskripsi",
        ];
    }
    private $rowNumber = 0;
    public function map($skillField): array
    {
        return [
            ++$this->rowNumber,
            $skillField->nama,
            $skillField->deskripsi,
        ];
    }
}
