<div class="bg-white text-gray-800">
    <!-- Hero -->
    <section class="relative bg-linear-to-br from-amber-50 via-white to-orange-50">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-16 md:py-24 grid md:grid-cols-2 gap-12 items-center">

            <!-- LEFT CONTENT -->
            <div>

                <!-- Badge -->
                <span class="inline-block bg-amber-100 text-amber-700 text-sm font-medium px-4 py-1 rounded-full mb-6">
                    🌿 100% Natural & Premium Quality
                </span>

                <!-- Heading -->
                <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold leading-tight text-gray-900">
                    Pure Taste,
                    <span class="text-primary">Healthy Snacking</span>
                    Everyday
                </h1>

                <!-- Paragraph -->
                <p class="mt-6 text-gray-600 text-lg leading-relaxed max-w-lg">
                    Discover freshly roasted makhana crafted with authentic flavors.
                    Light, crunchy, and packed with nutrition — guilt-free snacking made simple.
                </p>

                <!-- Buttons -->
                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="{{ route('shop') }}"
                        class="bg-primary text-white px-7 py-3 rounded-full shadow-md hover:shadow-lg hover:scale-105 transition font-medium">
                        Shop Now
                    </a>

                    <a href="{{ route('contact') }}"
                        class="text-gray-700 font-medium hover:text-primary transition flex items-center gap-2">
                        Learn More
                        <i class="fa-solid fa-arrow-right text-sm"></i>
                    </a>
                </div>

                <!-- Stats -->
                <div class="mt-12 flex gap-10">

                    <div>
                        <div class="text-3xl font-bold text-gray-900">10K+</div>
                        <div class="text-sm text-gray-500 mt-1">Happy Customers</div>
                    </div>

                    <div>
                        <div class="text-3xl font-bold text-gray-900">50+</div>
                        <div class="text-sm text-gray-500 mt-1">Premium Products</div>
                    </div>

                    <div>
                        <div class="text-3xl font-bold text-gray-900">4.9★</div>
                        <div class="text-sm text-gray-500 mt-1">Customer Rating</div>
                    </div>

                </div>

            </div>

            <!-- RIGHT IMAGE -->
            <div class="relative flex justify-center">

                <!-- Soft background circle -->
                <div class="absolute w-80 h-80 bg-amber-200 rounded-full blur-3xl opacity-40"></div>

                <img src="https://media.istockphoto.com/id/1020058602/vector/traditional-diwali-celebration-at-home-with-food.jpg?s=612x612&w=0&k=20&c=PfSWitf5C4M4gAKTCyUTaO2WIisevU2Sy5cmgFri8ZI="
                    alt="Healthy Makhana Snacks"
                    class="relative w-full max-w-md rounded-3xl shadow-2xl hover:scale-105 transition duration-500">

            </div>

        </div>

    </section>

  

    <section class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">

            <!-- Heading -->
            <div class="text-center">
                <h2 class="text-2xl md:text-3xl font-semibold text-gray-900">
                    Featured Products
                </h2>
                <p class="text-gray-500 mt-3 text-sm max-w-xl mx-auto">
                    Premium makhana & healthy snacks crafted with purity.
                </p>
            </div>

            <!-- Grid -->
            <div class="mt-12 grid sm:grid-cols-3 lg:grid-cols-4 gap-8">

                @foreach ($products as $product)
                    <div class="bg-white rounded-xl border border-gray-200 p-5 relative">

                        <!-- Discount Badge -->
                        @if ($product->mrp && $product->mrp > $product->price)
                            @php
                                $discount = round((($product->mrp - $product->price) / $product->mrp) * 100);
                            @endphp
                            <span class="absolute top-4 left-4 bg-red-500 text-white text-xs px-2 py-1 rounded">
                                {{ $discount }}% OFF
                            </span>
                        @endif

                        <!-- Wishlist -->
                        @auth
                            <button wire:click="toggleWishlist({{ $product->id }})"
                                class="absolute top-4 right-4 text-3xl
                                                                                                                                                            {{ $wishlistIds->contains($product->id) ? 'text-red-500' : 'text-gray-400' }}">
                                <i class="fas fa-heart"></i>
                            </button>
                        @else
                            <a href="{{ route('login') }}" class="absolute top-4 right-4 text-gray-400 text-3xl">
                                <i class="fas fa-heart"></i>
                            </a>
                        @endauth

                        <!-- Image -->
                        <a wire:navigate href="{{ route('item', $product->slug) }}">
                            <div class="w-full h-60 bg-gray-50 rounded-lg overflow-hidden">
                                <img src="{{ $product->imagelink }}" alt="{{ $product->name }}"
                                    class="w-full h-full object-cover">
                            </div>
                        </a>

                        <!-- Info -->
                        <div class="mt-5">

                            <!-- Category -->
                            <span class="text-xs font-medium text-primary">
                                {{ $product->category->name ?? 'Makhana' }}
                            </span>

                            <!-- Name -->
                            <h3 class="text-sm font-medium text-gray-800 leading-snug line-clamp-2 mt-1">
                                {{ $product->name }}
                            </h3>

                            <!-- Rating -->
                            <div class="flex items-center gap-2 mt-2 text-sm text-gray-600">
                                <i class="fas fa-star text-amber-500 text-base"></i>
                                <span>{{ number_format($product->reviews_avg_rating ?? 4.2, 1) }}</span>
                                <span class="text-xs text-gray-400">
                                    ({{ $product->reviews_count ?? 0 }})
                                </span>
                            </div>

                            <!-- Price -->
                            <div class="mt-3">
                                <div class="flex items-center gap-2">
                                    <span class="text-lg font-semibold text-gray-900">
                                        ₹{{ number_format($product->price, 0) }}
                                    </span>

                                    @if ($product->mrp && $product->mrp > $product->price)
                                        <span class="text-sm text-gray-400 line-through">
                                            ₹{{ number_format($product->mrp, 0) }}
                                        </span>
                                    @endif
                                </div>

                                @if ($product->mrp && $product->mrp > $product->price)
                                    <div class="text-xs text-green-600 mt-1">
                                        You Save ₹{{ number_format($product->mrp - $product->price, 0) }}
                                    </div>
                                @endif
                            </div>

                            <!-- Stock -->
                            @if ($product->stock)
                                <p class="text-xs text-green-600 mt-2">
                                    In Stock
                                </p>
                            @else
                                <p class="text-xs text-red-600 mt-2">
                                    Out of Stock
                                </p>
                            @endif

                            <!-- Add to Cart -->
                            @if ($product->stock)
                                <a href="{{ route('cart', ['add' => $product->id]) }}"
                                    class="mt-4 flex items-center justify-center gap-3 bg-primary text-white py-3 rounded-md text-sm font-medium">
                                    <i class="fas fa-shopping-cart text-lg"></i>
                                    Add to Cart
                                </a>
                            @else
                                <button disabled class="mt-4 w-full bg-gray-300 text-white py-3 rounded-md text-sm font-medium">
                                    Out of Stock
                                </button>
                            @endif

                        </div>

                    </div>
                @endforeach

            </div>

            <!-- View All -->
            <div class="mt-14 text-center">
                <a href="{{ route('shop') }}"
                    class="inline-block border border-primary text-primary px-6 py-2 rounded-md text-sm">
                    View All Products
                </a>
            </div>

        </div>
    </section>







    <!-- Customer Love -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">

            <div class="text-center">
                <h2 class="text-3xl font-semibold text-gray-900">
                    Loved by Snack Enthusiasts
                </h2>
                <p class="text-gray-500 mt-3 max-w-xl mx-auto text-sm">
                    Honest experiences from customers who made us part of their daily routine.
                </p>
            </div>

            <div class="mt-14 grid md:grid-cols-3 gap-10">

                <!-- Review Card -->
                <div class="bg-gray-50 p-8 rounded-xl border border-gray-200">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-14 h-14 bg-primary text-white rounded-full flex items-center justify-center font-semibold text-lg">
                            AS
                        </div>
                        <div>
                            <div class="font-semibold text-gray-900">Aditi Singh</div>
                            <div class="text-xs text-gray-500">Lucknow</div>
                        </div>
                    </div>

                    <div class="mt-4 text-amber-500 text-lg">
                        ★★★★★
                    </div>

                    <p class="mt-4 text-gray-600 text-sm leading-relaxed">
                        “The roasted makhana tastes incredibly fresh. Perfect crunch and balanced flavors.
                        My evening snack is sorted!”
                    </p>
                </div>

                <div class="bg-gray-50 p-8 rounded-xl border border-gray-200">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-14 h-14 bg-primary text-white rounded-full flex items-center justify-center font-semibold text-lg">
                            VK
                        </div>
                        <div>
                            <div class="font-semibold text-gray-900">Vikas Mehra</div>
                            <div class="text-xs text-gray-500">Chandigarh</div>
                        </div>
                    </div>

                    <div class="mt-4 text-amber-500 text-lg">
                        ★★★★★
                    </div>

                    <p class="mt-4 text-gray-600 text-sm leading-relaxed">
                        “Clean packaging, quick delivery, and premium quality. Feels like a brand
                        that truly cares about health.”
                    </p>
                </div>

                <div class="bg-gray-50 p-8 rounded-xl border border-gray-200">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-14 h-14 bg-primary text-white rounded-full flex items-center justify-center font-semibold text-lg">
                            NR
                        </div>
                        <div>
                            <div class="font-semibold text-gray-900">Neha Reddy</div>
                            <div class="text-xs text-gray-500">Hyderabad</div>
                        </div>
                    </div>

                    <div class="mt-4 text-amber-500 text-lg">
                        ★★★★★
                    </div>

                    <p class="mt-4 text-gray-600 text-sm leading-relaxed">
                        “Finally found a snack that’s light, nutritious, and tasty.
                        My whole family enjoys it guilt-free.”
                    </p>
                </div>

            </div>
        </div>
    </section>
    <!-- Join Movement CTA -->
    <section class="py-20 bg-gray-100">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center">

            <h2 class="text-3xl font-semibold text-gray-900">
                Make Smarter Snacking Your Daily Habit
            </h2>

            <p class="text-gray-600 mt-4 text-sm max-w-xl mx-auto">
                Choose clean ingredients. Choose mindful eating.
                Experience snacks crafted for wellness and flavor.
            </p>

            <div class="mt-10 flex flex-wrap justify-center gap-5">

                <a href="{{ route('shop') }}" class="bg-primary text-white px-8 py-3 rounded-md text-sm font-medium">
                    Explore Collection
                </a>

                <a href="#" class="text-primary border border-primary px-8 py-3 rounded-md text-sm font-medium">
                    Learn About Us
                </a>

            </div>

        </div>
    </section>


</div>