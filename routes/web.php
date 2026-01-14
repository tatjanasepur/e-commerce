<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\ProductsIndex;
use App\Livewire\CartShow;
use App\Models\Order;

Route::get('/', function () {
    return redirect('/products');
});

Route::get('/dashboard', function () {
    return redirect('/products');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/products', ProductsIndex::class)->middleware('auth');
Route::get('/cart', CartShow::class)->middleware('auth');

Route::get('/order/success/{order}', function (Order $order) {
    abort_unless($order->user_id === auth()->id(), 403);

    $order->load('items');

    return view('order-success', [
        'order' => $order,
    ]);
})->middleware('auth')->name('order.success');

Route::view('profile', 'profile')->middleware(['auth'])->name('profile');

require __DIR__ . '/auth.php';
