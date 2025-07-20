<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Course; // Import the Course model


class CourseDetail extends Component
{
    public Course $course; // Public property to hold the Course model instance

    /**
     * Mount method is called when the component is initialized.
     * Livewire automatically injects the Course model via route model binding.
     */
    public function mount(Course $course)
    {
        // Basic authorization check (similar to your other components)
       

        // Eager load related units and chapters to avoid N+1 query issues
        // This ensures all necessary data for the view is loaded efficiently.
        $this->course = $course->load(['category', 'instructor', 'units.chapters']);
    }

    /**
     * Render method defines the view to be displayed.
     */
    public function render()
    {
        return view('livewire.course-detail')->layout('layouts.app');
    }
}