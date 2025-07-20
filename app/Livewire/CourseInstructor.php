<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Course;
use App\Models\User; // Import the User model
use Illuminate\Support\Facades\Auth; // For authorization check

class CourseInstructor extends Component
{
    public $courses;
    public $instructors; // To hold the list of users who can be instructors
    public $courseInstructors = []; // To hold the selected instructor_id for each course

    public function mount()
    {
        // Authorization check: Only allow admins/staff to access this page
        $user = Auth::user();
        if (!$user || !($user->hasRole('admin') || $user->hasRole('staff'))) {
            abort(403, 'Unauthorized access to instructor assignment.');
        }

        // Fetch all courses with their current instructor relationship loaded
        $this->courses = Course::with('instructor')->latest()->get();

        // Fetch all users who have the 'instructor' role
        // You'll need to ensure your User model has a 'hasRole' method or similar
        // If you don't have a role system, you might fetch all users or users with a specific flag
        $this->instructors = User::whereHas('roles', function ($query) {
            $query->where('name', 'instructor');
        })->get();

        // Initialize courseInstructors array with current instructor IDs
        foreach ($this->courses as $course) {
            $this->courseInstructors[$course->id] = $course->instructor_id;
        }
    }

    /**
     * Updates the instructor for a given course.
     *
     * @param int $courseId The ID of the course to update.
     */
    public function updateCourseInstructor($courseId)
    {
        // Get the new instructor ID from the bound property
        $newInstructorId = $this->courseInstructors[$courseId] ?? null;

        // Validate the new instructor ID
        if ($newInstructorId && !User::where('id', $newInstructorId)->whereHas('roles', function ($query) {
            $query->where('name', 'instructor');
        })->exists()) {
            session()->flash('message', '<span class="text-red-700 font-semibold">Error:</span> Selected instructor is invalid.');
            return;
        }

        $course = Course::find($courseId);

        if ($course) {
            // Update the instructor_id
            $course->update(['instructor_id' => $newInstructorId]);

            // Get the instructor's name for the success message
            $instructorName = $newInstructorId ? User::find($newInstructorId)->name : 'None (Unassigned)';

            $message = "Instructor for course <span class=\"text-blue-700 font-semibold\">{$course->title}</span> updated to: <span class=\"text-purple-700 font-semibold\">{$instructorName}</span>.";
            session()->flash('message', $message);
        } else {
            session()->flash('message', '<span class="text-red-700 font-semibold">Error:</span> Course not found.');
        }
    }

    public function render()
    {
        // Pass courses and instructors to the view
        return view('livewire.course-instructor', [
            'courses' => $this->courses,
            'instructors' => $this->instructors,
        ])->layout('layouts.app');
    }
}
