<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\UserAuthController;
use Illuminate\Support\Facades\Auth;
use App\Livewire\CategoryComponent;
use App\Livewire\AddProductComponent;
use App\Livewire\OrderManagementComponent;
use App\Livewire\BrowseProductsComponent;
use App\Livewire\CartComponent;
use App\Livewire\SingleProductComponent;
use App\Http\Controllers\CategoryController;
use App\Livewire\AdminOverview;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\PaymentController;
use App\Livewire\UsersComponent;
use App\Http\Controllers\OrderController;

/*Route::get('/', function () {
    //return view('welcome');
    return view('components.layouts.store');
});*/

Route::get('/dashboard', function () {
//    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth:admin')->group(function () {
//    Route::get('admin/dashboard', function () {
//        return view('admin_dashboard', ['admin' => Auth::guard('admin')->user()]);
//    })->name('admin_dashboard');

    Route::get('/admin/dashboard', AdminOverview::class)->name('admin.dashboard');

    Route::get('/admin/categories', CategoryComponent::class)->name('admin.categories');

    Route::get('/admin/add-product', AddProductComponent::class)->name('admin.add-product');

    Route::get('/admin/orders', OrderManagementComponent::class)->name('admin.orders');

    Route::get('/admin/users', UsersComponent::class)->name('admin.users');

//    Route::get('/admin/users', UsersComponent::class)->name('admin.users');
});

Route::middleware('auth')->group(function () {
    Route::get('/user/add-product', \App\Livewire\UserAddProductComponent::class)->name('user.add-product');
    Route::get('/cart', CartComponent::class)->name('cart');
    Route::get('/order/confirm/{orderId}', [OrderController::class, 'confirm'])->name('order.confirm')->middleware('signed');
});

//Route::get('/cart', function () {
//    return view('components.layouts.cart')
//});

Route::get('/', BrowseProductsComponent::class)->name('products.browse');

Route::get('/product/{id}', SingleProductComponent::class)->name('product.show'); //idk

Route::get('/category/{id}', [CategoryController::class, 'index'])->name('category.show');

Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');

Route::middleware(['auth'])->group(function () {
    Route::get('/cart', CartComponent::class)->name('cart');
});

    // Admin Routes
Route::get('admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login.form');
Route::post('admin/login', [AdminAuthController::class, 'login'])->name('admin.login');
Route::get('admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*Route::get('/payment/success', fn() => view('payment.success'));
Route::get('/payment/cancel', fn() => view('payment.cancel'));

Route::post('/payment/callback', function (\Illuminate\Http\Request $request) {
    $data = $request->input('data');
    $sign = $request->input('ss1');

    $expectedSign = md5($data . env('PAYSERA_SIGN_PASSWORD'));
    if ($sign !== $expectedSign) return response('Invalid signature', 403);

    parse_str(base64_decode($data), $params);

    if (!empty($params['orderid'])) {
        $ids = explode('-', $params['orderid']);
        \App\Models\Order::whereIn('id', $ids)->update(['payment' => 'paid']);
    }

    return response('OK', 200);
});*/

/*Route::get('/paysera/success', function () {
    return view('payment.success');
});

Route::get('/paysera/cancel', function () {
    return view('payment.cancel');
});

Route::post('/paysera/callback', [\App\Http\Controllers\PayseraController::class, 'handleCallback']);*/

/*Route::get('/payment/success', function () {
return view('payment.success');
});*/

Route::get('/payment/cancel', function () {
//    return 'Payment cancelled.';
//})->name('payment.cancel');
return view('payment.cancel');
});

Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');

Route::get('/stripe/checkout', [StripeController::class, 'createCheckoutSession'])->name('stripe.checkout');

require __DIR__.'/auth.php';
