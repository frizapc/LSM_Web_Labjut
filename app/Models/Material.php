<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $table = 'materials';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'description', 'source', 'course_id'];
    public $timestamps = true;
}
