<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\User;
use App\Models\Admin;

class SingleProductComponent extends Component
{
    public $product;
    public $rating, $comment;
    public $adder;

    /**

     * Mount the component with the selected product.

     */

    public function mount($id)

    {

        $this->product = Product::findOrFail($id);

        $this->adder = 'Unknown';
        if ($this->product->user_id) {
            $user = User::find($this->product->user_id);
            if ($user) {
                $this->adder = $user->name;
            } else {
                $admin = Admin::find($this->product->user_id);
                $this->adder = $admin ? $admin->name : 'Unknown';
            }
        }

    }

    public function addToCart($productId)

    {

        $product = Product::find($productId);

        if (!$product) {

            session()->flash('error', 'Product not found.');

            return;

        }

        // Retrieve existing or create new cart

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

    public function submitReview()

    {

    if (!auth()->check()) {

        session()->flash('error', 'You must be logged in to rate products.');

        return;

    }

    $this->validate([

        'rating' => 'required|integer|min:1|max:5',

        'comment' => 'nullable|string|max:1000',

    ]);

    $product = Product::findOrFail($this->product->id);

    // Prevent duplicate
    $product->reviews()->updateOrCreate(

        ['user_id' => auth()->id()],

        ['rating' => $this->rating, 'comment' => $this->comment]

    );

    $product->rating = $product->averageRating();
    $product->save();

    $this->product = $product;
    $this->rating = null;
    $this->comment = null;

    session()->flash('message', 'Thank you for your review!');
    }

    public function removeReview($reviewId)
{
    $review = $this->product->reviews()->where('id', $reviewId)->where('user_id', auth()->id())->first();

    $review->delete();

    $this->product->rating = $this->product->averageRating();
    $this->product->save();

    $this->product = Product::findOrFail($this->product->id);

    session()->flash('message', 'Your review was removed successfully.');
}

    public function render()

    {

        return view('livewire.single-product-component');

    }
}
