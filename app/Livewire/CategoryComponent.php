<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Category;

class CategoryComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $name;

    public function saveCategory()
    {
        $this->validate(['name' => 'required|string|max:255']);
        Category::create(['name' => $this->name]);
        $this->name = '';
        $this->resetPage();
        session()->flash('message', 'Category added successfully!');
    }

    public function deleteCategory($id)
    {
        Category::findOrFail($id)->delete();
        $this->resetPage();
        session()->flash('message', 'Category deleted successfully!');
    }

    public function render()
    {
        return view('livewire.category-component', [
            'categories' => Category::orderBy('name')->paginate(10),
        ])->layout('components.layouts.admin');
    }
}
