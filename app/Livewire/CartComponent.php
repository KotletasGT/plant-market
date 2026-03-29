<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\Checkout\Session;
//use App\Helpers\PayseraHelper;
//use WebToPay;
//use WebToPayException;

class CartComponent extends Component
{
    public $cart = [];

    public $total = 0;

    public $city;
    public $street;
    public $house;

    public function mount()

    {

        $this->cart = session()->get('cart', []);

        $this->calculateTotal();

    }

    public function removeFromCart($productId)

    {

        if (isset($this->cart[$productId])) {

            unset($this->cart[$productId]);

            session()->put('cart', $this->cart);

            $this->calculateTotal();

            session()->flash('message', 'Product removed from cart.');

        }

    }

    public function updateQuantity($productId, $quantity)

    {

        if (isset($this->cart[$productId]) && $quantity > 0) {

            $this->cart[$productId]['quantity'] = $quantity;

            session()->put('cart', $this->cart);

            $this->calculateTotal();

            session()->flash('message', 'Cart updated successfully.');

        }

    }

    public function confirmOrder()

{

    if (empty($this->cart)) {

        session()->flash('error', 'Cart is empty. Add products to confirm an order.');

        return;

    }

//    DB::beginTransaction();

//    $orderTotal = 0;
    $orderIds = [];
    $lineItems = [];

    foreach ($this->cart as $productId => $item) { 

    if ($item['quantity'] < 1) {

        session()->flash('error', 'Order quantity cannot be negative.');

        return;

    }

    if (strlen($this->city) < 1 || strlen($this->street) < 1 || strlen($this->house) < 1) {

        session()->flash('error', 'City, street, and house must be provided.');

        return;

    }

    if (strlen($this->city) > 50 || strlen($this->street) > 100 || strlen($this->house) > 20) {

        session()->flash('error', 'City max 50 chars, street max 100 chars, house max 20 chars.');

        return;

    }
    
    $product = Product::find($productId);

    if ($item['quantity'] > $product->stock) {

        session()->flash('error', "Not enough stock for {$product->title}. Available: {$product->stock}");

        return;

    }


        $productTotal = $item['price'] * $item['quantity'];

//        $orderTotal += $productTotal;

        $order = Order::create([

            'product_id' => $productId,

            'user_id' => Auth::id(),

            'quantity' => $item['quantity'],

            'price_per_item' => $item['price'],

            'total_price' => $productTotal,

            'city' => $this->city,

            'street' => $this->street,

            'house' => $this->house,

            'status' => 'pending',

        ]);

        $orderIds[] = $order->id;

    }

//    $response = redirect()->route('stripe.checkout')->with([
//        'cart' => $this->cart
//    ]);

foreach ($this->cart as $item) {
    $lineItems[] = [
        'price_data' => [
            'currency' => 'eur',
            'product_data' => [
                'name' => $item['title'] ?? 'Product',
            ],
            'unit_amount' => $item['price'] * 100, // price in cents
        ],
        'quantity' => $item['quantity'],
    ];
}

session()->put('pending_order_ids', $orderIds);

// Initialize Stripe
Stripe::setApiKey(config('services.stripe.secret'));

$session = Session::create([
    'payment_method_types' => ['card'],
    'line_items' => $lineItems,
    'mode' => 'payment',
    'success_url' => config('services.stripe.success_url'),
    'cancel_url' => config('services.stripe.cancel_url'),
]);

//DB::commit();
    
//paclearinti

    session()->forget('cart');

    $this->cart = [];

    $this->total = 0;

    /*$paymentData = [
        'projectid'   => 100000, //env('PAYSERA_PROJECT_ID'),
        'orderid'     => implode('-', $orderIds),
        'accepturl'   => env('PAYSERA_ACCEPT'),
        'cancelurl'   => env('PAYSERA_CANCEL'),
        'callbackurl' => env('PAYSERA_CALLBACK'),
        'amount'      => (int)($orderTotal * 100), // cents
        'currency'    => 'EUR',
        'country'     => 'LT',
        'lang'        => 'ENG',
        'paytext'     => 'Payment for Order #' . implode(',', $orderIds),
        'test'        => 1,

    ];

        return redirect()->away(WebToPay::redirectToPayment($request));
    } catch (WebToPayException $e) {
        session()->flash('error', 'Paysera error: ' . $e->getMessage());
    }*/

    //session()->flash('message', "Order placed successfully! Your total is $orderTotal. We will notify you once it is approved.");

    //$paymentUrl = PayseraHelper::buildUrl($paymentData, env('PAYSERA_SIGN_PASSWORD'));

    //return redirect()->away($paymentUrl);

    //return $response;
    return redirect()->away($session->url);
}
//catch (\Exception $e) {
//    DB::rollBack();
//    session()->flash('error', $e->getMessage());
//}
//}

    public function calculateTotal()

    {

        $this->total = array_reduce($this->cart, function ($carry, $item) {

            return $carry + ($item['price'] * $item['quantity']);

        }, 0);

    }



    public function render()

    {

        return view('livewire.cart-component', ['cart' => $this->cart, 'total' => $this->total]);

    }
}
