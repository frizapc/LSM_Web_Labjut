<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Score extends Model
{
    protected $table = 'scores';
    protected $primaryKey = 'id';
    protected $fillable = ['score', 'user_id', 'course_id', 'exam_id'];
    public $timestamps = true;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
