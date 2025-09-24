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
                <img src="/images/hero-snacks.jpg" alt="Assorted healthy snacks" class="rounded-lg w-full h-auto">
            </div>
        </div>
    </section>

    <section class="bg-white flex flex-col items-center justify-center p-6">
        <!-- Heading -->
        <h1 class="font-poppins text-2xl md:text-3xl font-semibold mb-10">
            CATEGORIES JO DIL JEET LE!
        </h1>

        <!-- Categories Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl w-full">

            <!-- Category Card -->
            @foreach ($showCat as $cat)
                <a href="{{ route('special', [$cat->id, $cat->slug]) }}">
                    <div class="flex flex-col items-center rounded-xl border-2  p-6 hover:shadow-md transition">
                        <img src="{{ $cat->imagelink }}" alt="Whole Spices"
                            class="w-32 h-32 object-contain rounded-full bg-white p-3 mb-4">
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
            <div class="mt-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach ($products as $product)
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
                                    {{ number_format($product->reviews_avg_rating ?? 0, 1) }} ★
                                </span>
                                <span class="text-gray-500 text-sm">
                                    ({{ $product->reviews_count ?? 0 }} reviews)
                                </span>
                            </div>

                            <!-- Product Name -->
                            <h3 class="text-base font-semibold text-gray-900 truncate">
                                {{ $product->name }}
                            </h3>
                            <!-- Category -->
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