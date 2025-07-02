<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SessionExam extends Model
{
    protected $table = 'session_exams';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id', 'exam_id', 'completed_at'];
    public $timestamps = true;

    public function exams(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    protected $casts = [
        'completed_at' => 'datetime'
    ];
}
