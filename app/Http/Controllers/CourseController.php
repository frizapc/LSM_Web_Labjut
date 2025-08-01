<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::paginate(6);
        return view('pages.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Course::class);
        return view('pages.courses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:courses,name|max:50',
            'level' => 'required|string',
            'description' => 'nullable|string',
            'photo' => 'required|image|file|max:1024'
        ]);
        
        Course::create([
            'name' => $request->name,
            'level' => $request->level,
            'description' => $request->description,
            'photo' => $request->file('photo'),
        ]);

        return redirect()
            ->route('courses.index')
            ->with('success', 'Kursus berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        return view('pages.courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        Gate::authorize('update', $course);
        return view('pages.courses.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {   
        $request->validate([
            'name' => 'required|string|max:50|unique:courses,name,'.$course->id,
            'level' => 'required|string',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|file|max:1024'
        ]);
         
        $course->update([
            'name' => $request->name,
            'level' => $request->level,
            'description' => $request->description,
            'photo' => $request->file('photo'),
        ]);
        
        return redirect()
            ->route('courses.show', $course->id)
            ->with('success', 'Kursus berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        Gate::authorize('delete', $course);
        $course->delete();
        return redirect()
            ->route('courses.index')
            ->with('success', 'Kursus berhasil dihapus');
    }
}
  