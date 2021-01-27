<?php

namespace App\Http\Controllers\API;

use App\Device;
use App\Http\Controllers\Controller;
use App\Subscription;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'receipt'       => ['required'],
            'client_token'  => ['required'],
            'expire_date'   => ['required'],
        ]);
        $response='';
        $status=200;
        if($validator->fails()){
            $response=['success'=>false,'errors'=>$validator->errors()];
            $status=401;
        }else{
            $device=Device::where('client_token',$request->client_token)->first();
            $last_character=substr($request->receipt,-1);
            if ($last_character%2==0){
                $response=['success'=>false,'errors'=>'Verification Failed'];
                $status=401;
            }else{
                $expire_date=date('Y-m-d H:i:s',strtotime($request->expire_date));
                $subscription=new Subscription();
                $subscription->app_id=$device->id;
                $subscription->user_id=$device->user_id;
                $subscription->client_token=$request->client_token;
                $subscription->receipt=$request->receipt;
                $subscription->subscription_date=date('Y-m-d H:i:s');
                $subscription->expiry_date=$expire_date;
                $subscription->subscription_status='Started';
                if($subscription->save()){
                    $response=['success'=>true,'message'=>'Verified and Subscription has purchased!'];
                    $status=200;
                }
            }
        }
        return Response()->json($response,$status);
    }

    public function check_subscription(Request $request){
        $validator=Validator::make($request->all(),[
            'client_token'  => ['required'],
        ]);
        $response='';
        $status=200;
        if($validator->fails()){
            $response=['success'=>false,'errors'=>$validator->errors()];
            $status=401;
        }else{
            $device=Device::where('client_token',$request->client_token)->first();
            if(!empty($device)){
                $subscription=Subscription::where('app_id',$device->id)->first();
                if (!empty($subscription)){
                    $response=['success'=>true,'response'=>$subscription->subscription_status];
                    $status=200;
                }
            }
        }
        return Response()->json($response,$status);
    }
}
