<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    public function registerUser(Request $request){
        try{

            $userdata=$request->validate([
                'name'=>'string|required',
                'password'=>'min:8|required',
                'email'=>'required|email|unique:users,email',
            ]);
            $user=User::create([
                'name'=>$userdata['name'],
                'email'=>$userdata['email'],
                'password'=>Hash::make($userdata['password']),
            ]);

            return response()->json([
                "message"=>"User Signup Successfully",
                "user"=>$user
            ]);
        }
        catch(Exception $e){
            return response()->json([$e->getMessage()]);

        }
    }
    public function loginUser(Request $request)
    {
        try {
            $user_login_data = $request->validate([
                'email' => 'required',
                'password' => 'required|min:8'
            ]);

            $user = User::where('email', $user_login_data['email'])->first();

            if ($user && Hash::check($user_login_data['password'], $user->password)) {
                $token = $user->createToken('user-token')->plainTextToken;
                return response()->json([
                    "message" => "Login Successful",
                    "token" => $token
                ]);

            } else {
                return response()->json([
                    "message" => "Login Unsuccessful",
                ]);
            }

        } catch (Exception $e) {
            return response()->json([$e->getMessage()]);
        }
    }


}
