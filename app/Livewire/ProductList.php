<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\Cart;

class ProductList extends Component
{
    use WithPagination;

    public $searchTerm = ''; // Bind search input

    public function addToCart($productId)
    {
        $sessionId = session()->getId(); // Ambil session_id
        $product = Product::findOrFail($productId);

        // Cari produk di keranjang berdasarkan session_id dan product_id
        $cartItem = Cart::where('session_id', $sessionId)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += 1;
            $cartItem->total_price = $cartItem->quantity * $product->price;
            $cartItem->save();
        } else {
            Cart::create([
                'session_id' => $sessionId, // Tambahkan session_id
                'product_id' => $productId,
                'quantity' => 1,
                'total_price' => $product->price,
            ]);
        }

        $this->dispatch('cartUpdated');
    }


    public function render()
    {
        $products = Product::query()
            ->when($this->searchTerm, function ($query) {
                $query->where('name', 'like', '%' . $this->searchTerm . '%'); // Filter by search term
            })
            ->get();

        return view('livewire.product-list', [
            'products' => $products,
        ]);
    }
}
