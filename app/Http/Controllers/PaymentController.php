<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function success()
    {
        $orderIds = session('pending_order_ids', []);

        if (empty($orderIds)) {
            return redirect('/')->with('error', 'No orders found for confirmation.');
        }

        DB::transaction(function () use ($orderIds) {
            $orders = Order::whereIn('id', $orderIds)->where('user_id', Auth::id())->get();

            foreach ($orders as $order) {
                // Update stock
                $product = Product::find($order->product_id);

                if ($product && $product->stock >= $order->quantity) {
                    $product->stock -= $order->quantity;
                    $product->save();
                }

                // Mark as paid
                $order->status = 'paid';
                $order->save();
            }
        });

        session()->forget('pending_order_ids');

        //return redirect('/')->with('message', 'Payment successful! Your order is confirmed.');
        return view('payment.success');
    }
}
