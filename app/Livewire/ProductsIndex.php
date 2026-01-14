<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class ProductsIndex extends Component
{
    public function addToCart(int $productId): void
    {
        $user = Auth::user();
        if (!$user) {
            return;
        }

        $product = Product::findOrFail($productId);

        $cart = $user->cart()->firstOrCreate([]);

        $item = $cart->items()->where('product_id', $productId)->first();
        $currentQty = $item ? $item->quantity : 0;

        if ($currentQty >= $product->stock_quantity) {
            session()->flash('error', 'Not enough stock.');
            return;
        }

        if ($item) {
            $item->increment('quantity');
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $productId,
                'quantity' => 1,
            ]);
        }

        $this->dispatch('cart-updated');
        session()->flash('success', 'Added to cart.');
    }

    public function render()
    {
        return view('livewire.products-index', [
            'products' => Product::orderBy('name')->get(),
        ])->layout('components.layouts.app'); // OVO JE FIX
    }
}
