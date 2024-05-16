<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    //
    public function register(Request $request){
        $inputUSer=$request->validate([
            'name'=>['required','min:3','max:10'],
            'email'=>['required','email',Rule::unique('users','email')],
            'password'=>['required','min:8','max:200']
        ]);
        $input['password']=Hash::make( $inputUSer['password']);

       
        $user=  User::create($inputUSer);
        auth()->login($user);
        
        return response()->json(['status'=>true,
        'message'=>"Registration success"]);
    }
    
    public function logout(){
        auth()->logout();
        return redirect('/login');

    }
}
