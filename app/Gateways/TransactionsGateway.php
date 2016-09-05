<?php

namespace App\Gateways;

use App\Repositories\TransactionsRepository;

class TransactionsGateway
{
    public function __construct(
        TransactionsRepository $transactionsRepository
    ) {
        $this->transactionsRepository = $transactionsRepository;
    }

    public function getAll()
    {
        return $this->transactionsRepository->getAll();
    }

    public function getById($id)
    {
        return $this->transactionsRepository->getById($id);
    }
}
