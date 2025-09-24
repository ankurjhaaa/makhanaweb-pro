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
                <h2 class="text-lg font-semibold">Order #{{ $order->order_number }}</h2>
                <p class="text-sm text-gray-500">Placed on Sep 20, 2025 10:30 AM</p>
            </div>

            <div class="flex items-center gap-3">
                <!-- Order Status -->
                <!-- Order Status -->
                @switch($order->status)
                    @case('pending')
                        <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium">Pending</span>
                        @break
                    @case('processing')
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">Processing</span>
                        @break
                    @case('shipped')
                        <span class="px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full text-xs font-medium">Shipped</span>
                        @break
                    @case('delivered')
                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">Delivered</span>
                        @break
                    @case('cancelled')
                        <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-medium">Cancelled</span>
                        @break
                @endswitch

                <div class="text-lg font-semibold text-gray-800">
                    ₹{{ $order->total_amount }}
                </div>
            </div>
        </div>

        <!-- Address Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">
            <div>
                <h3 class="text-sm font-medium text-gray-700 mb-2">Shipping Address</h3>
                <p class="text-sm text-gray-600">
                    {{ Auth::user()->name }} <br>
                     {{ $order->shippingAddress->address_line1 }}
                    <br>
                    {{ $order->shippingAddress->city }}, {{ $order->shippingAddress->state }} - {{ $order->shippingAddress->postal_code }}
                </p>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-700 mb-2">Billing Address</h3>
                <p class="text-sm text-gray-600">
                    {{ Auth::user()->name }} <br>
                     {{ $order->billingAddress->address_line1 }}
                    <br>
                    {{ $order->billingAddress->city }}, {{ $order->billingAddress->state }} - {{ $order->billingAddress->postal_code }}
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
            @foreach($order->orderItems as $item)
                <div class="p-6 flex items-center border-b border-gray-100">
                    <a href="{{ route('item', $item->product->slug) }}">
                        <div class="h-16 w-16 flex-shrink-0 rounded-md overflow-hidden border border-gray-200">
                            <img src="{{ $item->product->imagelink }}" alt="Product 1" class="h-full w-full object-cover">
                        </div>
                    </a>

                    <div class="ml-4 flex-1">
                        <h4 class="text-sm font-medium text-gray-900">
                            {{ $item->product->name }}
                        </h4>
                        <p class="text-sm text-gray-500">
                            Qty: {{ $item->quantity }} × ₹{{ $item->product->price }}
                        </p>
                    </div>

                    @if(auth()->check() && $hasDeliveredOrder)
                        <button wire:click="$set('showReviewModal', true)"
                            class="mt-2 text-xs text-brand-600 hover:text-brand-500 flex items-center">
                            <button wire:click="openReviewModal({{ $item->id }})">Add Review</button>
                        </button>
                    @endif

                   <!-- Review Modal -->
@if($showReviewModal)
    <div class="fixed inset-0 flex items-center justify-center bg-black/60 z-50">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 relative transform transition-all scale-95 animate-fadeIn">
            
            <!-- Close Button -->
            <button wire:click="$set('showReviewModal', false)" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-lg"></i>
            </button>

            <!-- Title -->
            <h2 class="text-xl font-bold text-gray-800 mb-1">Write a Review</h2>
            <p class="text-sm text-gray-500 mb-5">Share your feedback about this product</p>

            <!-- Rating -->
            <div class="mb-5">
                <label class="block mb-2 text-sm font-medium text-gray-700">Your Rating</label>
                <div class="flex space-x-2">
                    @for ($i = 1; $i <= 5; $i++)
                        <button type="button" wire:click="$set('rating', {{ $i }})" class="text-3xl transition transform hover:scale-110 focus:outline-none {{ $i <= $rating ? 'text-yellow-400 drop-shadow' : 'text-gray-300 hover:text-yellow-300' }}"> ★
                        </button>
                    @endfor
                </div>
            </div>

            <!-- Comment -->
            <div class="mb-5">
                <label class="block mb-2 text-sm font-medium text-gray-700">Your Review</label>
                <textarea wire:model="comment" rows="4" class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand-500 focus:border-brand-500 resize-none" placeholder="Tell others what you liked or disliked..."></textarea>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end space-x-3">
                <button wire:click="$set('showReviewModal', false)" class="px-4 py-2 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200 transition"> Cancel
                </button>

                <button wire:click="addReview"  class="px-4 py-2 rounded-lg bg-gray-600 text-white hover:bg-gray-700 shadow-md transition">  Submit Review
                </button>
            </div>
        </div>
    </div>
@endif


                </div>
            @endforeach

        </div>
    </div>

    <!-- Coupon & Payment Info -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex flex-col sm:flex-row sm:justify-between gap-4">
            <div>
                @if($order->coupon_id != null)
                <p class="text-sm text-gray-600">Coupon Applied:
                    <span class="font-mono font-medium text-green-600">{{ $order->coupon->code }}</span>
                </p>
                @endif
                
            </div>
            <div class="text-right space-y-1">
                <p class="text-sm">Subtotal: ₹{{ $order->subtotal }}</p>
                <p class="text-sm">Tax: ₹{{ $order->subtotal * 0.18 }}</p>
                <p class="text-sm">Shipping: ₹{{ $order->shipping_cost }}</p>
                @if($order->coupon_id != null)
                <p class="text-sm text-gray-600">Coupon Applied: ₹{{ $order->discount }} </p>
                @endif
                <p class="text-base font-semibold">Total: ₹{{ $order->total_amount }}</p>
            </div>
        </div>
    </div>

</div>