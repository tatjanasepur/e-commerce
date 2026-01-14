<div class="max-w-5xl mx-auto p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold">🛒 Your Cart</h1>
        <a href="/products" class="text-sm underline">← Back to products</a>
    </div>

    @if (session('success'))
        <div class="mb-4 p-3 rounded bg-green-100 text-green-800">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 p-3 rounded bg-red-100 text-red-800">
            {{ session('error') }}
        </div>
    @endif

    @if(!$cart || $cart->items->isEmpty())
        <div class="border rounded-lg p-6 bg-white">
            <p class="text-gray-600">Cart is empty.</p>
        </div>
    @else
        <div class="space-y-4">
            @foreach($cart->items as $item)
                <div class="border rounded-lg p-4 bg-white flex items-center justify-between">
                    <div>
                        <div class="font-semibold">{{ $item->product->name }}</div>
                        <div class="text-sm text-gray-500">
                            {{ number_format($item->product->price, 0) }} RSD
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <button
                            wire:click="decreaseQty({{ $item->id }})"
                            class="px-3 py-2 rounded bg-gray-200 hover:bg-gray-300"
                            title="Decrease"
                        >
                            −
                        </button>

                        <div class="min-w-[40px] text-center font-semibold">
                            {{ $item->quantity }}
                        </div>

                        <button
                            wire:click="increaseQty({{ $item->id }})"
                            class="px-3 py-2 rounded bg-gray-200 hover:bg-gray-300"
                            title="Increase"
                        >
                            +
                        </button>

                        <button
                            wire:click="removeItem({{ $item->id }})"
                            class="ml-2 px-3 py-2 rounded bg-red-600 text-white hover:bg-red-700"
                        >
                            Remove
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6 flex items-center justify-between gap-4">
            <div class="text-lg font-bold">
                Total: {{ number_format($total, 0) }} RSD
            </div>

            <button
                wire:click="placeOrder"
                class="px-5 py-3 rounded bg-black text-white hover:bg-gray-800 transition"
            >
                Place order
            </button>
        </div>
    @endif
</div>
