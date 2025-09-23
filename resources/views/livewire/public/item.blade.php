<div class="bg-white min-h-screen px-4 sm:px-8 lg:px-16 py-1">
    <!-- Cart Header -->
    <header class="bg-white py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <ol class="flex items-center text-sm text-gray-500">
                @foreach($breadcrumbs as $breadcrumb)
                    <li>
                        <a href="{{ $breadcrumb['url'] }}" class="hover:text-brand-600 transition-all">
                            {{ $breadcrumb['label'] }}
                        </a>
                    </li>
                    @if(!$loop->last)
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mx-2 text-gray-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </li>
                    @endif


                @endforeach
            </ol>
        </div>
    </header>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
        <!-- Product Image -->
        <div class="flex justify-center items-start">
            <div class="rounded-xl bg-white  p-3 w-full max-w-md">
                <img src="{{ $productDetail->imagelink }}" alt="{{ $productDetail->name }}"
                    class="rounded-lg w-full h-[420px] object-contain ">
            </div>
        </div>

        <!-- Product Details -->
        <div class="space-y-6">
            <!-- Title -->
            <h1 class="text-2xl font-bold text-gray-900">{{ $productDetail->name }}</h1>

            <!-- Rating + Stock -->
            <div class="flex items-center flex-wrap gap-3 text-sm">
                <div
                    class="flex items-center gap-1 bg-yellow-50 px-2 py-0.5 rounded-full border border-yellow-200 text-yellow-600 font-medium text-xs">
                    ★ {{ number_format($productDetail->reviews()->avg('rating') ?? 0, 1) }}
                </div>
                <span class="text-gray-500">({{ $productDetail->reviews()->count('id') ?? 0 }} reviews)</span>
                @if ($productDetail->stock === 0)
                    <span class="text-gray-400 font-semibold text-xs">Out Of Stock</span>
                @else
                    <span class="text-green-600 font-semibold text-xs">In Stock</span>
                @endif
            </div>

            <!-- Price -->
            <div class="flex items-center gap-2 text-lg font-semibold">
                <span class="text-brand-600">₹{{ $productDetail->price }}</span>
                <span class="text-gray-400 line-through text-sm">₹{{ $productDetail->mrp }}</span>
                <span class="bg-green-100 text-green-600 text-xs px-2 py-0.5 rounded-md font-medium">
                    {{ round((($productDetail->mrp - $productDetail->price) / $productDetail->mrp) * 100) }}% OFF
                </span>
            </div>
            <div class="flex gap-4">
                @auth
                    <button wire:click="toggleWishlist({{ $productDetail->id }})" @class([
                        'h-11 w-11 flex items-center justify-center rounded-full shadow-md transition-colors',
                        'text-red-500 bg-red-50 hover:bg-red-100 border border-red-200' =>
                            $wishlistIds->contains($productDetail->id),
                        'text-gray-400 bg-white hover:bg-gray-50 border' =>
                            !$wishlistIds->contains($productDetail->id),
                    ])>
                        <i class="fas fa-heart"></i>
                    </button>
                @else
                    <a href="{{ route('login') }}"
                        class="h-11 w-11 flex items-center justify-center rounded-full border shadow-sm transition-colors text-gray-400 bg-white hover:bg-gray-100">
                        <i class="fas fa-heart"></i>
                    </a>
                @endauth

                <button onclick="sharePage()"
                    class="h-11 px-6 flex items-center gap-2 rounded-full border border-blue-500 text-blue-600 hover:bg-blue-50 transition shadow-sm font-medium">
                    <i class="fas fa-share-alt"></i> Share
                </button>
            </div>
            <script>
                function sharePage() {
                    const shareData = {
                        title: "{{ $productDetail->name }}",
                        text: "{{ Str::limit($productDetail->description, 80) }}",
                        url: window.location.href
                    };

                    if (navigator.share) {
                        navigator.share(shareData).catch(console.error);
                    } else {
                        navigator.clipboard.writeText(window.location.href).then(() => {
                            alert("Link copied to clipboard!");
                        });
                    }
                }
            </script>

            <!-- Quantity Selector -->
            <div class="space-y-2">
                <label class="text-sm font-medium text-gray-700"> Quantity:</label>
                <div class="flex gap-3">
                    <button
                        class="px-4 py-1.5 border rounded-md text-sm hover:border-brand-600 hover:text-brand-600 transition">
                        {{ $productDetail->quantity }} {{ $productDetail->unit }}
                    </button>

                </div>
            </div>

            <!-- Buttons -->
            <div class="flex flex-wrap gap-3">
                @if ($productDetail->stock === 0)
                    <a class="bg-gray-400 text-white px-6 py-2.5 rounded-md shadow cursor-not-allowed text-sm">
                        Sold Out
                    </a>
                @else
                    <a href="{{ route('cart', ['add' => $productDetail->id]) }}"
                        class="bg-brand-600 text-white px-6 py-2.5 rounded-md shadow hover:bg-brand-700 transition text-sm flex items-center gap-2">
                        <i class="fas fa-shopping-cart"></i> Add to Cart
                    </a>
                    <a href="{{ route('cart', ['add' => $productDetail->id]) }}"
                        class="border border-brand-600 text-brand-600 px-6 py-2.5 rounded-md shadow hover:bg-brand-50 transition text-sm">
                        Buy Now
                    </a>
                @endif
            </div>

            <!-- Offers -->
            <div class="bg-gray-50 border rounded-lg p-4 space-y-2">
                <h3 class="font-semibold text-gray-700 text-sm">Available Offers</h3>
                <ul class="list-disc list-inside text-gray-600 space-y-1 text-xs">
                    <li>Get extra <span class="font-semibold text-brand-600">₹200 off</span> on orders above ₹2,000
                        (Code:
                        <span class="font-bold">FIT200</span>)
                    </li>
                    <li>Flat <span class="font-semibold text-brand-600">₹100 cashback</span> with UPI payment</li>
                </ul>
            </div>

            <!-- Product Details -->
            <div class="space-y-2 text-sm text-gray-600">
                <h3 class="font-semibold text-gray-800">Product Details</h3>
                <ul class="space-y-1">
                    <li><span class="font-medium">Shelf Life:</span> 6 months</li>
                    <li><span class="font-medium">Ingredients:</span> 100% Natural Organic Ingredients</li>
                    <li><span class="font-medium">Origin:</span> India</li>
                    <li><span class="font-medium">Packaging:</span> Eco-friendly Pouch Pack</li>
                </ul>
            </div>


        </div>
    </div>


    <div class="mt-16">
        <div class="border-b flex space-x-8 text-gray-600 font-medium">
            <button wire:click="$set('activeTab', 'description')"
                class="py-3 px-2 text-base transition {{ $activeTab === 'description' ? 'border-b-2 border-brand-600 text-brand-600' : 'hover:text-brand-600' }}">
                Description
            </button>
            <button wire:click="$set('activeTab', 'reviews')"
                class="py-3 px-2 text-base transition {{ $activeTab === 'reviews' ? 'border-b-2 border-brand-600 text-brand-600' : 'hover:text-brand-600' }}">
                Reviews
            </button>
            <button wire:click="$set('activeTab', 'shipping')"
                class="py-3 px-2 text-base transition {{ $activeTab === 'shipping' ? 'border-b-2 border-brand-600 text-brand-600' : 'hover:text-brand-600' }}">
                Shipping Info
            </button>
        </div>

        <div class="mt-8 text-gray-700 text-base leading-relaxed">
            @if($activeTab === 'description')
                <p>{{ $productDetail->description }}.</p>
            @elseif($activeTab === 'reviews')
                <div class="space-y-6">
                    @forelse($reviews as $review)
                        <div class="border-b pb-4">
                            <p class="font-semibold text-gray-800">
                                {{ $review->user->name }}
                                <span class="text-yellow-500">
                                    {{ str_repeat('★', $review->rating) }}
                                    {{ str_repeat('☆', 5 - $review->rating) }}
                                </span>
                            </p>
                            <p class="text-gray-600">{{ $review->comment }}</p>
                            <p class="text-sm text-gray-400">{{ $review->created_at->diffForHumans() }}</p>
                        </div>
                    @empty
                        <p class="text-gray-500">No reviews yet. Be the first to review this product!</p>
                    @endforelse
                </div>

                {{-- @auth
                    <form wire:submit.prevent="addReview" class="mt-6 space-y-4">
                        <!-- ⭐ Star rating -->
                        <div>
                            <label class="block text-sm mb-1">Rating</label>
                            <div class="flex items-center space-x-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <button type="button" wire:click="$set('rating', {{ $i }})"
                                        class="text-2xl focus:outline-none transition" title="{{ $i }} Star{{ $i > 1 ? 's' : '' }}">
                                        @if($rating >= $i)
                                            <span class="text-yellow-500">★</span>
                                        @else
                                            <span class="text-gray-300">★</span>
                                        @endif
                                    </button>
                                @endfor
                            </div>
                            @error('rating') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm mb-1">Comment</label>
                            <textarea wire:model="comment"
                                class="border rounded w-full px-3 py-2 focus:ring focus:ring-brand-300 focus:border-brand-500"></textarea>
                            @error('comment') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                        </div>

                        <!-- Submit button -->
                        <button class="bg-brand-600 hover:bg-brand-700 text-white px-4 py-2 rounded transition">
                            Submit
                        </button>
                    </form>
                @else
                    <p class="text-gray-500 mt-4">
                        Please <a href="{{ route('login') }}" class="text-brand-600">login</a> to leave a review.
                    </p>
                @endauth --}}
            @elseif($activeTab === 'shipping')
                <div class="space-y-6 text-gray-700 text-sm leading-relaxed">

                    <!-- Delivery Info -->
                    <div class="bg-gray-50 p-5 rounded-xl border">
                        <h3 class="text-base font-semibold text-gray-900 mb-2">Delivery Information</h3>
                        <ul class="list-disc list-inside space-y-1">
                            <li>Standard delivery in <span class="font-medium">4-6 business days</span></li>
                            <li>Express delivery available in select locations</li>
                            <li>Cash on Delivery (COD) available</li>
                        </ul>
                    </div>

                    <!-- Shipping Charges -->
                    <div class="bg-gray-50 p-5 rounded-xl border">
                        <h3 class="text-base font-semibold text-gray-900 mb-2">Shipping Charges</h3>
                        <p>Free delivery on orders above <span class="font-medium">₹499</span>.
                            Orders below ₹499 will incur a shipping fee of ₹50.</p>
                    </div>

                    <!-- Return Policy -->
                    <div class="bg-gray-50 p-5 rounded-xl border">
                        <h3 class="text-base font-semibold text-gray-900 mb-2">Return & Replacement</h3>
                        <p>Easy <span class="font-medium">7-day replacement policy</span> in case of damaged or wrong
                            product delivery.</p>
                    </div>

                    <!-- Extra Info -->
                    <div class="bg-gray-50 p-5 rounded-xl border">
                        <h3 class="text-base font-semibold text-gray-900 mb-2">Other Information</h3>
                        <ul class="list-disc list-inside space-y-1">
                            <li>Packed with care and hygiene</li>
                            <li>Shipped directly from our warehouse</li>
                            <li>Tracking link will be shared via SMS/Email after dispatch</li>
                        </ul>
                    </div>

                </div>
            @endif


        </div>
    </div>

    <!-- Related Products -->
    <div class="mt-20">
        <h2 class="text-2xl font-bold text-gray-900 mb-8">You may also like</h2>

        <div class="mt-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach ($relatedProducts as $product)
                <div
                    class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-all relative border border-gray-200">

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
                        <button wire:click="toggleWishlist({{ $product->id }})" @class([
                            'absolute top-3 right-3 h-9 w-9 flex items-center justify-center rounded-full border shadow-sm transition-all z-10',
                            'text-red-500 bg-red-50 hover:bg-red-100' => $wishlistIds->contains($product->id),
                            'text-gray-400 bg-white hover:bg-gray-100' => !$wishlistIds->contains($product->id),
                        ])>
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
                        <div class="flex items-center justify-center bg-white p-6">
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
                                {{ $product->reviews()->count('id') ?? 0 }}
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
                                class="absolute bottom-4 right-4 h-11 w-11 rounded-full bg-brand-500 hover:bg-brand-600 text-white flex items-center justify-center shadow-lg transition-all">
                                <i class="fas fa-shopping-cart text-lg"></i>
                            </a>
                        @endif


                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>