<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Credit;
use App\Models\Withdraw;
use App\Models\Deposit;

use DB;

use Illuminate\Support\Facades\Hash;
use Validator;
use Carbon\Carbon;

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
        $unique_id = "P".rand(100000,999999);
        $user = new User([
            'name'  => $request->name,
            'email' => $request->email,
            'unique_id'=>$unique_id,
            'password' => bcrypt($request->password),
        ]);

        if($user->save()){
            $tokenResult = $user->createToken('LaravelSanctumAuth');
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

  
public function deposit(Request $request)
{
   
    $user_id = Auth::id();
        
   //return response()->json(['error'=>$request->all()]);

    $v = Validator::make($request->all(),[
            'amount' => 'required|integer|min:1',           
            'transaction_no'=>'required|string',
            'transaction_details'=>'required|string',
            'transaction_document'=>'required|mimes:jpg,png,jpeg',

        ]);

     if ($v->fails())
     {
        return response()->json(['error'=>'Provide proper details']);
     }
     else 
     {
        $current_date_time = Carbon::now()->toDateTimeString();

        $time =$user_id.'_'.time();
         $input['transaction_document'] = $time.'.'.$request->transaction_document->extension();
        $request->transaction_document->move(public_path('images/transaction_document'), $input['transaction_document']);

        $deposit = new Deposit([
            'user_id'=>$user_id,
            'deposit_time'=>$current_date_time,
            'amount'  => $request->amount,
            'transaction_no' => $request->transaction_no,
            'transaction_document'=>'images/transaction_document/'.$input['transaction_document'],
            'transaction_details' => $request->transaction_details,
            'createdBy'=>$user_id
            
        ]);

        if($deposit->save()){
           

            return response()->json([
            'message' => 'Successfully deposit!',            
            ],201);
        }
        else{
            return response()->json(['error'=>'Provide proper details']);
        }
     }

    
  }

  
  public function withdraw(Request $request)
{
   
    $user_id = Auth::id();
        
   //return response()->json(['error'=>$request->all()]);

    $v = Validator::make($request->all(),[
            'amount' => 'required|integer|min:1',           
                        
        ]);

     if ($v->fails())
     {
        return response()->json(['error'=>'Provide proper details']);
     }
     else 
     {
        $amount = $request->amount;
        $user_2 =  User:: where('id',$user_id)->first();
        $credits = $user_2->credits;
        $final_credits =  $credits - $amount;

        $bank_account_name = $user_2->bank_account_name;
        $bank_country = $user_2->bank_country;
        $bank_name = $user_2->bank_name;
        $bank_account_number = $user_2->bank_account_number;
        $bank_account_type = $user_2->bank_account_type;

        if($final_credits >= 0)
            {
                 $current_date_time = Carbon::now()->toDateTimeString();

                $withdraw = new Withdraw([
                    'user_id'=>$user_id,
                    'withdraw_time'=>$current_date_time,
                    'amount'  => $request->amount, 
                    'status' => 'Pending',
                    'before_withdraw_amount' => $credits,
                    'current_balance' => $final_credits, 
                    
                    'bank_account_name' => $bank_account_name,  
                    'bank_country' => $bank_country,  
                    'bank_name' => $bank_name,  
                    'bank_account_number' => $bank_account_number,  
                    'bank_account_type' => $bank_account_type,  

                    'createdBy'=>$user_id
                    
                ]);

                if($withdraw->save()){

                    $withdraw_id = $withdraw->id;

                      $user_2->credits = $final_credits;
                        $user_2->save(); 

                         $credit = new Credit([
                            'user_id'  => $user_id,
                            'before_deposit_withdraw_amount' => $credits,
                            'amount' => $request->amount,
                            'current_balance' => $final_credits,
                            'type'=>'Withdraw',
                            'reference_by'=>'Self',
                            'deposit_withdraw_id' => $withdraw_id,               
                            'createdBy'=>$user_id
                        ]);
                        $credit->save();
                   

                    return response()->json([
                    'message' => 'Successfully withdraw submit!',            
                    ],201);
                }
                else{
                    return response()->json(['error'=>'Provide proper details']);
                }
            }
            else 
            {
                return response()->json(['error'=>'You have not enough money, can maximum '.$credits]);
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
  $tokenResult = $user->createToken('LaravelSanctumAuth');
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
