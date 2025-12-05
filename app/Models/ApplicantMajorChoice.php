<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ApplicantMajorChoice extends Pivot
{
    protected $table = 'applicant_major_choices'; 

    protected $fillable = [
        'applicant_id',
        'major_id',
        'priority',
    ];

    public function major()
    {
        return $this->belongsTo(\App\Models\Major::class);
    }

    public function applicant()
    {
        return $this->belongsTo(\App\Models\Applicant::class);
    }

    public function newInstance($attributes = [], $exists = false)
    {
        $instance = new static();
        $instance->setRawAttributes((array) $attributes, true);
        $instance->setConnection($this->getConnectionName());
        return $instance;
    }
}
