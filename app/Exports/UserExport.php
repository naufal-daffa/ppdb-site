<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UserExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return User::whereIn(
            'role', ['admin', 'staff']
        )->get();
    }
    public function headings(): array
    {
        return [
            "No",
            "Nama",
            "Email",
            "Role",
        ];
    }
    private $rowNumber = 0;
    public function map($user): array
    {
        return [
            ++$this->rowNumber,
            $user->nama,
            $user->email,
            $user->role,
        ];
    }
}
