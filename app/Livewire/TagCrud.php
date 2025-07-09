<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class TagCrud extends Component
{
    public function mount()
    {
        if (!Auth::user() || !Auth::user()->hasRole('admin')) {
            abort(403);
        }
    }

    public function render()
    {
        return view('livewire.tag-crud');
    }
}
