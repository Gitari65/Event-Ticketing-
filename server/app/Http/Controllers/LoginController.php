<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    //
    public function login(Request $request ){
        $input =$request->validate([
            'email'=>['email','required'],
            'password'=>'required'
        ]);
        if(auth()->attempt(['email'=>$input['email'],'password'=>$input['password']])){
            $request->session()->regenerate();
            return redirect('/');
        }
        return redirect('/login');

    }
}
