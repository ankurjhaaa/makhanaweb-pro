<div class="space-y-6">

    <!-- Back -->
    <div>
        <a href="{{ route('user.orders') }}"
            class="inline-flex items-center text-sm text-brand-600 hover:text-brand-500 font-medium">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Orders
        </a>
    </div>



    <!-- Order Header -->
    <div class="bg-white border border-gray-100 rounded-lg shadow-sm">

        <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <div>
                <h2 class="font-poppins text-lg font-semibold text-gray-800">
                    Order #{{ $order->order_number }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Placed on {{ $order->created_at->format('M d, Y • h:i A') }}
                </p>
            </div>

            <div class="flex items-center gap-4">

                <!-- Status -->
                <span class="px-3 py-1 text-xs rounded-full
                    @if($order->status === 'delivered') bg-green-50 text-green-700
                    @elseif($order->status === 'processing') bg-blue-50 text-blue-700
                    @elseif($order->status === 'shipped') bg-indigo-50 text-indigo-700
                    @elseif($order->status === 'pending') bg-yellow-50 text-yellow-700
                    @elseif($order->status === 'cancelled') bg-red-50 text-red-700
                    @else bg-gray-100 text-gray-700
                    @endif">
                    {{ ucfirst($order->status) }}
                </span>

                <div class="text-lg font-semibold text-brand-600">
                    ₹{{ number_format($order->total_amount, 2) }}
                </div>

            </div>

        </div>



        <!-- Addresses -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">

            <div>
                <h3 class="text-sm font-medium text-gray-700 mb-2">
                    Shipping Address
                </h3>
                <p class="text-sm text-gray-600 leading-relaxed">
                    {{ $order->shippingAddress->address_line1 }}<br>
                    {{ $order->shippingAddress->city }},
                    {{ $order->shippingAddress->state }}
                    - {{ $order->shippingAddress->postal_code }}<br>
                    {{ $order->shippingAddress->country }}
                </p>
            </div>

            <div>
                <h3 class="text-sm font-medium text-gray-700 mb-2">
                    Billing Address
                </h3>
                <p class="text-sm text-gray-600 leading-relaxed">
                    {{ $order->billingAddress->address_line1 }}<br>
                    {{ $order->billingAddress->city }},
                    {{ $order->billingAddress->state }}
                    - {{ $order->billingAddress->postal_code }}<br>
                    {{ $order->billingAddress->country }}
                </p>
            </div>

        </div>

    </div>



    <!-- Order Items -->
    <div class="bg-white border border-gray-100 rounded-lg shadow-sm overflow-hidden">

        <div class="p-6 border-b border-gray-100">
            <h3 class="font-poppins text-lg font-semibold text-gray-800">
                Order Items
            </h3>
        </div>

        <div class="divide-y divide-gray-100">

            @foreach($order->orderItems as $item)

                <div class="p-6 flex flex-col sm:flex-row gap-4 sm:items-center">

                    <!-- Image -->
                    <a href="{{ route('item', $item->product->slug) }}"
                        class="w-20 h-20 bg-gray-100 rounded-md overflow-hidden border border-gray-200">
                        <img src="{{ $item->product->imagelink }}" class="w-full h-full object-cover">
                    </a>

                    <!-- Info -->
                    <div class="flex-1">
                        <h4 class="text-sm font-medium text-gray-800">
                            {{ $item->product->name }}
                        </h4>
                        <p class="text-xs text-gray-500 mt-1">
                            Qty: {{ $item->quantity }} × ₹{{ number_format($item->unit_price, 2) }}
                        </p>
                    </div>

                    <!-- Subtotal -->
                    <div class="text-sm font-semibold text-gray-800">
                        ₹{{ number_format($item->subtotal, 2) }}
                    </div>

                    <!-- Review -->
                    @if(auth()->check() && $order->status === 'delivered')
                        <button wire:click="openReviewModal({{ $item->id }})"
                            class="text-xs text-brand-600 hover:text-brand-500 font-medium">
                            Add Review
                        </button>
                    @endif

                </div>

            @endforeach

        </div>

    </div>



    <!-- Payment Summary -->
    <div class="bg-white border border-gray-100 rounded-lg shadow-sm p-6">

        <div class="flex flex-col md:flex-row md:justify-between gap-6">

            <div>
                @if($order->coupon)
                    <p class="text-sm text-gray-600">
                        Coupon Applied:
                        <span class="text-green-600 font-medium">
                            {{ $order->coupon->code }}
                        </span>
                    </p>
                @endif
            </div>

            <div class="w-full md:w-64 space-y-2 text-sm">

                <div class="flex justify-between">
                    <span>Subtotal</span>
                    <span>₹{{ number_format($order->subtotal, 2) }}</span>
                </div>

                <div class="flex justify-between">
                    <span>Tax</span>
                    <span>₹{{ number_format($order->tax_amount, 2) }}</span>
                </div>

                <div class="flex justify-between">
                    <span>Shipping</span>
                    <span>₹{{ number_format($order->shipping_cost, 2) }}</span>
                </div>

                @if($order->discount > 0)
                    <div class="flex justify-between text-green-600">
                        <span>Discount</span>
                        <span>-₹{{ number_format($order->discount, 2) }}</span>
                    </div>
                @endif

                <div class="border-t border-gray-200 pt-2 flex justify-between font-semibold text-base">
                    <span>Total</span>
                    <span>₹{{ number_format($order->total_amount, 2) }}</span>
                </div>

            </div>

        </div>

    </div>



    <!-- Review Modal -->
    @if($showReviewModal)
        <div class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">

            <div class="bg-white w-full max-w-md rounded-xl shadow-xl p-6 relative">

                <button wire:click="$set('showReviewModal', false)"
                    class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>

                <h2 class="text-lg font-semibold text-gray-800 mb-4">
                    Write a Review
                </h2>

                <!-- Rating -->
                <div class="mb-4">
                    <div class="flex gap-2 text-2xl">
                        @for ($i = 1; $i <= 5; $i++)
                            <button type="button" wire:click="$set('rating', {{ $i }})"
                                class="{{ $i <= $rating ? 'text-yellow-400' : 'text-gray-300' }}">
                                ★
                            </button>
                        @endfor
                    </div>
                </div>

                <!-- Comment -->
                <textarea wire:model="comment" rows="4"
                    class="w-full border border-gray-300 rounded-md p-3 text-sm focus:ring-brand-500 focus:border-brand-500"
                    placeholder="Share your experience..."></textarea>

                <div class="mt-4 flex justify-end gap-3">
                    <button wire:click="$set('showReviewModal', false)" class="px-4 py-2 text-sm border rounded-md">
                        Cancel
                    </button>
                    <button wire:click="addReview"
                        class="px-4 py-2 text-sm bg-brand-600 text-white rounded-md hover:bg-brand-700">
                        Submit
                    </button>
                </div>

            </div>

        </div>
    @endif

</div>