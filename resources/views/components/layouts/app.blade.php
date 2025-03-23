<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Online</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Alpine.js untuk interaksi real-time -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> <!-- Fallback for CSS -->
    <script src="{{ asset('js/app.js') }}" defer></script> <!-- Fallback for JS -->
    @livewireStyles
</head>
<body>

    {{-- <header class="relative">
        @php
            $store = \App\Models\Store::first();
        @endphp
        @if ($store && $store->image)
            <img src="{{ asset('storage/' . $store->image) }}" alt="Store Banner" class="w-full h-64 object-fill">
        @else
            <div class="w-full h-64 bg-gray-300 flex items-center justify-center">
                <p class="text-gray-700 text-lg">No Banner Available</p>
            </div>
        @endif
    </header> --}}

    <main>
        {{ $slot }}
    </main>

    <footer class="bottom-0">
        <p class="text-center text-gray-500 text-sm">
            &copy; 2025 IDNACODE. All rights reserved.
        </p>
    </footer>

    @livewireScripts
</body>
</html>
