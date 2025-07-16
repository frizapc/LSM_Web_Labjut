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
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class ExamController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Course $course)
    {
        Gate::authorize('create', Course::class);
        return view('pages.exams.create', [
            'course' => $course,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Course $course)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'note' => 'nullable|string',
        ]);

        Exam::create([
            'name' => $request->name,
            'note' => $request->note,
            'course_id' => $course->id,
        ]);

        return redirect()
            ->route('courses.show', $course->id)
            ->with('success', 'Ujian baru berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Course $course, Exam $exam)
    {
        $user = $request->user();
        
        $sessionExam = SessionExam::firstOrCreate(
        [
            'user_id' => $user->id,
            'exam_id' => $exam->id,
        ],
        [
            'completed_at' => now()->addMinutes($exam->duration),
            ]
        );
            
        $questions = Question::where('exam_id', $exam->id)->get();
        $questionIds = $questions->pluck('id')->toArray();

        $cacheKey = $user->id."_".$request->url();
        session(['cacheKey' => $cacheKey]);
            
        $shuffledIds = Cache::remember(
            $cacheKey, 
            now()->addMinutes($exam->duration), 
            fn() => collect($questionIds)->shuffle()->values()->all()
        );

        $currentPage = $request->get('page', 1);
        $currentQuestionId = $shuffledIds[$currentPage - 1] ?? null;

        $question = $questions->findOrFail($currentQuestionId);

        $questions = new \Illuminate\Pagination\LengthAwarePaginator(
            [$question],
            count($shuffledIds),
            1,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $timeLeft = now()->diffInSeconds($sessionExam->completed_at);

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
    public function edit(Course $course, Exam $exam)
    {
        Gate::authorize('update', $course);

        return view('pages.exams.edit', [
            'course' => $course,
            'exam' => $exam,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course, Exam $exam)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'duration' => 'required|integer|min:1|max:120',
            'note' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $exam->update([
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
    public function destroy(Course $course, Exam $exam)
    {
        Gate::authorize('delete', $course);
        $exam->delete();
        return redirect()
            ->route('courses.show', $course->id)
            ->with('success', 'Ujian berhasil dihapus!');
    }

    public function submit(Request $request, Course $course, Exam $exam){
        $user = $request->user();

        if ($request->answer) {
            $option = Option::findOrFail($request->answer);

            Answer::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'exam_id' => $exam->id,
                    'question_id' => $option->question_id,
                ],
                [
                    'option_id' => $option->id,
                ]
            );

            return response()->json([
                'status' => 'saved',
                'answered' => $option->id,
            ]);
        }

        return response()->json([
            'status' => 'saved',
            'answered' => $request->answer,
        ]);
    }

    public function finish(Request $request, Course $course, Exam $exam)
    {
        $user = $request->user();
        
        SessionExam::where([
            ['user_id', $user->id],
            ['exam_id', $exam->id]
        ])->update(['is_finish' => true]);

        ExamScoringService::calculate(
            $user->id, 
            $course->id,
            $exam->id,
        );    

        $cacheKey = $user->id."_".Str::before($request->url(), '/finish');

        Cache::forget($cacheKey);
        session()->remove('cacheKey');

        return redirect()
            ->route('courses.show', $course->id);
    }
}
