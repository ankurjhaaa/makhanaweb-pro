<?php

namespace App\Livewire\Public;

use App\Models\Coupon;
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



public function addToCart($productId)
{
    // Check if user is logged in
    if (!Auth::check()) {
        // Agar login nahi hai → login page par bhej do
        return redirect()->route('login')->with('error', 'Please login to add items to cart.');
    }

    // Get product from DB
    $product = \App\Models\Product::find($productId);

    if (!$product) {
        return;
    }

    // Load current cart from session
    $cart = session()->get('cart', []);

    if (isset($cart[$productId])) {
        $cart[$productId]['quantity']++;
    } else {
        $cart[$productId] = [
            'id' => $product->id,
            'name' => $product->name,
            'image' => $product->image,
            'price' => $product->price,
            'originalPrice' => $product->original_price ?? $product->price,
            'quantity' => 1,
            'category' => $product->category->name ?? 'General',
            'weight' => $product->weight ?? '',
        ];
    }

    // Save cart to session
    session()->put('cart', $cart);

    // Update local cart
    $this->cartItems = $cart;
    $this->calculateTotals();

    return redirect()->route('cart');
}



   public function mount()
{
    if (request()->has('add')) {
        $this->addToCart(request()->get('add'));
    } else {
        $this->cartItems = session()->get('cart', []);
        $this->calculateTotals();
    }
}

    
    public function calculateTotals()
    {
        $this->subtotal = 0;
        $count = 0;
        
        foreach ($this->cartItems as $item) {
            $this->subtotal += $item['price'] * $item['quantity'];
            $count += isset($item['quantity']) ? (int)$item['quantity'] : 1;
        }
        
        // Sample shipping cost calculation
        $this->shippingCost = $this->subtotal > 999 ? 0 : 49;
        
        // Sample tax calculation (5% GST)
        $this->tax = round($this->subtotal * 0.05, 2);
        
        // Calculate final total
        $this->total = $this->subtotal + $this->shippingCost + $this->tax - $this->couponDiscount;

        // Persist cart item count in session so header can display it
        try {
            session()->put('cart_count', $count);
            // Emit event so Livewire header components can update in real-time
            $this->dispatch('cartUpdated', $count);
        } catch (\Exception $e) {
            // ignore when session is not available (e.g., in tests)
        }
    }
    
   public function updateQuantity($productId, $newQuantity)
{
    $cart = session()->get('cart', []);

    if (isset($cart[$productId])) {
        $cart[$productId]['quantity'] = max(1, (int) $newQuantity);
        session()->put('cart', $cart);
        $this->cartItems = $cart;
    }

    $this->calculateTotals();
}

    
  public function removeItem($productId)
{
    $cart = session()->get('cart', []);

    if (isset($cart[$productId])) {
        unset($cart[$productId]);
        session()->put('cart', $cart);
        $this->cartItems = $cart;
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

    // Check status
    if ($coupon->status !== 'active') {
        $this->couponError = 'This coupon is inactive';
        return;
    }

    // Check validity dates
    $today = Carbon::today();
    if (($coupon->valid_from && $today->lt(Carbon::parse($coupon->valid_from))) ||
        ($coupon->valid_until && $today->gt(Carbon::parse($coupon->valid_until)))) {
        $this->couponError = 'This coupon is expired or not yet valid';
        return;
    }

    // Check minimum order amount
    if ($coupon->min_order_amount && $this->subtotal < $coupon->min_order_amount) {
        $this->couponError = "Minimum order ₹{$coupon->min_order_amount} required for this coupon";
        return;
    }

    // Calculate discount
    if ($coupon->discount_type === 'percentage') {
        $discount = round($this->subtotal * ($coupon->discount_value / 100), 2);
        if ($coupon->max_discount_amount) {
            $discount = min($discount, $coupon->max_discount_amount);
        }
    } else { // fixed
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
        // In a real app, redirect to checkout page or process
        return redirect()->to('/checkout');
    }

    public function render()
    {
        return view('livewire.public.cart');
    }
}
