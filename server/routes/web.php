<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TicketController;
use Illuminate\Http\Request;




// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/events', function () {
//     return view('events');
// });
// Route::get('/login', function () {
//     return view('login');
// });
// Route::get('/register', function () {
//     return view('register');
// });
// Route::get('/createEvent', function () {
//     return view('newevent');
// });
// Route::get('/sanctum/csrf-cookie', function (Request $request) {
//     return response()->json(['csrfToken' => csrf_token()]);
// });

Route::group(['middleware' => 'cors'], function () {
    // Your routes here
    
});


Route::post('/events',[EventController::class,'getEvents']);
Route::post('/event/create',[EventController::class,'store']);

Route::get('/event/{id}',[EventController::class,'showEventById']);

Route::post('/ticket/create', [TicketController::class, 'storeTickets']);


Route::post('/register',[RegisterController::class,'register']);

Route::post('/logout',[LoginController::class,'logout']);
Route::post('/login',[LoginController::class,'login']);
