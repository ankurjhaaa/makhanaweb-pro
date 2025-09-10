<?php

namespace App\Livewire\Public;

use App\Models\Address;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
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
        'payment_method' => 'required|in:cod,card,upi',
    ];

    protected $messages = [
        'billing_address_line1.required' => 'Address is required',
        'billing_address_line1.min' => 'Address must be at least 5 characters',
        'billing_phone.required' => 'Phone number is required',
        'billing_phone.min' => 'Phone number must be at least 10 digits',
    ];

    public function mount()
    {
        // Load cart data (in real app, from session/database)
        $this->loadCartData();

        // Pre-fill user data if authenticated
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
        // Clear payment fields when method changes
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
        $this->validate();

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
        if ($this->shipping_address_line1 != null)
            $shipping_address = Address::create([
                'user_id' => Auth::id(),
                'type' => 'shipping',
                'address_line1' => $this->shipping_address_line1,
                'address_line2' => $this->shipping_address_line2,
                'city' => $this->shipping_city,
                'state' => $this->shipping_state,
                'country' => $this->shipping_country,
                'postal_code' => $this->shipping_postal_code,
                'phone' => $this->shipping_phone,
            ]);
        else


            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'subtotal' => $this->subtotal,
                'shipping_cost' => $this->shippingCost,
                'tax' => $this->tax,
                'discount' => $this->couponDiscount,
                'total_amount' => $this->total,
                'shipping_address_id' => $billing_address->id,
                'billing_address_id' => $shipping_address->id ?? $billing_address->id,
                'payment_method' => $this->payment_method,
                'status' => 'pending',

            ]);

        $cartItems = CartItem::where('user_id', Auth::id())->get();
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'unit_price' => $item->price,
                'subtotal' => $item->price * $item->quantity,
            ]);
        }
        CartItem::where('user_id', Auth::id())->delete();


        session()->flash('success', 'Order placed successfully!');
        session()->flash('order_id', $order->id);

        return redirect()->route('order.success');
    }



    public function render()
    {
        return view('livewire.public.checkout');
    }
}
