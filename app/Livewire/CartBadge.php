<?php

namespace App\Livewire;

use Livewire\Component;

class CartBadge extends Component
{
    public $count = 0;

    protected $listeners = [
        'cartUpdated' => 'refreshCount',
    ];

    public function mount()
    {
        $this->refreshCount();
    }

    public function refreshCount()
    {
        $cart = session('cart', []);
        $this->count = array_sum(array_column($cart, 'quantity'));
    }

    public function render()
    {
        return view('livewire.cart-badge');
    }
}
