<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class BrowseProductsComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $sortOption = '';

    public function addToCart($productId)

    {

        $product = Product::find($productId);

        if (!$product) {

            session()->flash('error', 'Product not found.');

            return;

        }

        // Retrieve existing cart from session or create a new one

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {

            $cart[$productId]['quantity']++;

        } else {

            $cart[$productId] = [

                'title' => $product->title,

                'price' => $product->price,

                'quantity' => 1,

            ];

        }

        // Save updated cart to session

        session()->put('cart', $cart);

        session()->flash('message', "{$product->title} added to cart.");
        $this->dispatch('cartUpdated');

    }



    public function render()
    {
        $products = Product::where('approved', true);

        if ($this->sortOption === 'price_asc') {
            $products->orderBy('price', 'asc');
        } elseif ($this->sortOption === 'price_desc') {
            $products->orderBy('price', 'desc');
        } elseif ($this->sortOption === 'newest') {
            $products->orderBy('created_at', 'desc');
        } elseif ($this->sortOption === 'oldest') {
            $products->orderBy('created_at', 'asc');
        } elseif ($this->sortOption === 'rating_asc') {
            $products->where('rating', '>', 0)->orderBy('rating', 'asc');
        } elseif ($this->sortOption === 'rating_desc') {
            $products->where('rating', '>', 0)->orderBy('rating', 'desc');
        }

        return view('livewire.browse-products-component', [
            'products' => $products->paginate(12),
        ])->layout('components.layouts.app');
    }
}
