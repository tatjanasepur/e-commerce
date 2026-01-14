<x-app-layout>
    <div class="max-w-3xl mx-auto p-6">
        <div class="border rounded-lg bg-white p-6 shadow">
            <div class="flex items-start gap-3">
                <div class="text-3xl">✅</div>

                <div class="flex-1">
                    <h1 class="text-2xl font-bold">Order successful</h1>
                    <p class="text-gray-600 mt-1">Your order has been created successfully.</p>

                    <div class="mt-4 text-sm text-gray-700">
                        <span class="font-semibold">Order #</span>{{ $order->id }}
                    </div>

                    <div class="mt-6 border rounded-lg p-4">
                        <div class="font-semibold mb-3">Items</div>

                        <div class="space-y-3">
                            @foreach($order->items as $item)
                                <div class="flex items-center justify-between border-b pb-2 last:border-b-0 last:pb-0">
                                    <div>
                                        <div class="font-medium">{{ $item->product_name }}</div>
                                        <div class="text-sm text-gray-500">
                                            {{ number_format($item->price, 0) }} RSD × {{ $item->quantity }}
                                        </div>
                                    </div>

                                    <div class="font-semibold">
                                        {{ number_format($item->line_total, 0) }} RSD
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-4 flex justify-end text-lg font-bold">
                        Total: {{ number_format($order->total_amount, 0) }} RSD
                    </div>

                    <div class="mt-6">
                        <a href="/products"
                           class="inline-flex items-center px-4 py-2 rounded bg-black text-white hover:bg-gray-800 transition">
                            Back to products
                        </a>

                        <a href="/cart"
                           class="ml-3 inline-flex items-center px-4 py-2 rounded bg-gray-200 hover:bg-gray-300 transition">
                            View cart
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
