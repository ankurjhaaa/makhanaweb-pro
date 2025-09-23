<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-6">
    <nav class="text-sm text-gray-500 flex items-center space-x-2">
        @foreach($breadcrumbs as $breadcrumb)
            <a href="{{ $breadcrumb['url'] }}" class="hover:text-brand-600">
                {{ $breadcrumb['label'] }}
            </a>
            @if(!$loop->last)
                <span>/</span>
            @endif
        @endforeach
    </nav>


    <!-- Header + Search -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <h1 class="text-2xl font-semibold text-gray-800">
            {{ $category->name }}
        </h1>

        <!-- Search box -->
        <div class="relative w-full md:w-1/3">
            <input type="text" wire:model.live="search" placeholder="Search in {{ $category->name }}..."
                class="w-full border border-gray-300 rounded-lg pl-10 pr-3 py-2 focus:ring-brand-500 focus:border-brand-500" />

            <i class="fas fa-search absolute left-3 top-2.5 text-gray-400"></i>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($products as $product)
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
        @empty
            <div class="col-span-full text-center text-gray-500 py-10">
                No products found.
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div>
        {{ $products->links() }}
    </div>
</div>