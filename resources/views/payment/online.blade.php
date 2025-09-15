```html
<!-- File: resources/views/payment/online.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Payment</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-8">
        <h1 class="font-poppins text-3xl font-bold mb-6">Complete Your Payment</h1>
        <div class="bg-white border border-gray-100 rounded-lg p-6">
            <h2 class="font-poppins text-xl font-semibold mb-4">Order #{{ $order->order_number }}</h2>
            <p class="text-gray-600 mb-4">Total Amount: ₹{{ $order->total_amount }}</p>
            <form id="razorpay-form" action="{{ route('payment.success', $order->id) }}" method="POST">
                @csrf
                <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
                <input type="hidden" name="razorpay_order_id" id="razorpay_order_id" value="{{ $razorpayOrderId }}">
                <input type="hidden" name="razorpay_signature" id="razorpay_signature">
            </form>
            <button id="rzp-button" class="bg-brand-600 text-white px-6 py-3 rounded-full hover:bg-brand-700 transition-all font-medium">Pay Now</button>
            <div id="razorpay-error" class="text-red-600 text-xs mt-2 hidden"></div>
        </div>
    </div>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var options = {
                "key": "{{ $razorpayKey }}",
                "amount": {{ $order->total_amount * 100 }},
                "currency": "INR",
                "name": "Your Store Name",
                "description": "Order #{{ $order->order_number }}",
                "order_id": "{{ $razorpayOrderId }}",
                "prefill": {
                    "name": "{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}",
                    "email": "{{ Auth::user()->email }}"
                },
                "theme": {
                    "color": "#F37254"
                },
                "handler": function (response) {
                    document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
                    document.getElementById('razorpay_order_id').value = response.razorpay_order_id;
                    document.getElementById('razorpay_signature').value = response.razorpay_signature;
                    document.getElementById('razorpay-form').submit();
                },
                "modal": {
                    "ondismiss": function () {
                        window.location.href = "{{ route('checkout') }}";
                    }
                }
            };

            var rzp = new Razorpay(options);
            var rzpButton = document.getElementById('rzp-button');

            rzpButton.onclick = function (e) {
                rzp.open();
                e.preventDefault();
            };

            // Auto-open the popup
            rzp.open();

            rzp.on('payment.failed', function (response) {
                document.getElementById('razorpay-error').innerText = 'Payment failed: ' + response.error.description;
                document.getElementById('razorpay-error').classList.remove('hidden');
            });
        });
    </script>
</body>
</html>
```