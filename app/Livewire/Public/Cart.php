<?php

namespace App\Livewire\Public;

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

    public function mount()
    {
        // In a real application, you would load cart items from session or database
        // Here we're using sample data for demonstration
        $this->cartItems = [
            [
                'id' => 1,
                'name' => 'Premium Makhana',
                'image' => '/images/product1.jpg',
                'price' => 299,
                'originalPrice' => 399,
                'quantity' => 2,
                'category' => 'Makhana',
                'weight' => '200g',
            ],
            [
                'id' => 2,
                'name' => 'Authentic Spice Collection',
                'image' => '/images/product2.jpg',
                'price' => 199,
                'originalPrice' => 249,
                'quantity' => 1,
                'category' => 'Spices',
                'weight' => '150g',
            ],
            [
                'id' => 3,
                'name' => 'Healthy Mix Snacks',
                'image' => '/images/product3.jpg',
                'price' => 349,
                'originalPrice' => 449,
                'quantity' => 1,
                'category' => 'Healthy Snacks',
                'weight' => '250g',
            ],
        ];
        
        $this->calculateTotals();
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
    
    public function updateQuantity($itemId, $newQuantity)
    {
        if ($newQuantity < 1) {
            $newQuantity = 1;
        }
        
        foreach ($this->cartItems as $key => $item) {
            if ($item['id'] == $itemId) {
                $this->cartItems[$key]['quantity'] = $newQuantity;
                break;
            }
        }
        
        $this->calculateTotals();
    }
    
    public function removeItem($itemId)
    {
        foreach ($this->cartItems as $key => $item) {
            if ($item['id'] == $itemId) {
                unset($this->cartItems[$key]);
                $this->cartItems = array_values($this->cartItems);
                break;
            }
        }
        
        $this->calculateTotals();
    }
    
    public function applyCoupon()
    {
        // Sample coupon logic
        if (strtoupper($this->couponCode) === 'WELCOME10') {
            $this->couponDiscount = round($this->subtotal * 0.1, 2); // 10% discount
            $this->couponApplied = true;
            $this->couponError = '';
        } else {
            $this->couponDiscount = 0;
            $this->couponApplied = false;
            $this->couponError = 'Invalid coupon code';
        }
        
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
