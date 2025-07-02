<?php

namespace App\Observers;

use App\Models\Option;
use App\Models\Question;

class QuestionObserver
{


    /**
     * Handle the Question "created" event.
     */
    public function created(Question $question): void
    {
        $optionSize = 4;
        for ($i = 1; $i <= $optionSize; $i++) {
            Option::create([
                'question_id' => $question->id,
                'option_text' => null,
                'is_correct' => ($i == 1)
            ]);
        }
    }

    /**
     * Handle the Question "updated" event.
     */
    public function updated(Question $question): void
    {
        //
    }

    /**
     * Handle the Question "deleted" event.
     */
    public function deleted(Question $question): void
    {
        //
    }

    /**
     * Handle the Question "restored" event.
     */
    public function restored(Question $question): void
    {
        //
    }

    /**
     * Handle the Question "force deleted" event.
     */
    public function forceDeleted(Question $question): void
    {
        //
    }
}
