<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Chapter;
use Illuminate\Support\Facades\Auth;

class ChapterCrud extends Component
{
    public $chapters = [];

    public $chapterId;
    public $unit_id;
    public $title;
    public $video_url;
    public $content;
    public $position;
    public $duration_in_minutes;

    public function mount()
    {
        $user = Auth::user();
        if (!$user || !($user->hasRole('admin') || $user->hasRole('instructor'))) {
            abort(403);
        }

        $this->loadChapters();
    }

    public function loadChapters()
    {
        $this->chapters = Chapter::orderBy('position')->get();
    }

    public function resetForm()
    {
        $this->chapterId = null;
        $this->unit_id = '';
        $this->title = '';
        $this->video_url = '';
        $this->content = '';
        $this->position = '';
        $this->duration_in_minutes = '';
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
            Chapter::find($this->chapterId)->update($data);
        } else {
            Chapter::create($data);
        }

        $this->resetForm();
        $this->loadChapters();
    }

    public function editChapter($id)
    {
        $chapter = Chapter::findOrFail($id);
        $this->chapterId = $chapter->id;
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
        $this->loadChapters();
    }

    public function render()
    {
        return view('livewire.chapter-crud')
        ->layout('layouts.app');
    }
}
