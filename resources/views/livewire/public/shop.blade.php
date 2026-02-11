<div class="bg-gray-100 min-h-screen">

    <!-- Main Content Area -->
    <div class="max-w-7xl mx-auto px-4 py-5">

        <div class="grid lg:grid-cols-4 gap-12">

            <!-- Sidebar Filters -->
            <div class="lg:col-span-1">

                <!-- Search + Categories Card -->
                <div class="bg-white p-6 rounded-2xl border border-gray-200">

                    <!-- Search -->
                    <div class="mb-8">
                        <h3 class="font-semibold text-gray-900 mb-4">
                            Search Products
                        </h3>

                        <div class="relative">
                            <input type="text" wire:model.live="search" placeholder="Search here..."
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">

                            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                <i class="fas fa-search text-sm"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Categories -->
                    <h3 class="font-semibold text-gray-900 mb-4">
                        Browse Categories
                    </h3>

                    <div class="space-y-3">

                        <button wire:click="setCategory('All')" class="block w-full text-left px-4 py-2 rounded-lg text-sm
                {{ $selectedCategory === 'All' ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700' }}">
                            All Products
                        </button>

                        @foreach($categories as $category)
                            <button wire:click="setCategory('{{ $category }}')"
                                class="block w-full text-left px-4 py-2 rounded-lg text-sm
                                                                {{ $selectedCategory === $category ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700' }}">
                                {{ $category }}
                            </button>
                        @endforeach

                    </div>

                </div>



            </div>


            <!-- Product Grid Area -->
            <div class="lg:col-span-3">

                <h2 class="text-2xl font-semibold text-gray-900 mb-10">
                    Available Selections
                </h2>

                <!-- Grid -->
                <div class="mt-12 grid sm:grid-cols-2 lg:grid-cols-3 gap-8">

                    @forelse ($filteredProducts as $product)

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

                          

                            <!-- Image -->
                            <a wire:navigate href="{{ route('item', $product->slug) }}">
                                <div class="w-full h-60 bg-gray-50 rounded-lg overflow-hidden">
                                    <img src="{{ $product->imagelink }}" alt="{{ $product->name }}"
                                        class="w-full h-full object-cover">
                                </div>
                            </a>

                            <!-- Info -->
                            <div class="mt-5">

                                <span class="text-xs font-medium text-primary">
                                    {{ $product->category->name ?? 'Makhana' }}
                                </span>

                                <h3 class="text-sm font-medium text-gray-800 leading-snug line-clamp-2 mt-1">
                                    {{ $product->name }}
                                </h3>

                                <div class="flex items-center gap-2 mt-2 text-sm text-gray-600">
                                    <i class="fas fa-star text-amber-500 text-base"></i>
                                    <span>{{ number_format($product->reviews_avg_rating ?? 4.2, 1) }}</span>
                                    <span class="text-xs text-gray-400">
                                        ({{ $product->reviews_count ?? 0 }})
                                    </span>
                                </div>

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

                                @if ($product->stock)
                                    <p class="text-xs text-green-600 mt-2">
                                        In Stock
                                    </p>
                                @else
                                    <p class="text-xs text-red-600 mt-2">
                                        Out of Stock
                                    </p>
                                @endif

                                @if ($product->stock)
                                    <a href="{{ route('cart', ['add' => $product->id]) }}"
                                        class="mt-4 flex items-center justify-center gap-3 bg-primary text-white py-3 rounded-md text-sm font-medium">
                                        <i class="fas fa-shopping-cart text-lg"></i>
                                        Add to Cart
                                    </a>
                                @else
                                    <button disabled
                                        class="mt-4 w-full bg-gray-300 text-white py-3 rounded-md text-sm font-medium">
                                        Out of Stock
                                    </button>
                                @endif

                            </div>

                        </div>

                    @empty

                        <!-- Empty State -->
                        <div class="col-span-full text-center py-20">
                            <div class="text-gray-400 text-5xl mb-4">
                                <i class="fas fa-box-open"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800">
                                No Products Available
                            </h3>
                            <p class="text-gray-500 mt-2">
                                Try changing the category or search keyword.
                            </p>
                        </div>

                    @endforelse

                </div>
            </div>

        </div>

    </div>


    <!-- Bottom Brand Section -->
    <div class="bg-white border-t border-gray-200 py-24 mt-20">
        <div class="max-w-5xl mx-auto text-center px-4">

            <h2 class="text-3xl font-bold text-gray-900">
                Experience Better Ingredients
            </h2>

            <p class="mt-4 text-gray-600 max-w-2xl mx-auto">
                We focus on quality sourcing, careful roasting,
                and delivering freshness straight to your home.
            </p>

            <a href="{{ route('contact') }}" class="inline-block mt-8 bg-primary text-white px-8 py-3 rounded-xl">
                Contact Our Team
            </a>

        </div>
    </div>

</div>