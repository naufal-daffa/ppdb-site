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
        'lokasi_berkas',
        'ktp_ayah',
        'ktp_ibu',
        'surat_kesehatan',
        'status_verifikasi'
    ];

    public function applicant() { return $this->belongsTo(Applicant::class); }
}

