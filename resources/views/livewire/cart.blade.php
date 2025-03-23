<div class="bg-white shadow-md rounded-lg p-4" wire:poll.keep-alive wire:listen="cartCleared -> loadCart">
    <!-- Keranjang kosong -->
    @if (count($cartItems) === 0)
        <p class="text-gray-600 text-sm md:text-base">Keranjang Masih Kosong</p>
    @else
        <ul>
            @foreach ($cartItems as $item)
                <li class="flex flex-col md:flex-row justify-between items-center mb-4">
                    <div class="flex items-center mb-2 md:mb-0">
                        <img src="{{ asset('storage/' . $item->product->image) }}"
                            alt="{{ $item->product->name }}" class="w-16 h-16 object-cover rounded mr-4">
                        <span class="text-sm md:text-base">{{ $item->product->name }} (x{{ $item->quantity }})</span>
                    </div>
                    <div class="flex items-center">
                        <button wire:click="incrementQuantity({{ $item->id }})"
                            class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600 mr-2 text-xs md:text-sm">
                            +
                        </button>
                        <span class="mx-4 text-sm md:text-base">
                            Rp {{ number_format($item->total_price, 0, ',', '.') }}
                        </span>
                        <button wire:click="removeFromCart({{ $item->id }})"
                            class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 text-xs md:text-sm">
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
                <button wire:click="checkout"
                    id="checkoutBtn"
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-300"
                    wire:loading.attr="disabled"
                    wire:target="checkout">
                    Checkout via WhatsApp
                </button>

                <!-- Loader hanya muncul saat checkout -->
                <div wire:loading wire:target="checkout">
                    <div class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50">
                        <div class="bg-white rounded-lg shadow-lg p-6 text-center">
                            <p class="text-gray-700 text-sm mb-4">Memproses checkout...</p>
                            <div class="border-t-4 border-blue-500 rounded-full w-8 h-8 mx-auto animate-spin"></div>
                        </div>
                    </div>
                </div>
            @else
                <p class="text-red-500 text-sm">Nomor WhatsApp toko belum tersedia.</p>
            @endif
        </div>
    @endif
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        Livewire.on('openWhatsApp', url => {
            console.log("🚀 Redirecting to:", url);
            window.open(url, '_blank'); // Buka di tab baru
        });

        Livewire.on('cartCleared', () => {
            alert('✅ Checkout berhasil!');
            setTimeout(() => {
                window.location.href = "/"; // Redirect ke halaman utama
            }, 1000);
        });
    });
</script>
