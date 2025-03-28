<div class="container mx-auto py-8 px-4">
    <div class="container mx-auto px-4">
        <div class="fixed right-4 top-4 bg-white p-2 rounded-full shadow-lg z-50">
            <a href="{{ route('cart') }}" class="text-gray-700 text-2xl focus:outline-none relative">
                <i class="fas fa-shopping-cart"></i>
                <span class="absolute top-[-8px] -right-2 bg-red-500 text-white text-xs rounded-full px-2 py-1"
                    wire:poll>
                    {{ \App\Models\Cart::where('session_id', session()->getId())->sum('quantity') }}
                </span>

            </a>
        </div>
        <div class="relative">
            <img src="{{ asset('storage/' . \App\Models\Store::first()->image) }}" alt="Store Image"
                class="w-full h-50 lg:h-auto lg:max-h-80 lg:object-contain object-cover rounded-lg shadow-md">
            <img src="{{ asset('storage/' . \App\Models\Store::first()->profile_picture) }}" alt="Store Profile Picture"
                class="absolute -bottom-5 left-4 w-20 h-20 lg:w-32 lg:h-32 object-cover rounded-full border-4 border-white shadow-xl">
        </div>
        <div class="mt-8">
            <h1 class="lg:text-2xl text-lg font-bold">{{ \App\Models\Store::first()->name_store }}</h1>
        </div>
        <div class="mt-2">
            <h1 class="lg:text-2xl text-sm text-gray-500">{{ \App\Models\Store::first()->description }}</h1>
        </div>
        <div class="mt-2">
            <h2 class="text-black lg:text-xl lg:font-bold">Alamat:</h2>
            <livewire:address-toggle />
        </div>
        <div class="border-b border-gray-300 my-4"></div>
    </div>
    <form wire:submit.prevent="render" class="flex-grow mr-4 mb-7" onkeydown="return event.key !== 'Enter';">
        <input type="text" wire:model="searchTerm" placeholder="Cari produk..."
            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
    </form>
    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @foreach ($products as $product)
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <a href="{{ route('product.detail', $product->id) }}">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                        class="w-full lg:w-40 lg:mx-auto h-40 object-cover lg:object-fill">
                </a>
                <div class="px-4 py-2">
                    <h3 class="text-sm md:text-lg font-semibold mb-2">
                        {{ Str::limit($product->name, 30, '...') }} <!-- Truncate long names -->
                    </h3>
                    <p class="text-red-600 text-sm font-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    <hr class="border-gray-300 my-2">
                </div>
                <div class="flex justify-center m-2">
                    <button wire:click="addToCart({{ $product->id }})"
                        class="bg-blue-500 text-white px-3 py-2 rounded hover:bg-blue-600 transition duration-300 w-full text-sm md:text-base">Beli</button>
                </div>
            </div>
        @endforeach
    </div>
</div>
