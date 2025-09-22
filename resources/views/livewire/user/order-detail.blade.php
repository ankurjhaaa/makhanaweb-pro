<div class="space-y-6">
    <!-- Back Button -->
    <div>
        <a href="#" class="inline-flex items-center text-sm text-brand-600 hover:text-brand-500">
            <i class="fas fa-arrow-left mr-2"></i> Back to Orders
        </a>
    </div>

    <!-- Order Info -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6 border-b border-gray-200 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-lg font-semibold">Order #123456</h2>
                <p class="text-sm text-gray-500">Placed on Sep 20, 2025 10:30 AM</p>
            </div>

            <div class="flex items-center gap-3">
                <!-- Order Status -->
                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium">Pending</span>

                <div class="text-lg font-semibold text-gray-800">
                    ₹2,499.00
                </div>
            </div>
        </div>

        <!-- Address Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">
            <div>
                <h3 class="text-sm font-medium text-gray-700 mb-2">Billing Address</h3>
                <p class="text-sm text-gray-600">
                    Rahul Sharma <br>
                    123 MG Road <br>
                    Mumbai, Maharashtra - 400001
                </p>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-700 mb-2">Shipping Address</h3>
                <p class="text-sm text-gray-600">
                    Rahul Sharma <br>
                    456 Link Road <br>
                    Pune, Maharashtra - 411001
                </p>
            </div>
        </div>
    </div>

    <!-- Order Items -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Order Items</h3>
        </div>

        <div>
            <div class="p-6 flex items-center border-b border-gray-100">
                <div class="h-16 w-16 flex-shrink-0 rounded-md overflow-hidden border border-gray-200">
                    <img src="https://via.placeholder.com/100" alt="Product 1" class="h-full w-full object-cover">
                </div>

                <div class="ml-4 flex-1">
                    <h4 class="text-sm font-medium text-gray-900">
                        Sample Product Name
                    </h4>
                    <p class="text-sm text-gray-500">
                        Qty: 2 × ₹1,000.00
                    </p>
                </div>

                @if(auth()->check() && $hasDeliveredOrder)
                    <button wire:click="$set('showReviewModal', true)"
                        class="mt-2 text-xs text-brand-600 hover:text-brand-500 flex items-center">
                        @foreach($order->orderItems as $item)
                            <button wire:click="openReviewModal({{ $item->id }})">Add Review</button>
                        @endforeach
                    </button>
                @endif

                <!-- Review Modal -->
                @if($showReviewModal)
                    <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                        <div class="bg-white rounded-lg shadow-lg w-96 p-6">
                            <h2 class="text-lg font-semibold mb-4">Write a Review</h2>

                            <!-- Rating -->
                            <label class="block mb-2 text-sm font-medium">Rating</label>
                            <select wire:model="rating" class="w-full border rounded p-2 mb-4">
                                <option value="">Select rating</option>
                                <option value="1">⭐</option>
                                <option value="2">⭐⭐</option>
                                <option value="3">⭐⭐⭐</option>
                                <option value="4">⭐⭐⭐⭐</option>
                                <option value="5">⭐⭐⭐⭐⭐</option>
                            </select>

                            <!-- Comment -->
                            <label class="block mb-2 text-sm font-medium">Comment</label>
                            <textarea wire:model="comment" class="w-full border rounded p-2 mb-4"></textarea>

                            <div class="flex justify-end space-x-2">
                                <button wire:click="$set('showReviewModal', false)" class="px-3 py-1 bg-gray-300 rounded">
                                    Cancel
                                </button>
                                @foreach($order->orderItems ?? [] as $item)
                                    <button wire:click="addReview">Submit Review</button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

            </div>

            <div class="p-6 flex items-center border-b border-gray-100">
                <div class="h-16 w-16 flex-shrink-0 rounded-md overflow-hidden border border-gray-200">
                    <img src="https://via.placeholder.com/100" alt="Product 2" class="h-full w-full object-cover">
                </div>

                <div class="ml-4 flex-1">
                    <h4 class="text-sm font-medium text-gray-900">
                        Another Product Name
                    </h4>
                    <p class="text-sm text-gray-500">
                        Qty: 1 × ₹499.00
                    </p>
                </div>

                <div class="text-right">
                    <p class="text-sm font-medium text-gray-900">₹499.00</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Coupon & Payment Info -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex flex-col sm:flex-row sm:justify-between gap-4">
            <div>
                <p class="text-sm text-gray-600">Coupon Applied:
                    <span class="font-mono font-medium text-green-600">WELCOME10</span>
                </p>
            </div>
            <div class="text-right space-y-1">
                <p class="text-sm">Subtotal: ₹2,499.00</p>
                <p class="text-sm">Shipping: ₹50.00</p>
                <p class="text-base font-semibold">Total: ₹2,549.00</p>
            </div>
        </div>
    </div>

    <!-- Review Modal (Static Dummy) -->
    {{-- <div class="bg-white border rounded-lg shadow-lg p-6 max-w-md mx-auto">
        @foreach($order->orderItems as $item)
        <button wire:click="openReviewModal({{ $item->id }})">Add Review</button>
        @endforeach
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Rating</label>
                <select class="mt-1 block w-full border-gray-300 rounded-md">
                    <option value="">Select Rating</option>
                    <option value="5">⭐⭐⭐⭐⭐</option>
                    <option value="4">⭐⭐⭐⭐</option>
                    <option value="3">⭐⭐⭐</option>
                    <option value="2">⭐⭐</option>
                    <option value="1">⭐</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Comment</label>
                <textarea rows="4" class="mt-1 block w-full border-gray-300 rounded-md"></textarea>
            </div>
        </div>
        <div class="mt-4 flex justify-end">
            @foreach($order->orderItems ?? [] as $item)
            <button wire:click="addReview">Submit Review</button>
            @endforeach
            <button class="ml-2 px-4 py-2 border rounded-md">Cancel</button>
        </div>
    </div> --}}
</div>