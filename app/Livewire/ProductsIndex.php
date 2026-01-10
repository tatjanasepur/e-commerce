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
            return; // safety (middleware already protects)
        }

        $product = Product::findOrFail($productId);

        // Create cart if missing
        $cart = $user->cart()->firstOrCreate([]);

        // Find existing item for this product
        $item = $cart->items()->where('product_id', $productId)->first();

        // Current quantity in cart
        $currentQty = $item ? $item->quantity : 0;

        // Stock check
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
        ]);
    }
}
