<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class EnsureKeepExam
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $cacheKey = session('cacheKey');
        if ($cacheKey && Cache::has($cacheKey)) {
            return redirect(Str::after($cacheKey, '_'))
                ->with('warning', 'Tidak bisa logout, ujian sedang berlangsung!');
        }

        return $next($request);
    }
}
