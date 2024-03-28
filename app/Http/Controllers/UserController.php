<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function register(Request $request){
        try{
            $request->validate([
                'name'=>'required',
                'email'=>'required|unique:users|email',
                'password'=>'required|confirmed'
            ]);
    
            $user = User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($request->password)
            ]);

            return response()->json([
                'status'=>200,
                'user'=> $user
            ]); 
        }catch(ValidationException $e){
            return response()->json([
                'status'=>404,
                'errors' => $e->validator->getMessageBag()->toArray()
            ]);
        }       
    }

    public function login(Request $request){
        $request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);

        $email = $request->email;
        $password = $request->password;

        $user = User::where('email',$email)->first();
        if($user){
            if(Hash::check($password,$user->password)){
                return response()->json([
                    'status'=>200,
                    'user'=>$user
                ]);
            }else{
                return response()->json([
                    'status'=>404,
                    'message'=>'Password Not Match'
                ]);
            }
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'Username and Password Not Found'
            ]);
        }
    }
}
