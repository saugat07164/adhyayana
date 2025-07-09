<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class CouponCrud extends Component
{
    public function mount()
    {
        $user = Auth::user();
        if (!$user || !($user->hasRole('admin') || $user->hasRole('staff')) ) {
            abort(403);
        }
    }

    public function render()
    {
        return view('livewire.coupon-crud');
    }
}
