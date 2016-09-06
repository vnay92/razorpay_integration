<?php

namespace App\Http\Controllers;

use App\Gateways\TransactionsGateway;
use App\Gateways\PaymentGateway;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    public function __construct(
        Request $request,
        TransactionsGateway $transactionsGateway,
        PaymentGateway $paymentGateway
    ) {
        $this->request = $request;
        $this->transactionsGateway = $transactionsGateway;
        $this->paymentGateway = $paymentGateway;
    }

    public function handle()
    {
        $input = $this->request->all();
        $response = $this->transactionsGateway->handle($input['payment_id']);
        return response()->json($response);
    }
}
