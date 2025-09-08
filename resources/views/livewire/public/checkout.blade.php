<div class="bg-white text-gray-800">
    <!-- Checkout Header -->
    <header class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-6">
            <h1 class="font-poppins text-3xl font-bold">Checkout</h1>
            <div class="mt-2 flex items-center text-sm text-gray-500">
                <a href="/" class="hover:text-brand-600 transition-all">Home</a>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <a href="{{ route('cart') }}" class="hover:text-brand-600 transition-all">Cart</a>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span>Checkout</span>
            </div>
        </div>
    </header>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-8 md:py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Forms -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Contact Information -->
                <div class="bg-white border border-gray-100 rounded-lg p-6">
                    <h2 class="font-poppins text-xl font-semibold mb-4">Contact Information</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">First Name *</label>
                            <input type="text" wire:model.blur="first_name" 
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-brand-600 focus:ring-1 focus:ring-brand-600"
                                placeholder="Enter first name">
                            @error('first_name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Last Name *</label>
                            <input type="text" wire:model.blur="last_name" 
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-brand-600 focus:ring-1 focus:ring-brand-600"
                                placeholder="Enter last name">
                            @error('last_name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email Address *</label>
                            <input type="email" wire:model.blur="email" 
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-brand-600 focus:ring-1 focus:ring-brand-600"
                                placeholder="Enter email address">
                            @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Billing Address -->
                <div class="bg-white border border-gray-100 rounded-lg p-6">
                    <h2 class="font-poppins text-xl font-semibold mb-4">Billing Address</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Address Line 1 *</label>
                            <input type="text" wire:model.blur="billing_address_line1" 
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-brand-600 focus:ring-1 focus:ring-brand-600"
                                placeholder="House/Flat number, Street name">
                            @error('billing_address_line1') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Address Line 2</label>
                            <input type="text" wire:model="billing_address_line2" 
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-brand-600 focus:ring-1 focus:ring-brand-600"
                                placeholder="Landmark, Area (Optional)">
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">City *</label>
                                <input type="text" wire:model.blur="billing_city" 
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-brand-600 focus:ring-1 focus:ring-brand-600"
                                    placeholder="City">
                                @error('billing_city') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">State *</label>
                                <input type="text" wire:model.blur="billing_state" 
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-brand-600 focus:ring-1 focus:ring-brand-600"
                                    placeholder="State">
                                @error('billing_state') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Postal Code *</label>
                                <input type="text" wire:model.blur="billing_postal_code" 
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-brand-600 focus:ring-1 focus:ring-brand-600"
                                    placeholder="PIN Code">
                                @error('billing_postal_code') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Country *</label>
                                <select wire:model="billing_country" 
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-brand-600 focus:ring-1 focus:ring-brand-600">
                                    <option value="India">India</option>
                                    <option value="USA">USA</option>
                                    <option value="UK">UK</option>
                                    <option value="Canada">Canada</option>
                                </select>
                                @error('billing_country') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number *</label>
                                <input type="tel" wire:model.blur="billing_phone" 
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-brand-600 focus:ring-1 focus:ring-brand-600"
                                    placeholder="+91 XXXXX XXXXX">
                                @error('billing_phone') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shipping Address -->
                <div class="bg-white border border-gray-100 rounded-lg p-6">
                    <h2 class="font-poppins text-xl font-semibold mb-4">Shipping Address</h2>
                    
                    <div class="mb-4">
                        <label class="flex items-center">
                            <input type="checkbox" wire:model.live="same_as_billing" 
                                class="rounded border-gray-300 text-brand-600 focus:ring-brand-600">
                            <span class="ml-2 text-sm">Same as billing address</span>
                        </label>
                    </div>
                    
                    @if(!$same_as_billing)
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Address Line 1 *</label>
                                <input type="text" wire:model="shipping_address_line1" 
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-brand-600 focus:ring-1 focus:ring-brand-600"
                                    placeholder="House/Flat number, Street name">
                                @error('shipping_address_line1') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Address Line 2</label>
                                <input type="text" wire:model="shipping_address_line2" 
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-brand-600 focus:ring-1 focus:ring-brand-600"
                                    placeholder="Landmark, Area (Optional)">
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">City *</label>
                                    <input type="text" wire:model="shipping_city" 
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-brand-600 focus:ring-1 focus:ring-brand-600"
                                        placeholder="City">
                                    @error('shipping_city') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">State *</label>
                                    <input type="text" wire:model="shipping_state" 
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-brand-600 focus:ring-1 focus:ring-brand-600"
                                        placeholder="State">
                                    @error('shipping_state') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Postal Code *</label>
                                    <input type="text" wire:model="shipping_postal_code" 
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-brand-600 focus:ring-1 focus:ring-brand-600"
                                        placeholder="PIN Code">
                                    @error('shipping_postal_code') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Country *</label>
                                    <select wire:model="shipping_country" 
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-brand-600 focus:ring-1 focus:ring-brand-600">
                                        <option value="India">India</option>
                                        <option value="USA">USA</option>
                                        <option value="UK">UK</option>
                                        <option value="Canada">Canada</option>
                                    </select>
                                    @error('shipping_country') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number *</label>
                                    <input type="tel" wire:model="shipping_phone" 
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-brand-600 focus:ring-1 focus:ring-brand-600"
                                        placeholder="+91 XXXXX XXXXX">
                                    @error('shipping_phone') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Payment Method -->
                <div class="bg-white border border-gray-100 rounded-lg p-6">
                    <h2 class="font-poppins text-xl font-semibold mb-4">Payment Method</h2>
                    
                    <div class="space-y-4">
                        <!-- Payment Options -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-brand-600 transition-all {{ $payment_method === 'cod' ? 'border-brand-600 bg-brand-50' : '' }}">
                                <input type="radio" wire:model.live="payment_method" value="cod" class="text-brand-600 focus:ring-brand-600">
                                <div class="ml-3">
                                    <div class="font-medium">Cash on Delivery</div>
                                    <div class="text-sm text-gray-500">Pay when you receive</div>
                                </div>
                            </label>
                            
                            <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-brand-600 transition-all {{ $payment_method === 'card' ? 'border-brand-600 bg-brand-50' : '' }}">
                                <input type="radio" wire:model.live="payment_method" value="card" class="text-brand-600 focus:ring-brand-600">
                                <div class="ml-3">
                                    <div class="font-medium">Credit/Debit Card</div>
                                    <div class="text-sm text-gray-500">Visa, Mastercard, RuPay</div>
                                </div>
                            </label>
                            
                            <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-brand-600 transition-all {{ $payment_method === 'upi' ? 'border-brand-600 bg-brand-50' : '' }}">
                                <input type="radio" wire:model.live="payment_method" value="upi" class="text-brand-600 focus:ring-brand-600">
                                <div class="ml-3">
                                    <div class="font-medium">UPI Payment</div>
                                    <div class="text-sm text-gray-500">PhonePe, GPay, Paytm</div>
                                </div>
                            </label>
                        </div>
                        
                        <!-- Card Payment Form -->
                        @if($payment_method === 'card')
                            <div class="space-y-4 mt-4 p-4 bg-gray-50 rounded-lg">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Cardholder Name *</label>
                                    <input type="text" wire:model="card_name" 
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-brand-600 focus:ring-1 focus:ring-brand-600"
                                        placeholder="Name on card">
                                    @error('card_name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Card Number *</label>
                                    <input type="text" wire:model="card_number" 
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-brand-600 focus:ring-1 focus:ring-brand-600"
                                        placeholder="1234 5678 9012 3456">
                                    @error('card_number') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Expiry Date *</label>
                                        <input type="text" wire:model="card_expiry" 
                                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-brand-600 focus:ring-1 focus:ring-brand-600"
                                            placeholder="MM/YY">
                                        @error('card_expiry') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">CVV *</label>
                                        <input type="text" wire:model="card_cvv" 
                                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-brand-600 focus:ring-1 focus:ring-brand-600"
                                            placeholder="123">
                                        @error('card_cvv') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        <!-- UPI Payment Form -->
                        @if($payment_method === 'upi')
                            <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">UPI ID *</label>
                                    <input type="email" wire:model="upi_id" 
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-brand-600 focus:ring-1 focus:ring-brand-600"
                                        placeholder="yourname@paytm">
                                    @error('upi_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Order Notes -->
                <div class="bg-white border border-gray-100 rounded-lg p-6">
                    <h2 class="font-poppins text-xl font-semibold mb-4">Order Notes (Optional)</h2>
                    <textarea wire:model="order_notes" rows="3" 
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-brand-600 focus:ring-1 focus:ring-brand-600"
                        placeholder="Any special instructions for delivery..."></textarea>
                </div>
            </div>

            <!-- Right Column - Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white border border-gray-100 rounded-lg p-6 sticky top-8">
                    <h2 class="font-poppins text-xl font-semibold mb-4">Order Summary</h2>
                    
                    <!-- Cart Items -->
                    <div class="space-y-4 mb-6">
                        @foreach($cartItems as $item)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="h-12 w-12 bg-gray-100 rounded-md overflow-hidden mr-3">
                                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="h-full w-full object-cover">
                                    </div>
                                    <div>
                                        <div class="font-medium text-sm">{{ $item['name'] }}</div>
                                        <div class="text-xs text-gray-500">Qty: {{ $item['quantity'] }}</div>
                                    </div>
                                </div>
                                <div class="text-brand-600 font-semibold">₹{{ $item['price'] * $item['quantity'] }}</div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Price Breakdown -->
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
                        
                        <div class="border-t border-gray-100 pt-2 flex justify-between font-poppins font-semibold text-lg">
                            <span>Total</span>
                            <span>₹{{ $total }}</span>
                        </div>
                    </div>
                    
                    <!-- Place Order Button -->
                    <div class="mt-6">
                        <button type="button" wire:click="placeOrder" 
                            wire:loading.attr="disabled"
                            wire:loading.class="opacity-50 cursor-not-allowed"
                            class="w-full bg-brand-600 text-white px-6 py-3 rounded-full hover:bg-brand-700 transition-all font-medium">
                            <span wire:loading.remove wire:target="placeOrder">Place Order</span>
                            <span wire:loading wire:target="placeOrder">Processing...</span>
                        </button>
                    </div>
                    
                    <!-- Security Note -->
                    <div class="mt-4 flex items-center justify-center text-xs text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-9a2 2 0 00-2-2H6a2 2 0 00-2 2v9a2 2 0 002 2zm10-12V6a2 2 0 00-2-2H8a2 2 0 00-2 2v3h8z" />
                        </svg>
                        Secure checkout protected by SSL
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
