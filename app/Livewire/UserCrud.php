<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Role;

class UserCrud extends Component
{
    public $name;
    public $email;
    public $role; // role ID
    public $password;

    public $editMode = false;
    public $selectedUserId;

    public $roles;
    public $users;

    public function mount()
    {
        if (!Auth::user() || !Auth::user()->hasRole('admin')) {
            abort(403);
        }

        $this->loadUsers();
        $this->loadRoles();
    }

    public function loadUsers()
    {
        $this->users = User::with('roles')->get(); // eager load roles
    }

    public function loadRoles()
    {
        $this->roles = Role::all(); // load all roles
    }

    private function resetForm()
    {
        $this->name = '';
        $this->email = '';
        $this->role = '';
        $this->password = '';
        $this->editMode = false;
        $this->selectedUserId = null;
    }

    public function create()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|exists:roles,id',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->password),
        ]);

        // Assign role manually (custom many-to-many)
        $user->roles()->attach($this->role);

        session()->flash('message', 'User created successfully!');
        $this->resetForm();
        $this->loadUsers();
    }

    public function edit($userId)
    {
        $user = User::with('roles')->findOrFail($userId);
        $this->selectedUserId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->roles->first()->id ?? null;
        $this->password = '';
        $this->editMode = true;
    }

    public function update()
    {
        if (is_null($this->selectedUserId)) {
            session()->flash('message', 'Error: No user selected for update.');
            return;
        }

        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->selectedUserId,
            'role' => 'required|exists:roles,id',
        ]);

        $user = User::findOrFail($this->selectedUserId);

        $user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        // Optional password update
        if (!empty($this->password)) {
            $user->update(['password' => bcrypt($this->password)]);
        }

        // Replace role manually (custom pivot sync)
        $user->roles()->sync([$this->role]);

        session()->flash('message', 'User updated successfully!');
        $this->resetForm();
        $this->loadUsers();
    }

    public function delete($userId)
    {
        if (Auth::id() === $userId) {
            session()->flash('message', 'You cannot delete your own account!');
            return;
        }

        try {
            $user = User::findOrFail($userId);
            $user->roles()->detach(); // remove role pivot links
            $user->delete(); // soft delete or hard delete depending on your model

            session()->flash('message', 'User deleted successfully!');
            $this->loadUsers();
        } catch (\Exception $e) {
            \Log::error("Error deleting user {$userId}: " . $e->getMessage());
            session()->flash('message', 'Error deleting user: ' . $e->getMessage());
        }
    }

    public function cancelEdit()
    {
        $this->resetForm();
    }

    public function render()
    {
        return view('livewire.user-crud')->layout('layouts.app');
    }
}
