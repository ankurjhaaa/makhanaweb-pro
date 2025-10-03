<div class="bg-white text-gray-800">
    <!-- Hero -->
    <section
        class="max-w-7xl mx-auto px-4 sm:px-6 py-12 md:py-20 grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 items-center">
        <div>
            <h1 class="font-poppins text-4xl sm:text-5xl md:text-6xl font-bold leading-tight">
                Healthy, Tasty &amp; <span class="text-brand-600">Guilt-Free Snacks</span>
            </h1>

            <p class="mt-6 text-gray-600 text-lg leading-relaxed">
                Direct from Nature — Premium makhana, authentic spices, and natural snacks that nourish your body and
                delight your taste buds.
            </p>

            <div class="mt-8 flex flex-wrap gap-4">
                <a href="{{ route('shop') }}"
                    class="bg-brand-600 text-white px-6 py-3 rounded-full hover:bg-brand-700 transition-all font-medium">
                    Shop Now
                </a>
                <a href="{{ route('contact') }}"
                    class="border-2 border-brand-600 text-brand-600 px-6 py-3 rounded-full hover:bg-brand-50 transition-all font-medium">
                    Learn More
                </a>
            </div>

            <div class="mt-12 grid grid-cols-3 gap-6 max-w-md">
                <div class="border-l-4 border-brand-600 pl-4">
                    <div class="font-poppins font-bold text-2xl text-brand-600">10k+</div>
                    <div class="text-gray-600 text-sm mt-1">Happy Customers</div>
                </div>
                <div class="border-l-4 border-brand-600 pl-4">
                    <div class="font-poppins font-bold text-2xl text-brand-600">50+</div>
                    <div class="text-gray-600 text-sm mt-1">Premium Products</div>
                </div>
                <div class="border-l-4 border-brand-600 pl-4">
                    <div class="font-poppins font-bold text-2xl text-brand-600">4.9★</div>
                    <div class="text-gray-600 text-sm mt-1">Customer Rating</div>
                </div>
            </div>
        </div>

        <div class="flex justify-end mt-8 md:mt-0">
            <div class="w-full max-w-lg rounded-lg border-4 border-brand-100 p-4">
                <img src="https://media.istockphoto.com/id/1020058602/vector/traditional-diwali-celebration-at-home-with-food.jpg?s=612x612&w=0&k=20&c=PfSWitf5C4M4gAKTCyUTaO2WIisevU2Sy5cmgFri8ZI="
                    alt="Assorted healthy snacks" class="rounded-lg w-full h-auto">
            </div>
        </div>
    </section>

    <section class="bg-white flex flex-col items-center justify-center p-6">
        <!-- Heading -->
        <h1 class="font-poppins text-2xl md:text-3xl font-semibold mb-10">
            SPECIAL CATEGORIES
        </h1>

        <!-- Categories Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl w-full">

            <!-- Category Card -->
            @foreach ($showCat as $cat)
                <a href="{{ route('special', [$cat->id, $cat->slug]) }}">
                    <div class="flex flex-col items-center rounded-xl border-2  p-6 hover:shadow-md transition">
                        <img src="{{ $cat->imagelink }}" alt="Whole Spices"
                            class="w-32 h-32 object-cover rounded-full bg-white p-3 mb-4">
                        <h2 class="text-lg font-semibold text-gray-600">{{ $cat->name }}</h2>
                    </div>
                </a>
            @endforeach

        </div>
    </section>
    <!-- Featured Products -->
    <section class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="text-center">
                <h2 class="font-poppins text-3xl md:text-4xl font-semibold">Featured Products</h2>
                <p class="text-gray-600 mt-4 max-w-2xl mx-auto">
                    Discover our handpicked selection of premium healthy snacks, crafted with love and tested for
                    purity.
                </p>
            </div>

            <!-- Product Grid -->
            <!-- Product Grid -->
            <div class="mt-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6">
                @foreach ($products as $product)
                    <div
                        class="bg-white rounded-2xl border border-gray-100 relative overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500 hover:-translate-y-2 group">

                        <!-- Offer Badge -->
                        @if ($product->mrp && $product->mrp > $product->price)
                            @php
                                $discount = round((($product->mrp - $product->price) / $product->mrp) * 100);
                            @endphp
                            <div
                                class="absolute top-3 left-3 bg-gradient-to-r from-red-500 to-pink-500 text-white text-xs font-bold px-2 sm:px-3 py-1 rounded-full shadow-lg z-20 ">
                                {{ $discount }}% OFF
                            </div>
                        @endif

                        <!-- Wishlist Button -->
                        @auth
                            <button wire:click="toggleWishlist({{ $product->id }})" @class([
                                'absolute top-3 right-3 h-8 w-8 sm:h-10 sm:w-10 flex items-center justify-center rounded-full shadow-lg transition-all duration-300 z-20 hover:scale-110',
                                'text-red-500 bg-white border-2 border-red-500' => $wishlistIds->contains($product->id),
                                'text-gray-400 bg-white border-2 border-gray-200 hover:border-red-400 hover:text-red-500' => !$wishlistIds->contains($product->id),
                            ])>
                                <i @class([
                                    'fas fa-heart text-sm' => $wishlistIds->contains($product->id),
                                    'far fa-heart text-sm hover:fas' => !$wishlistIds->contains($product->id)
                                ])></i>
                            </button>
                        @else
                            <a href="{{ route('login') }}"
                                class="absolute top-3 right-3 h-8 w-8 sm:h-10 sm:w-10 flex items-center justify-center rounded-full border-2 border-gray-200 shadow-lg text-gray-400 bg-white hover:border-red-400 hover:text-red-500 hover:scale-110 transition-all duration-300 z-20">
                                <i class="far fa-heart text-sm hover:fas"></i>
                            </a>
                        @endauth

                        <!-- Product Image -->
                        <a wire:navigate href="{{ route('item', $product->slug) }}" class="block">
                            <div class="relative overflow-hidden bg-gradient-to-br from-green-50 to-green-100 aspect-square">
                                <img src="{{ $product->imagelink }}?tr=w-500,h-500,f-auto,q-90" alt="{{ $product->name }}"
                                    class="w-full h-full object-contain p-4 sm:p-6 transition-all duration-700 group-hover:scale-110 group-hover:rotate-2"
                                    loading="lazy"
                                    onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAwIiBoZWlnaHQ9IjQwMCIgdmlld0JveD0iMCAwIDQwMCA0MDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSI0MDAiIGhlaWdodD0iNDAwIiBmaWxsPSIjRkVGM0UyIi8+CjxjaXJjbGUgY3g9IjIwMCIgY3k9IjE4MCIgcj0iNDAiIGZpbGw9IiNGOTdGMTYiLz4KPHBhdGggZD0iTTE2MCAyNDBIMjQwVjI4MEgxNjBWMjQwWiIgZmlsbD0iI0Y5N0YxNiIvPgo8dGV4dCB4PSIyMDAiIHk9IjMzMCIgZmlsbD0iI0Y5N0YxNiIgZm9udC1zaXplPSIxNCIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZm9udC1mYW1pbHk9IkFyaWFsIj5Gb29kIEl0ZW08L3RleHQ+Cjwvc3ZnPg=='" />

                                <!-- Fresh Badge for Food -->
                                <div
                                    class="absolute bottom-3 left-3 bg-green-500 text-white text-xs font-semibold px-2 py-1 rounded-full opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-2 group-hover:translate-y-0">
                                    <i class="fas fa-leaf mr-1"></i>Fresh
                                </div>
                            </div>
                        </a>

                        <!-- Product Info -->
                        <div class="p-4 sm:p-5 space-y-2"> <!-- yaha 3 se 2 -->
                            <!-- Rating & Reviews -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-1">
                                    <div
                                        class="flex items-center bg-green-500 text-white text-xs font-bold px-2 py-1 rounded-md shadow-sm">
                                        <i class="fas fa-star mr-1"></i>
                                        {{ number_format($product->reviews_avg_rating ?? 4.2, 1) }}
                                    </div>
                                    <span class="text-gray-500 text-xs ml-1">
                                        ({{ $product->reviews_count ?? 0 }} reviews)
                                    </span>
                                </div>
                                <!-- Category Badge -->
                                <span class="text-xs text-orange-600 bg-green-100 px-2 py-1 rounded-full font-medium">
                                    {{ $product->category->name ?? 'Food' }}
                                </span>
                            </div>

                            <!-- Product Name -->
                            <div>
                                <h3
                                    class="text-sm sm:text-base font-bold text-gray-900 line-clamp-2 leading-snug group-hover:text-orange-600 transition-colors duration-300">
                                    {{ $product->name }}
                                </h3>
                            </div>

                            <!-- Price Section -->
                            <div class="space-y-0.5"> <!-- 1 se 0.5 -->
                                <div class="flex items-center gap-2">
                                    <span
                                        class="text-lg sm:text-xl font-black text-gray-900">₹{{ number_format($product->price, 0) }}</span>
                                    @if ($product->mrp && $product->mrp > $product->price)
                                        <span
                                            class="text-sm text-gray-400 line-through">₹{{ number_format($product->mrp, 0) }}</span>
                                    @endif
                                </div>
                                @if ($product->mrp && $product->mrp > $product->price)
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm text-green-600 font-semibold">
                                            You Save ₹{{ number_format($product->mrp - $product->price, 0) }}
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <!-- Delivery Info -->

                            <div class="flex items-center gap-4 text-xs text-gray-600">
                                @if ($product->price > 1000)
                                    <div class="flex items-center gap-1">
                                        <i class="fas fa-truck text-green-600"></i>
                                        <span>Free Delivery</span>
                                    </div>
                                @endif
                                @if ($product->stock)
                                    <div class="flex items-center gap-2 text-yellow-600 font-medium">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        <span>Limited Stock Only</span>
                                    </div>
                                @else
                                    <div class="flex items-center gap-2 text-red-600 font-medium">
                                        <i class="fas fa-times-circle"></i>
                                        <span>Out of Stock</span>
                                    </div>
                                @endif

                            </div>
                        </div>


                        <!-- Add to Cart Button - Hidden initially, shows on hover -->
                        <div
                            class="absolute bottom-0 left-0 right-0 p-4 sm:p-5 bg-gradient-to-t from-white via-white to-transparent transform translate-y-full group-hover:translate-y-0 transition-all duration-500 ease-out">
                            @if ($product->stock)
                                <a href="{{ route('cart', ['add' => $product->id]) }}"
                                    class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold py-3 px-4 rounded-xl transition-all duration-300 flex items-center justify-center gap-2 shadow-lg hover:shadow-xl transform hover:scale-105">
                                    <i class="fas fa-shopping-cart text-sm"></i>
                                    <span class="text-sm">Add to Cart</span>
                                </a>
                            @else
                                <button disabled
                                    class="w-full bg-gray-400 text-white font-bold py-3 px-4 rounded-xl transition-all duration-300 flex items-center justify-center gap-2 shadow-lg hover:shadow-xl transform hover:scale-105">
                                    <i class="fas fa-shopping-cart text-sm"></i>
                                    <span class="text-sm">Add to Cart</span>
                                </button>
                            @endif

                        </div>

                    </div>
                @endforeach
            </div>

            <!-- Empty State -->
            @if($products->isEmpty())
                <div class="mt-12 text-center py-16">
                    <div class="max-w-md mx-auto">
                        <div class="w-24 h-24 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-utensils text-3xl text-gray-400"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">No Food Items Found</h3>
                        <p class="text-gray-600">Try adjusting your filters or search terms.</p>
                    </div>
                </div>
            @endif


            <div class="mt-10 text-center">
                <a href="{{ route('shop') }}"
                    class="inline-block border-2 border-brand-600 text-brand-600 px-6 py-3 rounded-full hover:bg-brand-50 transition-all font-medium">
                    View All Products
                </a>
            </div>
        </div>
    </section>







    <!-- Testimonials -->
    <section class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <h3 class="font-poppins text-2xl md:text-3xl font-semibold text-center">What Our Customers Say</h3>
            <p class="text-center text-gray-600 mt-2 max-w-2xl mx-auto">Food reviews from real people who love our
                products</p>

            <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-lg border border-gray-100">
                    <div class="flex justify-between items-center">
                        <div>
                            <div class="font-poppins font-semibold">Priya Sharma</div>
                            <div class="text-sm text-gray-500">Mumbai</div>
                        </div>
                        <div
                            class="w-12 h-12 bg-brand-100 rounded-full flex items-center justify-center text-brand-600 font-poppins font-bold">
                            PS</div>
                    </div>
                    <div class="text-yellow-400 mt-4">★★★★★</div>
                    <p class="text-gray-600 mt-3 leading-relaxed">"The makhana quality is exceptional! My kids love the
                        roasted flavored ones. Will definitely order again."</p>
                </div>

                <div class="bg-white p-6 rounded-lg border border-gray-100">
                    <div class="flex justify-between items-center">
                        <div>
                            <div class="font-poppins font-semibold">Rajesh Kumar</div>
                            <div class="text-sm text-gray-500">Delhi</div>
                        </div>
                        <div
                            class="w-12 h-12 bg-brand-100 rounded-full flex items-center justify-center text-brand-600 font-poppins font-bold">
                            RK</div>
                    </div>
                    <div class="text-yellow-400 mt-4">★★★★★</div>
                    <p class="text-gray-600 mt-3 leading-relaxed">"Best spices I've ever bought online. Authentic taste
                        and aroma. Your's Snacks has become our go-to brand."</p>
                </div>

                <div class="bg-white p-6 rounded-lg border border-gray-100">
                    <div class="flex justify-between items-center">
                        <div>
                            <div class="font-poppins font-semibold">Anjali Patel</div>
                            <div class="text-sm text-gray-500">Pune</div>
                        </div>
                        <div
                            class="w-12 h-12 bg-brand-100 rounded-full flex items-center justify-center text-brand-600 font-poppins font-bold">
                            AP</div>
                    </div>
                    <div class="text-yellow-400 mt-4">★★★★★</div>
                    <p class="text-gray-600 mt-3 leading-relaxed">"I love the healthy snack options! Perfect for my
                        family's wellness journey. Great packaging and fast delivery."</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-16 bg-white border-t border-gray-100">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 text-center">
            <h3 class="font-poppins text-2xl md:text-3xl font-semibold">Ready to Start Your Healthy Journey?</h3>
            <p class="text-gray-600 mt-4 max-w-2xl mx-auto">Join thousands of satisfied customers who trust Your's
                Snacks for their daily nutrition needs.</p>
            <div class="mt-8 flex flex-wrap items-center justify-center gap-4">
                <a href="{{ route('shop') }}"
                    class="bg-brand-600 text-white px-8 py-4 rounded-full hover:bg-brand-700 transition-all font-medium">Shop
                    All Products</a>
                <a href="#"
                    class="border-2 border-brand-600 text-brand-600 px-8 py-4 rounded-full hover:bg-brand-50 transition-all font-medium">View
                    Our Story</a>
            </div>
        </div>
    </section>



    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Mobile menu toggle
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');

            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function () {
                    mobileMenu.classList.toggle('hidden');
                });
            }
        });
    </script>
</div>