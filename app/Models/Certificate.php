<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Certificate extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'applicant_id',
        'file_path',
        'nama_sertifikat',
        'deskripsi',
        'status_verifikasi',
        'catatan_staff'
    ];

    public function applicant() { return $this->belongsTo(Applicant::class); }
}
