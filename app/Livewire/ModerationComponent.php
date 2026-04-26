<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\Category;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class ModerationComponent extends Component
{
    use WithPagination, WithFileUploads;

    protected $paginationTheme = 'bootstrap';

    public $categories;
    public $editTitle = [];
    public $editDescription = [];
    public $editPrice = [];
    public $editCategory = [];
    public $stockValues = [];
    public $newPhoto = [];

    public function mount()
    {
        $this->categories = Category::all();

        $pending = Product::where('approved', false)->whereHas('user')->get();
        foreach ($pending as $product) {
            $this->editTitle[$product->id] = $product->title;
            $this->editDescription[$product->id] = $product->description;
            $this->editPrice[$product->id] = $product->price;
            $this->editCategory[$product->id] = $product->category_id;
            $this->stockValues[$product->id] = $product->stock;
        }
    }

    public function approveProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->approved = true;
        $product->save();

        session()->flash('message', 'Product approved.');
        $this->resetPage();
    }

    public function updateProduct($productId)
    {
        $product = Product::findOrFail($productId);
        $product->title = $this->editTitle[$productId] ?? $product->title;
        $product->description = $this->editDescription[$productId] ?? $product->description;
        $product->price = $this->editPrice[$productId] ?? $product->price;
        $product->category_id = $this->editCategory[$productId] ?? $product->category_id;
        $product->stock = $this->stockValues[$productId] ?? $product->stock;
        $product->save();

        session()->flash('message', 'Product updated successfully!');
    }

    public function updateProductImage($productId)
    {
        $product = Product::findOrFail($productId);
        if (isset($this->newPhoto[$productId])) {
            $path = $this->newPhoto[$productId]->store('products', 'public');
            $product->image = $path;
            $product->save();
            session()->flash('message', 'Product image updated successfully!');
        }
    }

    public function render()
    {
        $products = Product::where('approved', false)->whereHas('user')->with('category')->paginate(12);
        return view('livewire.moderation-component', ['products' => $products])->layout('components.layouts.admin');
    }
}
