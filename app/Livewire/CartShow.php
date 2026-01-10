<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class CartShow extends Component
{
    protected $listeners = ['cart-updated' => '$refresh'];

    public function removeItem(int $itemId): void
    {
        $user = Auth::user();
        if (!$user) return;

        $cart = $user->cart;
        if (!$cart) return;

        $cart->items()->where('id', $itemId)->limit(1)->delete();

        $this->dispatch('cart-updated');
        session()->flash('success', 'Item removed.');
    }

    public function increaseQty(int $itemId): void
    {
        $user = Auth::user();
        if (!$user) return;

        $cart = $user->cart()->with('items.product')->first();
        if (!$cart) return;

        $item = $cart->items->firstWhere('id', $itemId);
        if (!$item) return;

        if ($item->quantity >= $item->product->stock_quantity) {
            session()->flash('error', 'Not enough stock.');
            return;
        }

        $item->increment('quantity');

        $this->dispatch('cart-updated');
    }

    public function decreaseQty(int $itemId): void
    {
        $user = Auth::user();
        if (!$user) return;

        $cart = $user->cart()->with('items.product')->first();
        if (!$cart) return;

        $item = $cart->items->firstWhere('id', $itemId);
        if (!$item) return;

        if ($item->quantity <= 1) {
            $item->delete();
        } else {
            $item->decrement('quantity');
        }

        $this->dispatch('cart-updated');
    }

    public function render()
    {
        $cart = Auth::user()
            ? Auth::user()->cart()->with('items.product')->first()
            : null;

        $total = 0;
        if ($cart && $cart->items) {
            foreach ($cart->items as $item) {
                $total += ($item->product->price * $item->quantity);
            }
        }

        return view('livewire.cart-show', [
            'cart' => $cart,
            'total' => $total,
        ]);
    }
}
