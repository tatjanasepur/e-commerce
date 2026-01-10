<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\ProductsIndex;
use App\Livewire\CartShow;

Route::get('/', function () {
    return redirect('/products');
});

Route::get('/dashboard', function () {
    return redirect('/products');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/products', ProductsIndex::class)
    ->middleware('auth');

Route::get('/cart', CartShow::class)
    ->middleware('auth');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';
