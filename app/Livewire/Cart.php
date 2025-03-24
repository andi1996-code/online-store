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
    public $showCheckoutPopup = false; // Controls the visibility of the popup
    public $name;
    public $address;

    public function mount()
    {
        $this->loadCart();
    }

    public function loadCart()
    {
        $this->cartItems = CartModel::with('product')->get(); // Keep as a collection
        $this->totalPrice = collect($this->cartItems)->sum('total_price'); // Ensure it's a collection
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
            $cartItem->delete();
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

        // Simpan order
        $order = Order::create([
            'name_customer' => $this->name,
            'address' => $this->address,
            'total_price' => $this->totalPrice,
            'status' => 'pending',
        ]);

        $totalPriceFormatted = number_format($this->totalPrice, 0, ',', '.');

        $store = \App\Models\Store::first();
        if ($store && $store->phone) {
            $orderTemplate = ($store->wa_order_template ?? "Halo, saya ingin memesan:") . "\n\n";
            $whatsappUrl = "https://wa.me/{$store->phone}?text=" . urlencode(
                $orderTemplate .
                collect($this->cartItems)->map(function ($item) {
                    return "-> " . $item['product']['name'] . " (x" . $item['quantity'] . ")";
                })->join("\n") .
                "\n\nTotal: Rp *{$totalPriceFormatted}*" .
                "\n\nNama: {$this->name}" .
                "\nAlamat: {$this->address}"
            );

            $this->dispatch('openWhatsApp', $whatsappUrl);
        }

        CartModel::query()->delete();
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
