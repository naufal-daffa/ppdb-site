<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Major extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['skill_field_id', 'nama', 'deskripsi'];

    public function skillField()
    {
        return $this->belongsTo(SkillField::class);
    }
    public function applicants()
    {
        return $this->hasMany(Applicant::class);
    }
    
    public function applicantChoices()
    {
        return $this->belongsToMany(Applicant::class, 'applicant_major_choices')
            ->withPivot('priority');
    }
}
