<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create($courseId)
    {
        $course = Course::findOrFail($courseId);
        return view('pages.materials.create', [
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
            'description' => 'nullable|string',
            'source' => 'required|file|mimes:pdf|max:1024'
        ]);

        Material::create([
            'name' => $request->name,
            'description' => $request->description,
            'source' => $request->file('source'),
            'course_id' => $courseId,
        ]);

        return redirect()
            ->route('courses.show', $courseId)
            ->with('success', 'Materi baru berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($courseId, $materialId)
    {
        $course = Course::findOrFail($courseId);
        $material = Material::findOrFail($materialId);
        return view('pages.materials.edit', [
            'course' => $course,
            'material' => $material,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $courseId, $materialId)
    {
        Course::findOrFail($courseId);
        $material = Material::findOrFail($materialId);

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
            ->route('courses.show', $courseId)
            ->with('success', 'Materi berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($courseId, $materialId)
    {
        $course = Course::findOrFail($courseId);
        $material = Material::whereBelongsTo($course)
            ->findOrFail($materialId);
        $material
            ->delete();
        return redirect()
            ->route('courses.show', $courseId)
            ->with('success', 'Materi berhasil dihapus!');
    }
}
