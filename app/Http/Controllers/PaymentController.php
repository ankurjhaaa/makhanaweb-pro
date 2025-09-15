<?php

// File: app/Http/Controllers/PaymentController.php
namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Razorpay\Api\Api;

class PaymentController extends Controller
{
    public function pay($id)
    {
        $order = Order::findOrFail($id);

        $api = new Api(
            config('services.razorpay.key'),
            config('services.razorpay.secret')
        );

        try {
            $razorpayOrder = $api->order->create([
                'receipt' => $order->order_number,
                'amount' => $order->total_amount * 100, // Convert to paise
                'currency' => 'INR',
            ]);

            return view('payment.online', [
                'order' => $order,
                'razorpayOrderId' => $razorpayOrder['id'],
                'razorpayKey' => config('services.razorpay.key'),
            ]);
        } catch (\Exception $e) {
            \Log::error('Razorpay order creation failed: ' . $e->getMessage());
            session()->flash('error', 'Failed to initiate payment. Please try again.');
            return redirect()->route('checkout');
        }
    }

    public function paymentSuccess(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

        try {
            $attributes = [
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
            ];
            $api->utility->verifyPaymentSignature($attributes);

            $order->status = 'completed';
            $order->payment_method = 'online';
            $order->save();

            session()->flash('success', 'Payment successful! Order placed.');
            return redirect()->route('order.success');
        } catch (\Exception $e) {
            \Log::error('Payment verification failed: ' . $e->getMessage());
            session()->flash('error', 'Payment verification failed.');
            return redirect()->route('checkout');
        }
    }
}
