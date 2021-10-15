<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class UserController extends Controller
{
    public function signup(Request $req){
  
        $validator=Validator::make($req->all(),[
            'name'=>'required | max : 26',
            'email'=>'required | email',
            'password'=>'required'

        ]);
        if($validator->fails()){
            return response()->json([
                'message'=>$validator->messages()
            ]);
        }
        else{
            $count=User::where('email','=',$req->email)->count();
            if($count > 0){
                return response()->json([
                    'message'=>'User already exists!!!'
                ],403);
            }
            else{
                $data=New User;
                $data->name=$req->name;
                $data->email=$req->email;
                $data->password=Hash::make($req->password);
                $data->save();
                return response()->json([
                    'message'=>'success'
                ],200);
                
            }
           
        }


    }

    public function login(Request $req){
        $validator=Validator::make($req->all(),[
            'email' => 'required | email',
            'password' =>'required'
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=>$validator->messages()
            ]);

        }
        else{  
        $email=$req->email;
        $password=$req->password;
        $usercount=User::where('email','=',$email);
        if($usercount->count() > 0){
            $userdata=$usercount->first();
            if(Hash::check($password, $userdata->password)){
                return response()->json([
                    'message'=>'success',
                    'user'=>$userdata
                ],200);
            }
            else{
                return response()->json([
                    'message'=>'Incorrect Password'
                ],401); 
            }
        }
        else{
            return response()->json([
                'message'=>'User not exists!!!'
            ],404);
        }
        }


    }
}
