<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Exam;
use App\Models\Option;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $validated = $request->validate([
            'question_text' => 'nullable|string',
            'correct_option' => 'required|string',
        ]);
        
        try {
            DB::transaction(function () use ($request, $validated, $courseId, $examId, $questionId) {
                // Verifikasi relasi sekaligus
                $question = Question::where('id', $questionId)
                    ->where('exam_id', $examId)
                    ->whereHas('exam', function($q) use ($courseId) {
                        $q->where('course_id', $courseId);
                    })
                    ->firstOrFail();
    
                // Update pertanyaan
                $question->update(['question_text' => $validated['question_text']]);
    
                // Filter hanya opsi yang valid (non-null)
                $validOptions = array_filter($request->all(), function($value, $key) {
                    return is_numeric($key) && $value !== null;
                }, ARRAY_FILTER_USE_BOTH);
                
                // Batch update opsi
                foreach ($validOptions as $optionId => $optionText) {
                    Option::where('id', $optionId)
                        ->where('question_id', $questionId)
                        ->update([
                            'option_text' => $optionText,
                            'is_correct' => ($request->correct_option == $optionId)
                        ]);
                }
            });
    
            return back()->with('success', 'Soal berhasil diperbarui!');
    
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui soal');
        }
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
