<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Payment</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body
    class="bg-gradient-to-br from-orange-50 via-gray-100 to-blue-50 min-h-screen flex items-center justify-center font-sans">

    <div class="max-w-md w-full bg-white/90 backdrop-blur-lg shadow-2xl rounded-3xl p-8 border border-gray-100">
        <!-- Heading -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold text-gray-900">Complete Your Payment</h1>
            <p class="text-gray-500 text-sm mt-2">Secure checkout powered by Razorpay</p>
        </div>

        <!-- Order Info -->
        <div class="bg-gradient-to-r from-orange-100 to-blue-100 border border-gray-200 rounded-xl p-5 mb-8 shadow-sm">
            <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-orange-600" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 7h18M3 12h18M3 17h18M5 21h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
                Order #TEMP
            </h2>
            <p class="text-gray-700 mt-2 text-lg">Total Amount:</p>
            <p class="text-2xl font-bold text-blue-700">₹{{ $orderdetail->total_amount }}</p>
        </div>

        <!-- Hidden Form -->
        <form id="razorpay-form" action="{{ route('payment.success', $orderdetail->id) }}" method="POST">
            @csrf
            <input type="hidden" name="orderId" value="{{ $orderdetail->id }}">
            <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
            <input type="hidden" name="razorpay_order_id" id="razorpay_order_id">
            <input type="hidden" name="razorpay_signature" id="razorpay_signature">
        </form>

        <!-- Auto Trigger Info -->
        <div class="text-center mt-6">
            <p class="text-sm text-gray-500 animate-pulse">Redirecting to secure payment...</p>
        </div>

        <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
        <script>
            // ✅ Agar user back/refresh se aaya hai to home bhej do
            window.addEventListener("pageshow", function (event) {
                if (event.persisted || performance.getEntriesByType("navigation")[0].type === "back_forward") {
                    window.location.href = "{{ url('/') }}"; // Home page
                }
            });
            window.onload = function () {
                var options = {
                    "key": "{{ env('RAZORPAY_KEY') }}",
                    "amount": "{{ $orderdetail->total_amount * 100 }}",
                    "currency": "INR",
                    "name": "Yours Snacks",
                    "description": "Order Payment",
                    "image": "https://yourdomain.com/logo.png",
                    "order_id": "{{ $razorpayOrderId ?? '' }}",
                    "prefill": {
                        "name": "{{ Auth::user()->name }}",
                        "email": "{{ Auth::user()->email }}"
                    },
                    "theme": {
                        "color": "#2563eb"
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
                rzp.open(); // ✅ Auto open on page load
            }
        </script>

        <!-- Security Note -->
        <p class="text-xs text-gray-500 text-center mt-6 flex items-center justify-center gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-500" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 11c0-1.105.895-2 2-2s2 .895 2 2-.895 2-2 2-2-.895-2-2-2zM4.318 6.318a4.5 4.5 0 016.364 0l.318.318.318-.318a4.5 4.5 0 116.364 6.364L12 21.364l-7.682-7.682a4.5 4.5 0 010-6.364z" />
            </svg>
            100% Secure Payment
        </p>
    </div>

</body>

</html>