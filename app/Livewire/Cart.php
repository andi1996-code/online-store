<?php

namespace App\Livewire;

use App\Models\Cart as CartModel;
use App\Models\Product;
use Livewire\Component;
use App\Models\Order;
use App\Models\Order_item;
use App\Models\Store;

class Cart extends Component
{
    public $cartItems = [];
    public $totalPrice = 0;
    public $showCheckoutPopup = false; // Controls the visibility of the popup
    public $name;
    public $address;
    public $cartItemId;

    public function mount()
    {
        $this->loadCart();
    }

    public function loadCart()
    {
        $session_id = session()->getId(); // Ambil session ID dari Laravel

        $this->cartItems = CartModel::with('product')
            ->where('session_id', $session_id)
            ->get();

        $this->totalPrice = collect($this->cartItems)->sum('total_price');
    }


    public function addToCart($productId)
    {
        $session_id = session()->getId();
        $product = Product::findOrFail($productId);

        $cartItem = CartModel::where('session_id', $session_id)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += 1;
            $cartItem->total_price = $cartItem->quantity * $product->price;
            $cartItem->save();
        } else {
            CartModel::create([
                'session_id' => $session_id,
                'product_id' => $productId,
                'quantity' => 1,
                'total_price' => $product->price,
            ]);
        }

        $this->loadCart();
    }


    public function removeFromCart($cartItemId)
    {
        $session_id = session()->getId();
        $cartItem = CartModel::where('session_id', $session_id)
            ->where('id', $cartItemId)
            ->first();

        if ($cartItem) {
            if ($cartItem->quantity > 1) {
                $cartItem->quantity -= 1;
                $cartItem->total_price = $cartItem->quantity * $cartItem->product->price;
                $cartItem->save();
            } else {
                $cartItem->delete();
            }
        }

        $this->loadCart();
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
        $this->showCheckoutPopup = true; // Show the popup
    }

    public function confirmCheckout()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
        ]);

        $session_id = session()->getId();

        // Simpan order
        $order = Order::create([
            'name_customer' => $this->name,
            'address' => $this->address,
            'total_price' => $this->totalPrice,
            'status' => 'pending',
        ]);

        // Hapus hanya cart milik session yang checkout
        CartModel::where('session_id', $session_id)->delete();

        $this->cartItems = [];
        $this->totalPrice = 0;

        $this->dispatch('cartCleared');

        $this->showCheckoutPopup = false;
        session()->flash('success', 'Checkout berhasil!');
    }


    public function render()
    {
        return view('livewire.cart', [
            'cartItems' => $this->cartItems,
            'totalPrice' => $this->totalPrice,
        ]);
    }
}
