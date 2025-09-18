<div class="bg-white min-h-screen px-4 sm:px-8 lg:px-16 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
        <!-- Product Image -->
        <div class="flex justify-center items-start">
            <img src="{{ $productDetail->imagelink }}" alt="Premium Product"
                class="rounded-2xl shadow-md w-full max-w-md object-cover hover:scale-105 transition duration-300">

        </div>

        <!-- Product Details -->
        <div class="space-y-6">
            <!-- Title -->
            <h1 class="text-3xl font-bold text-gray-800">{{ $productDetail->name }}</h1>

            <!-- Ratings + Stock -->
            <div class="flex items-center space-x-4">
                <span class="text-yellow-500 text-lg">★★★★★</span>
                <span class="text-gray-600 text-sm">(124 reviews)</span>
                <span class="text-green-600 font-medium">In Stock</span>
            </div>

            <!-- Price -->
            <div class="flex items-center space-x-3">
                <span class="text-2xl font-bold text-brand-600">₹{{ $productDetail->price }}</span>
                <span class="text-gray-400 line-through">₹{{ $productDetail->mrp }}</span>
                <span class="bg-green-100 text-green-600 text-sm px-2 py-1 rounded-lg">20% OFF</span>
            </div>

            <!-- Coupon Section -->
            <div class="bg-gray-50 border rounded-lg p-4 space-y-2">
                <h3 class="font-semibold text-gray-700">Available Offers</h3>
                <ul class="list-disc list-inside text-sm text-gray-600">
                    <li>Get extra <span class="font-semibold text-brand-600">₹200 off</span> on orders above ₹2,000 (Use
                        code: <span class="font-bold">FIT200</span>)</li>
                    <li>Flat <span class="font-semibold text-brand-600">₹100 cashback</span> with UPI payment</li>
                </ul>
            </div>

            <!-- Short Description -->
            <p class="text-gray-600 text-sm leading-relaxed">
                {{ $productDetail->description }}
            </p>

            <!-- Quantity Selector -->
            <!-- <div class="flex items-center space-x-4">
                <label class="text-sm font-medium text-gray-700">Quantity:</label>
                <input type="number" wire:model="quantity" min="1"
                    class="w-16 border rounded-lg px-2 py-1 text-center focus:ring-2 focus:ring-brand-600 focus:outline-none">
            </div> -->

            <!-- Buttons -->
            <div class="flex space-x-4">
                <a href="{{ route('cart', ['add' => $productDetail->id]) }}"
                    class="bg-brand-600 text-white px-6 py-3 rounded-xl shadow hover:bg-brand-700 transition font-semibold">
                    Add to Cart
                </a>
                <a href="{{ route('cart', ['add' => $productDetail->id]) }}"
                    class="border border-brand-600 text-brand-600 px-6 py-3 rounded-xl shadow hover:bg-brand-50 transition font-semibold">
                    Buy Now
                </a>
            </div>
        </div>
    </div>

    <!-- Tabs Section -->
    <div class="mt-12">
        <div class="border-b flex space-x-6 text-gray-600 font-medium">
            <button wire:click="$set('activeTab', 'description')"
                class="py-3 px-2 text-sm sm:text-base transition {{ $activeTab === 'description' ? 'border-b-2 border-brand-600 text-brand-600' : 'hover:text-brand-600' }}">
                Description
            </button>
            <button wire:click="$set('activeTab', 'reviews')"
                class="py-3 px-2 text-sm sm:text-base transition {{ $activeTab === 'reviews' ? 'border-b-2 border-brand-600 text-brand-600' : 'hover:text-brand-600' }}">
                Reviews
            </button>
            <button wire:click="$set('activeTab', 'shipping')"
                class="py-3 px-2 text-sm sm:text-base transition {{ $activeTab === 'shipping' ? 'border-b-2 border-brand-600 text-brand-600' : 'hover:text-brand-600' }}">
                Shipping Info
            </button>
        </div>

        <div class="mt-6 text-gray-600 text-sm leading-relaxed">
            @if($activeTab === 'description')
                <p>
                    {{ $productDetail->description }}.
                </p>
            @elseif($activeTab === 'reviews')
                <div class="space-y-4">
                    <div class="border-b pb-3">
                        <p class="font-semibold text-gray-800">Ankur Jha <span class="text-yellow-500">★★★★★</span></p>
                        <p class="text-gray-600 text-sm">Amazing quality! Helped me recover faster after workouts.</p>
                    </div>
                    <div class="border-b pb-3">
                        <p class="font-semibold text-gray-800">Rahul Kumar <span class="text-yellow-500">★★★★☆</span></p>
                        <p class="text-gray-600 text-sm">Great taste and easy to mix, but a little pricey.</p>
                    </div>
                </div>
            @elseif($activeTab === 'shipping')
                <ul class="list-disc list-inside text-sm">
                    <li>Free shipping on orders above ₹999</li>
                    <li>Delivery time: 3–5 business days</li>
                    <li>Easy 7-day return policy</li>
                </ul>
            @endif
        </div>
    </div>
</div>