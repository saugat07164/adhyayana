<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Course;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class CourseCrud extends Component
{
    public $courses;
    public $categories;
    public $courseId;
    public $title;
    public $slug;
    public $description;
    public $price;
    public $category_id;
    public $editing = false;

    public function mount()
    {
        $user = Auth::user();
        if (!$user || !($user->hasRole('admin') || $user->hasRole('staff') || $user->hasRole('instructor')) ) {
            abort(403);
        }
        $this->fetch();
        $this->categories = Category::all();
    }

    public function fetch()
    {
        $this->courses = Course::with('category')->get();
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
            'title' => 'required',
            'slug' => 'required|unique:courses,slug',
            'description' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
        ]);
        Course::create([
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'price' => $this->price,
            'category_id' => $this->category_id,
            'instructor_id' => Auth::id(),
        ]);
        $this->resetForm();
        $this->fetch();
        session()->flash('success', 'Course created successfully!');
    }

    public function edit($id)
    {
        $course = Course::findOrFail($id);
        $this->courseId = $course->id;
        $this->title = $course->title;
        $this->slug = $course->slug;
        $this->description = $course->description;
        $this->price = $course->price;
        $this->category_id = $course->category_id;
        $this->editing = true;
    }

    public function update()
    {
        $this->validate([
            'title' => 'required',
            'slug' => 'required|unique:courses,slug,' . $this->courseId,
            'description' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
        ]);
        $course = Course::findOrFail($this->courseId);
        $course->update([
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'price' => $this->price,
            'category_id' => $this->category_id,
        ]);
        $this->resetForm();
        $this->fetch();
        session()->flash('success', 'Course updated successfully!');
    }

    public function delete($id)
    {
        Course::findOrFail($id)->delete();
        $this->fetch();
        session()->flash('success', 'Course deleted successfully!');
    }

    public function render()
    {
        return view('livewire.course-crud');
    }
} 