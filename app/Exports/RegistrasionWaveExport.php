<?php

namespace App\Exports;

use App\Models\RegistrationWave;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RegistrasionWaveExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return RegistrationWave::all();
    }
    public function headings(): array
    {
        return [
            "No",
            "Nama Gelombang",
            "Tanggal Mulai",
            "Tanggal Selesai",
            "Aktif"
        ];
    }
    private $rowNumber = 0;
    public function map($registrationWave): array
    {
        if($registrationWave->aktif == 1){
            $registrationWaveAktif = 'Aktif';
        }else{
            $registrationWaveAktif = 'Tidak aktif atau sudah selesai';
        };
        return [
            ++$this->rowNumber,
            $registrationWave->nama_gelombang,
            $registrationWave->tanggal_mulai,
            $registrationWave->tanggal_mulai,
            $registrationWaveAktif,
        ];
    }
}
