<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Course;
use App\Models\Payment;

class AdminDashboard extends Component
{
    public $userCount;
    public $courseCount;
    public $pendingApprovals;
    public $totalRevenue;

    public function mount()
    {
        $this->userCount = User::count();
        $this->courseCount = Course::count();
        $this->pendingApprovals = Course::where('status', 'pending')->count();
        $this->totalRevenue = Payment::sum('amount');
    }

    public function render()
    {
        return view('dashboard.admin-dashboard')->layout('layouts.app');
    }
}
