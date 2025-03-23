<?php
namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\Cart;

class ProductList extends Component
{
    use WithPagination;

    public $products;

    public function mount()
    {
        $this->products = Product::all();
    }

    public function addToCart($productId)
    {
        $product = Product::findOrFail($productId);

        $cartItem = Cart::where('product_id', $productId)->first();
        if ($cartItem) {
            $cartItem->quantity += 1;
            $cartItem->total_price = $cartItem->quantity * $product->price;
            $cartItem->save();
        } else {
            Cart::create([
                'product_id' => $productId,
                'quantity' => 1,
                'total_price' => $product->price,
            ]);
        }

        $this->dispatch('cartUpdated');
    }

    public function render()
    {
        return view('livewire.product-list', [
            'products' => $this->products,
        ])->with('layout', 'components.layouts.app');
    }
}

