<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Course;
use App\Models\Unit;
use App\Models\Chapter;
use Illuminate\Support\Facades\Auth; // Ensure this is needed, otherwise remove

class ChapterCrud extends Component
{
    // Form Properties
    public $form_course_id;
    public $unit_id;
    public $formUnits;

    public $chapterId;
    public $title;
    public $video_url;
    public $content;
    public $position;
    public $duration_in_minutes;

    // Filter Properties
    public $filter_course_id;
    public $filter_unit_id;
    public $filterUnits;
    public $filteredChapters;

    // General Properties
    public $courses;

    public function mount()
    {
        $this->courses = Course::orderBy('title')->get();
        $this->formUnits = collect();
        $this->filterUnits = collect();
        $this->filteredChapters = collect();

        $this->filter();
    }

    public function updatedFormCourseId()
    {
        if ($this->form_course_id) {
            $this->formUnits = Unit::where('course_id', $this->form_course_id)->orderBy('position')->get();
            if (!$this->chapterId) {
                $this->unit_id = null;
            }
        } else {
            $this->formUnits = collect();
            $this->unit_id = null;
        }
    }

    public function updatedUnitId()
    {
        if (!$this->chapterId && $this->unit_id) {
            $this->position = Chapter::where('unit_id', $this->unit_id)->max('position') + 1;
        }
    }

    public function updatedFilterCourseId()
    {
        if ($this->filter_course_id) {
            $this->filterUnits = Unit::where('course_id', $this->filter_course_id)->orderBy('position')->get();
            $this->filter_unit_id = null;
        } else {
            $this->filterUnits = collect();
            $this->filter_unit_id = null;
        }
        $this->filter();
    }

    public function updatedFilterUnitId()
    {
        $this->filter();
    }

    public function filter()
    {
        if ($this->filter_unit_id) {
            $this->filteredChapters = Chapter::where('unit_id', $this->filter_unit_id)->orderBy('position')->get();
        } else {
            $this->filteredChapters = collect();
        }
    }

    public function saveChapter()
    {
        $data = $this->validate([
            'unit_id' => 'required|numeric',
            'title' => 'required|string|max:255',
            'video_url' => 'nullable|url',
            'content' => 'nullable|string',
            'position' => 'required|numeric',
            'duration_in_minutes' => 'required|numeric'
        ]);

        if ($this->chapterId) {
            Chapter::findOrFail($this->chapterId)->update($data);
            session()->flash('message', 'Chapter updated successfully!');
        } else {
            Chapter::create($data);
            session()->flash('message', 'Chapter created successfully!');
        }

        $this->resetForm();
        $this->filter();
    }

    public function editChapter($id)
    {
        $chapter = Chapter::with('unit.course')->findOrFail($id);

        $this->chapterId = $chapter->id;
        $this->form_course_id = $chapter->unit->course_id;
        $this->updatedFormCourseId(); // Manually call to load units based on course

        $this->unit_id = $chapter->unit_id;
        $this->title = $chapter->title;
        $this->video_url = $chapter->video_url;
        $this->content = $chapter->content;
        $this->position = $chapter->position;
        $this->duration_in_minutes = $chapter->duration_in_minutes;
    }

    public function deleteChapter($id)
    {
        Chapter::findOrFail($id)->delete();
        session()->flash('message', 'Chapter deleted successfully!');
        $this->filter();
    }

    public function resetForm()
    {
        $this->chapterId = null;
        $this->form_course_id = null;
        $this->unit_id = null;
        $this->formUnits = collect();

        $this->title = '';
        $this->video_url = '';
        $this->content = '';
        $this->position = '';
        $this->duration_in_minutes = '';
    }

    public function render()
    {
        return view('livewire.chapter-crud')->layout('layouts.app');
    }
}