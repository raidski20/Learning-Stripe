<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Stripe\CheckoutSession;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function checkout(Request $request, CheckoutSession $checkoutSession)
    {
        // Getting a random user instead of the authenticated one,
        // because authentication system is not set up
        $user = User::where('id', random_int(1, 3))->first();

        $checkout_session = $checkoutSession->createCheckoutSession($request->product_id, $user);

        return redirect($checkout_session->url);
    }

    public function success(): string
    {
        return "Payment success";
    }

    public function cancel()
    {
        return "Payment canceled";
    }
}
