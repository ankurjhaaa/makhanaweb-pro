<?php

namespace App\Livewire\Public;

use App\Models\Address;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app')]
class Checkout extends Component
{
    // Cart data (from session/database)
    public $cartItems = [];
    public $subtotal = 0;
    public $shippingCost = 0;
    public $tax = 0;
    public $total = 0;
    public $couponDiscount = 0;

    // Billing Address
    public $billing_address_line1 = '';
    public $billing_address_line2 = '';
    public $billing_city = '';
    public $billing_state = '';
    public $billing_country = 'India';
    public $billing_postal_code = '';
    public $billing_phone = '';

    // Shipping Address
    public $same_as_billing = true;
    public $shipping_address_line1 = '';
    public $shipping_address_line2 = '';
    public $shipping_city = '';
    public $shipping_state = '';
    public $shipping_country = 'India';
    public $shipping_postal_code = '';
    public $shipping_phone = '';

    // Contact Information
    public $email = '';
    public $first_name = '';
    public $last_name = '';

    // Payment
    public $payment_method = 'cod'; // cod, card, upi
    public $card_number = '';
    public $card_expiry = '';
    public $card_cvv = '';
    public $card_name = '';
    public $upi_id = '';

    // Order notes
    public $order_notes = '';

    // couponApplied
    public $couponApplied = '';
    public $couponError = '';
    public $couponCode = '';
    public $coupon_id = '';

    // Validation rules
    protected $rules = [
        'email' => 'required|email',
        'first_name' => 'required|min:2',
        'last_name' => 'required|min:2',
        'billing_address_line1' => 'required|min:5',
        'billing_city' => 'required|min:2',
        'billing_state' => 'required|min:2',
        'billing_country' => 'required',
        'billing_postal_code' => 'required|min:5|max:10',
        'billing_phone' => 'required|min:10|max:15',
        'payment_method' => 'required|in:cod,online',
    ];

    protected $messages = [
        'billing_address_line1.required' => 'Address is required',
        'billing_address_line1.min' => 'Address must be at least 5 characters',
        'billing_phone.required' => 'Phone number is required',
        'billing_phone.min' => 'Phone number must be at least 10 digits',
    ];

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
    public function mount()
    {

        $this->loadCartData();


        if (Auth::check()) {
            $user = Auth::user();
            $this->email = $user->email;
            $this->first_name = $user->first_name ?? '';
            $this->last_name = $user->last_name ?? '';
        }
    }

    private function loadCartData()
    {
        $this->cartItems = CartItem::where('user_id', Auth::id())
            ->with('product')
            ->get();
        $this->calculateTotals();
    }

    private function calculateTotals()
    {
        $this->subtotal = 0;

        foreach ($this->cartItems as $item) {
            $this->subtotal += $item['price'] * $item['quantity'];
        }

        // Sample shipping cost calculation
        $this->shippingCost = $this->subtotal > 999 ? 0 : 49;

        // Sample tax calculation (5% GST)
        $this->tax = round($this->subtotal * 0.05, 2);

        // Calculate final total
        $this->total = $this->subtotal + $this->shippingCost + $this->tax - $this->couponDiscount;
    }

    public function updatedSameAsBilling($value)
    {
        if ($value) {
            $this->shipping_address_line1 = $this->billing_address_line1;
            $this->shipping_address_line2 = $this->billing_address_line2;
            $this->shipping_city = $this->billing_city;
            $this->shipping_state = $this->billing_state;
            $this->shipping_country = $this->billing_country;
            $this->shipping_postal_code = $this->billing_postal_code;
            $this->shipping_phone = $this->billing_phone;
        } else {
            $this->shipping_address_line1 = '';
            $this->shipping_address_line2 = '';
            $this->shipping_city = '';
            $this->shipping_state = '';
            $this->shipping_country = 'India';
            $this->shipping_postal_code = '';
            $this->shipping_phone = '';
        }
    }

    public function updatedPaymentMethod($value)
    {

        $this->card_number = '';
        $this->card_expiry = '';
        $this->card_cvv = '';
        $this->card_name = '';
        $this->upi_id = '';
    }

    public function validateStep($step)
    {
        switch ($step) {
            case 'contact':
                $this->validateOnly('email');
                $this->validateOnly('first_name');
                $this->validateOnly('last_name');
                break;
            case 'billing':
                $this->validateOnly('billing_address_line1');
                $this->validateOnly('billing_city');
                $this->validateOnly('billing_state');
                $this->validateOnly('billing_country');
                $this->validateOnly('billing_postal_code');
                $this->validateOnly('billing_phone');
                break;
        }
    }

    public function placeOrder()
    {
        if (!Auth::check()) {
            session()->flash('error', 'Please login to place an order.');
            return redirect()->route('login');
        }



        $this->validate();

        // dd($this->payment_method);
        if (!$this->same_as_billing) {
            $this->validate([
                'shipping_address_line1' => 'required|min:5',
                'shipping_city' => 'required|min:2',
                'shipping_state' => 'required|min:2',
                'shipping_country' => 'required',
                'shipping_postal_code' => 'required|min:5|max:10',
                'shipping_phone' => 'required|min:10|max:15',
            ]);
        }
        if ($this->payment_method === 'cod') {
            // Billing & Shipping Address
            $billing_address = Address::create([
                'user_id' => Auth::id(),
                'type' => 'billing',
                'address_line1' => $this->billing_address_line1,
                'address_line2' => $this->billing_address_line2,
                'city' => $this->billing_city,
                'state' => $this->billing_state,
                'country' => $this->billing_country,
                'postal_code' => $this->billing_postal_code,
                'phone' => $this->billing_phone,
            ]);

            $shipping_address = Address::create([
                'user_id' => Auth::id(),
                'type' => 'shipping',
                'address_line1' => $this->shipping_address_line1 ?: $this->billing_address_line1,
                'address_line2' => $this->shipping_address_line2 ?: $this->billing_address_line2,
                'city' => $this->shipping_city ?: $this->billing_city,
                'state' => $this->shipping_state ?: $this->billing_state,
                'country' => $this->shipping_country ?: $this->billing_country,
                'postal_code' => $this->shipping_postal_code ?: $this->billing_postal_code,
                'phone' => $this->shipping_phone ?: $this->billing_phone,
            ]);

            $coupondetail = Coupon::where('code', $this->couponCode)->first();
            $coupon_id = $coupondetail->id ?? null;

            // Status depending on payment method
            $status = $this->payment_method === 'cod' ? 'success' : 'pending';

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'coupon_id' => $coupon_id ?? null,
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'subtotal' => $this->subtotal,
                'shipping_cost' => $this->shippingCost,
                'tax' => $this->tax,
                'discount' => $this->couponDiscount,
                'total_amount' => $this->total,
                'billing_address_id' => $billing_address->id,
                'shipping_address_id' => $shipping_address->id,
                'payment_method' => $this->payment_method,
                $status = $this->payment_method === 'cod' ? 'completed' : 'pending'
            ]);

            // Move cart items
            $cartItems = CartItem::where('user_id', Auth::id())->get();
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->price,
                    'subtotal' => $item->price * $item->quantity,
                ]);

                $product = Product::findOrFail($item->product_id);
                $product->stock -= $item->quantity;
                $product->save();
            }

            // Clear cart

            CartItem::where('user_id', Auth::id())->delete();
            session()->flash('success', 'Order placed successfully!');
            return $this->redirectRoute('order.success');

        }
    }
    public function placeOnline()
    {
        if (!Auth::check()) {
            session()->flash('error', 'Please login to place an order.');
            return redirect()->route('login');
        }
        $this->validate();

        // dd($this->payment_method);
        if (!$this->same_as_billing) {
            $this->validate([
                'shipping_address_line1' => 'required|min:5',
                'shipping_city' => 'required|min:2',
                'shipping_state' => 'required|min:2',
                'shipping_country' => 'required',
                'shipping_postal_code' => 'required|min:5|max:10',
                'shipping_phone' => 'required|min:10|max:15',
            ]);
        }
        if ($this->payment_method === 'online') {
            // Billing & Shipping Address
            $billing_address = Address::create([
                'user_id' => Auth::id(),
                'type' => 'billing',
                'address_line1' => $this->billing_address_line1,
                'address_line2' => $this->billing_address_line2,
                'city' => $this->billing_city,
                'state' => $this->billing_state,
                'country' => $this->billing_country,
                'postal_code' => $this->billing_postal_code,
                'phone' => $this->billing_phone,
            ]);

            $shipping_address = Address::create([
                'user_id' => Auth::id(),
                'type' => 'shipping',
                'address_line1' => $this->shipping_address_line1 ?: $this->billing_address_line1,
                'address_line2' => $this->shipping_address_line2 ?: $this->billing_address_line2,
                'city' => $this->shipping_city ?: $this->billing_city,
                'state' => $this->shipping_state ?: $this->billing_state,
                'country' => $this->shipping_country ?: $this->billing_country,
                'postal_code' => $this->shipping_postal_code ?: $this->billing_postal_code,
                'phone' => $this->shipping_phone ?: $this->billing_phone,
            ]);

            $coupondetail = Coupon::where('code', $this->couponCode)->first();
            $coupon_id = $coupondetail->id ?? null;

            // Status depending on payment method
            $status = 'pending';

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'coupon_id' => $coupon_id ?? null,
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'subtotal' => $this->subtotal,
                'shipping_cost' => $this->shippingCost,
                'tax' => $this->tax,
                'discount' => $this->couponDiscount,
                'total_amount' => $this->total,
                'billing_address_id' => $billing_address->id,
                'shipping_address_id' => $shipping_address->id,
                'payment_method' => $this->payment_method,
                $status = $this->payment_method === 'online' ? 'completed' : 'pending'
            ]);

            // Move cart items
            $cartItems = CartItem::where('user_id', Auth::id())->get();
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->price,
                    'subtotal' => $item->price * $item->quantity,
                ]);

                $product = Product::findOrFail($item->product_id);
                $product->stock -= $item->quantity;
                $product->save();
            }

            // Clear cart

            CartItem::where('user_id', Auth::id())->delete();
            return redirect()->route('payment.online',$order->id);
            

        }


    }

    public function render()
    {
        return view('livewire.public.checkout');
    }
}
