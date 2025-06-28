<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
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
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $courseId, $materialId)
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
