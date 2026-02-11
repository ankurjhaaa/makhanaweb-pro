<div class="min-h-screen bg-gray-50">

    <!-- Header -->
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-6 py-8">
            <h1 class="text-3xl font-semibold text-gray-900">Checkout</h1>
            <div class="flex items-center gap-2 text-sm text-gray-500 mt-2">
                <a href="/" class="hover:text-gray-900">Home</a>
                <span>/</span>
                <a href="{{ route('cart') }}" class="hover:text-gray-900">Cart</a>
                <span>/</span>
                <span class="text-gray-900 font-medium">Checkout</span>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="max-w-7xl mx-auto px-6 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">

            <!-- LEFT SIDE -->
            <div class="lg:col-span-2 space-y-10">

                <!-- Contact -->
                <div class="bg-white border border-gray-200 rounded-2xl p-8">
                    <h2 class="text-xl font-semibold mb-6">Contact Details</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <input type="text" wire:model.blur="first_name"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm bg-gray-100"
                            placeholder="First Name" disabled>

                        <input type="text" wire:model.blur="last_name"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm bg-gray-100"
                            placeholder="Last Name" disabled>

                        <div class="md:col-span-2">
                            <input type="email" wire:model.blur="email"
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm bg-gray-100"
                                placeholder="Email" disabled>
                        </div>
                    </div>
                </div>

                <!-- Shipping Address -->
                <div class="bg-white border border-gray-200 rounded-2xl p-8">
                    <h2 class="text-xl font-semibold mb-6">Shipping Address</h2>

                    @if($addresses->count())
                        <div class="space-y-4">
                            @foreach($addresses as $addr)
                                <label class="flex gap-4 p-5 border rounded-xl cursor-pointer hover:border-gray-400 transition">
                                    <input type="radio" wire:model.defer="shipping_address_id"
                                        value="{{ $addr->id }}" class="mt-1">
                                    <div class="text-sm">
                                        <div class="font-medium text-gray-900">
                                            {{ $addr->address_line1 }}
                                        </div>
                                        <div class="text-gray-500">
                                            {{ $addr->city }}, {{ $addr->state }} - {{ $addr->postal_code }}
                                        </div>
                                        <div class="text-gray-500">
                                            {{ $addr->country }} • {{ $addr->phone }}
                                        </div>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-500">No saved addresses found.</p>
                    @endif

                    <div class="mt-6">
                        <button wire:click.prevent="openAddAddress('billing')"
                            class="text-sm font-medium text-gray-900 underline">
                            + Add New Address
                        </button>
                    </div>
                </div>

                <!-- Payment -->
                <div class="bg-white border border-gray-200 rounded-2xl p-8">
                    <h2 class="text-xl font-semibold mb-6">Payment Method</h2>

                    <div class="space-y-4">
                        <label class="flex items-center justify-between border rounded-xl p-5 cursor-pointer">
                            <div>
                                <div class="font-medium">Cash on Delivery</div>
                                <div class="text-sm text-gray-500">Pay when delivered</div>
                            </div>
                            <input type="radio" wire:model.live="payment_method" value="cod">
                        </label>

                        <label class="flex items-center justify-between border rounded-xl p-5 cursor-pointer">
                            <div>
                                <div class="font-medium">Online Payment</div>
                                <div class="text-sm text-gray-500">Card / UPI / Net Banking</div>
                            </div>
                            <input type="radio" wire:model.live="payment_method" value="online">
                        </label>
                    </div>

                    @if($payment_method === 'online')
                        <div class="mt-4 text-sm text-gray-500 bg-gray-50 p-4 rounded-lg">
                            Secure payment gateway will open after clicking place order.
                        </div>
                    @endif
                </div>

                <!-- Notes -->
                <div class="bg-white border border-gray-200 rounded-2xl p-8">
                    <h2 class="text-xl font-semibold mb-4">Order Notes</h2>
                    <textarea wire:model="order_notes" rows="3"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm"
                        placeholder="Optional delivery instructions"></textarea>
                </div>

            </div>

            <!-- RIGHT SIDE SUMMARY -->
            <div>
                <div class="bg-white border border-gray-200 rounded-2xl p-8 sticky top-10">

                    <h2 class="text-xl font-semibold mb-6">Order Summary</h2>

                    <div class="space-y-5 mb-6">
                        @foreach($cartItems as $item)
                            <div class="flex justify-between text-sm">
                                <div>
                                    <div class="font-medium text-gray-900">
                                        {{ $item->product->name }}
                                    </div>
                                    <div class="text-gray-500">
                                        Qty: {{ $item->quantity }}
                                    </div>
                                </div>
                                <div class="font-medium">
                                    ₹{{ $item->price * $item->quantity }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t pt-5 space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Subtotal</span>
                            <span>₹{{ $subtotal }}</span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-600">Shipping</span>
                            <span>{{ $shippingCost > 0 ? '₹'.$shippingCost : 'Free' }}</span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-600">Tax</span>
                            <span>₹{{ $tax }}</span>
                        </div>

                        @if($couponDiscount > 0)
                            <div class="flex justify-between text-green-600">
                                <span>Discount</span>
                                <span>-₹{{ $couponDiscount }}</span>
                            </div>
                        @endif

                        <div class="border-t pt-3 flex justify-between font-semibold text-lg">
                            <span>Total</span>
                            <span>₹{{ $total }}</span>
                        </div>
                    </div>

                    <!-- Button -->
                    <div class="mt-8">
                        @auth
                            @if ($payment_method === 'cod')
                                <button wire:click="placeOrder"
                                    class="w-full bg-gray-900 text-white py-3 rounded-lg text-sm font-medium hover:bg-gray-800 transition">
                                    Place Order
                                </button>
                            @else
                                <button wire:click="placeOnline"
                                    class="w-full bg-gray-900 text-white py-3 rounded-lg text-sm font-medium hover:bg-gray-800 transition">
                                    Pay Securely
                                </button>
                            @endif
                        @else
                            <a href="{{ route('login') }}"
                                class="w-full block text-center bg-gray-800 text-white py-3 rounded-lg text-sm">
                                Login to Continue
                            </a>
                        @endauth
                    </div>

                    <div class="mt-6 text-xs text-gray-500 text-center">
                        Secure checkout • SSL encrypted
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>