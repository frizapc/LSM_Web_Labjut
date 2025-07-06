<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $table = 'answers';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id', 'exam_id', 'question_id', 'option_id'];
    public $timestamps = false;
}
