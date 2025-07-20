<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Course;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Http\Request; // This is not needed for Livewire component properties, but kept for context if it was used elsewhere.

class OurCourses extends Component
{
    use WithPagination;

    // Public properties that will be bound to your form inputs
    public $search = '';
    public $category_id = '';
    public $level = '';

    // This method is called when any public property bound with wire:model.live or wire:model changes.
    // It's good practice to reset pagination here so that filter changes bring you back to the first page.
    public function updating($field)
    {
        $this->resetPage();
    }

    // Helper method for trimming description (this looks fine)
    public function getTrimmedDesc($text, $limit = 100, $end = '...')
    {
        return strlen($text) > $limit
            ? substr($text, 0, $limit) . $end
            : $text;
    }

    // The main method where data is fetched and filtered for the view
    public function render()
{
    $categories = Category::all();

    $baseQuery = Course::with('category')->where('status', 'published');

    // Search filter
    if ($this->search) {
        $baseQuery->where(function ($q) {
            $q->where('title', 'like', '%' . $this->search . '%')
              ->orWhere('description', 'like', '%' . $this->search . '%');
        });
    }

    // Category filter
    if ($this->category_id) {
        $baseQuery->where('category_id', $this->category_id);
    }

    // Level filter
    if ($this->level) {
        $baseQuery->where('level', $this->level);
    }

    // Get **only paid courses** here (exclude free courses)
    $paidCoursesQuery = (clone $baseQuery)->where('is_free', false);

    // Get **only free courses** here (include only free)
    $freeCoursesQuery = (clone $baseQuery)->where('is_free', true);

    // Paginate paid courses
    $paid_courses = $paidCoursesQuery->orderBy('created_at', 'desc')->paginate(12);

    // Get free courses (no pagination here, but you can paginate if you want)
    $free_courses = $freeCoursesQuery->orderBy('created_at', 'desc')->get();

    return view('courses.index', [
        'courses' => $paid_courses,  // only paid courses here
        'free_courses' => $free_courses,  // only free courses here
        'categories' => $categories,
        'currentSearch' => $this->search,
        'currentCategoryId' => $this->category_id,
        'currentLevel' => $this->level,
    ])->layout('layouts.app');
}

    // The `index` method is not needed in a Livewire component for rendering the main view.
    // It's typically used in a Laravel Controller.
    // You can remove this method.
    // public function index(Request $request)
    // {
    //     // ... (this logic has been moved to render() method)
    // }
}