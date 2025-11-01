<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SkillField extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['nama', 'deskripsi'];

    public function majors()
    {
        return $this->hasMany(Major::class);
    }
}
