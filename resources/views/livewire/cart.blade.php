<div class="container mx-auto py-4 px-4">
    <div class="container mx-auto py-4 px-4">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl md:text-2xl font-bold">Keranjang</h2>
            <a href="/" class="text-gray-700 hover:text-gray-900 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 md:w-7 md:h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
        </div>


    <div class="bg-white shadow-md rounded-lg p-4" wire:poll.keep-alive wire:listen="cartCleared -> loadCart">
        @if (count($cartItems) === 0)
            <p class="text-gray-600 text-sm md:text-base text-center">Keranjang masih kosong</p>
        @else
            <ul class="space-y-4">
                @foreach ($cartItems as $item)
                    <li class="flex flex-col md:flex-row items-center justify-between bg-gray-100 p-3 rounded-lg">

                        <div class="flex items-center gap-3 w-full md:w-2/3">
                            <img src="{{ asset('storage/' . $item->product->image) }}"
                                alt="{{ $item->product->name }}"
                                class="w-16 h-16 md:w-20 md:h-20 object-cover rounded-lg">
                            <span class="text-sm md:text-base font-medium">{{ $item->product->name }} (x{{ $item->quantity }})</span>
                        </div>


                        <div class="flex items-center gap-2 md:gap-4 mt-3 md:mt-0">
                            <button wire:click="removeFromCart({{ $item->id }})"
                                class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 text-xs md:text-sm">
                                -
                            </button>
                            <span class="text-sm md:text-base font-bold">Rp {{ number_format($item->total_price, 0, ',', '.') }}</span>
                            <button wire:click="incrementQuantity({{ $item->id }})"
                                class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600 text-xs md:text-sm">
                                +
                            </button>
                        </div>
                    </li>
                @endforeach
            </ul>


            <div class="mt-4 flex justify-between items-center text-lg font-bold border-t pt-3">
                <span>Total:</span>
                <span>Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
            </div>


            <div class="mt-4 text-center">
                @if (\App\Models\Store::first()?->phone)
                    <button wire:click="checkout"
                        id="checkoutBtn"
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-300 w-full md:w-auto"
                        wire:loading.attr="disabled"
                        wire:target="checkout">
                        Checkout via WhatsApp
                    </button>


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
