@extends('admin.layout')

@section('title', 'All Orders')

@section('content')
    <div class="pt-8 pb-4">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Orders Management</h1>
                <p class="text-gray-600 mt-1">View and manage all customer orders</p>
            </div>

            <form method="GET" class="mt-4 md:mt-0 flex gap-3">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search orders..."
                        class="py-2 pl-10 pr-4 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                </div>

                <select name="status"
                    class="py-2 px-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>

                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md flex items-center gap-2">
                    <i class="fas fa-filter"></i>
                    <span>Filter</span>
                </button>
            </form>

        </div>

        <div class="bg-white shadow-sm border border-gray-200 rounded-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order
                                #</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Subtotal</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Discount</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Shipping Cost</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total
                                Amount</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($allOrders as $order)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 whitespace-nowrap font-medium">{{ $order->order_number }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-gray-500">
                                    {{ \Carbon\Carbon::parse($order->created_at)->format('M d, Y') }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap"> ₹{{ number_format($order->subtotal, 2) }}</td>
                                <td class="px-4 py-3 whitespace-nowrap"> ₹{{ number_format($order->discount, 2) }}</td>
                                <td class="px-4 py-3 whitespace-nowrap"> ₹{{ number_format($order->shipping_cost, 2) }}</td>
                                <td class="px-4 py-3 whitespace-nowrap font-bold"> ₹{{ number_format($order->total_amount, 2) }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    @if($order->status == 'pending')
                                        <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">Pending</span>
                                    @elseif($order->status == 'completed')
                                        <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Completed</span>
                                    @elseif($order->status == 'cancelled')
                                        <span class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded-full">Cancelled</span>
                                    @else
                                        <span
                                            class="px-2 py-1 text-xs bg-gray-100 text-gray-800 rounded-full">{{ $order->status }}</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-center">
                                    <div class="flex justify-center space-x-2">
                                        <!-- View Order -->
                                        <a href="{{ route('admin.viewOrder', $order->id) }}"
                                            class="text-blue-600 hover:text-blue-900" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-4 py-6 text-center text-gray-500">
                                    <div class="flex flex-col items-center py-8">
                                        <i class="fas fa-shopping-cart text-gray-300 text-5xl mb-4"></i>
                                        <p class="text-lg font-medium">No orders found</p>
                                        <p class="text-gray-400">Orders will appear here when customers make purchases</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="bg-gray-50 border-t border-gray-200 px-4 py-3 ">
                {{ $allOrders->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection