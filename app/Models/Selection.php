<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Selection extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'applicant_id',
        'nilai_ujian',
        'nilai_wawancara',
        'hasil_akhir',
        'status'
    ];

    protected $casts = [
        'nilai_ujian' => 'float',
        'nilai_wawancara' => 'float',
        'hasil_akhir' => 'float',
    ];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }
}
