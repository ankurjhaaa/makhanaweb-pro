<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delivery Slip - Order #{{ $order->order_number }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { margin: 0; }
        }
    </style>
</head>
<body class="bg-gray-100 p-6">

    <div class="max-w-lg mx-auto bg-white shadow-lg rounded-xl p-6 border border-dashed border-gray-400">
        <!-- Header -->
        <div class="text-center mb-4">
            <h2 class="text-2xl font-bold text-gray-800">Delivery Slip</h2>
            <p class="text-sm text-gray-500">Order #{{ $order->order_number }}</p>
            <p class="text-xs text-gray-400">Date: {{ $order->created_at->format('d M Y') }}</p>
        </div>

        <hr class="my-4">

        <!-- Shipping Address -->
        <div class="mb-4">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Ship To</h3>
            @if($order->shippingAddress)
                <ul class="text-gray-600 text-sm space-y-1">
                    <li class="font-medium text-gray-800">{{ $order->shippingAddress->name }}</li>
                    <li>{{ $order->shippingAddress->address_line1 }}</li>
                    <li>{{ $order->shippingAddress->city }}, {{ $order->shippingAddress->state }} - {{ $order->shippingAddress->zip }}</li>
                    <li>📞 {{ $order->shippingAddress->phone }}</li>
                </ul>
            @else
                <p class="text-gray-500 text-sm">No shipping address available.</p>
            @endif
        </div>

        <hr class="my-4">

        <!-- Products -->
        <div>
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Products</h3>
            <table class="w-full border border-gray-300 text-sm">
                <thead class="bg-gray-100 text-gray-600">
                    <tr>
                        <th class="border border-gray-300 px-3 py-2 text-left">Item</th>
                        <th class="border border-gray-300 px-3 py-2 text-center">Qty</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderItems as $item)
                        <tr>
                            <td class="border border-gray-300 px-3 py-2">{{ $item->product->name }}</td>
                            <td class="border border-gray-300 px-3 py-2 text-center">{{ $item->quantity }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Total -->
        <div class="mt-4 text-right">
            <p class="text-lg font-bold text-gray-800">Grand Total: ₹{{ number_format($order->total_amount, 2) }}</p>
        </div>
    </div>

    <!-- Buttons -->
    <div class="no-print flex justify-center gap-4 mt-6">
        <button onclick="window.print()"
            class="px-5 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition">
            🖨 Print Slip
        </button>
        <a href="{{ route('allOrders') }}"
            class="px-5 py-2 bg-gray-700 text-white rounded-lg shadow hover:bg-gray-800 transition">
            ← Back to Orders
        </a>
    </div>

</body>
</html>
