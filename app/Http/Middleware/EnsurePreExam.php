<?php

namespace App\Http\Middleware;

use App\Models\Course;
use App\Models\Exam;
use App\Models\SessionExam;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class EnsurePreExam
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ability = Gate::allows('create', Course::class);
        $user = $request->user();
        $examId = $request->exam;
        $course = Course::findOrFail($request->course);
        $exam = Exam::findOrFail($examId);
        $sessionExam = SessionExam::where([
            ['user_id', "=", $user->id],
            ['exam_id', "=", $exam->id],
        ])->first();

        if($sessionExam){
            if(!$exam->is_active || $sessionExam->is_finish){
                return redirect()
                    ->route('courses.show', $course->id)
                    ->with('warning', 'Tidak dapat memulai ujian');
            }
        } elseif (!$exam->is_active || $ability){
            return redirect()
                    ->route('courses.show', $course->id)
                    ->with('warning', 'Tidak dapat memulai ujian');
        }
        
        // $request->attributes->set('exam', $exam);

        return $next($request);
    }
}
