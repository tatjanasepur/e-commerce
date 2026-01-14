<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Order;
use App\Models\OrderItem;
use App\Jobs\SendLowStockNotificationJob;

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

    public function placeOrder()
    {
        $user = Auth::user();
        if (!$user) return;

        $cart = $user->cart()->with('items.product')->first();

        if (!$cart || $cart->items->isEmpty()) {
            session()->flash('error', 'Cart is empty.');
            return;
        }

        try {
            $order = DB::transaction(function () use ($user, $cart) {

                foreach ($cart->items as $item) {
                    $product = $item->product;
                    if (!$product) {
                        throw new \Exception("Product not found for cart item.");
                    }
                    if ($item->quantity > $product->stock_quantity) {
                        throw new \Exception("Not enough stock for: {$product->name}");
                    }
                }

                $total = 0;
                foreach ($cart->items as $item) {
                    $total += ($item->product->price * $item->quantity);
                }

                $order = Order::create([
                    'user_id' => $user->id,
                    'total_amount' => $total,
                    'status' => 'paid', 
                ]);

                $threshold = (int) config('shop.low_stock_threshold', 5);

                foreach ($cart->items as $item) {
                    $product = $item->product;

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'product_name' => $product->name,   
                        'price' => $product->price,         
                        'quantity' => $item->quantity,
                        'line_total' => $product->price * $item->quantity,
                    ]);

                    $product->decrement('stock_quantity', $item->quantity);

                    $product->refresh();
                    if ($product->stock_quantity <= $threshold) {
                        SendLowStockNotificationJob::dispatch($product->id);
                    }
                }

                $cart->items()->delete();

                return $order;
            });

            session()->flash('success', 'Order placed!');
            return redirect("/order/success/{$order->id}");

        } catch (\Throwable $e) {
            session()->flash('error', $e->getMessage());
            return;
        }
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
