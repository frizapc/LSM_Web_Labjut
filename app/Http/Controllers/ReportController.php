<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Score;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ReportController extends Controller
{
    public function index()
    {
        $courses = Course::with(['exams' => function($query) {
            $query->withCount('scores')
                  ->with(['scores' => function($q) {
                      $q->with('user')
                        ->orderBy('created_at', 'desc');
                  }]);
        }])->paginate(5);

        return view('pages.reports.index', compact('courses'));
    }

    public function reset()
    {
        Gate::authorize('create', Course::class);
        Score::truncate();
        return redirect()->route('reports.index');
    }
}
