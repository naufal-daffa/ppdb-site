<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'applicant_id',
        'tanggal_wawancara',
        'waktu_wawancara',
        'status_kehadiran'
    ];
}
