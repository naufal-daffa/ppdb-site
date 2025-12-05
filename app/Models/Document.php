<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'applicant_id',
        'kartu_keluarga',
        'akte_kelahiran',
        'ijazah',
        'surat_kelulusan',
        'ktp_ayah',
        'ktp_ibu',
        'surat_kesehatan',
        'status_verifikasi',
        'verification_status',
        'verification_notes',
    ];

    protected $casts = [
        'verification_status' => 'array',
        'verification_notes'  => 'array',
    ];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class, 'applicant_id');
    }
}
