<!-- File: resources/views/livewire/public/checkout.blade.php -->
<div class="bg-white text-gray-800">
    <header class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-6">
            <h1 class="font-poppins text-3xl font-bold">Checkout</h1>
            <div class="mt-2 flex items-center text-sm text-gray-500">
                <a href="/" class="hover:text-brand-600 transition-all">Home</a>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <a href="{{ route('cart') }}" class="hover:text-brand-600 transition-all">Cart</a>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span>Checkout</span>
            </div>
        </div>
    </header>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-8 md:py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white border border-gray-100 rounded-lg p-6">
                    <h2 class="font-poppins text-xl font-semibold mb-4">Contact Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">First Name *</label>
                            <input type="text" wire:model.blur="first_name"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-brand-600 focus:ring-1 focus:ring-brand-600"
                                placeholder="Enter first name" disabled>
                            @error('first_name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Last Name *</label>
                            <input type="text" wire:model.blur="last_name"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-brand-600 focus:ring-1 focus:ring-brand-600"
                                placeholder="Enter last name" disabled>
                            @error('last_name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email Address *</label>
                            <input type="email" wire:model.blur="email"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-brand-600 focus:ring-1 focus:ring-brand-600"
                                placeholder="Enter email address" disabled>
                            @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6">
                    <div class="bg-white border border-gray-100 rounded-md p-6">
                        <h2 class="flex font-poppins text-xl font-semibold mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-brand-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 7l1.664 12.428a2 2 0 001.992 1.572h10.688a2 2 0 001.992-1.572L21 7M5 7h14M10 11v6m4-6v6" />
                            </svg>
                            Shipping Address
                        </h2>

                        <!-- Existing addresses list -->
                        @if($addresses->count())
                            <div class="space-y-3 max-h-64 overflow-y-auto pr-2">
                                @foreach($addresses as $addr)
                                    <label
                                        class="flex items-start gap-3 p-4 border rounded-xl cursor-pointer transition-all duration-200 ">
                                        <input type="radio" wire:model.defer="shipping_address_id" value="{{ $addr->id }}"
                                            class="mt-1 text-brand-600 focus:ring-brand-600">
                                        <div>
                                            <div class="font-medium text-gray-800">
                                                {{ $addr->address_line1 }}
                                                @if($addr->address_line2)
                                                    <span class="text-gray-600"> — {{ $addr->address_line2 }}</span>
                                                @endif
                                            </div>
                                            <div class="text-sm text-gray-600">
                                                {{ $addr->city }}, {{ $addr->state }} — {{ $addr->postal_code }}
                                            </div>
                                            <div class="text-sm text-gray-600">
                                                {{ $addr->country }} • {{ $addr->phone }}
                                            </div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        @else
                            <div class="text-sm text-gray-600 mb-3">No saved addresses yet.</div>
                        @endif

                        <!-- Add address button -->
                        @if($showAddAddressFor !== 'billing')
                            <div class="mt-4 flex items-center gap-3">
                                <button wire:click.prevent="openAddAddress('billing')"
                                    class="px-4 py-2 bg-brand-600 text-white rounded-lg">+ Add New Address</button>
                                <span class="text-sm text-gray-600">or select from saved addresses above</span>
                            </div>
                            @if(!$addresses->count())
                                <div class="text-red-500 text-sm mt-1">Enter at least one address And select to place order</div>
                            @endif
                        @endif


                        <!-- Inline Add Address Form (for billing) -->
                        @if($showAddAddressFor === 'billing')
                            <div class="mt-6 border-t pt-6">
                                <h3 class="font-semibold mb-4 text-gray-800">Add Billing Address</h3>
                                <div class="space-y-4">
                                    <input type="text" wire:model.defer="new_line1" placeholder="Address Line 1 *"
                                        class="w-full border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-lg px-4 py-2.5 text-gray-700">
                                    <input type="text" wire:model.defer="new_line2" placeholder="Address Line 2"
                                        class="w-full border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-lg px-4 py-2.5 text-gray-700">

                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <input type="text" wire:model.defer="new_city" placeholder="City *"
                                            class="border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-lg px-4 py-2.5 text-gray-700">
                                        <input type="text" wire:model.defer="new_state" placeholder="State *"
                                            class="border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-lg px-4 py-2.5 text-gray-700">
                                        <input type="text" wire:model.defer="new_postal_code" placeholder="PIN Code *"
                                            class="border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-lg px-4 py-2.5 text-gray-700">
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <select wire:model.defer="new_country"
                                            class="border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-lg px-4 py-2.5 text-gray-700">
                                            <option>India</option>
                                            <option>USA</option>
                                            <option>UK</option>
                                            <option>Canada</option>
                                        </select>
                                        <input type="tel" wire:model.defer="new_phone" placeholder="Phone *"
                                            class="border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-lg px-4 py-2.5 text-gray-700">
                                    </div>

                                    <!-- Error messages -->
                                    @error('new_line1') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
                                    @error('new_city') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
                                    @error('new_state') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
                                    @error('new_postal_code') <div class="text-red-500 text-sm">{{ $message }}</div>
                                    @enderror
                                    @error('new_phone') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror

                                    <div class="flex gap-3 pt-2">
                                        <button wire:click.prevent="saveNewAddress"
                                            class="px-5 py-2 bg-brand-600 text-white rounded-md shadow hover:bg-brand-700 transition-all">
                                            Save & Select
                                        </button>
                                        <button wire:click.prevent="closeAddAddress"
                                            class="px-5 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition-all">
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>


                </div>





                <div class="bg-white border border-gray-100 rounded-lg p-6">
                    <h2 class="font-poppins text-xl font-semibold mb-4">Payment Method</h2>
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <label
                                class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-brand-600 transition-all {{ $payment_method === 'cod' ? 'border-brand-600 bg-brand-50' : '' }}">
                                <input type="radio" wire:model.live="payment_method" value="cod"
                                    class="text-brand-600 focus:ring-brand-600">
                                <div class="ml-3">
                                    <div class="font-medium">Cash on Delivery</div>
                                    <div class="text-sm text-gray-500">Pay when you receive</div>
                                </div>
                            </label>
                            <label
                                class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-brand-600 transition-all {{ $payment_method === 'online' ? 'border-brand-600 bg-brand-50' : '' }}">
                                <input type="radio" wire:model.live="payment_method" value="online"
                                    class="text-brand-600 focus:ring-brand-600">
                                <div class="ml-3">
                                    <div class="font-medium">Pay Online</div>
                                    <div class="text-sm text-gray-500">Credit/Debit Card or UPI</div>
                                </div>
                            </label>
                        </div>
                        @if($payment_method === 'online')
                            <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                                <p class="text-gray-600">You will be redirected to a secure payment gateway after clicking
                                    Place Order.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="bg-white border border-gray-100 rounded-lg p-6">
                    <h2 class="font-poppins text-xl font-semibold mb-4">Order Notes (Optional)</h2>
                    <textarea wire:model="order_notes" rows="3"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-brand-600 focus:ring-1 focus:ring-brand-600"
                        placeholder="Any special instructions for delivery..."></textarea>
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="bg-white border border-gray-100 rounded-lg p-6 sticky top-8">
                    <h2 class="font-poppins text-xl font-semibold mb-4">Order Summary</h2>
                    <div class="space-y-4 mb-6">
                        @foreach($cartItems as $item)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="h-12 w-12 bg-gray-100 rounded-md overflow-hidden mr-3">
                                        <img src="{{ $item->product->imagelink }}" alt="{{ $item->product->name }}"
                                            class="h-full w-full object-cover">
                                    </div>
                                    <div>
                                        <div class="font-medium text-sm">{{ $item->product->name }}</div>
                                        <div class="text-xs text-gray-500">Qty: {{ $item->quantity }}</div>
                                    </div>
                                </div>
                                <div class="text-brand-600 font-semibold">₹{{ $item->price * $item->quantity }}</div>
                            </div>
                        @endforeach
                    </div>
                    <div class="border-t border-gray-100 pt-4 space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-medium">₹{{ $subtotal }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Shipping</span>
                            @if($shippingCost > 0)
                                <span class="font-medium">₹{{ $shippingCost }}</span>
                            @else
                                <span class="text-brand-600">Free</span>
                            @endif
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Tax (5% GST)</span>
                            <span class="font-medium">₹{{ $tax }}</span>
                        </div>
                        @if($couponDiscount > 0)
                            <div class="flex justify-between text-sm text-brand-600">
                                <span>Discount</span>
                                <span>-₹{{ $couponDiscount }}</span>
                            </div>
                        @endif
                        <div
                            class="border-t border-gray-100 pt-2 flex justify-between font-poppins font-semibold text-lg">
                            <span>Total</span>
                            <span>₹{{ $total }}</span>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="text-sm font-medium mb-2">Coupon Code</div>
                        <div class="flex">
                            <input type="text" wire:model="couponCode"
                                class="flex-1 border border-gray-300 rounded-l-full px-4 py-2 focus:outline-none focus:border-brand-600 focus:ring-0 text-sm {{ $couponApplied ? 'bg-brand-50 border-brand-600' : '' }}"
                                placeholder="Enter coupon code" {{ $couponApplied ? 'readonly' : '' }}>
                            @if($couponApplied)
                                <button type="button" wire:click="removeCoupon"
                                    class="bg-brand-600 text-white px-4 py-2 rounded-r-full hover:bg-brand-700 transition-all text-sm">Remove</button>
                            @else
                                <button type="button" wire:click="applyCoupon"
                                    class="bg-brand-600 text-white px-4 py-2 rounded-r-full hover:bg-brand-700 transition-all text-sm">Apply</button>
                            @endif
                        </div>
                        @if($couponError)
                            <div class="mt-2 text-red-600 text-xs">{{ $couponError }}</div>
                        @elseif($couponApplied)
                            <div class="mt-2 text-brand-600 text-xs">Coupon applied successfully!</div>
                        @endif
                        <div class="mt-4 text-xs text-gray-500">
                            @if($subtotal < 999)
                                Add items worth ₹{{ 999 - $subtotal }} more for FREE shipping!
                            @else
                                You've qualified for FREE shipping!
                            @endif
                        </div>
                    </div>
                    <div class="mt-6">
                        @auth
                            @if ($payment_method === 'cod')
                                <button type="button" wire:click="placeOrder" wire:loading.attr="disabled"
                                    wire:loading.class="opacity-50 cursor-not-allowed"
                                    class="w-full bg-brand-600 text-white px-6 py-3 rounded-full hover:bg-brand-700 transition-all font-medium">
                                    <span wire:loading.remove wire:target="placeOrder">Place Order</span>
                                    <span wire:loading wire:target="placeOrder">Processing...</span>
                                </button>
                            @else
                                <button type="button" wire:click="placeOnline" wire:loading.attr="disabled"
                                    wire:loading.class="opacity-50 cursor-not-allowed"
                                    class="w-full bg-brand-600 text-white px-6 py-3 rounded-full hover:bg-brand-700 transition-all font-medium">
                                    <span wire:loading.remove wire:target="placeOnline">Place Online</span>
                                    <span wire:loading wire:target="placeOnline">Processing...</span>
                                </button>
                            @endif

                        @else
                            <a href="{{ route('login') }}"
                                class="w-full inline-block text-center bg-gray-600 text-white px-6 py-3 rounded-full hover:bg-gray-700 transition-all font-medium">Login
                                to Place Order</a>
                        @endauth
                    </div>
                    <div class="mt-4 flex items-center justify-center text-xs text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-9a2 2 0 00-2-2H6a2 2 0 00-2 2v9a2 2 0 002 2zm10-12V6a2 2 0 00-2-2H8a2 2 0 00-2 2v3h8z" />
                        </svg>
                        Secure checkout protected by SSL
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>