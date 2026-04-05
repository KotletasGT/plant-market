<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderApprovedMail;
use App\Mail\OrderConfirmationMail;
use App\Mail\SellerOrderNotificationMail;

class OrderManagementComponent extends Component
{
    public function approveOrder($orderId)

    {

        $order = Order::with(['user', 'product'])->find($orderId);

    if ($order) {

        $order->update(['status' => 'approved']);

        // Send confirmation email to buyer
//        Mail::to($order->user->email)->send(new OrderConfirmationMail($order));

        // Send notification to seller if product is added by user (not admin)
//        if ($order->product->user_id) {
//            $seller = $order->product->user;
//            Mail::to($seller->email)->send(new SellerOrderNotificationMail($order));
//        }

        session()->flash('message', "Order #{$order->id} approved successfully, and notifications sent.");

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
