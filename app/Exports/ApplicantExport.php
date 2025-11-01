<?php

namespace App\Exports;

use App\Models\Applicant;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ApplicantExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Applicant::all();
    }
    public function headings(): array
    {
        return [
            "No",
            "NISN",
            "Nama Lengkap",
            "Alamat",
            "Tanggal Lahir",
            "Nomor Telepon Wali",
            "Nomor Telepon",
        ];
    }
    private $rowNumber = 0;
    public function map($applicant): array
    {
        return [
            ++$this->rowNumber,
            $applicant->nisn,
            $applicant->nama_lengkap,
            $applicant->alamat,
            $applicant->tanggal_lahir,
            $applicant->nomor_telepon_wali,
            $applicant->nomor_telepon
        ];
    }
}
