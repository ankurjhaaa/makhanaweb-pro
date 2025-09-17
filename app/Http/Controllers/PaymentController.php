<?php

// File: app/Http/Controllers/PaymentController.php
namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\Payment;
use Auth;
use Illuminate\Http\Request;
use Log;
use Razorpay\Api\Api;

class PaymentController extends Controller
{
    public function paymentpage($id)
    {
        $orderdetail = Order::findOrFail($id);

        return view('payment.online', compact('orderdetail'));

    }


    public function paymentSuccess(Request $request, $id)
    {
        try {
            $paymentId = $request->get('razorpay_payment_id');

            if (!$paymentId) {
                return redirect()->back()->with('error', 'Payment ID not received.');
            }

            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

            // Fetch payment from Razorpay
            $payment = $api->payment->fetch($paymentId);

            // Check if authorized before capturing
            if ($payment->status === 'authorized') {
                $payment->capture(['amount' => $payment->amount]); // capture amount in paise
            }

            // Re-fetch after capture
            $payment = $api->payment->fetch($paymentId);

            if ($payment->status === 'captured') {
                Payment::create([
                    'user_id' => Auth::id(), // ✅ save user ID
                    'order_id' => $id, // ✅ save user ID
                    'payment_status' => $payment->status,
                    'payment_method' => 'online',
                    'transaction_id' => $payment->id,
                    'payment_details' => 'successful', // ✅ store full response
                ]);

                return redirect()->route('order.success')->with('success', 'Payment successful!');
            } else {
                return redirect()->back()->with('error', 'Payment not captured. Try again.');
            }
        } catch (\Exception $e) {
            Log::error('Razorpay Payment Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong during payment verification.');
        }
    }



}
