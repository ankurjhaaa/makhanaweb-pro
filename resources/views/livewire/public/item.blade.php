<div>
    <div class="bg-gray-50 min-h-screen font-sans text-gray-800 pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            <!-- Breadcrumbs -->
            <nav class="flex items-center text-sm text-gray-500 mb-6 overflow-x-auto whitespace-nowrap">
                <a href="{{ route('home') }}" class="hover:text-orange-600 transition-colors">Home</a>
                @foreach($breadcrumbs as $breadcrumb)
                    <svg class="w-4 h-4 mx-2 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <a href="{{ $breadcrumb['url'] }}"
                        class="hover:text-orange-600 transition-colors {{ $loop->last ? 'text-gray-900 font-medium' : '' }}">
                        {{ $breadcrumb['label'] }}
                    </a>
                @endforeach
            </nav>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-0">

                    <!-- Left Column: Image Gallery (Sticky) -->
                    <div class="lg:col-span-5 p-6 lg:p-8 border-b lg:border-b-0 lg:border-r border-gray-100 bg-white">
                        <div class="sticky top-24">
                            <!-- Main Image Container -->
                            <div
                                class="relative group w-full aspect-[4/5] sm:aspect-square flex items-center justify-center bg-gray-50 rounded-xl overflow-hidden mb-6">

                                <!-- Wishlist Button -->
                                <button wire:click="toggleWishlist({{ $productDetail->id }})"
                                    class="absolute top-4 right-4 z-10 w-10 h-10 flex items-center justify-center rounded-full bg-white shadow-md hover:shadow-lg hover:scale-110 transition-all duration-300 group-hover:opacity-100">
                                    <i
                                        class="fas fa-heart text-lg {{ $wishlistIds->contains($productDetail->id) ? 'text-red-500' : 'text-gray-300 hover:text-red-400' }}"></i>
                                </button>

                                <!-- Tags -->
                                @if($productDetail->stock > 0)
                                    <span
                                        class="absolute top-4 left-4 bg-green-100 text-green-700 text-xs font-bold px-3 py-1 rounded-full">
                                        In Stock
                                    </span>
                                @else
                                    <span
                                        class="absolute top-4 left-4 bg-gray-100 text-gray-500 text-xs font-bold px-3 py-1 rounded-full">
                                        Sold Out
                                    </span>
                                @endif

                                <img src="{{ $productDetail->imagelink }}" alt="{{ $productDetail->name }}"
                                    class="max-w-[85%] h-100 object-contain transform group-hover:scale-105 transition duration-500 ease-in-out drop-shadow-xl "
                                    id="mainImage">
                            </div>

                            <!-- Action Buttons -->
                            <div class="grid grid-cols-2 gap-4">
                                @if ($productDetail->stock > 0)
                                    <a href="{{ route('cart', ['add' => $productDetail->id]) }}"
                                        class="col-span-1 bg-white border-2 border-orange-500 text-orange-600 hover:bg-orange-50 py-3.5 rounded-xl text-base font-bold shadow-sm transition-all flex items-center justify-center gap-2">
                                        <i class="fas fa-shopping-cart"></i> Add to Cart
                                    </a>
                                    <a href="{{ route('cart', ['add' => $productDetail->id]) }}"
                                        class="col-span-1 bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 text-white py-3.5 rounded-xl text-base font-bold shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                                        <i class="fas fa-bolt"></i> Buy Now
                                    </a>
                                @else
                                    <button disabled
                                        class="col-span-2 bg-gray-100 text-gray-400 py-4 rounded-xl font-bold cursor-not-allowed border border-gray-200">
                                        Notify Me When Available
                                    </button>
                                @endif
                            </div>

                            <!-- Safety/Quality Icons -->
                            <div class="mt-8 flex justify-center gap-6 text-center">
                                <div class="flex flex-col items-center gap-1 group">
                                    <div
                                        class="w-10 h-10 bg-green-50 text-green-600 rounded-full flex items-center justify-center mb-1 group-hover:bg-green-100 transition">
                                        <i class="fas fa-leaf"></i>
                                    </div>
                                    <span class="text-[10px] text-gray-500 font-medium uppercase tracking-wide">100%
                                        Natural</span>
                                </div>
                                <div class="flex flex-col items-center gap-1 group">
                                    <div
                                        class="w-10 h-10 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mb-1 group-hover:bg-blue-100 transition">
                                        <i class="fas fa-certificate"></i>
                                    </div>
                                    <span class="text-[10px] text-gray-500 font-medium uppercase tracking-wide">FSSAI
                                        Cert.</span>
                                </div>
                                <div class="flex flex-col items-center gap-1 group">
                                    <div
                                        class="w-10 h-10 bg-amber-50 text-amber-600 rounded-full flex items-center justify-center mb-1 group-hover:bg-amber-100 transition">
                                        <i class="fas fa-shipping-fast"></i>
                                    </div>
                                    <span class="text-[10px] text-gray-500 font-medium uppercase tracking-wide">Fast
                                        Shipping</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Product Details -->
                    <div class="lg:col-span-7 p-6 lg:p-10">

                        <!-- Header -->
                        <div class="border-b border-gray-100 pb-6 mb-6">
                            <div class="flex items-center gap-2 mb-2">
                                <a href="{{ route('category', $productDetail->category->slug) }}"
                                    class="text-xs font-bold text-orange-600 uppercase tracking-wider bg-orange-50 px-2 py-1 rounded">
                                    {{ $productDetail->category->name }}
                                </a>
                                <a href="#reviews"
                                    class="flex items-center gap-1 text-sm text-gray-500 hover:text-orange-600 transition">
                                    <div class="flex text-amber-400 text-xs">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i
                                                class="fas fa-star {{ $i <= ($productDetail->reviews()->avg('rating') ?? 4) ? '' : 'text-gray-200' }}"></i>
                                        @endfor
                                    </div>
                                    ({{ $reviews->count() }} Reviews)
                                </a>
                            </div>

                            <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 leading-tight mb-4">
                                {{ $productDetail->name }}
                            </h1>

                            <div class="flex items-end gap-3">
                                <span
                                    class="text-4xl font-bold text-gray-900">₹{{ number_format($productDetail->price) }}</span>
                                @if($productDetail->mrp > $productDetail->price)
                                    <span
                                        class="text-lg text-gray-400 line-through mb-1">₹{{ number_format($productDetail->mrp) }}</span>
                                    <span class="text-green-600 font-bold mb-1 text-sm bg-green-50 px-2 py-0.5 rounded">
                                        {{ round((($productDetail->mrp - $productDetail->price) / $productDetail->mrp) * 100) }}%
                                        OFF
                                    </span>
                                @endif
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Inclusive of all taxes</p>
                        </div>

                        <!-- Offers & Promotions -->
                        <div class="bg-blue-50/50 border border-blue-100 rounded-xl p-4 mb-8">
                            <h3 class="flex items-center gap-2 font-semibold text-gray-900 mb-3 text-sm">
                                <i class="fas fa-tags text-blue-600"></i> Offers for you
                            </h3>
                            <div class="grid gap-2 text-sm text-gray-700">
                                <div class="flex items-start gap-2">
                                    <span class="text-green-600 mt-0.5"><i class="fas fa-check-circle"></i></span>
                                    <div><span class="font-bold">Flat ₹100 Off</span> on your first order. Use code
                                        <span
                                            class="font-mono bg-white px-1 border rounded text-xs font-bold">WELCOME100</span>
                                    </div>
                                </div>
                                <div class="flex items-start gap-2">
                                    <span class="text-green-600 mt-0.5"><i class="fas fa-check-circle"></i></span>
                                    <div><span class="font-bold">Bulk Discount:</span> Buy 3 get 5% additional off.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-8">
                            <h3 class="text-lg font-bold text-gray-900 mb-3">About this item</h3>
                            <div class="prose prose-sm text-gray-600 leading-relaxed">
                                <p>{{ $productDetail->description }}</p>
                                <ul class="mt-4 grid sm:grid-cols-2 gap-2 text-sm">
                                    <li class="flex items-center gap-2"><svg class="w-4 h-4 text-green-500" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg> Premium Quality Fox Nuts</li>
                                    <li class="flex items-center gap-2"><svg class="w-4 h-4 text-green-500" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg> Rich in Antioxidants</li>
                                    <li class="flex items-center gap-2"><svg class="w-4 h-4 text-green-500" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg> Zero Trans Fat</li>
                                    <li class="flex items-center gap-2"><svg class="w-4 h-4 text-green-500" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg> Quantity: {{ $productDetail->quantity }} {{ $productDetail->unit }}</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Delivery Checker -->
                        <div class="mb-8 border-t border-gray-100 pt-6">
                            <label class="block text-sm font-semibold text-gray-900 mb-2">Check Delivery</label>
                            <div class="flex max-w-sm">
                                <div class="relative flex-grow">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-map-marker-alt text-gray-400"></i>
                                    </div>
                                    <input type="text"
                                        class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-l-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500 sm:text-sm"
                                        placeholder="Enter Pincode">
                                </div>
                                <button
                                    class="bg-gray-900 text-white px-6 py-2 rounded-r-lg text-sm font-semibold hover:bg-gray-800 transition">Check</button>
                            </div>
                            <p class="mt-2 text-xs text-green-600 flex items-center gap-1">
                                <i class="fas fa-truck"></i> Free delivery by {{ now()->addDays(4)->format('l, d M') }}
                            </p>
                        </div>

                        <!-- Reviews Section ID Link -->
                        <div id="reviews" class="border-t border-gray-100 pt-8">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-xl font-bold text-gray-900">Ratings & Reviews</h3>
                                <button class="text-orange-600 font-semibold text-sm hover:underline">Write a
                                    Review</button>
                            </div>

                            <div class="grid gap-6">
                                @forelse($reviews->take(3) as $review)
                                    <div class="bg-gray-50 rounded-xl p-5 border border-gray-100">
                                        <div class="flex items-center justify-between mb-3">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="w-8 h-8 rounded-full bg-white border border-gray-200 flex items-center justify-center font-bold text-gray-700 text-xs">
                                                    {{ substr($review->user->name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <p class="text-sm font-bold text-gray-900">{{ $review->user->name }}</p>
                                                    <div class="flex text-amber-400 text-[10px]">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <i
                                                                class="fas fa-star {{ $i <= $review->rating ? '' : 'text-gray-200' }}"></i>
                                                        @endfor
                                                    </div>
                                                </div>
                                            </div>
                                            <span
                                                class="text-xs text-gray-400">{{ $review->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-gray-600 text-sm leading-relaxed">
                                            "{{ $review->comment }}"
                                        </p>
                                    </div>
                                @empty
                                    <div class="text-center py-8">
                                        <p class="text-gray-500">No reviews yet. Be the first to review!</p>
                                    </div>
                                @endforelse
                            </div>

                            @if($reviews->count() > 3)
                                <button
                                    class="w-full mt-4 py-2 text-sm font-semibold text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                                    View all {{ $reviews->count() }} reviews
                                </button>
                            @endif
                        </div>

                    </div>
                </div>
            </div>

            <!-- Similar Products -->
            <div class="mt-16">
                <h2 class="text-2xl font-bold text-gray-900 mb-8">Similar Products</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
                    @foreach ($relatedProducts as $product)
                        <a href="{{ route('item', $product->slug) }}"
                            class="group bg-white border border-gray-100 rounded-xl p-4 hover:shadow-xl hover:border-orange-100 transition-all duration-300">
                            <div
                                class="aspect-square bg-gray-50 rounded-lg mb-4 flex items-center justify-center overflow-hidden relative">
                                <img src="{{ $product->imagelink }}?tr=w-300,h-300" alt="{{ $product->name }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition duration-500">

                                @if($product->mrp && $product->mrp > $product->price)
                                    <span
                                        class="absolute top-2 left-2 bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded">
                                        {{ round((($product->mrp - $product->price) / $product->mrp) * 100) }}% OFF
                                    </span>
                                @endif
                            </div>


                            <h3
                                class="font-medium text-gray-900 mb-1 truncate group-hover:text-orange-600 transition-colors">
                                {{ $product->name }}
                            </h3>

                            <div class="flex items-center justify-between mt-2">
                                <div class="flex flex-col">
                                    <span class="text-lg font-bold text-gray-900">₹{{ $product->price }}</span>
                                    @if($product->mrp)
                                        <span class="text-xs text-gray-400 line-through">₹{{ $product->mrp }}</span>
                                    @endif
                                </div>
                                <div
                                    class="w-8 h-8 rounded-full bg-gray-100 text-gray-600 flex items-center justify-center group-hover:bg-orange-500 group-hover:text-white transition">
                                    <i class="fas fa-arrow-right text-xs"></i>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

        </div>

    </div>