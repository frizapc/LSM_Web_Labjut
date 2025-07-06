<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Course;
use App\Models\Exam;
use App\Models\Option;
use App\Models\Question;
use App\Models\SessionExam;
use App\Services\ExamScoringService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Psy\CodeCleaner\ReturnTypePass;

class ExamController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create($courseId)
    {
        $course = Course::findOrFail($courseId);
        return view('pages.exams.create', [
            'course' => $course,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $courseId)
    {
        Course::findOrFail($courseId);
        $request->validate([
            'name' => 'required|string|max:50',
            'note' => 'nullable|string',
        ]);

        Exam::create([
            'name' => $request->name,
            'note' => $request->note,
            'course_id' => $courseId,
        ]);

        return redirect()
            ->route('courses.show', $courseId)
            ->with('success', 'Ujian baru berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request,  $courseId, $examId)
    {
        $course = Course::findOrFail($courseId);

        $exam = Exam::whereBelongsTo($course)
        ->findOrFail($examId);
        
        $user = $request->user();
        
        $sessionExam = SessionExam::firstOrCreate(
        [
            'user_id' => $user->id,
            'exam_id' => $examId,
        ],
        [
            'completed_at' => now()->addMinutes($exam->duration),
            ]
        );
            
        $timeLeft = now()->diffInSeconds($sessionExam->completed_at);
            
        $questionIds = Question::where('exam_id', $exam->id)
            ->pluck('id')
            ->toArray();

        $cacheName = "exam_{$exam->id}_user_{$user->id}_shuffled_ids";
        session(['cacheName' => $cacheName]);
            
        $shuffledIds = Cache::remember(
                $cacheName, 
                now()->addMinutes($exam->duration), 
                function () use ($questionIds) {
            return collect($questionIds)
            ->shuffle()
            ->values()
            ->all();
        });

        $currentPage = $request->get('page', 1);
        $currentQuestionId = $shuffledIds[$currentPage - 1] ?? null;

        $question = Question::findOrFail($currentQuestionId);

        $questions = new \Illuminate\Pagination\LengthAwarePaginator(
            [$question],
            count($shuffledIds),
            1,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );


        return view('pages.exams.show', [
            'course' => $course,
            'exam' => $exam,
            'questions' => $questions,
            'timeLeft' => $timeLeft
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $courseId, $examId)
    {
        $course = Course::findOrFail($courseId);

        $exam = Exam::whereBelongsTo($course)
            ->findOrFail($examId);

        return view('pages.exams.edit', [
            'course' => $course,
            'exam' => $exam,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $courseId, $examId)
    {
        $course = Course::findOrFail($courseId);
        $request->validate([
            'name' => 'required|string|max:255',
            'duration' => 'required|integer|min:1|max:120',
            'note' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        Exam::whereBelongsTo($course)
            ->findOrFail($examId)
            ->update([
                'name' => $request->name,
                'duration' => $request->duration,
                'note' => $request->note,
                'is_active' => $request->has('is_active'),
            ]);

        return redirect()
            ->back()
            ->with('success', 'Ujian berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $courseId, $examId)
    {
        $course = Course::findOrFail($courseId);
        $exam = Exam::whereBelongsTo($course)
            ->findOrFail($examId);
        $exam
            ->delete();
        return redirect()
            ->route('courses.show', $courseId)
            ->with('success', 'Ujian berhasil dihapus!');
    }

    public function submit(Request $request, $courseId, $examId){
        $user = $request->user();
        $exam = Exam::findOrFail($examId);
        $option = Option::findOrFail($request->answer);

        if($option){
            Answer::firstOrCreate([
                'user_id' => $user->id,
                'exam_id' => $exam->id,
                'question_id' => $option->question_id,
            ],[
                'user_id' => $user->id,
                'exam_id' => $exam->id,
                'question_id' => $option->question_id,
                'option_id' => $request->answer,
            ])->update(['option_id' => $request->answer]);
        } else {
            Answer::where([
                ['user_id', "=", $user->id],
                ['question_id', "=", $option->question_id],
            ])->delete();
        }

        return response()->json([
            'status' => 'saved',
            'question_id' => $option->question_id,
            'answered' => $request->answer,
        ]);
    }

    public function finish(Request $request, $courseId, $examId)
    {
        $user = $request->user();

        SessionExam::where([
            ['user_id', $user->id],
            ['exam_id', $examId]
        ])->update(['is_finish' => true]);

        ExamScoringService::calculate(
            $user->id, 
            $courseId,
            $examId,
        );

        Cache::forget("exam_{$examId}_user_{$user->id}_shuffled_ids");

        return redirect()
            ->route('courses.show', $courseId);
    }
}
