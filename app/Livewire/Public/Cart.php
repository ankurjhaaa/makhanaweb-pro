<?php

namespace App\Livewire\Public;

use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Cart extends Component
{
    public $cartItems = [];
    public $subtotal = 0;
    public $shippingCost = 0;
    public $tax = 0;
    public $total = 0;
    public $couponCode = '';
    public $couponDiscount = 0;
    public $couponApplied = false;
    public $couponError = '';


    public function addToCart($productId, $redirect = true)
    {
        $product = Product::find($productId);
        if (!$product)
            return;

        if (!Auth::check()) {
            $cart = session()->get('cart', []);
            if (isset($cart[$productId])) {
                $cart[$productId]['quantity']++;
            } else {
                $cart[$productId] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'image' => $product->image,
                    'price' => $product->price,
                    'quantity' => 1,
                ];
            }
            session()->put('cart', $cart);
            $this->cartItems = $cart;
        } else {
            $cartItem = CartItem::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->first();

            if ($cartItem) {
                $cartItem->quantity++;
                $cartItem->save();
            } else {
               CartItem::create([
                    'user_id' => Auth::id(),
                    'product_id' => $product->id,
                    'quantity' => 1,
                    'price' => $product->price,
                    'total' => $product->price,
                ]);
            }

            $this->cartItems =CartItem::where('user_id', Auth::id())
                ->with('product')
                ->get()
                ->toArray();
        }

        $this->calculateTotals();

        if ($redirect) {
            return redirect()->route('cart');
        }
    }



    public function mount()
    {

        if (request()->has('add')) {
            $this->addToCart(request()->get('add'));
        }


        if (Auth::check()) {

            $sessionCart = session()->get('cart', []);
            if (!empty($sessionCart)) {
                foreach ($sessionCart as $productId => $item) {
                    $cartItem = CartItem::where('user_id', Auth::id())
                        ->where('product_id', $productId)
                        ->first();

                    if ($cartItem) {

                        $cartItem->quantity += $item['quantity'];
                        $cartItem->total = $cartItem->quantity * $cartItem->price;
                        $cartItem->save();
                    } else {

                        CartItem::create([
                            'user_id' => Auth::id(),
                            'product_id' => $item['id'],
                            'quantity' => $item['quantity'],
                            'price' => $item['price'],
                            'total' => $item['price'] * $item['quantity'],
                        ]);
                    }
                }


                session()->forget('cart');
            }


            $this->cartItems = CartItem::with('product.category')
                ->where('user_id', Auth::id())
                ->get();
        } else {

            $this->cartItems = session()->get('cart', []);
        }


        $this->calculateTotals();
    }




    public function calculateTotals()
    {
        $this->subtotal = 0;
        $count = 0;

        foreach ($this->cartItems as $item) {

            $price = $item['price'] ?? ($item['product']['price'] ?? 0);
            $quantity = $item['quantity'] ?? 1;

            $this->subtotal += $price * $quantity;
            $count += $quantity;
        }

        $this->shippingCost = $this->subtotal > 999 ? 0 : 49;
        $this->tax = round($this->subtotal * 0.05, 2);
        $this->total = $this->subtotal + $this->shippingCost + $this->tax - $this->couponDiscount;

        try {
            session()->put('cart_count', $count);
            $this->dispatch('cartUpdated', $count);
        } catch (\Exception $e) {
        }
    }


    public function updateQuantity($productId, $newQuantity)
    {
        $newQuantity = max(1, (int) $newQuantity);

        if (!Auth::check()) {
            $cart = session()->get('cart', []);
            if (isset($cart[$productId])) {
                $cart[$productId]['quantity'] = $newQuantity;
                session()->put('cart', $cart);
                $this->cartItems = $cart;
            }
        } else {
            $cartItem = CartItem::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->first();

            if ($cartItem) {
                $cartItem->quantity = $newQuantity;
                $cartItem->total = $cartItem->quantity * $cartItem->price;
                $cartItem->save();
            }

            $this->cartItems = CartItem::where('user_id', Auth::id())
                ->with('product')
                ->get()
                ->toArray();
        }

        $this->calculateTotals();
    }


    public function removeItem($productId)
    {
        if (!Auth::check()) {
            $cart = session()->get('cart', []);
            if (isset($cart[$productId])) {
                unset($cart[$productId]);
                session()->put('cart', $cart);
                $this->cartItems = $cart;
            }
        } else {
            CartItem::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->delete();

            $this->cartItems = CartItem::where('user_id', Auth::id())
                ->with('product')
                ->get()
                ->toArray();
        }

        $this->calculateTotals();
    }


    public function applyCoupon()
    {
        $code = strtoupper(trim($this->couponCode));
        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon) {
            $this->couponError = 'Invalid coupon code';
            $this->couponApplied = false;
            $this->couponDiscount = 0;
            return;
        }

        if ($coupon->status !== 'active') {
            $this->couponError = 'This coupon is inactive';
            return;
        }

        $today = Carbon::today();
        if (
            ($coupon->valid_from && $today->lt(Carbon::parse($coupon->valid_from))) ||
            ($coupon->valid_until && $today->gt(Carbon::parse($coupon->valid_until)))
        ) {
            $this->couponError = 'This coupon is expired or not yet valid';
            return;
        }

        if ($coupon->min_order_amount && $this->subtotal < $coupon->min_order_amount) {
            $this->couponError = "Minimum order ₹{$coupon->min_order_amount} required for this coupon";
            return;
        }

        if ($coupon->discount_type === 'percentage') {
            $discount = round($this->subtotal * ($coupon->discount_value / 100), 2);
            if ($coupon->max_discount_amount) {
                $discount = min($discount, $coupon->max_discount_amount);
            }
        } else {
            $discount = $coupon->discount_value;
        }

        $this->couponDiscount = $discount;
        $this->couponApplied = true;
        $this->couponError = '';

        $this->calculateTotals();
    }

    public function removeCoupon()
    {
        $this->couponCode = '';
        $this->couponDiscount = 0;
        $this->couponApplied = false;
        $this->couponError = '';

        $this->calculateTotals();
    }

    public function checkout()
    {
        return redirect()->to('/checkout');
    }

    public function render()
    {
        if (Auth::check()) {
            $this->cartItems = CartItem::with('product.category')
                ->where('user_id', Auth::id())
                ->get();
        } else {
            $this->cartItems = session()->get('cart', []);
        }

        return view('livewire.public.cart', [
            'cartItems' => $this->cartItems,
        ]);
    }
}
