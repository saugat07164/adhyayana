<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Course;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class CourseCrud extends Component
{
    use WithFileUploads;

    public $courses = [];
    public $categories = [];

    public $courseId = null;
    public $title = '';
    public $slug = '';
    public $description = '';
    public $price = '';
    public $category_id = '';
    public $editing = false;

    public $new_thumbnail;
    public $current_thumbnail_path_db;
    public $current_thumbnail_url;

    // A flag to know if the user has manually changed the slug
    public $slugManuallyEdited = false;

    protected $rules = [
        'title'       => 'required|string|max:255',
        'description' => 'required|string',
        'price'       => 'required|numeric|min:0',
        'category_id' => 'required|exists:categories,id',
        'slug'        => 'required|string|max:255',
        'new_thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ];

    // Listen for when the slug field is updated directly by the user
    public function updatedSlug()
    {
        // Set a flag if the user has typed into the slug field
        $this->slugManuallyEdited = true;
    }

    /**
     * Updated hook for the 'title' property.
     * This method is called whenever the 'title' property is updated.
     */
    public function updatedTitle($value)
    {
        // Only auto-generate slug if the user has NOT manually edited the slug field.
        // If it's a brand new course and no slug is set, generate it.
        // If editing and the user hasn't touched the slug, regenerate it.
        if (!$this->slugManuallyEdited) {
            $this->generateUniqueSlug();
        }
    }

    public function updatedNewThumbnail()
    {
        $this->validateOnly('new_thumbnail');
    }

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
        $this->courses = Course::with(['category', 'units.chapters'])->latest()->get();
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
        $this->new_thumbnail = null;
        $this->current_thumbnail_url = null;
        $this->current_thumbnail_path_db = null;
        $this->slugManuallyEdited = false; // Reset the flag
        $this->resetValidation();
    }

    public function create()
    {
        // Ensure slug is generated if user hasn't manually set it
        if (!$this->slugManuallyEdited || empty($this->slug)) {
            $this->generateUniqueSlug();
        }

        $this->rules['slug'] = 'required|unique:courses,slug|string|max:255';
        $this->validate();

        $courseData = [
            'title'        => $this->title,
            'slug'         => $this->slug,
            'description'  => $this->description,
            'price'        => $this->price,
            'category_id'  => $this->category_id,
            'instructor_id'=> Auth::id(),
            'created_by'   => Auth::id(),
        ];

        if ($this->new_thumbnail) {
            $courseData['thumbnail_path'] = $this->new_thumbnail->store('course-thumbs', 'public');
        }

        Course::create($courseData);

        $this->resetForm();
        $this->loadCourses();

        session()->flash('success', 'Course created successfully!');
    }

    public function edit($id)
    {
        $course = Course::findOrFail($id);

        $this->courseId          = $course->id;
        $this->title             = $course->title;
        $this->slug              = $course->slug;
        $this->description       = $course->description;
        $this->price             = $course->price;
        $this->category_id       = $course->category_id;

        $this->current_thumbnail_path_db = $course->thumbnail_path;
        $this->current_thumbnail_url = $course->thumbnail_path ? Storage::url($course->thumbnail_path) : null;

        $this->editing           = true;
        $this->slugManuallyEdited = false; // Assume slug is not manually edited initially when loaded for edit

        $this->resetValidation();
        $this->dispatch('scroll-to-form');
    }

    public function update()
    {
        // If slug was not manually edited, and title has changed, regenerate it.
        // This ensures if the user edits title but leaves slug untouched, it updates.
        if (!$this->slugManuallyEdited) {
            $this->generateUniqueSlug();
        }

        // Dynamic slug rule for update: ignore current course's ID
        $this->rules['slug'] = 'required|unique:courses,slug,' . $this->courseId . '|string|max:255';
        $this->validate();

        $course = Course::findOrFail($this->courseId);

        $courseData = [
            'title'       => $this->title,
            'slug'        => $this->slug,
            'description' => $this->description,
            'price'       => $this->price,
            'category_id' => $this->category_id,
        ];

        if ($this->new_thumbnail) {
            if ($this->current_thumbnail_path_db && Storage::disk('public')->exists($this->current_thumbnail_path_db)) {
                Storage::disk('public')->delete($this->current_thumbnail_path_db);
            }
            $courseData['thumbnail_path'] = $this->new_thumbnail->store('course-thumbs', 'public');
        } else {
            $courseData['thumbnail_path'] = $this->current_thumbnail_path_db;
        }

        $course->update($courseData);

        $this->resetForm();
        $this->loadCourses();

        session()->flash('success', 'Course updated successfully!');
    }

    public function delete($id)
    {
        $course = Course::findOrFail($id);

        if ($course->thumbnail_path && Storage::disk('public')->exists($course->thumbnail_path)) {
            Storage::disk('public')->delete($course->thumbnail_path);
        }

        $course->delete();

        $this->loadCourses();

        session()->flash('success', 'Course deleted successfully!');
    }

    /**
     * Generates a unique slug based on the title.
     * Accounts for existing slugs and the current course being edited.
     */
    private function generateUniqueSlug()
    {
        if (empty($this->title)) {
            $this->slug = '';
            return;
        }

        $base = Str::slug($this->title);
        $slug = $base;
        $counter = 1;

        while (
            Course::where('slug', $slug)
                ->when($this->editing && $this->courseId, fn($query) => $query->where('id', '!=', $this->courseId))
                ->exists()
        ) {
            $slug = $base . '-' . $counter++;
        }

        $this->slug = $slug;
    }

    public function render()
    {
        if (empty($this->categories)) {
            $this->categories = Category::all();
        }

        return view('livewire.course-crud')->layout('layouts.app');
    }
}