<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Applicant extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'bukti_pembayaran',
        'status_verifikasi',
        'payment_url',
        'nisn',
        'nama_lengkap',
        'tanggal_lahir',
        'alamat',
        'nomor_telepon',
        'jenis_kelamin',
        'asal_sekolah',
        // 'major_id',
        'pekerjaan_ayah',
        'pekerjaan_ibu',
        'nomor_telepon_wali',
        'admission_path_id',
        'status_pendaftaran',
        'id_registration_wave'
    ];

    public function majorChoices()
    {
        return $this->belongsToMany(Major::class, 'applicant_major_choices', 'applicant_id', 'major_id')
            ->withPivot('priority')
            ->orderBy('pivot_priority')
            ->using(ApplicantMajorChoice::class);
    }
    public function applicantChoices()
    {
        return $this->belongsToMany(Major::class, 'applicant_major_choices')
                    ->using(ApplicantMajorChoice::class)
                    ->withPivot('priority')
                    ->orderBy('priority');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function staff()
    {
        return $this->hasOne(Staff::class, 'applicant_id');
    }
    public function major()
    {
        return $this->belongsTo(Major::class);
    }
    public function admissionPath()
    {
        return $this->belongsTo(AdmissionPath::class);
    }
    public function registrationWave()
    {
        return $this->belongsTo(RegistrationWave::class, 'id_registration_wave');
    }
    public function document()
    {
        return $this->hasOne(Document::class, 'applicant_id');
    }
    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }
    public function selections()
    {
        return $this->hasMany(Selection::class);
    }
}
