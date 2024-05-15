<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    //
   

    public function store(Request $request){
        
        // $csrfToken=csrf_token();
        // $requestToken=$request->header('X-CSRF-TOKEN');

        // if ($csrfToken !== $requestToken) {
        //     // CSRF token mismatch, handle error
        //     return response()->json(['error' => 'CSRF token mismatch'], 403);
        // }
        $data=$request->validate([
            'name'=>'required',
            'venue'=>'required',
            'location'=>'required'

        ]);
        $data['user_id']=auth()->id();

        $newEvent=Event::create($data);
        return response()->json(['status'=>true,
        'message'=>'event created successfully'
    ]);

    }
    public function  getEvents(){
        $events=Event::all();
        return view('events',['events'=>$events]);
    }
}
