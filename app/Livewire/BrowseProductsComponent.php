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

    }



    public function render()
    {
        $products = Product::query();

        if ($this->sortOption === 'price_asc') {
            $products->orderBy('price', 'asc');
        } elseif ($this->sortOption === 'price_desc') {
            $products->orderBy('price', 'desc');
        }

        return view('livewire.browse-products-component', [
            'products' => $products->paginate(12),
        ])->layout('components.layouts.app');
    }
}
