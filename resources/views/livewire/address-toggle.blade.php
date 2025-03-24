<div class="mt-2">

    @if (!$showFullAddress && $isLong)
        <p class="lg:text-2xl text-sm text-gray-500 inline">
            {{ Str::limit($address, 50, '...') }}
            <button wire:click="toggleAddress" class="text-blue-500 hover:underline cursor-pointer ml-1">
                Show More
            </button>
        </p>
    @else
        <p class="lg:text-2xl text-sm text-gray-500">
            {{ $address }}
            @if ($isLong)
                <button wire:click="toggleAddress" class="text-blue-500 hover:underline cursor-pointer ml-1">
                    Show Less
                </button>
            @endif
        </p>
    @endif
</div>
