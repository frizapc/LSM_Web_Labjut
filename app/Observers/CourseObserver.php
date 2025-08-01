<?php

namespace App\Observers;

use App\Models\Course;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CourseObserver
{
    /**
     * Handle the Course "creating" event.
     */
    public function creating(Course $course): void
    {
        $course->code = 'kursus-' . Str::random(6);
        $filename = uniqid('course_') . '.' . $course->photo->extension();
        $course->photo = $course->photo->storeAs('courses', $filename);
    }

    /**
     * Handle the Course "updating" event.
     */
    public function updating(Course $course): void
    {
        if ($course->photo) {
            Storage::delete($course->getOriginal('photo'));
            $filename = uniqid('course_') . '.' . $course->photo->extension();
            $course->photo = $course->photo->storeAs('courses', $filename);
        } else {
            $course->photo = $course->getOriginal('photo');
        }
    }

    /**
     * Handle the Course "deleting" event.
     */
    public function deleting(Course $course): void
    {
        Storage::delete($course->photo);
    }

    /**
     * Handle the Course "restored" event.
     */
    public function restored(Course $course): void
    {
        //
    }

    /**
     * Handle the Course "force deleted" event.
     */
    public function forceDeleted(Course $course): void
    {
        //
    }
}
