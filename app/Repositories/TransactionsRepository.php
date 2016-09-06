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

    public function update($id, $data)
    {
        $row = $this->model->where('id', '=', $id)->first();
        if(!$row) {
            throw new \Exception('Transaction Not Found!');
        }

        return $row->update($data);
    }

    public function getByOrderId($id)
    {
        $row = $this->model->where('order_id', '=', $id)->first();
        if(!$row) {
            throw new \Exception('Transaction Not Found!');
        }

        return $row->toArray();
    }
}
