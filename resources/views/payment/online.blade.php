<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Payment</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body
    class="bg-gradient-to-br from-gray-50 via-gray-100 to-gray-200 min-h-screen flex items-center justify-center font-sans">

    <div class="max-w-lg w-full bg-white/80 backdrop-blur-lg shadow-xl rounded-2xl p-8 border border-gray-200">
        <!-- Heading -->
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Complete Your Payment</h1>
            <p class="text-gray-500 text-sm mt-2">Secure checkout powered by Razorpay</p>
        </div>

        <!-- Order Info -->
        <div class="bg-gray-50 border rounded-lg p-4 mb-6">
            <h2 class="text-lg font-semibold text-gray-700 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 7h18M3 12h18M3 17h18M5 21h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
                Order #TEMP
            </h2>
            <p class="text-gray-600 mt-2">Total Amount: <span
                    class="text-xl font-bold text-indigo-600">₹{{ $orderdetail->total_amount }}</span></p>
        </div>

        <form action="{{ route('payment.success',$orderdetail->id) }}" method="POST"
            class="bg-gradient-to-r from-orange-600 to-blue-800 text-white px-3 py-2 rounded hover:from-blue-800 hover:to-orange-600 transition duration-300">
            @csrf
            <input type="hidden" name="orderId" value="{{ $orderdetail->id }}">
            <script src="https://checkout.razorpay.com/v1/checkout.js" data-key="{{ env('RAZORPAY_KEY') }}"
                data-amount="{{ $orderdetail->total_amount * 100 }}" data-currency="INR" data-buttontext="Pay Now"
                data-name="Yours Snacks" data-description="Order Payment" data-image="https://yourdomain.com/logo.png"
                data-prefill.name="{{ Auth::user()->name }}" data-prefill.email="{{ Auth::user()->email }}"
                data-theme.color="#16a34a" data-callback_url="{{ route('checkout') }}">
                </script>
        </form>


        <!-- Security Note -->
        <p class="text-xs text-gray-500 text-center mt-6 flex items-center justify-center gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-500" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 11c0-1.105.895-2 2-2s2 .895 2 2-.895 2-2 2-2-.895-2-2zM4.318 6.318a4.5 4.5 0 016.364 0l.318.318.318-.318a4.5 4.5 0 116.364 6.364L12 21.364l-7.682-7.682a4.5 4.5 0 010-6.364z" />
            </svg>
            100% Secure Payment
        </p>
    </div>


</body>

</html>