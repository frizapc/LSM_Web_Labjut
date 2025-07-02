<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    protected $table = 'courses';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'level', 'description', 'photo', 'code'];
    public $timestamps = true;

    public function materials(): HasMany
    {
        return $this->hasMany(Material::class);
    }
    public function exams(): HasMany
    {
        return $this->hasMany(Exam::class);
    }
}
