<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantMajorChoice extends Model
{
    use HasFactory;

    protected $fillable = ['applicant_id', 'major_id', 'priority'];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }

    public function major()
    {
        return $this->belongsTo(Major::class);
    }
}
