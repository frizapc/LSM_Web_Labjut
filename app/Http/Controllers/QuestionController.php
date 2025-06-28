<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Exam;
use App\Models\Option;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($courseId, $examId)
    {
        Course::findOrFail($courseId);
        Exam::findOrFail($examId);
        Question::create([
            'exam_id' => $examId
        ]);

        return redirect()
            ->back()
            ->with('success', 'Soal berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $courseId, $examId, $questionId)
    {
        $request->validate([
            'question_text' => 'nullable',
            'correct_option' => 'required|string',
        ]);
        Course::findOrFail($courseId);
        Exam::findOrFail($examId);
        $question = Question::findOrFail($questionId);
        $question->update([
            'question_text' => $request->question_text,
        ]);
        $optionIds = array_values(
    array_filter(
        array_keys($request->all()), 'is_numeric'
            )
        );

        foreach ($optionIds as $optionId){
            Option::findOrFail($optionId)
                ->update([
                    'option_text' => $request[$optionId],
                    'is_correct' => $request->correct_option == $optionId ? true : false
                ]);

        }
        return redirect()
            ->back()
            ->with('success', 'Soal berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $courseId, $examId, $questionId)
    {
        Course::findOrFail($courseId);
        Exam::findOrFail($examId);
        Question::findOrFail($questionId)
            ->delete();

        return redirect()
            ->back()
            ->with('success', 'Soal berhasil dihapus!');
    }
}
