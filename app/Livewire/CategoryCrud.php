<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;

class CategoryCrud extends Component
{
    public $categories;
    public $name;
    public $categoryId;
    public $editMode = false;

    public function mount()
    {
        if (!Auth::user() || !Auth::user()->hasRole('admin')) {
            abort(403);
        }
        $this->fetch();
    }

    public function fetch()
    {
        $this->categories = Category::all();
    }

    public function create()
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ]);
        Category::create(['name' => $this->name]);
        $this->resetForm();
        $this->fetch();
        session()->flash('message', 'Category created successfully!');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $this->categoryId = $category->id;
        $this->name = $category->name;
        $this->editMode = true;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ]);
        $category = Category::findOrFail($this->categoryId);
        $category->update(['name' => $this->name]);
        $this->resetForm();
        $this->fetch();
        session()->flash('message', 'Category updated successfully!');
    }

    public function delete($id)
    {
        Category::findOrFail($id)->delete();
        $this->fetch();
        session()->flash('message', 'Category deleted successfully!');
    }

    public function cancelEdit()
    {
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->categoryId = null;
        $this->name = '';
        $this->editMode = false;
    }

    public function render()
    {
        return view('livewire.category-crud')->layout('layouts.app');
    }
}
