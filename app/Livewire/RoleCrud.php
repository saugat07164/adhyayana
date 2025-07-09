<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;

class RoleCrud extends Component
{
    public $name;
    public $roles;
    public $editMode = false;
    public $selectedRoleId;

    public function mount()
    {
        if (!Auth::user() || !Auth::user()->hasRole('admin')) {
            abort(403);
        }

        $this->loadRoles();
    }

    public function loadRoles()
    {
        $this->roles = Role::all();
    }

    private function resetForm()
    {
        $this->name = '';
        $this->editMode = false;
        $this->selectedRoleId = null;
    }

    public function create()
    {
        $this->validate([
            'name' => 'required|string|unique:roles,name|max:255',
        ]);

        Role::create([
            'name' => $this->name,
        ]);

        session()->flash('message', 'Role created successfully!');
        $this->resetForm();
        $this->loadRoles();
    }

    public function edit($roleId)
    {
        $role = Role::findOrFail($roleId);
        $this->selectedRoleId = $role->id;
        $this->name = $role->name;
        $this->editMode = true;
    }

    public function update()
    {
        if (is_null($this->selectedRoleId)) {
            session()->flash('message', 'No role selected for update.');
            return;
        }

        $this->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $this->selectedRoleId,
        ]);

        $role = Role::findOrFail($this->selectedRoleId);
        $role->update([
            'name' => $this->name,
        ]);

        session()->flash('message', 'Role updated successfully!');
        $this->resetForm();
        $this->loadRoles();
    }

    public function delete($roleId)
    {
        try {
            $role = Role::findOrFail($roleId);

            // Optional: prevent deletion of important roles
            if (in_array($role->name, ['admin'])) {
                session()->flash('message', 'Cannot delete critical role!');
                return;
            }

            $role->delete();

            session()->flash('message', 'Role deleted successfully!');
            $this->loadRoles();
        } catch (\Exception $e) {
            \Log::error("Role deletion failed [ID: {$roleId}] - " . $e->getMessage());
            session()->flash('message', 'Error deleting role: ' . $e->getMessage());
        }
    }

    public function cancelEdit()
    {
        $this->resetForm();
    }

    public function render()
    {
        return view('livewire.role-crud')->layout('layouts.app');
    }
}
