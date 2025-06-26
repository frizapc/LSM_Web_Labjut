<?php

namespace App\Http\Controllers;

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
    public function create(Request $request)
    {
        return view('pages.materials.create', [
            'course' => $request->course,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'description' => 'required|string',
            'source' => 'required|file|mimes:pdf|max:1024'
        ]);

        Material::create([
            'name' => $request->name,
            'description' => $request->description,
            'source' => $request->file('source'),
            'course_id' => $request->course->id,
        ]);

        return redirect()
            ->route('courses.show', $request->course->id)
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
    public function destroy(Request $request, string $course, $material)
    {
        $material = Material::findOrFail($material);
        $material->delete();
        return redirect()
            ->route('courses.show', $request->course->id)
            ->with('success', 'Materi berhasil dihapus!');
    }
}
