<div class="min-h-screen bg-gray-50 text-gray-900">



    <div class="max-w-6xl mx-auto px-6 py-12">

        @if(count($cartItems) == 0)

            <!-- Empty State -->
            <div class="text-center py-20 bg-white border border-gray-200 rounded-xl">
                <h2 class="text-xl font-medium mb-4">Your cart is empty</h2>
                <p class="text-gray-500 mb-6 text-sm">
                    Start exploring our products and add something you like.
                </p>
                <a href="/shop"
                    class="inline-block bg-gray-900 text-white px-6 py-3 rounded-lg text-sm hover:bg-gray-800 transition">
                    Browse Products
                </a>
            </div>

        @else

            <div class="grid lg:grid-cols-3 gap-12">

                <!-- Cart Items -->
                <div class="lg:col-span-2 space-y-6">

                    @foreach($cartItems as $productId => $item)

                        @php
                            $isGuest = is_array($item);
                            $id = $isGuest ? $item['id'] : $item->product_id;
                            $name = $isGuest ? $item['name'] : ($item->product->name ?? '');
                            $image = $isGuest ? $item['image'] : $item->product->imagelink;
                            $price = $isGuest ? $item['price'] : $item->product->price;
                            $quantity = $isGuest ? $item['quantity'] : $item->quantity;
                        @endphp

                        <div class="bg-white border border-gray-200 rounded-xl p-5">

                            <!-- Top Section -->
                            <div class="flex gap-4">

                                <!-- Image -->
                                <div class="w-20 h-20 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                                    <img src="{{ $image }}" class="w-full h-full object-cover">
                                </div>

                                <!-- Title + Remove -->
                                <div class="flex-1 flex justify-between">
                                    <div>
                                        <h3 class="font-medium text-base leading-snug">
                                            {{ $name }}
                                        </h3>
                                        <p class="text-sm text-gray-500 mt-1">
                                            ₹{{ $price }} each
                                        </p>
                                    </div>

                                    <button wire:click="removeItem({{ $id }})"
                                        class="text-gray-400 hover:text-gray-700 text-lg">
                                        ✕
                                    </button>
                                </div>

                            </div>

                            <!-- Bottom Section -->
                            <div class="mt-5 flex items-center justify-between">

                                <!-- Quantity Control -->
                                <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
                                    <button wire:click="updateQuantity({{ $id }}, {{ $quantity - 1 }})"
                                        class="px-3 py-1 text-gray-600 hover:bg-gray-100">
                                        −
                                    </button>

                                    <span class="px-4 text-sm">
                                        {{ $quantity }}
                                    </span>

                                    <button wire:click="updateQuantity({{ $id }}, {{ $quantity + 1 }})"
                                        class="px-3 py-1 text-gray-600 hover:bg-gray-100">
                                        +
                                    </button>
                                </div>

                                <!-- Subtotal -->
                                <div class="text-base font-semibold">
                                    ₹{{ $price * $quantity }}
                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

                <!-- Order Summary -->
                <div>

                    <div class="bg-white border border-gray-200 rounded-xl p-8 sticky top-8">

                        <h2 class="text-lg font-semibold mb-6">
                            Order Summary
                        </h2>

                        <div class="space-y-4 text-sm">

                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal</span>
                                <span>₹{{ $subtotal }}</span>
                            </div>

                            <div class="flex justify-between text-gray-600">
                                <span>Shipping</span>
                                <span>
                                    {{ $shippingCost > 0 ? '₹' . $shippingCost : 'Free' }}
                                </span>
                            </div>

                            <div class="flex justify-between text-gray-600">
                                <span>Tax</span>
                                <span>₹{{ $tax }}</span>
                            </div>

                            @if($couponDiscount > 0)
                                <div class="flex justify-between text-gray-600">
                                    <span>Discount</span>
                                    <span>-₹{{ $couponDiscount }}</span>
                                </div>
                            @endif

                            <div class="border-t border-gray-200 pt-4 flex justify-between font-semibold text-base">
                                <span>Total</span>
                                <span>₹{{ $total }}</span>
                            </div>

                        </div>

                        <div class="mt-8">
                            @auth
                                <button wire:click="checkout"
                                    class="w-full bg-gray-900 text-white py-3 rounded-lg text-sm hover:bg-gray-800 transition">
                                    Checkout
                                </button>
                            @else
                                <a href="{{ route('login') }}"
                                    class="block w-full text-center bg-gray-900 text-white py-3 rounded-lg text-sm hover:bg-gray-800 transition">
                                    Login to Continue
                                </a>
                            @endauth
                        </div>

                    </div>

                </div>

            </div>

        @endif

    </div>
</div>