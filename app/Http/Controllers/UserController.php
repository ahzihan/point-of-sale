<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Mail\OTPMail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function UserRegistration(Request $request){

        try{
            User::create([
                "firstName"=>$request->input('firstName'),
                "lastName"=>$request->input('lastName'),
                "email"=>$request->input('email'),
                "mobile"=>$request->input('mobile'),
                "password"=>$request->input('password'),
            ]);

        return response()->json([
            "message"=>"User Register Successfully!",
            "status"=>"success"
        ],200);
        }catch(Exception $e){
            return response()->json([
            "message"=>$e->getMessage(),
            "status"=>"failed"
        ],200);
        }

    }

    public function UserLogin(Request $request){
        $user=User::where('email','=',$request->input('email'))
                    ->where('password','=',$request->input('password'))
                    ->count();

        if($user==1){

            $token=JWTToken::CreateToken($request->input('email'));
            return response()->json([
                "token"=>$token,
                "message"=>"User Login Successfully!",
                "status"=>"success"
            ],200);

        }else{

            return response()->json([
            "message"=>"Unauthorized",
            "status"=>"failed"
            ],200);
        }
    }

    function SendOTPCode(Request $request){
        $email=$request->input('email');
        $otp=rand(1000,9999);
        $user=User::where('email','=',$email)->count();

        if($user==1){
            Mail::to($email)->send(new OTPMail($otp));
            User::where('email','=',$email)->update(['otp'=>$otp]);
            return response()->json([
                "message"=>"4 - Digit OTP Code Has Been Send Your Email.",
                "status"=>"success"
            ],200);
        }else{
            return response()->json([
            "message"=>"Unauthorized",
            "status"=>"failed"
            ],200);
        }

    }

    function VerifyOTP(Request $request){

        $email=$request->input('email');
        $otp=$request->input('otp');
        $count = User::where('email', '=', $email)
        ->where('otp', '=', $otp)->count();

        if($count==1){
            User::where('email', '=', $email)->update(['otp'=>'0']);

            $token=JWTToken::CreateTokenForResetPassword($request->input('email'));
            return response()->json([
                'status'=>'success',
                'message'=>'OTP Verify Successfully!',
                'token'=>$token
            ],200);

        }else{
            return response()->json([
            "message"=>"Unauthorized",
            "status"=>"failed"
            ],200);
        }

    }
}
