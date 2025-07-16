<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Unit;

class UnitCrud extends Component
{
    public $units = [];

    public $unitId;
    public $course_id;
    public $title;
    public $position;

    public function mount()
    {
        $user = Auth::user();
        if (!$user || !($user->hasRole('admin') || $user->hasRole('instructor'))) {
            abort(403);
        }

        $this->loadUnits();
    }

    public function loadUnits()
    {
        $this->units = Unit::orderBy('position')->get();
    }

    public function saveUnit()
    {
        $this->validate([
            'course_id' => 'required|integer',
            'title' => 'required|string|max:255',
            'position' => 'required|integer',
        ]);

        $data = [
            'course_id' => $this->course_id,
            'title' => $this->title,
            'position' => $this->position,
        ];

        if ($this->unitId) {
            Unit::findOrFail($this->unitId)->update($data);
        } else {
            Unit::create($data);
        }

        $this->resetForm();
        $this->loadUnits();
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
        $this->loadUnits();
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
        return view('livewire.unit-crud')
        ->layout('layouts.app');
    }
}
