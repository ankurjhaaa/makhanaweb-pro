<div class="bg-white min-h-screen px-4 sm:px-8 lg:px-16 py-10">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        <!-- Product Image -->
        <div class="flex justify-center items-start">
            <img src="{{ $productDetail->imagelink }}" alt="{{ $productDetail->name }}"
                class="rounded-2xl shadow-lg w-full max-w-lg h-[480px] object-cover hover:scale-105 transition duration-300">
        </div>

        <!-- Product Details -->
        <div class="space-y-8">
            <!-- Title -->
            <h1 class="text-4xl font-bold text-gray-900">{{ $productDetail->name }}</h1>

            <div class="flex items-center space-x-5 text-lg">
                <!-- <span class="text-yellow-500">★★★★★</span>
                <span class="text-gray-600 text-sm">(124 reviews)</span> -->
                @if ($productDetail->stock === 0)
                    <span class="text-gray-400 font-medium">Out Of stock</span>
                @else
                    <span class="text-green-600 font-medium">In Stock</span>
                @endif
            </div>

            <div class="flex items-center space-x-3 text-xl">
                <span class="font-bold text-brand-600">₹{{ $productDetail->price }}</span>
                <span class="text-gray-400 line-through">₹{{ $productDetail->mrp }}</span>
                <span
                    class="bg-green-100 text-green-600 text-sm px-2 py-1 rounded-lg">{{ round((($productDetail->mrp - $productDetail->price) / $productDetail->mrp) * 100) }}%
                    OFF</span>

            </div>


            <div class="flex gap-4">
                @auth
                    <button wire:click="toggleWishlist({{ $productDetail->id }})" @class([
                        'h-11 w-11 flex items-center justify-center rounded-full border shadow-sm transition-colors',
                        'text-red-500 bg-red-50 hover:bg-red-100' => $wishlistIds->contains($productDetail->id),
                        'text-gray-400 bg-white hover:bg-gray-100' => !$wishlistIds->contains($productDetail->id),
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
                    class="h-11 px-5 flex items-center gap-2 rounded-full border border-blue-600 text-blue-600 hover:bg-blue-50 transition font-medium shadow-sm">
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
                        // fallback
                        navigator.clipboard.writeText(window.location.href).then(() => {
                            alert("Link copied to clipboard!");
                        });
                    }
                }
            </script>



            <!-- Coupon Section -->
            <div class="bg-gray-50 border rounded-xl p-6 space-y-3">
                <h3 class="font-semibold text-gray-700 text-lg">Available Offers</h3>
                <ul class="list-disc list-inside text-gray-600 space-y-2 text-sm">
                    <li>Get extra <span class="font-semibold text-brand-600">₹200 off</span> on orders above ₹2,000 (Use
                        code: <span class="font-bold">FIT200</span>)</li>
                    <li>Flat <span class="font-semibold text-brand-600">₹100 cashback</span> with UPI payment</li>
                </ul>
            </div>

            <p class="text-gray-600 text-base leading-relaxed">
                {{ $productDetail->description }}
            </p>

            <!-- Buttons -->
            <div class="flex flex-wrap gap-4">
                @if ($productDetail->stock === 0)
                    <a class="bg-gray-400 text-white px-10 py-3 rounded-xl shadow  transition font-semibold text-lg">
                        Sold Out
                    </a>
                @else
                    <a href="{{ route('cart', ['add' => $productDetail->id]) }}"
                        class="bg-brand-600 text-white px-10 py-3 rounded-xl shadow hover:bg-brand-700 transition font-semibold text-lg">
                        Add to Cart
                    </a>
                    <a href="{{ route('cart', ['add' => $productDetail->id]) }}"
                        class="border border-brand-600 text-brand-600 px-10 py-3 rounded-xl shadow hover:bg-brand-50 transition font-semibold text-lg">
                        Buy Now
                    </a>
                @endif

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

    @auth
        <form wire:submit.prevent="addReview" class="mt-6 space-y-4">
            <!-- ⭐ Star rating -->
            <div>
                <label class="block text-sm mb-1">Rating</label>
                <div class="flex items-center space-x-1">
                    @for($i = 1; $i <= 5; $i++)
                        <button type="button"
                                wire:click="$set('rating', {{ $i }})"
                                class="text-2xl focus:outline-none transition"
                                title="{{ $i }} Star{{ $i > 1 ? 's' : '' }}">
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

            <!-- 💬 Comment -->
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
    @endauth
@endif

        </div>
    </div>

    <!-- Related Products -->
    <div class="mt-20">
        <h2 class="text-2xl font-bold text-gray-900 mb-8">You may also like</h2>

        <div class="mt-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($relatedProducts as $item)
                <div class="bg-white rounded-lg border border-gray-100 p-6 transition-all hover:border-brand-200 relative">

                    <!-- Wishlist Button -->
                    <button wire:click="toggleWishlist({{ $item->id }})" @class([
                        'absolute top-3 right-3 h-9 w-9 flex items-center justify-center rounded-full border shadow-sm transition-colors',
                        'text-red-500 bg-red-50 hover:bg-red-100' => $wishlistIds->contains($item->id),
                        'text-gray-400 bg-white hover:bg-gray-100' => !$wishlistIds->contains($item->id),
                    ])>
                        <i class="fas fa-heart"></i>
                    </button>

                    <div class="text-xs uppercase tracking-wider font-medium text-brand-600 mb-3">
                        {{ $item->category->name ?? 'Uncategorized' }}
                    </div>

                    <a href="{{ route('item', $item->slug) }}">
                        <div class="aspect-w-1 aspect-h-1 mb-5">
                            <img src="{{ $item->imagelink }}?tr=w-200,h-200,fo-face,f-auto,q-10" alt="{{ $item->name }}"
                                loading="lazy" class="w-full h-48 object-cover rounded-md">
                        </div>
                    </a>

                    <h3 class="font-poppins font-semibold text-lg">{{ $item->name }}</h3>
                    <p class="text-gray-600 text-sm mt-2">{{ Str::limit($item->description, 80) }}</p>

                    <div class="mt-4 flex items-center justify-between">
                        <div>
                            <span class="text-brand-600 font-bold text-lg">₹{{ $item->price }}</span>
                            @if($item->old_price)
                                <span class="text-gray-400 text-sm line-through ml-2">₹{{ $item->old_price }}</span>
                            @endif
                        </div>
                        @if ($item->stock === 0)
                            <a class="bg-gray-400 text-white px-4 py-2 rounded-full hover:bg-brand-700 transition-all text-sm">
                                Sold Out
                            </a>
                        @else
                            <a href="{{ route('cart', ['add' => $item->id]) }}"
                                class="bg-brand-600 text-white px-4 py-2 rounded-full hover:bg-brand-700 transition-all text-sm">
                                Add to Cart
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>