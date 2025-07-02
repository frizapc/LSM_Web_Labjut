<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Exam;
use App\Models\Question;
use App\Models\SessionExam;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
        
        $questions = Question::where('exam_id', $exam->id)->paginate(1);
        
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
        
        if($request->action){
            return redirect($request->action);
        }
        return response()->json([
            'status' => 'saved',
            'message' => 'Jawaban disimpan sementara.'
        ]);
    }
}
