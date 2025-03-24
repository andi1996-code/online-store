<?php

use App\Livewire\ProductList;
use Illuminate\Support\Facades\Route;
use App\Livewire\Cart;
use App\Livewire\ProductDetail;

// Route for displaying the product list
Route::get('/', ProductList::class)->name('product.list');

// Route for displaying the cart
Route::get('/cart', Cart::class)->name('cart');

// Route for displaying the product detail
Route::get('/product/{id}', ProductDetail::class)->name('product.detail');
