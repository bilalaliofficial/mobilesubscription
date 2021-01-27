<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(Request $request){
        if (Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
            $user=Auth::user();
            $access_token=$user->createToken('authtoken')->plainTextToken;
            return response()->json(['success'=>true,'user'=>$user,'access_token'=>$access_token],401);
        } else{
            return response()->json(['success'=>false,'error'=>'Unauthorised'], 200);
        }
    }
}
