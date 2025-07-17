<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MaterialController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Course $course)
    {
        Gate::authorize('create', Course::class);
        return view('pages.materials.create', compact('course'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Course $course)
    {

        $request->validate([
            'name' => 'required|string|max:50',
            'description' => 'nullable|string',
            'source' => 'required|file|mimes:pdf|max:1024'
        ]);

        Material::create([
            'name' => $request->name,
            'description' => $request->description,
            'source' => $request->file('source'),
            'course_id' => $course->id,
        ]);

        return redirect()
            ->route('courses.show', $course->id)
            ->with('success', 'Materi baru berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course, Material $material)
    {
        Gate::authorize('update', $course);
        return view('pages.materials.edit', [
            'course' => $course,
            'material' => $material,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course, Material $material)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'description' => 'nullable|string',
            'source' => 'nullable|file|mimes:pdf|max:1024'
        ]);

        $material->update([
            'name' => $request->name,
            'description' => $request->description,
            'source' => $request->file('source'),
        ]);

        return redirect()
            ->route('courses.show', $course->id)
            ->with('success', 'Materi berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course, Material $material)
    {
        Gate::authorize('delete', $course);
        $material->delete();
        return redirect()
            ->route('courses.show', $course->id)
            ->with('success', 'Materi berhasil dihapus!');
    }
}
