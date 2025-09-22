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


    public $addresses; // collection of user's saved addresses

    // Selected IDs (radios)
    public $billing_address_id = null;
    public $shipping_address_id = null;

    // Same-as-billing checkbox

    // Controls whether "Add address" form is shown and for which type
    // null | 'billing' | 'shipping'
    public $showAddAddressFor = null;

    // New address form fields (for add address)
    public $new_line1;
    public $new_line2;
    public $new_city;
    public $new_state;
    public $new_postal_code;
    public $new_country = 'India';
    public $new_phone;
    // Validation rules
    protected $rules = [
        'email' => 'required|email',
        'first_name' => 'required|min:2',
        'last_name' => 'required|min:2',
        'payment_method' => 'required|in:cod,online',
        'billing_address_id' => 'required',
        'shipping_address_id' => 'required',


        'new_line1' => 'required|string|max:255',
        'new_city' => 'required|string|max:100',
        'new_state' => 'required|string|max:100',
        'new_postal_code' => 'required|string|max:20',
        'new_country' => 'required|string|max:100',
        'new_phone' => 'required|string|max:30',
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
        //  pehle se jo hai use call rehne do
        $this->loadCartData();
        $this->loadAddresses();
        if (Auth::check()) {
            $user = Auth::user();
            $this->email = $user->email;
            $this->first_name = $user->first_name ?? '';
            $this->last_name = $user->last_name ?? '';

            //  yaha address load karenge
            $this->addresses = Address::where('user_id', $user->id)->get();

            // agar koi address nahi mila to Add Address form dikhana hai
            if ($this->addresses->isEmpty()) {
                $this->showAddAddress = true;
            }

        }


    }


    public function loadAddresses()
    {
        $this->addresses = Address::where('user_id', Auth::id())->orderBy('id', 'desc')->get();
        if ($this->addresses->count() && !$this->billing_address_id) {
            $this->billing_address_id = $this->addresses->first()->id;
        }

        if ($this->addresses->count() && !$this->shipping_address_id) {
            $this->shipping_address_id = $this->addresses->first()->id;
        }

    }





    public function openAddAddress($which)
    {
        // $which = 'billing' or 'shipping'
        $this->resetNewAddressForm();
        $this->showAddAddressFor = $which;
    }

    public function closeAddAddress()
    {
        $this->showAddAddressFor = null;
        $this->resetValidation();
    }

    protected function resetNewAddressForm()
    {
        $this->new_line1 = null;
        $this->new_line2 = null;
        $this->new_city = null;
        $this->new_state = null;
        $this->new_postal_code = null;
        $this->new_country = 'India';
        $this->new_phone = null;
    }

    public function saveNewAddress()
    {
        $this->validate([
            'new_line1' => 'required|string|max:255',
            'new_city' => 'required|string|max:100',
            'new_state' => 'required|string|max:100',
            'new_postal_code' => 'required|string|max:20',
            'new_country' => 'required|string|max:100',
            'new_phone' => 'required|string|max:15',
        ], [
            'new_line1.required' => 'Address Line 1 is required.',
            'new_city.required' => 'City is required.',
            'new_state.required' => 'State is required.',
            'new_postal_code.required' => 'PIN Code is required.',
            'new_country.required' => 'Country is required.',
            'new_phone.required' => 'Phone number is required.',
        ]);

        $address = Address::create([
            'user_id' => Auth::id(),
            'address_line1' => $this->new_line1,
            'address_line2' => $this->new_line2,
            'city' => $this->new_city,
            'state' => $this->new_state,
            'postal_code' => $this->new_postal_code,
            'country' => $this->new_country,
            'phone' => $this->new_phone,
            'type' => 'billing',
        ]);

        $this->loadAddresses();
        $this->closeAddAddress();

        session()->flash('message', 'Address saved.');
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

        $this->validate([
            'billing_address_id' => 'required',
            'shipping_address_id' => 'required',
            'payment_method' => 'required|in:cod,online',
        ]);

        if ($this->payment_method === 'cod') {
            $coupon = Coupon::where('code', $this->couponCode)->first();
            $coupon_id = $coupon->id ?? null;

            // ✅ Create Order
            $order = Order::create([
                'user_id' => Auth::id(),
                'coupon_id' => $coupon_id,
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'subtotal' => $this->subtotal,
                'shipping_cost' => $this->shippingCost,
                'tax' => $this->tax,
                'discount' => $this->couponDiscount,
                'total_amount' => $this->total,
                'billing_address_id' => $this->billing_address_id,
                'shipping_address_id' => $this->shipping_address_id,
                'payment_method' => 'cod',
            ]);

            // ✅ Move Cart Items to Order
            $cartItems = CartItem::where('user_id', Auth::id())->get();
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->price,
                    'subtotal' => $item->price * $item->quantity,
                ]);

                // Reduce stock
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->stock -= $item->quantity;
                    $product->save();
                }
            }

            // ✅ Clear Cart
            CartItem::where('user_id', Auth::id())->delete();

            session()->flash('success', 'Order placed successfully!');
            session()->flash('order_id', $order->order_number);
            return redirect()->route('order.success');
        }

        // Agar online method aaya to abhi ke liye error
        session()->flash('error', 'Only COD available right now.');
        return;
    }

    public function placeOnline()
    {
        if (!Auth::check()) {
            session()->flash('error', 'Please login to place an order.');
            return redirect()->route('login');
        }
        $this->validate([
            'billing_address_id' => 'required',
            'shipping_address_id' => 'required',
            'payment_method' => 'required|in:cod,online',
        ]);

        if ($this->payment_method === 'online') {

            $coupondetail = Coupon::where('code', $this->couponCode)->first();
            $coupon_id = $coupondetail->id ?? null;

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
                'billing_address_id' => $this->billing_address_id,
                'shipping_address_id' => $this->shipping_address_id,
                'payment_method' => $this->payment_method,
                'status' => 'cancelled',
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
            session()->flash('success', 'Order placed successfully!');
            return redirect()->route('payment.online', $order->id);


        }


    }

    public function render()
    {
        return view('livewire.public.checkout');
    }
}
