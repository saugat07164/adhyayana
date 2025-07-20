<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Chapter; // Make sure to import your Chapter model
use App\Models\Unit; // Make sure to import your Unit model
use App\Models\Course; // Make sure to import your Course model
use Illuminate\Support\Facades\Auth;

class ChapterDetail extends Component
{
    public Course $course;
    public Unit $unit;
    public Chapter $chapter;

    public function mount(Course $course, Unit $unit, Chapter $chapter)
    {
        $user = Auth::user();
        if (!$user || !($user->hasRole('admin') || $user->hasRole('staff') || $user->hasRole('instructor'))) {
            abort(403);
        }

        // Ensure the chapter belongs to the unit and the unit belongs to the course
        if ($chapter->unit_id !== $unit->id || $unit->course_id !== $course->id) {
            abort(404, 'Chapter not found in this unit or unit not found in this course.');
        }

        $this->course = $course;
        $this->unit = $unit;
        $this->chapter = $chapter;
    }

    public function render()
    {
        return view('livewire.chapter-detail', [
            'chapter' => $this->chapter,
            'unit' => $this->unit,
            'course' => $this->course,
        ])->layout('layouts.app');
    }
}