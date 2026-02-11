<div class="space-y-6">

    <!-- Page Header -->
    <div class="bg-white border border-gray-100 rounded-lg shadow-sm p-6">
        <h1 class="font-poppins text-2xl font-semibold text-gray-800">
            My Orders
        </h1>
        <p class="text-sm text-gray-500 mt-1">
            Track, manage and review your purchases
        </p>
    </div>



    <!-- Filters -->
    <div class="bg-white border border-gray-100 rounded-lg shadow-sm p-5">

        <div class="flex flex-col lg:flex-row gap-4">

            <!-- Search -->
            <div class="relative flex-1">
                <input wire:model.live.debounce.300ms="searchQuery" type="text" placeholder="Search by order number..."
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md text-sm focus:ring-brand-500 focus:border-brand-500">
                <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                    <i class="fas fa-search"></i>
                </div>
            </div>

            <!-- Status -->
            <select wire:model.live="filterStatus"
                class="w-full lg:w-44 px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-brand-500 focus:border-brand-500 bg-white">
                @foreach($orderStatuses as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>

           

        </div>

    </div>



    <!-- Orders -->
    <div wire:loading.class="opacity-50">

        @forelse($orders as $order)

            <div class="bg-white border border-gray-100 rounded-lg shadow-sm overflow-hidden mb-5">

                <!-- Order Top -->
                <div
                    class="p-4 md:p-6 bg-gray-50 border-b border-gray-100 flex flex-col md:flex-row md:items-center md:justify-between gap-3">

                    <div>
                        <div class="text-sm text-gray-500">
                            Order ID
                        </div>
                        <div class="font-semibold text-gray-800">
                            #{{ $order->order_number }}
                        </div>
                        <div class="text-xs text-gray-400 mt-1">
                            {{ $order->created_at->format('M d, Y • h:i A') }}
                        </div>
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

                        <!-- Total -->
                        <div class="font-semibold text-brand-600">
                            ₹{{ number_format($order->total_amount, 2) }}
                        </div>

                    </div>

                </div>


                <!-- Items -->
                <div class="divide-y divide-gray-100">

                    @foreach($order->orderItems as $item)

                        <div class="p-4 flex gap-4 items-center">

                            <!-- Image -->
                            <div class="w-16 h-16 bg-gray-100 rounded-md overflow-hidden">
                                @if($item->product && $item->product->imagelink)
                                    <img src="{{ $item->product->imagelink }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        <i class="fas fa-box"></i>
                                    </div>
                                @endif
                            </div>

                            <!-- Info -->
                            <div class="flex-1">
                                <div class="text-sm font-medium text-gray-800">
                                    {{ $item->product->name ?? 'Product Unavailable' }}
                                </div>
                                <div class="text-xs text-gray-500 mt-1">
                                    Qty: {{ $item->quantity }} • ₹{{ number_format($item->unit_price, 2) }}
                                </div>
                            </div>

                            <!-- Subtotal -->
                            <div class="text-sm font-medium text-gray-800">
                                ₹{{ number_format($item->subtotal, 2) }}
                            </div>

                        </div>

                    @endforeach

                </div>


                <!-- Footer -->
                <div
                    class="p-4 md:p-6 bg-gray-50 border-t border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

                    <div>
                        @if($order->coupon)
                            <span class="text-xs text-gray-500">
                                Coupon:
                                <span class="text-green-600 font-medium">
                                    {{ $order->coupon->code }}
                                </span>
                            </span>
                        @endif
                    </div>

                    <div class="flex items-center gap-4">

                        <a href="{{ route('user.orderdetail', $order->order_number) }}"
                            class="text-sm font-medium text-brand-600 hover:text-brand-500">
                            View Details
                        </a>

                        @if($order->status === 'pending' || $order->status === 'processing')
                            <button wire:click="cancelOrder({{ $order->id }})"
                                class="text-sm font-medium text-red-600 hover:text-red-500">
                                Cancel
                            </button>
                        @endif

                    </div>

                </div>

            </div>

        @empty

            <!-- Empty -->
            <div class="bg-white border border-gray-100 rounded-lg shadow-sm p-10 text-center">

                <div class="w-16 h-16 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-shopping-bag text-gray-400 text-xl"></i>
                </div>

                <h3 class="text-lg font-medium text-gray-800 mb-2">
                    No Orders Yet
                </h3>

                <p class="text-sm text-gray-500 mb-6">
                    Looks like you haven’t placed any orders.
                </p>

                <a href="{{ route('shop') }}"
                    class="inline-flex items-center px-5 py-2 bg-brand-600 text-white rounded-md hover:bg-brand-700 transition text-sm">
                    <i class="fas fa-shopping-cart mr-2"></i>
                    Browse Products
                </a>

            </div>

        @endforelse

        <!-- Pagination -->
        <div class="mt-6">
            {{ $orders->links() }}
        </div>

    </div>




</div>