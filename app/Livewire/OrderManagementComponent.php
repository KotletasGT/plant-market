<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderApprovedMail;

class OrderManagementComponent extends Component
{
    public function approveOrder($orderId)

    {

        $order = Order::with(['user', 'product'])->find($orderId);

    if ($order) {

        $order->update(['status' => 'approved']);

// emeilui (TO-DO)

        Mail::to($order->user->email)->send(new OrderApprovedMail($order));

        session()->flash('message', "Order #{$order->id} approved successfully, and the user has been notified.");

    } else {

        session()->flash('error', "Order #{$orderId} not found.");

    }

    }

    public function cancelOrder($orderId)

    {

        $order = Order::find($orderId);

        $order->delete();
        
        session()->flash('message', 'Order deleted successfully!');

    }

    public function render()

    {

        return view('livewire.order-management-component', ['orders' => Order::with('product', 'user')->get()])->layout('components.layouts.admin');

    }
}
