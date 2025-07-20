<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Unit; // Make sure to import your Unit model
use App\Models\Course; // Make sure to import your Course model
use Illuminate\Support\Facades\Auth;

class UnitDetail extends Component
{
    public Course $course;
    public Unit $unit;

    public function mount(Course $course, Unit $unit)
    {
        $user = Auth::user();
        if (!$user || !($user->hasRole('admin') || $user->hasRole('staff') || $user->hasRole('instructor'))) {
            abort(403);
        }

        // Ensure the unit belongs to the course
        if ($unit->course_id !== $course->id) {
            abort(404, 'Unit not found in this course.');
        }

        $this->course = $course;
        $this->unit = $unit;
    }

    public function render()
    {
        return view('livewire.unit-detail', [
            'unit' => $this->unit,
            'course' => $this->course,
        ])->layout('layouts.app');
    }
}