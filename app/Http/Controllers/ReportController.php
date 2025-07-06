<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

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
        }])->get();

        return view('pages.reports.index', compact('courses'));
    }
}
