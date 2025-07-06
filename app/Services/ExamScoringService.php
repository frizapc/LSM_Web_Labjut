<?php

namespace App\Services;

use App\Models\Answer;
use App\Models\Option;
use App\Models\Question;
use App\Models\Score;
use App\Models\SessionExam;

class ExamScoringService
{
    public static function calculate($userId, $courseId, $examId)
    {
        $answers = Answer::where([
            ['user_id', $userId],
            ['exam_id', $examId],
        ]);

        $questions = Question::where([
           ['exam_id', $examId],
        ])->get();

        $questionIds = $questions
            ->pluck('id')
            ->unique();

        $options = Option::whereIn('question_id', $questionIds)
          ->get();

        $correctAnswers = 0;

        foreach ($answers->get() as $answer) {
            $selectedOption = $options->firstWhere('id', $answer->option_id);
          
            if ($selectedOption && $selectedOption->is_correct) {
                $correctAnswers++;
            }
        }

        $score = $correctAnswers 
            ? (($correctAnswers / $questions->count()) * 100)
            : $correctAnswers;

        Score::create([
            'score' => $score,
            'user_id' => $userId,
            'course_id' => $courseId,
            'exam_id' => $examId,
        ]);

        $answers->delete();

        return  $questionIds;
    }
}