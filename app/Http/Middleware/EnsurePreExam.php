<?php

namespace App\Http\Middleware;

use App\Models\Course;
use App\Models\SessionExam;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
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
        $cacheKey = $user->id."_".Str::before($request->url(), '/finish');
        $cacheSession = session('cacheKey');

        $sessionExam = SessionExam::where([
            ['user_id', "=", $user->id],
            ['exam_id', "=", $request->exam->id],
        ])->first();
        
        if($cacheSession){
            if($cacheSession != $cacheKey){
                return redirect()->back();
            }
        }
        
        if($sessionExam){
            if($sessionExam->is_finish){
                Cache::forget($cacheKey);
                session()->remove('cacheKey');
                return redirect()
                    ->route('courses.show', $request->course)
                    ->with('warning', 'Kamu sudah mengerjakan ujian ini');
            }
            if(!$request->exam->is_active){
                Cache::forget($cacheKey);
                session()->remove('cacheKey');
                return redirect()
                    ->route('courses.show', $request->exam->course_id)
                    ->with('warning', 'Ujian belum dibuka');
            }
        } elseif ($ability){
            return redirect()
                    ->route('courses.show', $request->course_id)
                    ->with('warning', 'Tidak dapat memulai ujian');
        }
        
        return $next($request);
    }
}
