<div class="bg-white text-gray-800">
    <!-- Cart Header -->
    <header class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-6">
            <h1 class="font-poppins text-3xl font-bold">Your Shopping Cart</h1>
            <div class="mt-2 flex items-center text-sm text-gray-500">
                <a href="/" class="hover:text-brand-600 transition-all">Home</a>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span>Shopping Cart</span>
            </div>
        </div>
    </header>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-8 md:py-12">
        <!-- Empty Cart Message (shown when cart is empty) -->
        @if(count($cartItems) == 0)
            <div class="text-center py-16">
                <div class="text-brand-600 text-5xl mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mx-auto" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <h2 class="font-poppins text-2xl font-semibold mb-4">Your cart is empty</h2>
                <p class="text-gray-600 max-w-md mx-auto mb-8">
                    Looks like you haven't added any products to your cart yet. Browse our collection of premium healthy
                    snacks.
                </p>
                <a href="/shop"
                    class="bg-brand-600 text-white px-6 py-3 rounded-full hover:bg-brand-700 transition-all font-medium">
                    Continue Shopping
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items (Left Column) -->
                <div class="lg:col-span-2">
                    <div class="border border-gray-100 rounded-lg overflow-hidden">
                        <!-- Cart Header -->
                        <div class="bg-gray-50 px-6 py-4 hidden md:grid md:grid-cols-12 text-sm font-medium text-gray-500">
                            <div class="col-span-6">Product</div>
                            <div class="col-span-2 text-center">Price</div>
                            <div class="col-span-2 text-center">Quantity</div>
                            <div class="col-span-2 text-right">Subtotal</div>
                        </div>

                        <!-- Cart Items -->
                        @foreach($cartItems as $productId => $item)
                            @php
                                $isGuest = is_array($item);

                                $id = $isGuest ? $item['id'] : $item->product_id;
                                $stock = $isGuest ? $item['stock'] : $item->product->stock;
                                $name = $isGuest ? $item['name'] : ($item->product->name ?? 'Unknown Product');
                                $image = $isGuest ? $item['image'] : $item->product->imagelink;
                                $category = $isGuest ? ($item['category'] ?? 'General') : ($item->product->category->name ?? 'General');
                                $weight = $isGuest ? ($item['weight'] ?? '') : ($item->product->weight ?? '');
                                $price = $isGuest ? $item['price'] : $item->product->price;
                                $originalPrice = $isGuest ? ($item['originalPrice'] ?? $price) : ($item->product->original_price ?? $item->product->price);
                                $quantity = $isGuest ? $item['quantity'] : $item->quantity;
                            @endphp

                            <div class="border-t border-gray-100 first:border-t-0 px-4 py-6 md:px-6 md:py-4">
                                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">

                                    <!-- Product Info -->
                                    <div class="col-span-1 md:col-span-6">
                                        <div class="flex items-center">
                                            <!-- Remove Item Button (Mobile) -->
                                            <div class="md:hidden">
                                                <button type="button" wire:click="removeItem({{ $id }})"
                                                    class="text-gray-400 hover:text-brand-600 transition-all">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </div>

                                            <!-- Product Image -->
                                            <div class="h-20 w-20 ml-3 md:ml-0 bg-gray-100 rounded-md overflow-hidden">
                                                <img src="{{ $image }}" alt="{{ $name }}" class="h-full w-full object-cover">
                                            </div>

                                            <!-- Product Details -->
                                            <div class="ml-4">
                                                <h3 class="font-poppins font-medium">{{ $name }}</h3>
                                                <div class="text-sm text-gray-500">{{ $category }} • {{ $weight }}</div>

                                                <!-- Price (Mobile Only) -->
                                                <div class="mt-1 md:hidden">
                                                    <span class="text-brand-600 font-semibold">₹{{ $price }}</span>
                                                    @if($originalPrice > $price)
                                                        <span
                                                            class="text-gray-400 text-xs line-through ml-1">₹{{ $originalPrice }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Price (Desktop) -->
                                    <div class="hidden md:block md:col-span-2 text-center">
                                        <span class="text-brand-600 font-semibold">₹{{ $price }}</span>
                                        @if($originalPrice > $price)
                                            <div class="text-gray-400 text-xs line-through">₹{{ $originalPrice }}</div>
                                        @endif
                                    </div>

                                    <!-- Quantity -->
                                    <div class="col-span-1 md:col-span-2 md:text-center">
                                        <div
                                            class="flex items-center border border-gray-200 rounded-full max-w-[120px] mx-auto">
                                            <button type="button" wire:click="updateQuantity({{ $id }}, {{ $quantity - 1 }})"
                                                class="w-8 h-8 flex items-center justify-center text-gray-600 hover:text-brand-600">
                                                -
                                            </button>
                                            <input type="number" min="1" value="{{ $quantity }}"
                                                wire:change="updateQuantity({{ $id }}, $event.target.value)"
                                                class="w-10 text-center border-0 focus:ring-0 text-gray-900 text-sm px-0"
                                                readonly>
                                            @if ($stock > $quantity)
                                                <button type="button" wire:click="updateQuantity({{ $id }}, {{ $quantity + 1 }})"
                                                    class="w-8 h-8 flex items-center justify-center text-gray-600 hover:text-brand-600">
                                                    +
                                                </button>
                                            @endif

                                        </div>
                                    </div>

                                    <!-- Subtotal -->
                                    <div class="col-span-1 md:col-span-2 flex justify-between items-center">
                                        <div class="text-brand-600 font-semibold md:text-right md:w-full">
                                            ₹{{ $price * $quantity }}
                                        </div>

                                        <!-- Remove Item Button (Desktop) -->
                                        <div class="hidden md:block">
                                            <button type="button" wire:click="removeItem({{ $id }})"
                                                class="text-gray-400 hover:text-brand-600 transition-all">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>

                    <!-- Continue Shopping Button -->
                    <div class="mt-6">
                        <a href="/shop" class="inline-block text-brand-600 hover:text-brand-700 font-medium transition-all">
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Continue Shopping
                            </span>
                        </a>
                    </div>
                </div>

                <!-- Order Summary (Right Column) -->
                <div class="lg:col-span-1">
                    <div class="border border-gray-100 rounded-lg p-6">
                        <h2 class="font-poppins text-xl font-semibold mb-4">Order Summary</h2>

                        <!-- Subtotal -->
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-medium">₹{{ $subtotal }}</span>
                        </div>

                        <!-- Shipping -->
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-600">Shipping</span>
                            @if($shippingCost > 0)
                                <span class="font-medium">₹{{ $shippingCost }}</span>
                            @else
                                <span class="text-brand-600">Free</span>
                            @endif
                        </div>

                        <!-- Tax -->
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-600">Tax (5% GST)</span>
                            <span class="font-medium">₹{{ $tax }}</span>
                        </div>

                        <!-- Discount -->
                        @if($couponDiscount > 0)
                            <div class="flex justify-between py-2 border-b border-gray-100 text-brand-600">
                                <span>Discount</span>
                                <span>-₹{{ $couponDiscount }}</span>
                            </div>
                        @endif

                        <!-- Total -->
                        <div class="flex justify-between py-3 font-poppins font-semibold text-lg">
                            <span>Total</span>
                            <span>₹{{ $total }}</span>
                        </div>



                        <!-- Checkout Button -->
                        <div class="mt-6">
                            <button type="button" wire:click="checkout"
                                class="w-full bg-brand-600 text-white px-6 py-3 rounded-full hover:bg-brand-700 transition-all font-medium">
                                Proceed to Checkout
                            </button>
                        </div>

                        <!-- Payment Methods -->
                        <div class="mt-4 flex justify-center gap-2">
                            <div class="text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                            </div>
                            <div class="text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <div class="text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>