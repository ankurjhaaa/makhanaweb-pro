<div class="bg-white">
    <!-- Shop Header -->
    <div class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 text-center">
            <h1 class="font-poppins text-4xl font-bold text-gray-900 mb-4">Shop Our Products</h1>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto">Discover our complete range of healthy, natural snacks</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-8">
        <!-- Success Message -->
        @if (session()->has('success'))
            <div class="mb-6 p-4 bg-brand-50 border border-brand-200 rounded-lg">
                <p class="text-brand-700 text-sm">{{ session('success') }}</p>
            </div>
        @endif

        <!-- Search and Filters -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
                <!-- Search Bar -->
                <div class="relative flex-1 max-w-md">
                    <input type="text" 
                        wire:model.live.debounce.300ms="search"
                        placeholder="Search products..."
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>

                <!-- Category Filter -->
                <div class="flex flex-wrap gap-2">
                    @foreach($categories as $category)
                        <button type="button" 
                            wire:click="setCategory('{{ $category }}')"
                            class="px-4 py-2 rounded-full text-sm font-medium transition-all {{ $selectedCategory === $category ? 'bg-brand-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            {{ $category }}
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Results Count and Sort -->
            <div class="mt-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <p class="text-gray-600">Showing {{ count($filteredProducts) }} of {{ $totalProducts }} products</p>
                
                <div class="flex items-center gap-2">
                    <label for="sort" class="text-sm text-gray-600">Sort by:</label>
                    <select wire:model.live="sortBy" id="sort" class="border border-gray-300 rounded-lg px-3 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
                        <option value="name">Name</option>
                        <option value="price_low">Price: Low to High</option>
                        <option value="price_high">Price: High to Low</option>
                        <option value="rating">Rating</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($filteredProducts as $product)
                <div class="bg-white border border-gray-100 rounded-lg overflow-hidden hover:shadow-lg transition-all duration-300 group">
                    <!-- Product Image -->
                    <div class="relative overflow-hidden bg-gray-100 aspect-square">
                        <!-- Product Tag -->
                        @if($product['tag'])
                            <div class="absolute top-3 left-3 z-10">
                                <span class="px-2 py-1 text-xs font-medium text-white rounded-full {{ $product['tag_color'] }}">
                                    {{ $product['tag'] }}
                                </span>
                            </div>
                        @endif

                        <!-- Stock Status -->
                        @if(!$product['in_stock'])
                            <div class="absolute top-3 right-3 z-10">
                                <span class="px-2 py-1 text-xs font-medium text-gray-600 bg-gray-200 rounded-full">
                                    Out of Stock
                                </span>
                            </div>
                        @endif

                        <img src="{{ $product['image'] }}" 
                             alt="{{ $product['name'] }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>

                    <!-- Product Info -->
                    <div class="p-4">
                        <!-- Category -->
                        <div class="text-xs text-gray-500 uppercase tracking-wide mb-1">
                            {{ $product['category'] }}
                        </div>

                        <!-- Product Name -->
                        <h3 class="font-medium text-gray-900 mb-2 line-clamp-2">
                            {{ $product['name'] }}
                        </h3>

                        <!-- Description -->
                        <p class="text-sm text-gray-600 mb-3 line-clamp-2">
                            {{ $product['description'] }}
                        </p>

                        <!-- Rating and Reviews -->
                        <div class="flex items-center gap-2 mb-3">
                            <div class="flex items-center">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($product['rating']))
                                        <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4 text-gray-300 fill-current" viewBox="0 0 20 20">
                                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                        </svg>
                                    @endif
                                @endfor
                            </div>
                            <span class="text-sm text-gray-600">{{ $product['rating'] }}</span>
                            <span class="text-xs text-gray-400">({{ $product['reviews'] }} reviews)</span>
                        </div>

                        <!-- Price -->
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-2">
                                <span class="text-lg font-semibold text-brand-600">₹{{ $product['price'] }}</span>
                                @if($product['original_price'] > $product['price'])
                                    <span class="text-sm text-gray-400 line-through">₹{{ $product['original_price'] }}</span>
                                @endif
                            </div>
                            @if($product['original_price'] > $product['price'])
                                <span class="text-xs bg-red-100 text-red-600 px-2 py-1 rounded-full">
                                    {{ round((($product['original_price'] - $product['price']) / $product['original_price']) * 100) }}% OFF
                                </span>
                            @endif
                        </div>

                        <!-- Add to Cart Button -->
                        @if($product['in_stock'])
                            <button type="button" 
                                wire:click="addToCart({{ $product['id'] }})"
                                wire:loading.attr="disabled"
                                wire:loading.class="opacity-50"
                                wire:target="addToCart({{ $product['id'] }})"
                                class="w-full bg-brand-600 text-white py-2 px-4 rounded-lg hover:bg-brand-700 transition-all font-medium text-sm">
                                <span wire:loading.remove wire:target="addToCart({{ $product['id'] }})">
                                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                    Add to Cart
                                </span>
                                <span wire:loading wire:target="addToCart({{ $product['id'] }})">
                                    Adding...
                                </span>
                            </button>
                        @else
                            <button type="button" disabled class="w-full bg-gray-300 text-gray-500 py-2 px-4 rounded-lg font-medium text-sm cursor-not-allowed">
                                Sold Out
                            </button>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2 2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-4.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 009.586 13H7"/>
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">No products found</h3>
                    <p class="mt-2 text-gray-500">Try adjusting your search or filter criteria.</p>
                </div>
            @endforelse
        </div>

        <!-- Load More / Pagination (if needed) -->
        @if(count($filteredProducts) > 0)
            <div class="mt-12 text-center">
                <p class="text-gray-600 mb-4">Showing {{ count($filteredProducts) }} products</p>
                <!-- You can add pagination here if needed -->
            </div>
        @endif
    </div>

    <!-- Newsletter Section -->
    <div class="bg-gray-50 py-16 mt-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center">
            <h2 class="font-poppins text-3xl font-bold text-gray-900 mb-4">Stay Connected</h2>
            <p class="text-gray-600 mb-8">Subscribe to get special offers, free giveaways, and exclusive deals.</p>
            
            <div class="flex flex-col sm:flex-row max-w-md mx-auto gap-4">
                <input type="email" placeholder="Enter your email" 
                    class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                <button type="button" class="bg-brand-600 text-white px-6 py-3 rounded-lg hover:bg-brand-700 transition-all font-medium">
                    Subscribe
                </button>
            </div>
        </div>
    </div>

    <!-- Footer Info -->
    <div class="bg-white border-t border-gray-100 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- About -->
                <div>
                    <h3 class="font-poppins font-semibold text-gray-900 mb-4">Your's Snacks</h3>
                    <p class="text-gray-600 text-sm">Bringing pure, natural, and nutritious snacks to every home. Quality products from farms, prepared using traditional methods.</p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="font-semibold text-gray-900 mb-4">Quick Links</h3>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li><a href="#" class="hover:text-brand-600 transition-all">About Us</a></li>
                        <li><a href="#" class="hover:text-brand-600 transition-all">Shop</a></li>
                        <li><a href="#" class="hover:text-brand-600 transition-all">Recipes</a></li>
                        <li><a href="#" class="hover:text-brand-600 transition-all">Contact</a></li>
                    </ul>
                </div>

                <!-- Customer Service -->
                <div>
                    <h3 class="font-semibold text-gray-900 mb-4">Customer Service</h3>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li><a href="#" class="hover:text-brand-600 transition-all">FAQ</a></li>
                        <li><a href="#" class="hover:text-brand-600 transition-all">Shipping Info</a></li>
                        <li><a href="#" class="hover:text-brand-600 transition-all">Returns</a></li>
                        <li><a href="#" class="hover:text-brand-600 transition-all">Track Order</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h3 class="font-semibold text-gray-900 mb-4">Stay Connected</h3>
                    <div class="space-y-2 text-sm text-gray-600">
                        <p>📞 +91 98765-43210</p>
                        <p>✉️ contact@yourssnacks.com</p>
                        <p>📍 Mumbai, Maharashtra, 400</p>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-100 mt-8 pt-8 text-center">
                <p class="text-sm text-gray-500">© 2024 Your's Snacks. All rights reserved. 
                    <a href="#" class="hover:text-brand-600">Privacy Policy</a> • 
                    <a href="#" class="hover:text-brand-600">Terms of Service</a>
                </p>
            </div>
        </div>
    </div>
</div>
