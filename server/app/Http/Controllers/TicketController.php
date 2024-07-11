<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function storeTickets(Request $request)
    {
        $ticketData = $request->validate([
            'eventId' => ['required', 'numeric'],
            'tickets' => ['required', 'array'],
            'tickets.*.type' => ['required'],
            'tickets.*.price' => ['required'],
            'tickets.*.amount' => ['required'],
        ]);

        foreach ($ticketData['tickets'] as $inputData) {
            Ticket::create([
                'event_id' => $ticketData['eventId'],
                'type' => $inputData['type'],
                'price' => $inputData['price'],
                'amount' => $inputData['amount'] // Ensure 'amount' is provided
            ]);
        }

        return response()->json([
            'message' => 'Tickets created successfully',
        ], 201);
    }
}
