<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RegistrationWave extends Model
{
    use HasFactory, SoftDeletes;
    public $table = 'registration_wave';

    protected $fillable = ['nama_gelombang', 'tanggal_mulai', 'tanggal_selesai', 'aktif'];

    public function applicants()
    {
        return $this->hasMany(Applicant::class, 'id_registration_wave');
    }
}

