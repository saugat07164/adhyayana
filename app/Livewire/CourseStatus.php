<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Course;
class CourseStatus extends Component
{
    public $courses;
    public $courseStatuses = [];
    public $statuschange;
    public function mount(){
   $this->courses = Course::all(); 
   foreach ($this->courses as $course) {
            $this->courseStatuses[$course->id] = $course->status;
        }// full models, not just status
}
public function updateCourseStatus($courseId)
{
    $newStatus = $this->courseStatuses[$courseId] ?? null;

    if ($newStatus) {
        $course = Course::find($courseId);
        if ($course) {
            $course->update(['status' => $newStatus]);
            $message = "Course titled <span class=\"text-blue-700 font-semibold\">{$course->title}</span> updated to status: <span class=\"text-purple-700 font-semibold\">{$newStatus}</span>.";
            session()->flash('message', $message);
        }
    }
}

    public function render()
    {
        return view('livewire.course-status', ['courses'=>$this->courses])->layout('layouts.app');
    }
}
