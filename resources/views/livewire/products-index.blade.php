<div class="max-w-6xl mx-auto p-6">

    {{-- HEADER --}}
    <div class="flex items-center justify-between mb-6">

        <h1 class="text-3xl font-bold">🛒 Products</h1>

        <div class="flex items-center gap-4">
            <a href="/cart"
               class="px-4 py-2 rounded bg-black text-white hover:bg-gray-800">
                View cart
            </a>

            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        type="submit"
                        class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700"
                    >
                        Logout
                    </button>
                </form>
            @else
                <a href="/login"
                   class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300">
                    Login
                </a>

                <a href="/register"
                   class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300">
                    Register
                </a>
            @endauth
        </div>

    </div>

    {{-- SUCCESS --}}
    @if (session('success'))
        <div class="mb-4 p-3 rounded bg-green-100 text-green-800">
            {{ session('success') }}
        </div>
    @endif

    {{-- ERROR --}}
    @if (session('error'))
        <div class="mb-4 p-3 rounded bg-red-100 text-red-800">
            {{ session('error') }}
        </div>
    @endif

    {{-- PRODUCTS GRID --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($products as $product)
            <div class="border rounded-lg p-4 shadow bg-white flex flex-col">

                <h2 class="text-xl font-semibold">
                    {{ $product->name }}
                </h2>

                <p class="text-gray-600 mt-2 flex-grow">
                    {{ $product->description }}
                </p>

                <p class="mt-3 font-bold">
                    {{ number_format($product->price, 0) }} RSD
                </p>

                <p class="text-sm text-gray-500 mb-2">
                    In stock: {{ $product->stock_quantity }}
                </p>

                @if($product->stock_quantity > 0)
                    <button
                        wire:click="addToCart({{ $product->id }})"
                        class="mt-3 w-full bg-black text-white py-2 rounded hover:bg-gray-800 transition"
                    >
                        Add to cart
                    </button>
                @else
                    <button
                        disabled
                        class="mt-3 w-full bg-gray-300 text-gray-600 py-2 rounded cursor-not-allowed"
                    >
                        Out of stock
                    </button>
                @endif

            </div>
        @endforeach
    </div>

</div>
