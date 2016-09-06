<?php

namespace App\Gateways;

use App\Repositories\TransactionsRepository;
use Illuminate\Contracts\Auth\Guard as Auth;

class TransactionsGateway
{
    public function __construct(
        Auth $auth,
        PaymentGateway $paymentGateway,
        TransactionsRepository $transactionsRepository
    ) {
        $this->transactionsRepository = $transactionsRepository;
        $this->auth = $auth;
        $this->paymentGateway = $paymentGateway;
    }

    public function getAll()
    {
        return $this->transactionsRepository->getAll(['user']);
    }

    public function getById($id)
    {
        return $this->transactionsRepository->getById($id, ['user']);
    }

    public function create($data)
    {
        if(!isset($data['amount']) || empty($data['amount'])) {
            return [
                'status' => 'FAIL',
                'message' => 'Amount cannot be empty'
            ];
        }

        $user = $this->auth->user();
        $data['user_id'] = $user->id;
        $data['status'] = 'PENDING';

        $transaction_created = $this->transactionsRepository->create($data);

        if($transaction_created) {
            $order_data = $this->getOrderData($transaction_created);
            $order_id = $this->paymentGateway->createOrder($order_data);

            $this->transactionsRepository->update($transaction_created['id'], [
                'status' => 'ORDER_CREATED',
                'order_id' => $order_id
            ]);

            return [
                'status' => 'SUCCESS',
                'order_id' => $order_id
            ];
        }
    }

    public function handle($payment_id)
    {
        $payment = $this->paymentGateway->getPayment($payment_id);

        $data_to_update = [
            'order_id' => $payment->order_id,
            'status' => $payment->status
        ];

        $transaction = $this->transactionsRepository->getByOrderId($payment->order_id);
        dd($transaction);
        $this->transactionsRepository->update($transaction['id'], $data_to_update);
    }

    public function capturePayment($transaction_id, $order_id, $payment_id)
    {
        // $transa
    }

    private function getOrderData($transaction)
    {
        return [
            'amount' => $transaction['amount'],
            'currency' => 'INR',
            'receipt' => 'TXN_' . $transaction['id'],
            'notes' => [
                'user' => $this->auth->user()->name,
                'timestamp' => time()
            ]
        ];
    }
}
