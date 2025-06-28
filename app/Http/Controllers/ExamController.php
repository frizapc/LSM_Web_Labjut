<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Exam;
use Illuminate\Http\Request;

class ExamController extends Controller
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
    public function show(string $id)
    {
        //
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
            'duration' => 'required|integer|min:1',
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
}
