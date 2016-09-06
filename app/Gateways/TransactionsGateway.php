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

        try {
            $transaction = $this->transactionsRepository->getByOrderId($payment->order_id);
            $this->verifyTransaction($transaction);
        } catch (\Exception $e) {
            return [
                'status' => 500,
                'message' => $e->getMessage()
            ];
        }

        $data_to_update = [
            'order_id' => $payment->order_id,
            'payment_id' => $payment_id,
            'status' => $payment->status
        ];

        $this->transactionsRepository->update($transaction['id'], $data_to_update);

        $captured = $this->capturePayment($payment_id, $transaction['amount']);
        if(isset($captured['status'])) {
            return $captured;
        }

        $this->transactionsRepository->update($transaction['id'], [
            'status' => 'COMPLETED'
        ]);

        return [
            'status' => 200,
            'message' => 'Transaction Complete'
        ];
    }

    public function capturePayment($payment_id, $amount)
    {
        try {
            return $this->paymentGateway->capturePayment($payment_id, $amount);
        } catch (\Exception $e) {
            return [
                'status' => 500,
                'message' => $e->getMessage()
            ];
        }
    }

    private function verifyTransaction($transaction)
    {
        if($transaction['status'] != 'ORDER_CREATED') {
            throw new \Exception('Transaction is invalid');
        }
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
