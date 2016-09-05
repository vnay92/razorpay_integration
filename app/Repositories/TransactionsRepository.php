<?php

namespace App\Repositories;

use App\Models\Transactions as Model;

class TransactionsRepository extends AbstractRepository
{
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function create($data)
    {
        return $this->model->create($data);
    }
}
