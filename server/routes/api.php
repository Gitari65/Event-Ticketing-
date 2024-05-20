<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;

// Route::post('/login',[LoginController::class,'check']);

Route::post('/register',[RegisterController::class,'store']);




