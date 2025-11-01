<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function createTransaction($orderId, $grossAmount, $customer)
    {
        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $grossAmount,
            ],
            'customer_details' => $customer,
        ];

        $snapTransaction = Snap::createTransaction($params);

        return [
            'token' => $snapTransaction->token ?? null,
            'url' => $snapTransaction->redirect_url
                ?? $snapTransaction->deeplink_url
                ?? null,
        ];
    }
}
