@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto p-6 bg-white rounded-lg shadow mt-10">
    <h1 class="text-2xl font-bold mb-4">Pay for Order #{{ $order->order_number }}</h1>
    <p class="mb-2">Amount: ₹{{ $order->total_amount }}</p>
    <p class="mb-4">Name: {{ $order->billingAddress->name ?? '' }}</p>
    <button id="payButton" class="bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700">Pay Now</button>
</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
document.getElementById('payButton').onclick = function(e) {
    e.preventDefault();

    fetch("{{ route('online.payment.process', ['order' => $order->id]) }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Content-Type": "application/json"
        }
    })
    .then(res => res.json())
    .then(data => {
        var options = {
            "key": data.key,
            "amount": data.amount,
            "currency": data.currency,
            "name": data.name,
            "order_id": data.order_id,
            "prefill": data.prefill,
            "handler": function (response){
                window.location.href = "/payment-success/{{ $order->id }}?payment_id=" + response.razorpay_payment_id;
            },
            "modal": {
                "ondismiss": function(){
                    alert('Payment cancelled');
                }
            }
        };
        var rzp = new Razorpay(options);
        rzp.open();
    })
    .catch(err => console.error(err));
}
</script>
@endsection
