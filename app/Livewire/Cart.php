<?php

namespace App\Livewire;

use App\Models\Cart as CartModel;
use App\Models\Product;
use Livewire\Component;
use App\Models\Order;
use App\Models\Order_item;

class Cart extends Component
{
    public $cartItems = [];
    public $totalPrice = 0;

    public function mount()
    {
        $this->loadCart();
    }

    public function loadCart()
    {
        $this->cartItems = CartModel::with('product')->get();
        $this->totalPrice = collect($this->cartItems)->sum('total_price');
    }

    public function addToCart($productId)
    {
        $product = Product::findOrFail($productId);

        $cartItem = CartModel::where('product_id', $productId)->first();
        if ($cartItem) {
            $cartItem->quantity += 1;
            $cartItem->total_price = $cartItem->quantity * $product->price;
            $cartItem->save();
        } else {
            CartModel::create([
                'product_id' => $productId,
                'quantity' => 1,
                'total_price' => $product->price,
            ]);
        }

        $this->loadCart();
    }

    public function removeFromCart($cartItemId)
    {
        $cartItem = CartModel::findOrFail($cartItemId);

        if ($cartItem->quantity > 1) {
            $cartItem->quantity -= 1;
            $cartItem->total_price = $cartItem->quantity * $cartItem->product->price;
            $cartItem->save();
        } else {
            $cartItem->delete(); // Delete the cart item if quantity is 1
        }

        $this->loadCart(); // Refresh the cart items and total price
    }

    public function incrementQuantity($cartItemId)
    {
        $cartItem = CartModel::findOrFail($cartItemId);
        $cartItem->quantity += 1;
        $cartItem->total_price = $cartItem->quantity * $cartItem->product->price;
        $cartItem->save();

        $this->loadCart();
    }

    public function checkout()
    {
        if (empty($this->cartItems)) {
            return;
        }

        $order = Order::create([
            'name_customer' => 'Anonymous',
            'address' => 'Unknown',
            'total_price' => $this->totalPrice,
            'status' => 'pending',
        ]);

        foreach ($this->cartItems as $item) {
            Order_item::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['total_price'],
            ]);
        }

        // Hapus semua item dari cart
        CartModel::query()->delete();

        // Reset cart di Livewire
        $this->cartItems = [];
        $this->totalPrice = 0;

        // Ambil nomor WhatsApp toko
        $store = \App\Models\Store::first();
        if ($store && $store->phone) {
            $cartDetails = collect($this->cartItems)->map(function ($item) {
                return $item['product']['name'] . ' (x' . $item['quantity'] . ')';
            })->join(', ');

            $whatsappUrl = "https://wa.me/{$store->phone}?text=" . urlencode(
                "Halo, saya ingin memesan: {$cartDetails}. Total: Rp " . number_format($this->totalPrice, 0, ',', '.')
            );

            // Kirim event ke JavaScript agar bisa buka WhatsApp di tab baru
            $this->dispatch('openWhatsApp', $whatsappUrl);
        }

        // Kirim event untuk mengosongkan keranjang di frontend
        $this->dispatch('cartCleared');
    }



    public function render()
    {
        return view('livewire.cart', [
            'cartItems' => $this->cartItems,
            'totalPrice' => $this->totalPrice,
        ]);
    }
}
