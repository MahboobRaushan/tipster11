<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

use DB;

use Illuminate\Support\Facades\Hash;
use Validator;

class AuthController extends Controller
{
/**
* Create user
*
* @param  [string] name
* @param  [string] email
* @param  [string] password
* @param  [string] password_confirmation
* @return [string] message
*/
public function register(Request $request)
{
   
    $v = Validator::make($request->all(),[
            'name' => 'required|string',
            'email'=>'required|string|unique:users',
            'password'=>'required|string',
            'password_confirmation' => 'required|same:password'
        ]);

     if ($v->fails())
     {
        return response()->json(['error'=>'Provide proper details']);
     }
     else 
     {
        $user = new User([
            'name'  => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        if($user->save()){
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->plainTextToken;

            return response()->json([
            'message' => 'Successfully created user!',
            'accessToken'=> $token,
            ],201);
        }
        else{
            return response()->json(['error'=>'Provide proper details']);
        }
     }

    
  }

  public function login(Request $request)
{
  $request->validate([
  'email' => 'required|string|email',
  'password' => 'required|string',
  'remember_me' => 'boolean'
  ]);

  $credentials = request(['email','password']);
  if(!Auth::attempt($credentials))
  {
  return response()->json([
      'message' => 'Unauthorized'
  ],401);
  }

  $user = $request->user();
  $tokenResult = $user->createToken('Personal Access Token');
  $token = $tokenResult->plainTextToken;

  return response()->json([
  'accessToken' =>$token,
  'token_type' => 'Bearer',
  ]);
}
public function user(Request $request)
{
    return response()->json($request->user());
}

public function testing(Request $request)
{
    $data = DB::table('testing')->get();
    return response()->json($data);
}
public function logout(Request $request)
{
    $request->user()->tokens()->delete();

    return response()->json([
    'message' => 'Successfully logged out'
    ]);

}

}