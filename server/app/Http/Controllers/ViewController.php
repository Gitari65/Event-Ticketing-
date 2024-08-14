<?php


namespace App\Http\Controllers;

use App\Models\View;
use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function updateCount(Request $request)
    {
        $view = View::firstOrCreate(
            [
                'event_id' => $request->input('event_id'),
                'user_id' => $request->input('user_id')
            ],
            ['count' => 0]
        );

        $view->increment('count');
        
        return response()->json($view, 200);
    }
};
