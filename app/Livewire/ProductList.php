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

    /**
     * Menambahkan produk ke dalam keranjang.
     */
    public function addToCart($productId)
    {
        $sessionId = session()->getId(); // Ambil session ID
        $product = Product::findOrFail($productId);

        // Cek apakah produk sudah ada di keranjang
        $cartItem = Cart::where('session_id', $sessionId)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity'); // Tambah jumlah produk
            $cartItem->update(['total_price' => $cartItem->quantity * $product->price]);
        } else {
            Cart::create([
                'session_id' => $sessionId,
                'product_id' => $productId,
                'quantity' => 1,
                'total_price' => $product->price,
            ]);
        }

        $this->dispatch('cartUpdated');
    }

    /**
     * Render komponen Livewire dan ambil daftar produk.
     */
    public function render()
    {
        $products = Product::query()
            ->when($this->searchTerm, fn($query) =>
                $query->where('name', 'like', "%{$this->searchTerm}%")
            )
            ->get();

        return view('livewire.product-list', compact('products'));
    }

    
}
