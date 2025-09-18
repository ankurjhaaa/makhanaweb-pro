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
                <a href="#"
                    class="bg-brand-600 text-white px-6 py-3 rounded-full hover:bg-brand-700 transition-all font-medium">
                    Shop Now
                </a>
                <a href="#"
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
            <div class="mt-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($products as $product)
                    <div
                        class="bg-white rounded-lg border border-gray-100 p-6 transition-all hover:border-brand-200 relative">

                        <!-- Wishlist Button -->
                        <button wire:click="toggleWishlist({{ $product->id }})" @class([
                            'absolute top-3 right-3 h-9 w-9 flex items-center justify-center rounded-full border shadow-sm transition-colors',
                            'text-red-500 bg-red-50 hover:bg-red-100' => $wishlistIds->contains($product->id),
                            'text-gray-400 bg-white hover:bg-gray-100' => !$wishlistIds->contains($product->id),
                        ])>
                            <i class="fas fa-heart"></i>
                        </button>

                        <div class="text-xs uppercase tracking-wider font-medium text-brand-600 mb-3">
                            {{ $product->category->name ?? 'Uncategorized' }}
                        </div>

                        <a href="{{ route('item',$product->slug) }}">
                            <div class="aspect-w-1 aspect-h-1 mb-5">
                                <img src="{{ $product->imagelink }}?tr=w-200,h-200,fo-face,f-auto,q-10"
                                    alt="{{ $product->name }}" loading="lazy" class="w-full h-48 object-cover rounded-md">
                            </div>
                        </a>

                        <h3 class="font-poppins font-semibold text-lg">{{ $product->name }}</h3>
                        <p class="text-gray-600 text-sm mt-2">{{ Str::limit($product->description, 80) }}</p>

                        <div class="mt-4 flex items-center justify-between">
                            <div>
                                <span class="text-brand-600 font-bold text-lg">₹{{ $product->price }}</span>
                                @if($product->old_price)
                                    <span class="text-gray-400 text-sm line-through ml-2">₹{{ $product->old_price }}</span>
                                @endif
                            </div>
                            @if ($product->stock === 0)
                                <a
                                    class="bg-gray-400 text-white px-4 py-2 rounded-full hover:bg-brand-700 transition-all text-sm">
                                    Sold Out
                                </a>
                            @else
                                <a href="{{ route('cart', ['add' => $product->id]) }}"
                                    class="bg-brand-600 text-white px-4 py-2 rounded-full hover:bg-brand-700 transition-all text-sm">
                                    Add to Cart
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>


            <div class="mt-10 text-center">
                <a href=""
                    class="inline-block border-2 border-brand-600 text-brand-600 px-6 py-3 rounded-full hover:bg-brand-50 transition-all font-medium">
                    View All Products
                </a>
            </div>
        </div>
    </section>


    <!-- Why Choose Makhana -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 py-16 md:py-20">
        <div class="text-center">
            <h2 class="font-poppins text-3xl md:text-4xl font-semibold">Why Choose Makhana?</h2>
            <p class="text-gray-600 mt-4 max-w-2xl mx-auto">Discover the incredible health benefits of this ancient
                superfood that's perfect for modern wellness</p>
        </div>

        <div class="mt-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
            <div
                class="bg-white p-6 border border-gray-100 rounded-lg text-center hover:border-brand-200 transition-all">
                <div class="inline-block p-3 bg-brand-50 rounded-full text-brand-600 text-3xl mb-4">♥</div>
                <h4 class="font-poppins font-semibold text-xl">Heart Healthy</h4>
                <p class="text-gray-600 mt-3">Low in cholesterol and sodium, high in magnesium for cardiovascular
                    health.</p>
            </div>
            <div
                class="bg-white p-6 border border-gray-100 rounded-lg text-center hover:border-brand-200 transition-all">
                <div class="inline-block p-3 bg-brand-50 rounded-full text-brand-600 text-3xl mb-4">⚡</div>
                <h4 class="font-poppins font-semibold text-xl">Energy Boost</h4>
                <p class="text-gray-600 mt-3">Rich in complex carbs that provide sustained energy without sugar spikes.
                </p>
            </div>
            <div
                class="bg-white p-6 border border-gray-100 rounded-lg text-center hover:border-brand-200 transition-all">
                <div class="inline-block p-3 bg-brand-50 rounded-full text-brand-600 text-3xl mb-4">🛡️</div>
                <h4 class="font-poppins font-semibold text-xl">Antioxidant Rich</h4>
                <p class="text-gray-600 mt-3">Natural antioxidants help fight free radicals and reduce inflammation.</p>
            </div>
            <div
                class="bg-white p-6 border border-gray-100 rounded-lg text-center hover:border-brand-200 transition-all">
                <div class="inline-block p-3 bg-brand-50 rounded-full text-brand-600 text-3xl mb-4">🍃</div>
                <h4 class="font-poppins font-semibold text-xl">Weight Management</h4>
                <p class="text-gray-600 mt-3">High fiber and protein content help you feel full longer naturally.</p>
            </div>
        </div>
    </section>

    <!-- Nutritional Powerhouse -->
    <section class="bg-brand-50 py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center">
            <h3 class="font-poppins text-2xl md:text-3xl font-semibold">Nutritional Powerhouse</h3>
            <p class="text-gray-600 mt-2">Per 100g of premium makhana</p>

            <div class="mt-10 grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
                <div class="bg-white p-6 rounded-lg border-2 border-brand-100">
                    <div class="text-3xl font-bold text-brand-600 font-poppins">9.7g</div>
                    <div class="text-gray-600 font-medium mt-1">Protein</div>
                </div>
                <div class="bg-white p-6 rounded-lg border-2 border-brand-100">
                    <div class="text-3xl font-bold text-brand-600 font-poppins">14.5g</div>
                    <div class="text-gray-600 font-medium mt-1">Fiber</div>
                </div>
                <div class="bg-white p-6 rounded-lg border-2 border-brand-100">
                    <div class="text-3xl font-bold text-brand-600 font-poppins">0.1g</div>
                    <div class="text-gray-600 font-medium mt-1">Fat</div>
                </div>
                <div class="bg-white p-6 rounded-lg border-2 border-brand-100">
                    <div class="text-3xl font-bold text-brand-600 font-poppins">347</div>
                    <div class="text-gray-600 font-medium mt-1">Calories</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Amazing Facts -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 py-16">
        <h3 class="font-poppins text-2xl md:text-3xl font-semibold text-center">Amazing Makhana Facts</h3>
        <p class="text-center text-gray-600 mt-2 max-w-2xl mx-auto">Fascinating insights about this remarkable superfood
        </p>

        <div class="mt-10 grid grid-cols-1 md:grid-cols-2 gap-8 text-gray-700 max-w-5xl mx-auto">
            <div class="bg-white p-6 border border-gray-100 rounded-lg">
                <ul class="space-y-3">
                    <li class="flex items-start">
                        <span class="text-brand-600 mr-2">•</span>
                        <span>India produces 90% of the world's makhana supply</span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-brand-600 mr-2">•</span>
                        <span>Consumed for over 3000 years in Asian cultures</span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-brand-600 mr-2">•</span>
                        <span>Considered a superfood in Ayurvedic medicine</span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-brand-600 mr-2">•</span>
                        <span>Also known as 'Fox Nuts' or 'Lotus Seeds'</span>
                    </li>
                </ul>
            </div>
            <div class="bg-white p-6 border border-gray-100 rounded-lg">
                <ul class="space-y-3">
                    <li class="flex items-start">
                        <span class="text-brand-600 mr-2">•</span>
                        <span>Bihar state is the largest producer in India</span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-brand-600 mr-2">•</span>
                        <span>Seeds are harvested by hand from lotus flowers</span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-brand-600 mr-2">•</span>
                        <span>Makhana plants can live for over 100 years</span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-brand-600 mr-2">•</span>
                        <span>Naturally gluten-free and vegan friendly</span>
                    </li>
                </ul>
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
                <a href="#"
                    class="bg-brand-600 text-white px-8 py-4 rounded-full hover:bg-brand-700 transition-all font-medium">Shop
                    All Products</a>
                <a href="#"
                    class="border-2 border-brand-600 text-brand-600 px-8 py-4 rounded-full hover:bg-brand-50 transition-all font-medium">View
                    Our Story</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-50 border-t border-gray-100 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div>
                    <div class="text-brand-600 font-poppins font-bold text-xl">Your's Snacks</div>
                    <p class="text-gray-600 mt-4">Bringing pure, natural, and nutritious snacks to every home with
                        quality sourced ingredients.</p>
                    <div class="mt-6 flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-brand-600 transition-all">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-brand-600 transition-all">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-brand-600 transition-all">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path
                                    d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84">
                                </path>
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="lg:ml-auto">
                    <h4 class="font-poppins font-semibold text-lg">Quick Links</h4>
                    <ul class="mt-4 space-y-2 text-gray-600">
                        <li><a href="#" class="hover:text-brand-600 transition-all">About Us</a></li>
                        <li><a href="#" class="hover:text-brand-600 transition-all">Shop</a></li>
                        <li><a href="#" class="hover:text-brand-600 transition-all">Recipes</a></li>
                        <li><a href="#" class="hover:text-brand-600 transition-all">Contact</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-poppins font-semibold text-lg">Customer Service</h4>
                    <ul class="mt-4 space-y-2 text-gray-600">
                        <li><a href="#" class="hover:text-brand-600 transition-all">FAQ</a></li>
                        <li><a href="#" class="hover:text-brand-600 transition-all">Shipping Info</a></li>
                        <li><a href="#" class="hover:text-brand-600 transition-all">Returns</a></li>
                        <li><a href="#" class="hover:text-brand-600 transition-all">Track Order</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-poppins font-semibold text-lg">Stay Connected</h4>
                    <p class="text-gray-600 mt-4">care@yoursnacks.com</p>
                    <div class="mt-4">
                        <form class="flex flex-col space-y-3">
                            <input type="email" placeholder="Enter your email"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
                            <button type="submit"
                                class="w-full bg-brand-600 text-white py-3 px-4 rounded-lg hover:bg-brand-700 transition-all font-medium">Subscribe</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 mt-12 pt-8 border-t border-gray-200 text-center text-gray-500">
            © 2024 Your's Snacks. All rights reserved.
        </div>
    </footer>

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