<?php

namespace App\Http\Middleware;

use App\Models\Exam;
use App\Models\SessionExam;
use Closure;
use Illuminate\Http\Request;
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
        
        $user = $request->user();
        $examId = $request->exam;
        $courseId = $request->course;
        $exam = Exam::findOrFail($examId);
        $sessionExam = SessionExam::where([
            ['user_id', "=", $user->id],
            ['exam_id', "=", $exam->id],
        ])->first();

        if($sessionExam){
            if(!$exam->is_active || $sessionExam->is_finish){
                return redirect()
                    ->route('courses.show', $courseId)
                    ->with('warning', 'Tidak dapat memulai ujian');
            }
        } elseif (!$exam->is_active){
            return redirect()
                    ->route('courses.show', $courseId)
                    ->with('warning', 'Tidak dapat memulai ujian');
        }
        
        $request->attributes->set('exam', $exam);

        return $next($request);
    }
}
