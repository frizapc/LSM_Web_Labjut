<?php

namespace App\Services;

use App\Models\Answer;
use App\Models\Option;
use App\Models\Question;
use App\Models\SessionExam;

class ExamScoringService
{
    public static function calculate($userId, $examId)
    {
        $answers = Answer::where([
            ['user_id', $userId],
            ['exam_id', $examId],
        ])->get();

        $questionIds = $answers
            ->pluck('question_id')
            ->unique();

        $options = Option::whereIn('question_id', $questionIds)
          ->get();

        $correctAnswers = 0;

        foreach ($answers as $answer) {
            $selectedOption = $options->firstWhere('id', $answer->option_id);
          
            if ($selectedOption && $selectedOption->is_correct) {
                $correctAnswers++;
            }
        }

        return  $correctAnswers;
    }
}