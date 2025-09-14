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
                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                        <div class="relative">
                            <img src="{{ $product->imagelink ?? '' }}" alt="{{ $product->name }}"
                                class="w-full h-48 object-cover">

                            <!-- Like / Unlike Button -->
                            <button wire:click="toggleWishlist({{ $product->id }})"
                                class="absolute top-3 right-3 h-8 w-8 rounded-full bg-white shadow-md flex items-center justify-center transition-colors duration-200 {{ in_array($product->id, $wishlistItems->pluck('product_id')->toArray()) ? 'text-red-500' : 'text-gray-400' }}  hover:text-red-600">
                                <i class="fas fa-heart"></i>
                            </button>

                        </div>
                        <div class="p-4">
                            <h3 class="text-lg font-medium text-gray-900 mb-2">{{ $product->name }}</h3>
                            <p class="text-gray-500 mb-2">{{ $product->description }}</p>
                            <div class="flex items-center justify-between">
                                <span class="text-lg font-bold text-gray-900">₹{{ number_format($product->price, 2) }}</span>
                                <a href="/cart/add/{{ $product->id }}"
                                    class="inline-flex items-center px-3 py-1.5 rounded-md text-sm font-medium text-white bg-brand-600 hover:bg-brand-700">
                                    <i class="fas fa-shopping-cart mr-1.5"></i>
                                    Add to Cart
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>