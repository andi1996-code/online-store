<div class="container mx-auto py-8 px-4">
    <div class="container">
        <div class="flex items-center mb-4">
            <a href="/" class="text-gray-700 hover:text-gray-900 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 md:w-7 md:h-7" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h2 class="text-xl md:text-2xl font-bold ml-4">Detail Produk</h2>
        </div>
    </div>
    <div class="flex flex-col lg:flex-row items-center lg:items-start">
        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
            class="w-full lg:w-1/2 h-auto object-cover rounded-lg shadow-md">
        <div class="lg:ml-8 mt-4 lg:mt-0">
            <h1 class="lg:text-2xl text-lg font-bold mb-4">{{ $product->name }}</h1>
            <div class="border-b border-gray-300 my-4"></div>
            <p class="text-red-600 font-bold text-lg mb-4">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
            <p class="text-gray-700 mb-6 text-justify">{{ $product->description }}</p>
            <div class="flex justify-center">
                <button wire:click="addToCart({{ $product->id }})"
                    class="bg-blue-500 text-white px-6 py-3 rounded hover:bg-blue-600 transition duration-300">
                    Tambahkan ke Keranjang
                </button>
            </div>
        </div>
    </div>
</div>
