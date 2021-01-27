<?php

namespace App\Http\Controllers\API;

use App\Device;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function index(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'uID'            => ['required'],
            'deviceID'       => ['required'],
            'language'       => ['required'],
            'operatingSystem'=> ['required']
        ]);
        $response='';
        if($validator->fails()){
            return response()->json(['success'=>false,'errors'=>$validator->errors()], 401);
        }else{
            $user=User::where('email',$request->uID)->first();
            if (!empty($user)){
                $device=Device::firstOrNew(['user_id'=>$user->id,'device_id'=>$request->deviceID]);
                $device->language=$request->language;
                $device->operating_system=$request->operatingSystem;
                $device->save();
                $client_token=$device->createToken('client-token')->plainTextToken;
                Device::where(['user_id'=>$user->id,'device_id'=>$request->deviceID])->update(['client_token'=>$client_token]);
            }
            return response()->json(['success'=>true,'response'=>'OK','data'=>$device,'client-token'=>$client_token],200);
        }
    }
}
