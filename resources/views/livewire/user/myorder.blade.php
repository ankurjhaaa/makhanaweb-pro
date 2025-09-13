<div class="space-y-6">
    <!-- Filters Section -->
    <div class="bg-white p-5 rounded-lg border border-gray-100 shadow-sm">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <!-- Search -->
            <div class="relative w-full md:w-auto md:flex-1">
                <input 
                    wire:model.live.debounce.300ms="searchQuery" 
                    type="text" 
                    placeholder="Search by order number..." 
                    class="w-full px-4 py-2 pl-10 border border-gray-300 rounded-md text-sm focus:ring-brand-500 focus:border-brand-500"
                >
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
            </div>

            <div class="flex items-center space-x-4">
                <!-- Status Filter -->
                <div class="w-full md:w-auto">
                    <select 
                        wire:model.live="filterStatus"
                        class="w-full md:w-40 px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-brand-500 focus:border-brand-500 bg-white"
                    >
                        @foreach($orderStatuses as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Date Range Picker (placeholder - would require JS implementation) -->
                <div class="w-full md:w-auto hidden md:block">
                    <div class="relative">
                        <input 
                            wire:model.live="dateRange" 
                            type="text" 
                            placeholder="Date range" 
                            class="w-full md:w-40 px-3 py-2 pl-10 border border-gray-300 rounded-md text-sm focus:ring-brand-500 focus:border-brand-500"
                        >
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-calendar-alt text-gray-400"></i>
                        </div>
                    </div>
                </div>

                <!-- Clear Filters -->
                <button 
                    wire:click="clearFilters"
                    type="button"
                    class="hidden md:flex items-center px-3 py-2 border border-gray-300 rounded-md text-sm text-gray-700 hover:bg-gray-50"
                >
                    <i class="fas fa-times mr-2"></i>
                    Clear
                </button>
            </div>
        </div>

        <!-- Mobile Date Range and Clear -->
        <div class="flex items-center space-x-4 mt-4 md:hidden">
            <div class="relative flex-1">
                <input 
                    wire:model.live="dateRange" 
                    type="text" 
                    placeholder="Date range" 
                    class="w-full px-3 py-2 pl-10 border border-gray-300 rounded-md text-sm focus:ring-brand-500 focus:border-brand-500"
                >
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-calendar-alt text-gray-400"></i>
                </div>
            </div>

            <button 
                wire:click="clearFilters"
                type="button"
                class="px-3 py-2 border border-gray-300 rounded-md text-sm text-gray-700 hover:bg-gray-50"
            >
                <i class="fas fa-times mr-2"></i>
                Clear
            </button>
        </div>
    </div>

    <!-- Orders List -->
    <div wire:loading.class="opacity-50">
        @if($orders->isEmpty())
            <!-- Empty State -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                    <i class="fas fa-shopping-bag text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-1">No orders found</h3>
                <p class="text-gray-500 mb-6">You haven't placed any orders yet.</p>
                <a href="{{ route('shop') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-brand-600 hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500">
                    <i class="fas fa-shopping-cart mr-2"></i>
                    Browse Products
                </a>
            </div>
        @else
            <!-- Order Items -->
            <div class="space-y-6">
                @foreach($orders as $order)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                        <!-- Order Header -->
                        <div class="p-4 bg-gray-50 border-b border-gray-200 flex flex-col md:flex-row md:items-center md:justify-between gap-2">
                            <div>
                                <div class="flex items-center">
                                    <span class="text-gray-600 text-sm mr-2">Order:</span>
                                    <span class="font-medium">#{{ $order->order_number }}</span>
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ $order->created_at->format('M d, Y, h:i A') }}
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <div>
                                    @switch($order->status)
                                        @case('pending')
                                            <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium">
                                                Pending
                                            </span>
                                            @break
                                        @case('processing')
                                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">
                                                Processing
                                            </span>
                                            @break
                                        @case('shipped')
                                            <span class="px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full text-xs font-medium">
                                                Shipped
                                            </span>
                                            @break
                                        @case('delivered')
                                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">
                                                Delivered
                                            </span>
                                            @break
                                        @case('cancelled')
                                            <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-medium">
                                                Cancelled
                                            </span>
                                            @break
                                        @default
                                            <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-medium">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                    @endswitch
                                </div>
                                
                                <div class="text-sm font-medium text-gray-800">
                                    ₹{{ number_format($order->total_amount, 2) }}
                                </div>
                            </div>
                        </div>

                        <!-- Order Items -->
                        <div class="px-4">
                            @foreach($order->orderItems->take(3) as $item)
                                <div class="py-4 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                                    <div class="flex items-center">
                                        <div class="h-16 w-16 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                                            @if($item->product && $item->product->image_url)
                                                <img src="{{ $item->product->image_url }}?tr=w-100,h-100" alt="{{ $item->product->name }}" class="h-full w-full object-cover object-center">
                                            @else
                                                <div class="h-full w-full bg-gray-100 flex items-center justify-center">
                                                    <i class="fas fa-box text-gray-400"></i>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="ml-4 flex-1">
                                            <h4 class="text-sm font-medium text-gray-900">
                                                {{ $item->product->name ?? 'Product Unavailable' }}
                                            </h4>
                                            <p class="mt-1 text-sm text-gray-500 flex items-center">
                                                <span class="mr-4">Qty: {{ $item->quantity }}</span>
                                                <span>₹{{ number_format($item->unit_price, 2) }} each</span>
                                            </p>
                                        </div>

                                        <div class="text-right">
                                            <p class="text-sm font-medium text-gray-900">₹{{ number_format($item->subtotal, 2) }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            
                            @if($order->orderItems->count() > 3)
                                <div class="py-3 text-center border-t border-gray-100">
                                    <button type="button" class="text-sm text-brand-600 hover:text-brand-500 font-medium">
                                        + {{ $order->orderItems->count() - 3 }} more items
                                    </button>
                                </div>
                            @endif
                        </div>

                        <!-- Order Footer -->
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                            <div>
                                @if($order->coupon)
                                    <span class="text-xs text-gray-500">Coupon Applied: <span class="font-mono font-medium text-green-600">{{ $order->coupon->code }}</span></span>
                                @endif
                            </div>

                            <div class="flex items-center space-x-3">
                                <a href="#" class="text-sm font-medium text-brand-600 hover:text-brand-500">
                                    View Details
                                </a>

                                @if($order->status === 'pending' || $order->status === 'processing')
                                    <button 
                                        wire:click="cancelOrder({{ $order->id }})"
                                        wire:confirm="Are you sure you want to cancel this order?"
                                        type="button" 
                                        class="text-sm font-medium text-red-600 hover:text-red-500">
                                        Cancel Order
                                    </button>
                                @elseif($order->status === 'delivered')
                                    <a href="#" class="inline-flex items-center px-3 py-1.5 border border-transparent rounded-md text-xs font-medium bg-brand-600 text-white hover:bg-brand-700">
                                        <i class="fas fa-star mr-1"></i> 
                                        Write Review
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $orders->links() }}
                </div>
            </div>
        @endif
    </div>

    <!-- Loading Indicator -->
    <div wire:loading class="fixed inset-0 bg-black bg-opacity-25 flex items-center justify-center z-50">
        <div class="bg-white p-4 rounded-lg shadow-lg">
            <div class="flex items-center space-x-3">
                <div class="animate-spin rounded-full h-6 w-6 border-4 border-brand-600 border-t-transparent"></div>
                <span>Loading orders...</span>
            </div>
        </div>
    </div>
</div>
