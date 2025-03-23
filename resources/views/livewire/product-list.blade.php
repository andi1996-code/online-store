<div class="container mx-auto py-8 px-4">
    <div class="flex justify-end mb-4">
        <div class="relative">
            <a href="{{ route('cart') }}" class="text-gray-700 text-2xl focus:outline-none">
            <i class="fas fa-shopping-cart"></i>
            <span class="absolute top-[-8px] -right-2 bg-red-500 text-white text-xs rounded-full px-2 py-1" wire:poll>
                {{ \App\Models\Cart::sum('quantity') }}
            </span>
            </a>
        </div>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @foreach($products as $product)
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full lg:w-40 lg:mx-auto h-40 object-cover lg:object-fill"> <!-- Adjusted height -->
                <div class="px-4 py-2">
                    <h3 class="text-sm md:text-lg font-semibold mb-2">{{ $product->name }}</h3>
                    <p class="text-gray-600 text-sm">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    <hr class="border-gray-300 my-2">
                </div>
                <div class="flex justify-center m-2">
                    <button wire:click="addToCart({{ $product->id }})" class="bg-blue-500 text-white px-3 py-2 rounded hover:bg-blue-600 transition duration-300 w-full text-sm md:text-base">Beli</button>
                </div>
            </div>
        @endforeach
    </div>
</div>
