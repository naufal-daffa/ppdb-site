<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Major extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'skill_field_id',
        'nama',
        'deskripsi'
    ];

    public function skillField()
    {
        return $this->belongsTo(SkillField::class, 'skill_field_id');
    }

    public function applicants()
    {
        return $this->belongsToMany(Applicant::class, 'applicant_major_choices')
                    ->withPivot('priority')
                    ->withTimestamps();
    }

    public function applicantMajorPriorities()
    {
        return $this->hasMany(ApplicantMajorPriority::class, 'major_id');
    }

    public function priority1Applicants()
    {
        return $this->applicants()
                    ->wherePivot('priority_level', 1);
    }
}
