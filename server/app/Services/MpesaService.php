<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class MpesaService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function generateAccessToken()
    {
        $url = config('mpesa.base_url') . '/oauth/v1/generate?grant_type=client_credentials';
        $credentials = base64_encode(config('mpesa.consumer_key') . ':' . config('mpesa.consumer_secret'));

        $response = $this->client->request('GET', $url, [
            'headers' => [
                'Authorization' => 'Basic ' . $credentials,
                'Content-Type' => 'application/json',
            ],
        ]);

        return json_decode($response->getBody())->access_token;
    }

    public function lipaNaMpesa($phoneNumber, $amount, $accountReference, $transactionDesc)
    {
        $url = config('mpesa.base_url') . '/mpesa/stkpush/v1/processrequest';
        $accessToken = $this->generateAccessToken();
        $timestamp = date('YmdHis');
        $password = base64_encode(config('mpesa.shortcode') . config('mpesa.passkey') . $timestamp);

        $response = $this->client->request('POST', $url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'BusinessShortCode' => config('mpesa.shortcode'),
                'Password' => $password,
                'Timestamp' => $timestamp,
                'TransactionType' => 'CustomerPayBillOnline',
                'Amount' => $amount,
                'PartyA' => $phoneNumber,
                'PartyB' => config('mpesa.shortcode'),
                'PhoneNumber' => $phoneNumber,
                'CallBackURL' => route('mpesa.callback'),
                'AccountReference' => $accountReference,
                'TransactionDesc' => $transactionDesc,
            ],
        ]);

        return json_decode($response->getBody());
    }
}
