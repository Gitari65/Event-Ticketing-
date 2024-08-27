<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use PhpParser\Node\Stmt\TryCatch;

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
            'location'=>'required',
            'user_id'=>'required',
            'date'=>'required',
            'time'=>'required'

        ]);
       

        $newEvent=Event::create($data);
        return response()->json(['status'=>true,
        'message'=>'event created successfully',
        'eventId'=>$newEvent->id
    ],201);

    }
    public function  getEvents(){
        $events=Event::all();
        return response()->json(['events'=>$events],200);
    }
    public function showEventById($eventId){
  try {
   
    $event=Event::with('tickets')->findOrFail($eventId);
   return response()->json($event);
    } catch (\Exception $e) {
    //throw $th;
    return response()->json(['message' => 'Event not found'], 404);
  }
    }
    public function index()
                {
                    $recentEvents = Event::orderBy('created_at', 'desc')->take(10)->get();
                    $trendingEvents = Event::withCount('views')
                                            ->orderBy('views_count', 'desc')
                                            ->take(10)
                                            ->get();

                    return response()->json([
                        'recent' => $recentEvents,
                        'trending' => $trendingEvents,
                    ]);
                }

}
