<?php

namespace App\Http\Controllers;

use App\Services\MpesaService;
use Illuminate\Http\Request;

class MpesaController extends Controller
{
    protected $mpesaService;

    public function __construct(MpesaService $mpesaService)
    {
        $this->mpesaService = $mpesaService;
    }

    public function initiatePayment(Request $request)
    {
        $validatedData = $request->validate([
            'phone_number' => 'required',
            'amount' => 'required|numeric',
        ]);

        $response = $this->mpesaService->lipaNaMpesa(
            $validatedData['phone_number'],
            $validatedData['amount'],
            'EventTickets',
            'Payment for Event Tickets'
        );

        return response()->json($response);
    }

    public function mpesaCallback(Request $request)
    {
        Log::info('M-Pesa Callback:', $request->all());

        // Process the callback data here

    }
}
