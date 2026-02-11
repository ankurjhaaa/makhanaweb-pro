<div class="space-y-8">

    <!-- Header -->
    <div class="bg-white border border-gray-100 rounded-lg shadow-sm p-6">
        <h1 class="font-poppins text-2xl font-semibold text-gray-800">
            My Wishlist
        </h1>
    </div>

    @if ($wishlistItems->isEmpty())

        <!-- Empty State -->
        <div class="bg-white border border-gray-100 rounded-lg shadow-sm p-10 text-center">
            <div class="w-16 h-16 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-heart text-gray-400 text-xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">
                Your wishlist is empty
            </h3>
            <p class="text-sm text-gray-500 mb-6">
                Save products you love and find them here.
            </p>
            <a href="/shop" class="px-5 py-2.5 bg-brand-600 text-white text-sm rounded-md hover:bg-brand-700 transition">
                Browse Products
            </a>
        </div>

    @else

        <!-- Wishlist Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

            @foreach ($wishlistItems as $item)
                @php $product = $item->product; @endphp

                <div
                    class="bg-white border border-gray-100 rounded-xl shadow-sm hover:shadow-md transition relative overflow-hidden">

                    <!-- Discount Badge -->
                    @if ($product->mrp && $product->mrp > $product->price)
                        @php
                            $discount = round((($product->mrp - $product->price) / $product->mrp) * 100);
                        @endphp
                        <span class="absolute top-3 left-3 bg-red-600 text-white text-xs font-semibold px-2 py-1 rounded-md z-10">
                            {{ $discount }}% OFF
                        </span>
                    @endif

                    <!-- Remove Wishlist -->
                    <button wire:click="toggleWishlist({{ $product->id }})"
                        class="absolute top-3 right-3 h-9 w-9 rounded-full bg-red-50 text-red-500 flex items-center justify-center hover:bg-red-100 transition z-10">
                        <i class="fas fa-heart text-sm"></i>
                    </button>

                    <!-- Image -->
                    <a wire:navigate href="{{ route('item', $product->slug) }}">
                        <div class="h-56 flex items-center justify-center p-6 bg-gray-50">
                            <img src="{{ $product->imagelink }}?tr=w-400,h-400" class="max-h-full object-contain">
                        </div>
                    </a>

                    <!-- Content -->
                    <div class="p-4 pb-16">

                        <h3 class="text-sm font-semibold text-gray-800 truncate">
                            {{ $product->name }}
                        </h3>

                        <p class="text-xs text-gray-500 mb-2">
                            {{ $product->category->name ?? 'Food Item' }}
                        </p>

                        <!-- Price -->
                        <div class="flex items-center gap-2">
                            <span class="text-base font-semibold text-gray-900">
                                ₹{{ $product->price }}
                            </span>
                            @if ($product->mrp)
                                <span class="text-xs text-gray-400 line-through">
                                    ₹{{ $product->mrp }}
                                </span>
                            @endif
                        </div>

                    </div>

                    <!-- Floating Cart Button (ALWAYS VISIBLE) -->
                    @if ($product->stock === 0)
                        <button disabled
                            class="absolute bottom-4 right-4 h-11 w-11 rounded-full bg-gray-400 text-white flex items-center justify-center shadow-lg">
                            <i class="fas fa-shopping-cart text-sm"></i>
                        </button>
                    @else
                        <a wire:navigate href="{{ route('cart', ['add' => $product->id]) }}"
                            class="absolute bottom-4 right-4 h-11 w-11 rounded-full bg-brand-600 hover:bg-brand-700 text-white flex items-center justify-center shadow-lg transition">
                            <i class="fas fa-shopping-cart text-sm"></i>
                        </a>
                    @endif

                </div>

            @endforeach

        </div>

    @endif

</div>