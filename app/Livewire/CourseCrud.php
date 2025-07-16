<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Course;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CourseCrud extends Component
{
    public $courses = [];
    public $categories = [];

    public $courseId = null;
    public $title = '';
    public $slug = '';
    public $description = '';
    public $price = '';
    public $category_id = '';
    public $editing = false;

    public function mount()
    {
        $user = Auth::user();
        if (!$user || !($user->hasRole('admin') || $user->hasRole('staff') || $user->hasRole('instructor'))) {
            abort(403);
        }

        $this->categories = Category::all();
        $this->loadCourses();
    }

    public function loadCourses()
    {
        $this->courses = Course::with('category')->latest()->get();
    }

    public function resetForm()
    {
        $this->courseId = null;
        $this->title = '';
        $this->slug = '';
        $this->description = '';
        $this->price = '';
        $this->category_id = '';
        $this->editing = false;
    }

    public function create()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        if (!$this->slug || trim($this->slug) === '') {
            $this->generateUniqueSlug();
        }

        Course::create([
            'title'        => $this->title,
            'slug'         => $this->slug,
            'description'  => $this->description,
            'price'        => $this->price,
            'category_id'  => $this->category_id,
            'instructor_id'=> Auth::id(),
            'created_by'   => Auth::id(),
        ]);

        $this->resetForm();
        $this->loadCourses();

        session()->flash('success', 'Course created successfully!');
    }

    // Loads course data into the form for editing
    public function show($id)
    {
        $course = Course::findOrFail($id);

        $this->courseId     = $course->id;
        $this->title        = $course->title;
        $this->slug         = $course->slug;
        $this->description  = $course->description;
        $this->price        = $course->price;
        $this->category_id  = $course->category_id;
        $this->editing      = true;
    }

    // Update existing course
    public function update()
    {
        $this->validate([
            'title'       => 'required|string|max:255',
            'slug'        => 'required|unique:courses,slug,' . $this->courseId,
            'description' => 'required',
            'price'       => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        $course = Course::findOrFail($this->courseId);
        $course->update([
            'title'       => $this->title,
            'slug'        => $this->slug,
            'description' => $this->description,
            'price'       => $this->price,
            'category_id' => $this->category_id,
        ]);

        $this->resetForm();
        $this->loadCourses();

        session()->flash('success', 'Course updated successfully!');
    }

    public function delete($id)
    {
        Course::findOrFail($id)->delete();

        $this->loadCourses();

        session()->flash('success', 'Course deleted successfully!');
    }

    public function updatedTitle($value)
    {
        if (!$this->editing) {
            $this->generateUniqueSlug();
        }
    }

    private function generateUniqueSlug()
    {
        $base = Str::slug($this->title);
        $slug = $base;
        $counter = 1;

        while (Course::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $counter++;
        }

        $this->slug = $slug;
    }

    public function render()
    {
        return view('livewire.course-crud')->layout('layouts.app');
    }
}
