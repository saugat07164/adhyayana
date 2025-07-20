<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Course;

class CourseStatus extends Component
{
    public $courses;
    public $courseStatuses = [];
    public $coursePaidorFree = [];

    public function mount()
    {
        $this->courses = Course::all(); 
        foreach ($this->courses as $course) {
            $this->courseStatuses[$course->id] = $course->status;
            $this->coursePaidorFree[$course->id] = $course->is_free;
        }
    }

    public function updateCourseStatus($courseId)
    {
        $newStatus = $this->courseStatuses[$courseId] ?? null;

        if ($newStatus !== null) {
            $course = Course::find($courseId);
            if ($course) {
                $course->update(['status' => $newStatus]);
                session()->flash('message', "Course <strong>{$course->title}</strong> updated to status: <strong>{$newStatus}</strong>.");
            }
        }
    }

    public function updatePaidorFree($courseId)
    {
        $newValue = $this->coursePaidorFree[$courseId] ?? null;

        if ($newValue !== null) {
            $course = Course::find($courseId);
            if ($course) {
                $course->update(['is_free' => $newValue]);
                $statusLabel = $newValue == 1 ? 'Free' : 'Paid';
                session()->flash('message', "Course <strong>{$course->title}</strong> marked as: <strong>{$statusLabel}</strong>.");
            }
        }
    }

    public function render()
    {
        return view('livewire.course-status', ['courses' => $this->courses])
            ->layout('layouts.app');
    }
}
