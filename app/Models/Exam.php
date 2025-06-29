<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Exam extends Model
{
    protected $table = 'exams';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'note', 'total', 'duration', 'course_id'];
    public $timestamps = true;

    /**
     * Get the course that owns the material.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
