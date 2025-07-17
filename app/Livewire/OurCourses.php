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
        // Start with a base query for Courses, eager-loading the category relationship
        $query = Course::with('category');

        // Apply search filter if 'search' property is not empty
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        // Apply category filter if 'category_id' property is not empty
        if ($this->category_id) {
            $query->where('category_id', $this->category_id);
        }

        // Apply level filter if 'level' property is not empty
        if ($this->level) {
            $query->where('level', $this->level);
        }

        // Order the results (optional, but good practice)
        $query->orderBy('created_at', 'desc');

        // Get the paginated courses based on the applied filters
        $courses = $query->paginate(12);

        // Get all categories to populate the dropdown filter
        $categories = Category::all();

        // Return the view with the filtered courses and all categories
        return view('courses.index', [
            'courses' => $courses,
            'categories' => $categories,
            // You might also pass the current filter values back to the view
            // so the dropdowns/inputs retain their selected state.
            'currentSearch' => $this->search,
            'currentCategoryId' => $this->category_id,
            'currentLevel' => $this->level,
        ])->layout('layouts.app'); // Assuming you have a layout named 'app'
    }

    // The `index` method is not needed in a Livewire component for rendering the main view.
    // It's typically used in a Laravel Controller.
    // You can remove this method.
    // public function index(Request $request)
    // {
    //     // ... (this logic has been moved to render() method)
    // }
}