<?php

namespace App\Http\Controllers;

use App\Gateways\TransactionsGateway;

class TransactionsController extends Controller
{
    public function __construct(
        TransactionsGateway $transactionsGateway
    ) {
        $this->transactionsGateway = $transactionsGateway;
    }

    public function getAll()
    {
        $response = $this->transactionsGateway->getAll();
        return response()->json($response);
    }

    public function getById($id)
    {
        $response = $this->transactionsGateway->getById($id);
        return response()->json($response);
    }
}
