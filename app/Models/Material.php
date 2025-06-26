<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Material extends Model
{
    protected $table = 'materials';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'description', 'source', 'course_id'];
    public $timestamps = true;

    /**
     * Get the course that owns the material.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
