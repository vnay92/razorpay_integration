<?php

namespace App\Repositories;

use App\Models\Users as Model;

class TransactionsRepository extends AbstractRepository
{
    public function __construct(Model $model)
    {
        $this->model = $model;
    }
}
