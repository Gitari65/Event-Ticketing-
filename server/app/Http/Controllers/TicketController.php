<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    //
    public function storeTickets(Request $request){
        $ticketData=$request->validate([
            'type'=>['required'],
            'price'=>['required']
        ]);
        $ticket = Ticket::create($ticketData);

        return response()->json([
            'message' => 'Ticket created successfully',
            'ticket' => $ticket
        ], 201);
    }
}
