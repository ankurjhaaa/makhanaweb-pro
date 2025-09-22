<div>
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h1 class="text-2xl font-semibold text-gray-800 mb-6">My Wishlist</h1>

        @if (session()->has('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if ($wishlistItems->isEmpty())
            <!-- Empty Wishlist -->
            <div class="bg-gray-50 border border-dashed border-gray-200 rounded-lg p-8 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                    <i class="fas fa-heart text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-1">Your wishlist is empty</h3>
                <p class="text-gray-500 mb-6">Save your favorite products to your wishlist</p>
                <a href="/shop"
                    class="inline-flex items-center px-4 py-2 rounded-md text-sm font-medium text-white bg-brand-600 hover:bg-brand-700">
                    <i class="fas fa-shopping-cart mr-2"></i>
                    Browse Products
                </a>
            </div>
        @else
            <!-- Wishlist Items -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($wishlistItems as $item)
                    @php $product = $item->product; @endphp
                    <div class=" rounded-xl border relative ">

                        <!-- Offer Badge -->
                        @if ($product->mrp && $product->mrp > $product->price)
                            @php
                                $discount = round((($product->mrp - $product->price) / $product->mrp) * 100);
                            @endphp
                            <span class="absolute top-3 left-3 bg-red-600 text-white text-xs font-bold px-2 py-1 rounded">
                                {{ $discount }}% OFF
                            </span>
                        @endif

                        <!-- Wishlist Button -->
                        @auth
                            <button wire:click="toggleWishlist({{ $product->id }})"
                                class="absolute top-3 right-3 h-9 w-9 flex items-center justify-center rounded-full border shadow-sm transition-all z-10 text-red-500 bg-red-50 hover:bg-red-100 ">
                                <i class="fas fa-heart"></i>
                            </button>
                        @else
                            <a href="{{ route('login') }}"
                                class="absolute top-3 right-3 h-9 w-9 flex items-center justify-center rounded-full border shadow-sm text-gray-400 bg-white hover:bg-gray-100 z-10">
                                <i class="fas fa-heart"></i>
                            </a>
                        @endauth

                        <!-- Product Image -->
                        <a wire:navigate href="{{ route('item', $product->slug) }}">
                            <div class="flex items-center justify-center  p-6">
                                <img src="{{ $product->imagelink }}?tr=w-400,h-400,f-auto,q-80" alt="{{ $product->name }}"
                                    class="max-w-full max-h-64 object-contain">
                            </div>
                        </a>

                        <!-- Product Info -->
                        <div class="px-4 pb-4">
                            <!-- Rating -->
                            <div class="flex items-center gap-2 mb-2">
                                <span class="bg-green-600 text-white text-xs font-semibold px-2 py-0.5 rounded">
                                    {{ number_format($product->reviews()->avg('rating') ?? 0, 1) }} ★
                                </span>
                                <span class="text-gray-500 text-sm">
                                    ({{ $product->reviews()->count('id') ?? 0 }} reviews )
                                </span>
                            </div>

                            <!-- Product Name -->
                            <h3 class="text-base font-semibold text-gray-900 truncate">
                                {{ $product->name }}
                            </h3>
                            <p class="text-sm text-gray-600 mb-2">
                                {{ $product->category->name ?? 'Food Item' }}
                            </p>

                            <!-- Price Section (same as before) -->
                            <div class="flex flex-col gap-1 text-sm">
                                <div class="flex items-center gap-2">
                                    <span class="text-lg font-bold text-gray-900">₹{{ $product->price }}</span>
                                    @if ($product->mrp)
                                        <span class="text-red-500 font-medium">
                                            (Rs. {{ $product->mrp - $product->price }} OFF)
                                        </span>
                                    @endif
                                </div>
                                @if ($product->mrp)
                                    <span class="text-xs text-gray-500">MRP: ₹{{ $product->mrp }}</span>
                                @endif
                            </div>

                            <!-- Floating Cart Icon -->
                            @if ($product->stock === 0)
                                <button disabled
                                    class="absolute bottom-4 right-4 h-11 w-11 rounded-full bg-gray-500 text-white flex items-center justify-center shadow-lg transition-all">
                                    <i class="fas fa-shopping-cart text-lg"></i>
                                </button>
                            @else
                                <a wire:navigate href="{{ route('cart', ['add' => $product->id]) }}"
                                    class="absolute bottom-4 right-4 h-11 w-11 rounded-full bg-green-600 hover:bg-brand-600 text-white flex items-center justify-center shadow-lg transition-all">
                                    <i class="fas fa-shopping-cart text-lg"></i>
                                </a>
                            @endif


                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>