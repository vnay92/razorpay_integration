<?php

namespace App\Gateways;

use App\Repositories\TransactionsRepository;
use Illuminate\Contracts\Auth\Guard as Auth;

class TransactionsGateway
{
    public function __construct(
        Auth $auth,
        TransactionsRepository $transactionsRepository
    ) {
        $this->transactionsRepository = $transactionsRepository;
        $this->auth = $auth;
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
            return $this->paymentGateway->createOrder();
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
