<?php

namespace App\Http\Controllers;

use App\Gateways\TransactionsGateway;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    public function __construct(
        Request $request,
        TransactionsGateway $transactionsGateway
    ) {
        $this->request = $request;
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

    public function create()
    {
        $input = $this->request->json()->all();
        $response = $this->transactionsGateway->create($input);
        return response()->json($response);
    }

    public function update($id)
    {
        $response = $this->transactionsGateway->update($id);
        return response()->json($response);
    }
}
