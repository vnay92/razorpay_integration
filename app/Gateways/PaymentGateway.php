<?php

namespace App\Gateways;

use Razorpay\Api\Api;
use Illuminate\Contracts\Auth\Guard as Auth;

class PaymentGateway
{
    public function __construct()
    {
        $api_key = config('key');
        $api_secret = config('secret');

        $this->api = new Api($api_key, $api_secret);
    }

    public function createOrder($order_data)
    {
        $order = $this->api->order->create($order_data); // Returns array of payment objects
        return $order->id;
    }

    public function capturePayment($payment_id, $amount)
    {
        return $this->api->payment->fetch($payment_id)->capture([
            'amount' => $amount
        ]);
    }

    public function getPayment($payment_id)
    {
        return $this->api->payment->fetch($payment_id);
    }

}
