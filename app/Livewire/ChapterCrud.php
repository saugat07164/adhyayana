<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ChapterCrud extends Component
{
    public function mount()
    {
        $user = Auth::user();
        if (!$user || !($user->hasRole('admin') || $user->hasRole('instructor')) ) {
            abort(403);
        }
    }

    public function render()
    {
        return view('livewire.chapter-crud');
    }
}
