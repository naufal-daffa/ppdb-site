<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdmissionPath extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'prestasi'
    ];

    public function applicants()
    {
        return $this->hasMany(Applicant::class);
    }
}

