@extends('admin.layout')

@section('title', 'Order Details')

@section('content')
<div class="bg-white shadow-lg rounded-2xl mt-20 p-6">
    <!-- Order Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">
            Order <span class="text-brand-600">#{{ $order->order_number }}</span>
        </h2>

        <span class="
            px-3 py-1 text-sm font-medium rounded-full mt-3 sm:mt-0
            @if($order->status == 'pending') bg-yellow-100 text-yellow-700 
            @elseif($order->status == 'completed') bg-green-100 text-green-700 
            @elseif($order->status == 'cancelled') bg-red-100 text-red-700 
            @else bg-gray-100 text-gray-700 @endif">
            {{ ucfirst($order->status) }}
        </span>
    </div>

    <!-- Order Summary -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="p-4 border rounded-xl bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-700 mb-3">Order Summary</h3>
            <ul class="space-y-2 text-gray-600">
                <li><strong>User ID:</strong> {{ $order->user_id }}</li>
                <li><strong>Subtotal:</strong> ₹{{ number_format($order->subtotal, 2) }}</li>
                <li><strong>Discount:</strong> ₹{{ number_format($order->discount, 2) }}</li>
                <li><strong>Shipping:</strong> ₹{{ number_format($order->shipping_cost, 2) }}</li>
                <li class="font-bold text-gray-800 text-lg">
                    Total: ₹{{ number_format($order->total_amount, 2) }}
                </li>
            </ul>
        </div>

       <div class="p-4 border rounded-xl bg-gray-50">
    <h3 class="text-lg font-semibold text-gray-700 mb-3">Addresses</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <!-- Shipping Address -->
        <div>
            <h4 class="font-semibold text-gray-800 mb-2">Shipping Address</h4>
            @if($order->shippingAddress)
                <ul class="space-y-1 text-gray-600 text-sm">
                    <li>{{ $order->shippingAddress->name }}</li>
                    <li>{{ $order->shippingAddress->address_line1 }}</li>
                    <li>{{ $order->shippingAddress->city }}, {{ $order->shippingAddress->state }}</li>
                    <li>{{ $order->shippingAddress->zip }}</li>
                    <li>📞 {{ $order->shippingAddress->phone }}</li>
                </ul>
            @else
                <p class="text-gray-500 text-sm">No shipping address available.</p>
            @endif
        </div>

        <!-- Billing Address -->
        <div>
            <h4 class="font-semibold text-gray-800 mb-2">Billing Address</h4>
            @if($order->billingAddress)
                <ul class="space-y-1 text-gray-600 text-sm">
                    <li>{{ $order->billingAddress->address_line1 }}</li>
                    <li>{{ $order->billingAddress->address_line2 }}</li>
                    <li>{{ $order->billingAddress->city }}, {{ $order->billingAddress->state }}</li>
                    <li>{{ $order->billingAddress->zip }}</li>
                    <li>📞 {{ $order->billingAddress->phone }}</li>
                </ul>
            @else
                <p class="text-gray-500 text-sm">No billing address available.</p>
            @endif
        </div>

    </div>
</div>

    </div>

    <!-- Products Table -->
    <h3 class="text-xl font-semibold text-gray-800 mb-4">Ordered Products</h3>
    <div class="overflow-x-auto rounded-xl border">
        <table class="min-w-full text-sm divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left font-semibold text-gray-600">Product</th>
                    <th class="px-4 py-2 text-left font-semibold text-gray-600">Price</th>
                    <th class="px-4 py-2 text-left font-semibold text-gray-600">Quantity</th>
                    <th class="px-4 py-2 text-left font-semibold text-gray-600">Total</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($order->orderItems as $item)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3 font-medium text-gray-800">
                            {{ $item->product->name }}
                        </td>
                        <td class="px-4 py-3">₹{{ number_format($item->product->price, 2) }}</td>
                        <td class="px-4 py-3">{{ $item->quantity }}</td>
                        <td class="px-4 py-3 font-semibold text-gray-700">
                            ₹{{ number_format($item->product->price * $item->quantity, 2) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Back Button -->
  <div class="mt-6">
    <a href="{{ route('allOrders') }}" 
       class="inline-flex items-center gap-2 px-5 py-2 bg-brand-600 text-yellow-600 rounded-xl shadow hover:bg-brand-700 transition">
        <span>←</span> Back to Orders
    </a>
</div>
</div>
@endsection
