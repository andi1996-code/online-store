<div class="container mx-auto py-4 px-4">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl md:text-2xl font-bold">Keranjang</h2>
        <a href="/" class="text-sm md:text-lg font-bold">Home</a>
    </div>

    <div class="bg-white shadow-md rounded-lg p-4" wire:poll wire:listen="cartCleared -> loadCart">
        @if (count($cartItems) === 0)
            <p class="text-gray-600 text-sm md:text-base">Keranjang Masih Kosong</p>
        @else
            <ul>
                @foreach ($cartItems as $item)
                    <li class="flex flex-col md:flex-row justify-between items-center mb-4">
                        <div class="flex items-center mb-2 md:mb-0">
                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-16 h-16 object-cover rounded mr-4">
                            <span class="text-sm md:text-base">{{ $item->product->name }} (x{{ $item->quantity }})</span>
                        </div>
                        <div class="flex items-center">
                            <button wire:click="incrementQuantity({{ $item->id }})" class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600 mr-2 text-xs md:text-sm">
                                +
                            </button>
                            <span class="mx-4 text-sm md:text-base">Rp {{ number_format($item->total_price, 0, ',', '.') }}</span>
                            <button wire:click="removeFromCart({{ $item->id }})" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 text-xs md:text-sm">
                                -
                            </button>
                        </div>
                    </li>
                @endforeach
            </ul>
            <hr class="my-4">
            <div class="flex justify-between items-center">
                <span class="font-bold text-sm md:text-base">Total:</span>
                <span class="font-bold text-sm md:text-base">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
            </div>
            <div class="mt-4 text-center">
                @if (\App\Models\Store::first()?->phone)
                    <button
                        wire:click="checkout"
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-300">
                        Checkout via WhatsApp
                    </button>
                @else
                    <p class="text-red-500 text-sm">Nomor WhatsApp toko belum tersedia.</p>
                @endif
            </div>
        @endif
    </div>
</div>

<script>
    Livewire.on('openWhatsApp', url => {
        window.open(url, '_blank'); // Buka WhatsApp di tab baru
    });

    Livewire.on('cartCleared', () => {
        alert('Checkout berhasil! Keranjang kosong.');
    });
</script>
