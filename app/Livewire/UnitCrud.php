<?php
namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\Unit;
use App\Models\Course;

class UnitCrud extends Component
{
    use WithPagination;

    public $courses = [];
    public $unitId;
    public $course_id = '';
    public $title = '';
    public $position = '';
    public $filter_course_id = '';
    public $applyFilter = false;

    public function mount()
    {
        $user = Auth::user();
        if (!$user || !($user->hasRole('admin') || $user->hasRole('instructor'))) {
            abort(403);
        }

        $this->loadCourses();
    }

    public function loadCourses()
    {
        $this->courses = Course::select('id', 'title')->orderBy('title')->get();
    }

    public function updatedFilterCourseId()
    {
        // no auto filter
    }

    public function filterUnits()
    {
        $this->applyFilter = true;
        $this->resetPage(); // reset pagination to page 1
    }

    public function saveUnit()
    {
        $this->validate([
            'course_id' => 'required|integer',
            'title' => 'required|string|max:255',
        ]);

        $lastPosition = Unit::where('course_id', $this->course_id)->max('position');
        $position = $lastPosition ? $lastPosition + 1 : 1;

        $data = [
            'course_id' => $this->course_id,
            'title' => $this->title,
            'position' => $position,
        ];

        if ($this->unitId) {
            Unit::findOrFail($this->unitId)->update($data);
        } else {
            Unit::create($data);
        }

        $this->resetForm();
        $this->resetPage();
    }

    public function editUnit($id)
    {
        $unit = Unit::findOrFail($id);
        $this->unitId = $unit->id;
        $this->course_id = $unit->course_id;
        $this->title = $unit->title;
        $this->position = $unit->position;
    }

    public function deleteUnit($id)
    {
        Unit::findOrFail($id)->delete();
        $this->resetPage();
    }

    public function resetForm()
    {
        $this->unitId = null;
        $this->course_id = '';
        $this->title = '';
        $this->position = '';
    }

    public function render()
    {
        $query = Unit::with('course')->orderBy('position');

        if ($this->applyFilter && $this->filter_course_id) {
            $query->where('course_id', $this->filter_course_id);
        }

        $units = $query->paginate(10);

        return view('livewire.unit-crud', [
            'units' => $units,
            'courses' => $this->courses,
        ])->layout('layouts.app');
    }
}
