<?php

namespace App\Services\Midtrans;

use Midtrans\Snap;

class CreateSnapTokenService extends Midtrans
{
    protected $order;

    public function __construct($order)
    {
        parent::__construct();

        $this->order = $order;
    }

    public function getSnapToken()
    {
        $params = [
            'transaction_details' => [
                'order_id' => $this->order->order_number,
                'gross_amount' => $this->order->total_amount,
            ],
            'item_details' => $this->order->items,
            'customer_details' => [
                'first_name' => $this->order->first_name . ' ' . $this->order->last_name,
                'email' => $this->order->email,
                'phone' => $this->order->phone,
            ]
        ];

        $snapToken = Snap::getSnapToken($params);

        return $snapToken;
    }
}
