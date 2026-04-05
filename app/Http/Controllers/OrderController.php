<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Confirm order receipt by buyer
     */
    public function confirm(Request $request, $orderId)
    {
        $order = Order::find($orderId);

        if (!$order) {
            return redirect('/')->with('error', 'Order not found.');
        }

        // Verify the user is the buyer
        if ($order->user_id !== auth()->id()) {
            return redirect('/')->with('error', 'Unauthorized access.');
        }

        // Update order status to approved
        $order->update(['status' => 'approved']);

        return redirect('/')->with('message', 'Order confirmed! Thank you for your purchase.');
    }
}
