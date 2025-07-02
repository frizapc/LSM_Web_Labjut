<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Option extends Model
{
    protected $table = 'options';
    protected $primaryKey = 'id';
    protected $fillable = ['option_text', 'is_correct', 'question_id'];
    public $timestamps = false;

    public function exam(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
