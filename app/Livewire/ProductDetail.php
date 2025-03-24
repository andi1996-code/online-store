<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class ProductDetail extends Component
{
    public $product;

    public function mount($id)
    {
        $this->product = Product::findOrFail($id); // Fetch product details by ID
    }

    public function addToCart($productId)
    {
        // Logic to add the product to the cart
    }

    public function render()
    {
        return view('livewire.product-detail', ['product' => $this->product]);
    }
}
