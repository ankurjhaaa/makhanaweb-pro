@extends('admin.layout')

@section('title', 'All Orders')

@section('content')
    <div class="bg-white shadow rounded-lg mt-20 p-4">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-gray-800">All Orders</h2>
            
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">User ID</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Coupon ID</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Order Number</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Discount</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Shipping Cost</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Total Amount</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Shipping Address ID</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Billing Address ID</th>
                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($allOrders as $order)
                        <tr>
                            <td class="px-4 py-2 whitespace-nowrap">{{ $order->user_id }}</td>
                            <td class="px-4 py-2 whitespace-nowrap">{{ $order->coupon_id ?? '-' }}</td>
                            <td class="px-4 py-2 whitespace-nowrap">{{ $order->order_number }}</td>
                            <td class="px-4 py-2 whitespace-nowrap"> ₹{{ number_format($order->subtotal, 2) }}</td>
                            <td class="px-4 py-2 whitespace-nowrap"> ₹{{ number_format($order->discount, 2) }}</td>
                            <td class="px-4 py-2 whitespace-nowrap"> ₹{{ number_format($order->shipping_cost, 2) }}</td>
                            <td class="px-4 py-2 whitespace-nowrap font-bold"> ₹{{ number_format($order->total_amount, 2) }}</td>
                            <td class="px-4 py-2 whitespace-nowrap">
                                @if($order->status == 'pending')
                                    <span class="px-2 py-1 text-xs bg-yellow-200 text-yellow-800 rounded-full">Pending</span>
                                @elseif($order->status == 'completed')
                                    <span class="px-2 py-1 text-xs bg-green-200 text-green-800 rounded-full">Completed</span>
                                @elseif($order->status == 'cancelled')
                                    <span class="px-2 py-1 text-xs bg-red-200 text-red-800 rounded-full">Cancelled</span>
                                @else
                                    <span
                                        class="px-2 py-1 text-xs bg-gray-200 text-gray-800 rounded-full">{{ $order->status }}</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 whitespace-nowrap">{{ $order->shipping_address_id }}</td>
                            <td class="px-4 py-2 whitespace-nowrap">{{ $order->billing_address_id }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-center">
                                <a href="{{ route('admin.viewOrder', $order->id) }}"
                                    class="text-yellow-500 hover:underline mr-2">View</a>
                                <form action="" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline"
                                        onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="px-4 py-6 text-center text-gray-500">
                                No orders found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
@endsection