<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Credit;
use App\Models\Withdraw;
use App\Models\Deposit;
use App\Models\Pool;
use App\Models\Bet;
use App\Models\Betdetails;
use App\Models\Megajackpot;
use App\Models\Megajackpotdetails;

use App\Models\Bettransaction;

use File;

use DB;

use Mail;

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
            'user_id' => 'required|string|unique:users',
            'email'=>'required|string|unique:users',
            'password'=>'required|string',
            'password_confirmation' => 'required|same:password',
            //'referal_id' => 'string'
        ]);

     if($request->referal_id!='')
        {
             $referal_id_exit=  DB::table('users')->where('status',1)->where('user_type','agent')->where('unique_id',$request->referal_id)->count();
             if($referal_id_exit == 0)
             {
                return response()->json(['error'=>'Referal ID not exist in our system','registerStatus'=>false],201);
             }
        }


     if ($v->fails())
     {
        if($request->user_id!='')
        {
             $user_id_exit=  DB::table('users')->where('user_id',$request->user_id)->count();
             if($user_id_exit > 0)
             {
                return response()->json(['error'=>'User ID exist, Please provide other User ID','registerStatus'=>false],201);
             }
        }
      if($request->email!='')
        {
             $email_exit=  DB::table('users')->where('email',$request->email)->count();
             if($email_exit > 0)
             {
                return response()->json(['error'=>'Email exist, Please provide other Email','registerStatus'=>false],201);
             }
        }

         if($request->password!=$request->password_confirmation)
        {
             
           return response()->json(['error'=>'Password and Confirm Password are not same','registerStatus'=>false],201);
           
        }
        //else 
       // {
        //     return response()->json(['error'=>'Provide proper details','registerStatus'=>false],201);
      //  }

        //return response()->json(['error'=>'Please Provide proper details'.$v->messages(),'registerStatus'=>false],201);

       
       
     }
     else 
     {

        $agent_id=0;
        if($request->referal_id!='')
        {
             $referal_id_exit=  DB::table('users')->where('status',1)->where('user_type','agent')->where('unique_id',$request->referal_id)->count();
             if($referal_id_exit > 0)
             {
                $agent_id= DB::table('users')->where('status',1)->where('user_type','agent')->where('unique_id',$request->referal_id)->first()->id;
             }
        }


        $unique_id = "P".rand(100000,999999);
        $user = new User([
            'name'=>'',
            'user_id'  => $request->user_id,
            'email' => $request->email,
            'unique_id'=>$unique_id,
            'password' => bcrypt($request->password),
            'referal_id' => $request->referal_id,
            'agent_id' => $agent_id,
        ]);

        if($user->save()){
            $tokenResult = $user->createToken('LaravelSanctumAuth');
            $token = $tokenResult->plainTextToken;

            return response()->json([
            'message' => 'Successfully created user!',
            'accessToken'=> $token,
            'registerStatus'=>true,
            ],201);
        }
        else{
            return response()->json(['error'=>'Provide proper details','registerStatus'=>false],201);
        }
     }

    
  }


public function reset(Request $request)
{
   
    $v = Validator::make($request->all(),[
            'email' => 'required|string',
            'two_factor_recovery_codes' => 'required|string',
            'password'=>'required|string',
            'password_confirmation' => 'required|same:password'
        ]);

     if ($v->fails())
     {
        return response()->json(['error'=>'Provide proper details','resetStatus'=>false],201);
     }
     else 
     {
        $user =  User:: where('two_factor_recovery_codes',$request->two_factor_recovery_codes)->where('email',$request->email)->first();
          if($user)
          {
            $user->two_factor_recovery_codes = null;
            $user->password = bcrypt($request->password);
            $user->save(); 
            return response()->json(['error'=>'Successfully Updated','resetStatus'=>true],201);
          }
          else 
          {
            return response()->json(['error'=>'Reset Code / Email were wrong','resetStatus'=>false],201);
          }
     }

    
  }

    
public function deposit(Request $request)
{
   
    $user_id = Auth::id();

        
   //return response()->json(['error'=> $image = str_replace('data:image/jpeg;base64,', '', $request->transaction_document) ]);

    $v = Validator::make($request->all(),[
            'amount' => 'required|numeric|min:0.1|between:0,9999999999.99',         
            'transaction_no'=>'required|string',
            'date'=>'required',
            'time'=>'required',
            'transaction_document'=>'required',

        ]);

    

     if ($v->fails())
     {
        return response()->json(['error'=>'Provide proper details','depositStatus'=>false,'deposit'=>null]);
     }
     else 
     {
        //$current_date_time = Carbon::now()->toDateTimeString();
        $current_date_time = $request->date.' '.$request->time.':00';

         $image = str_replace('data:image/jpeg;base64,', '', $request->transaction_document); 
         $image = str_replace(' ', '+', $image);
         $fileName = rand(1000,9999).'.jpeg';

        $time =$user_id.'_'.time();
         $input['transaction_document'] = $time.'_'.$fileName;
        //$request->transaction_document->move(public_path('images/transaction_document'), $input['transaction_document']);

        \File::put( public_path('images/transaction_document/') . $input['transaction_document'], base64_decode($image));

        $deposit = new Deposit([
            'user_id'=>$user_id,
            'deposit_time'=>$current_date_time,
            'amount'  => $request->amount,
            'transaction_no' => $request->transaction_no,
            'transaction_document'=>'images/transaction_document/'.$input['transaction_document'],
            'transaction_details' => '',
            'createdBy'=>$user_id
            
        ]);

        if($deposit->save()){
           
           $last_inser_id = $deposit->id;

           $deposit_details =  Deposit:: where('id',$last_inser_id)->where('user_id',$user_id)->first();

            return response()->json([
            'error' => 'Successfully deposit!',  
            'depositStatus'=>true, 
            'deposit'=>$deposit_details,         
            ],201);
        }
        else{
            return response()->json(['error'=>'Provide proper details','depositStatus'=>false,'deposit'=>null]);
        }
     }

    
  }

  
  public function withdraw(Request $request)
{
   
    $user_id = Auth::id();
        
   //return response()->json(['error'=>$request->all()]);

    $v = Validator::make($request->all(),[
            'amount' => 'required|numeric|min:0.1|between:0,9999999999.99', 
            'bank_account_name'=>'required|string',          
                        
        ]);

     if ($v->fails())
     {
        return response()->json(['error'=>'Provide proper details...','withdrawStatus'=>false,'withdraw'=>null]);
     }
     else 
     {
        $amount = $request->amount;
        $bank_account_name = $request->bank_account_name;

        $user_2 =  User:: where('id',$user_id)->first();
        $credits = $user_2->credits;
        $final_credits =  $credits - $amount;

       // $bank_account_name = $user_2->bank_account_name;
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

                   $withdraw_details =  Withdraw:: where('id',$withdraw_id)->where('user_id',$user_id)->first();


                    return response()->json([
                    'error' => 'Successfully withdraw submit!', 
                    'withdrawStatus'=>true, 
                    'withdraw'=>$withdraw_details,             
                    ],201);
                }
                else{
                    return response()->json(['error'=>'Provide proper details','withdrawStatus'=>false,'withdraw'=>null]);
                }
            }
            else 
            {
                return response()->json(['error'=>'You have not enough money, can maximum '.$credits,'withdrawStatus'=>false,'withdraw'=>null]);
            }

       
     }

    
  }
 public function placebet(Request $request)
{

   

    $user_id = Auth::id();

    $user_2 =  User:: where('id',$user_id)->first();
    $credits = $user_2->credits;

    $pool_id = $request->id;

    $pool =  Pool:: where('id',$pool_id)->first();
    $pool_perBetAmount = $pool->perBetAmount;

   
  


    if($pool_perBetAmount <= $credits)
    {
        //credit minus from user credit

        $final_credits =  $credits - $pool_perBetAmount;
        $user_2->credits = $final_credits;
        $user_2->save(); 

         $bet = new Bet([
        'user_id'  => $user_id,
        'pool_id' => $pool_id,
        'bet_amount' => $pool_perBetAmount,
        'total_match' => $request->total_match
    ]);

         $tempvar = "";
         $betresult=[];

  
   
     if($bet->save())
     { 

         $pool_poolPercentage = $pool->poolPercentage;
         $pool_megaPercentage = $pool->megaPercentage;
         $pool_comPercentage = $pool->comPercentage;
         $pool_agentPercentage = $pool->agentPercentage;

        $pool_group1Percentage = $pool->group1Percentage;
        $pool_group2Percentage = $pool->group2Percentage;
        $pool_group3Percentage = $pool->group3Percentage;

         $pool_megaPrize = $pool->megaPrize;

        $pool_group1TotalPrize = $pool->group1TotalPrize;
        $pool_group2TotalPrize = $pool->group2TotalPrize;
        $pool_group3TotalPrize = $pool->group3TotalPrize;

        $pool_poolAmount = ($pool_perBetAmount * $pool_poolPercentage)/100;

        

         
          $pool_megaAmount = ($pool_perBetAmount * $pool_megaPercentage)/100;
           $pool_comAmount = ($pool_perBetAmount * $pool_comPercentage)/100;
           $pool_agentAmount = ($pool_perBetAmount * $pool_agentPercentage)/100;

           $pool_megaPrize = $pool_megaPrize + $pool_megaAmount;

        $group1PrizeAmount = ($pool_poolAmount * $pool_group1Percentage)/100;
        $group2PrizeAmount = ($pool_poolAmount * $pool_group2Percentage)/100;
        $group3PrizeAmount = ($pool_poolAmount * $pool_group3Percentage)/100;

        $pool_group1TotalPrize = $pool_group1TotalPrize + $group1PrizeAmount;
        $pool_group2TotalPrize = $pool_group2TotalPrize + $group2PrizeAmount;
        $pool_group3TotalPrize = $pool_group3TotalPrize + $group3PrizeAmount;

        $pool->group1TotalPrize = $pool_group1TotalPrize;
        $pool->group2TotalPrize = $pool_group2TotalPrize;
        $pool->group3TotalPrize = $pool_group3TotalPrize;

         $pool->megaPrize = $pool_megaPrize;

      

         $pool->save(); 

         
         $megajackpot =  DB::table('mega_jackpot')->where('status','Active')->first();
        $megajackpot_accumulatedPrize = $megajackpot->accumulatedPrize;
        $megajackpot_accumulatedPrize = $megajackpot_accumulatedPrize + $pool_megaAmount;
        
        DB::table('mega_jackpot')->where('status','Active')->update(['accumulatedPrize' => $megajackpot_accumulatedPrize]); 

        

       
        $megajackpotdetails =  DB::table('mega_jackpot_details')->where('pool_id',$pool_id)->first();

        if(!empty($megajackpotdetails))
        {
        
            $megajackpotdetails_accumulatedPrize = $megajackpotdetails->accumulatedPrize;
            
            $megajackpotdetails_accumulatedPrize = $megajackpotdetails_accumulatedPrize + $pool_megaAmount;
            

            DB::table('mega_jackpot_details')->where('pool_id',$pool_id)->update(['accumulatedPrize' => $megajackpotdetails_accumulatedPrize]); 
        }
        
       

     //$tempvar=$tempvar.'<br>Save';        
         $bet_id = $bet->id;

         $bettransaction = new Bettransaction([
                'user_id'  => $user_id,
                'pool_id' => $pool_id,
                'bet_id' => $bet_id,
                'perBetAmount' => $pool_perBetAmount,
                'megaAmount' => $pool_megaAmount,
                'poolAmount' => $pool_poolAmount,
                'comAmount' => $pool_comAmount,
                'agentAmount' => $pool_agentAmount,
            ]);

         $bettransaction->save();

         

          
         if($request->match_details)
         {

             

            $match_details_string = $request->match_details;

            //$tempvar=$tempvar.'<br>match_details_string='.$match_details_string; 

            $match_details_array = explode('@@',$match_details_string);

            if(count($match_details_array) > 1)
            {
                for($ii=0; $ii< (count($match_details_array) - 1);$ii++)
                {
                    $temp_ii = $match_details_array[$ii];

                    $dump_array = explode('::',$temp_ii);

                    $match_id = $dump_array[0];
                    $player_result = $dump_array[1];


                   
                    

                    

                    DB::table('bet_details')
                        ->insert([
                        'user_id'  => $user_id,
                        'pool_id' => $pool_id,
                        'match_id' => $match_id,
                        'bet_id' => $bet_id,                       
                        'player_result' => $player_result
                        ]);

                     



                }
            }

            
             if(count($match_details_array) > 1)
            {
                for($ii=0; $ii< (count($match_details_array) - 1);$ii++)
                {
                    $temp_ii = $match_details_array[$ii];

                    $dump_array = explode('::',$temp_ii);

                    $match_id = $dump_array[0];
                 


                    $home=  DB::table('bet_details')
                            ->where('bet_details.player_result','home')
                            ->where('bet_details.match_id',$match_id)
                            ->count();
                    $draw=  DB::table('bet_details')
                            ->where('bet_details.player_result','draw')
                            ->where('bet_details.match_id',$match_id)
                            ->count();
                    $away=  DB::table('bet_details')
                            ->where('bet_details.player_result','away')
                            ->where('bet_details.match_id',$match_id)
                            ->count();

                    $homeP=0;
                    $drawP=0;
                    $awayP=0; 

                    $total = $home + $draw + $away;
                    if($total > 0)
                    {
                       $homeP = (($home/$total) * 100);
                       $homeP = intval($homeP);
                       $awayP = (($away/$total) * 100);
                       $awayP = intval($awayP);
                       $drawP = (100 -($homeP + $awayP));
                       

                    }
                                
                           

                    

                        DB::table('match')->where('id',$match_id)->update(['home_percentage'  => $homeP, 'draw_percentage'  => $drawP, 'away_percentage'  => $awayP]); 



                }
            }

            
                
            
           
             
         }
         $tempvar=$tempvar.'<br>bet_id='.$bet_id; 
          $result_1 =  DB::table('bets') 
                 ->leftJoin('pools', 'bets.pool_id', '=', 'pools.id')
                 ->where('bets.id',$bet_id)->where('bets.user_id',$user_id)->whereIn('pools.status',['Active','Calculating','Finished'])->select('pools.name as pool_name','pools.status as pool_status','bets.id','bets.user_id','bets.pool_id','bets.bet_amount','bets.total_match','bets.total_win','bets.created_at','bets.losswinType','bets.losswinValue')->orderBy('id','desc')->get();

                if(!empty($result_1))
                 {
                    foreach ($result_1 as $key_1 => $value_1) 
                    {
                        $bet_details=[];

                         $bet_details_query    = DB::table('bet_details')
                   
                            ->select('bet_details.id','bet_details.user_id','bet_details.pool_id','bet_details.match_id','bet_details.bet_id','bet_details.match_result','bet_details.player_result','bet_details.result')
                            ->where('bet_details.bet_id',$value_1->id)
                            ->get();

                             if(!empty($bet_details_query))
                             {
                                foreach ($bet_details_query as $key_2 => $value_2) 
                                {
                                    $bet_details[]=array('id'=>$value_2->id,'user_id'=>$value_2->user_id,'pool_id'=>$value_2->pool_id,'match_id'=>$value_2->match_id,'bet_id'=>$value_2->bet_id,'match_result'=>$value_2->match_result,'player_result'=>$value_2->player_result,'result'=>$value_2->result);
                                   
                                }
                            }

                             $megajackpot =  DB::table('mega_jackpot')->where('status','Active')->first();
                            $megajackpot_accumulatedPrize = $megajackpot->accumulatedPrize;
                            $megajackpot_basePrize = $megajackpot->basePrize;
                            $megajackpot_Prize = $megajackpot_accumulatedPrize+$megajackpot_basePrize;

                            $megajackpot_Prize = floor($megajackpot_Prize);

                            $betresult[]=array('megajackpot_Prize'=>$megajackpot_Prize,'id'=>$value_1->id,'created_at'=>$value_1->created_at,'user_id'=>$value_1->user_id,'pool_id'=>$value_1->pool_id,'pool_name'=>$value_1->pool_name,'pool_status'=>$value_1->pool_status,'bet_amount'=>$value_1->bet_amount,'total_match'=>$value_1->total_match,'total_win'=>$value_1->total_win,'losswinType'=>$value_1->losswinType,'losswinValue'=>$value_1->losswinValue,'bet_details'=>$bet_details);

                    }

                }
        
        
         }
     

        return response()->json(['error'=>'user_id='.$user_id." user credits=".$credits." pool_id=".$pool_id." pool_perBetAmount=".$pool_perBetAmount." tempvar=".$tempvar ,'placebetStatus'=>true,'bet'=>$betresult]);
    }
    else 
    {
         return response()->json(['error'=>'You have not sufficient credits to placed this Bet' ,'placebetStatus'=>false,'bet'=>null]);
    }

    

}
 public function getbet(Request $request)
    {
       
           $user_id = Auth::id();
            if($user_id > 0)
            {


                 $bet = [];
                 $result_1 =  DB::table('bets') 
                 ->leftJoin('pools', 'bets.pool_id', '=', 'pools.id')
                 ->where('bets.user_id',$user_id)->whereIn('pools.status',['Active','Calculating','Finished'])->select('pools.name as pool_name','pools.status as pool_status','bets.id','bets.user_id','bets.pool_id','bets.bet_amount','bets.total_match','bets.total_win','bets.created_at','bets.losswinType','bets.losswinValue')->orderBy('id','desc')->get();
                 if(!empty($result_1))
                 {
                    foreach ($result_1 as $key_1 => $value_1) {
                        $bet_details=[];
                     $bet_details_query    = DB::table('bet_details')
                     ->leftJoin('match', 'bet_details.match_id', '=', 'match.id')
                     ->leftJoin('tims as t1', 'match.homeTeam', '=', 't1.id')
                     ->leftJoin('leagues as l', 't1.league_id', '=', 'l.id')
                     ->leftJoin('tims as t2', 'match.awayTeam', '=', 't2.id')
                    ->select('bet_details.id','bet_details.user_id','bet_details.pool_id','bet_details.match_id','bet_details.bet_id','bet_details.match_result','bet_details.player_result','bet_details.result','match.home_percentage','match.draw_percentage','match.away_percentage','match.home_score','match.away_score','t1.name as homeTeam_name','t2.name as awayTeam_name','l.name as league_name','match.startTime')
                    ->where('bet_details.bet_id',$value_1->id)
                    ->get();
                    if(!empty($bet_details_query))
                     {
                        foreach ($bet_details_query as $key_2 => $value_2) 
                        {
                            $bet_details[]=array('id'=>$value_2->id,'user_id'=>$value_2->user_id,'pool_id'=>$value_2->pool_id,'match_id'=>$value_2->match_id,'bet_id'=>$value_2->bet_id,'match_result'=>ucfirst($value_2->match_result),'player_result'=>$value_2->player_result,'result'=>$value_2->result,'home_percentage'=>$value_2->home_percentage,'draw_percentage'=>$value_2->draw_percentage,'away_percentage'=>$value_2->away_percentage,'home_score'=>$value_2->home_score,'away_score'=>$value_2->away_score,'homeTeam_name'=>$value_2->homeTeam_name,'awayTeam_name'=>$value_2->awayTeam_name,'league_name'=>$value_2->league_name,'startTime'=>$value_2->startTime);
                           
                        }
                    }

                   
                        $bet[]=array('id'=>$value_1->id,'created_at'=>$value_1->created_at,'user_id'=>$value_1->user_id,'pool_id'=>$value_1->pool_id,'pool_name'=>$value_1->pool_name,'pool_status'=>$value_1->pool_status,'bet_amount'=>$value_1->bet_amount,'total_match'=>$value_1->total_match,'total_win'=>$value_1->total_win,'losswinType'=>$value_1->losswinType,'losswinValue'=>$value_1->losswinValue,'bet_details'=>$bet_details);
                    }
                 }
                 
                 //id name isJackpotPool
                 return response()->json($bet);

            }
            else
            {
                 return response()->json([]);

            }
       
        
    }
  public function getwithdraw(Request $request)
    {
        $user_id = Auth::id();
        if($user_id > 0)
        {
            //return response()->json($request->user());

             $withdraw =  Withdraw:: where('user_id',$user_id)->orderBy('id','desc')->whereIn('status',['Pending','Approved','Reject'])->get();
             return response()->json($withdraw);
        }
        else 
        {
            return response()->json([]);
        }
        
    }

    public function getjackpot(Request $request)
    {
         
                $megajackpot =  DB::table('mega_jackpot')->where('status','Active')->first();
                $megajackpot_accumulatedPrize = $megajackpot->accumulatedPrize;
                $megajackpot_basePrize = $megajackpot->basePrize;
                 $megajackpot_Prize = $megajackpot_accumulatedPrize + $megajackpot_basePrize;
                $megajackpot_Prize = floor($megajackpot_Prize);

       
            //return response()->json($request->user());
            $jackpot = [];

             $result_1 =  Pool:: where('status','Active')->select('pools.id','pools.name','pools.isJackpotPool','pools.icon_path','pools.perBetAmount','pools.basePrice','pools.group1TotalPrize','pools.group2TotalPrize','pools.group3TotalPrize','pools.endTime')->orderBy('endTime','desc')->get();
             if(!empty($result_1))
             {
                foreach ($result_1 as $key_1 => $value_1) {
                    $match_details=[];
                 $match_details_query    = DB::table('pool_match')
                ->leftJoin('match', 'pool_match.match_id', '=', 'match.id')
                ->leftJoin('tims as t1', 'match.homeTeam', '=', 't1.id')
                ->leftJoin('leagues as l', 't1.league_id', '=', 'l.id')
                ->leftJoin('tims as t2', 'match.awayTeam', '=', 't2.id')
                ->select('pool_match.id','pool_match.match_id','pool_match.pool_id','l.name as league_name','t1.name as homeTeam_name','t2.name as awayTeam_name','match.result','match.home_score','match.away_score','match.startTime','match.endTime','match.home_percentage','match.draw_percentage','match.away_percentage')
                ->where('pool_match.pool_id',$value_1->id)
                ->get();
                if(!empty($match_details_query))
                 {
                    foreach ($match_details_query as $key_2 => $value_2) 
                    {
                        
                         

                             $homeP=$value_2->home_percentage;
                             $drawP=$value_2->draw_percentage;
                             $awayP=$value_2->away_percentage; 

                           /*
                            $activeclassforhome ='team-valu team-active';
                            $activeclassforaway ='team-valu';
                            $activeclassfordraw ='team-valu';

                             if(($homeP>=$awayP) && ($homeP>=$drawP))
                                   {
                                       
                                         $activeclassforhome ='team-valu team-active';
                                        $activeclassforaway ='team-valu';
                                        $activeclassfordraw ='team-valu';
                                   }
                                   else if(($awayP>=$homeP) && ($awayP>=$drawP))
                                   {
                                           $activeclassforhome ='team-valu';
                                            $activeclassforaway ='team-valu team-active';
                                            $activeclassfordraw ='team-valu';
                                   }
                                    else if(($drawP>=$homeP) && ($drawP>=$awayP))
                                   {
                                         $activeclassforhome ='team-valu';
                                            $activeclassforaway ='team-valu';
                                            $activeclassfordraw ='team-valu team-active';
                                   }                            
                             */ 

                             $activeclassforhome ='team-valu';
                            $activeclassforaway ='team-valu';
                            $activeclassfordraw ='team-valu';                          


                            $match_details[]=array('id'=>$value_2->id,'league_name'=>$value_2->league_name,'startTime'=>$value_2->startTime,'homeTeam_name'=>$value_2->homeTeam_name,'awayTeam_name'=>$value_2->awayTeam_name,'pool_id'=>$value_2->pool_id,'match_id'=>$value_2->match_id,'homeP'=>$homeP,'drawP'=>$drawP,'awayP'=>$awayP,'activeclassforhome'=>$activeclassforhome,'activeclassforaway'=>$activeclassforaway,'activeclassfordraw'=>$activeclassfordraw);
                       
                    }
                }
                $icon_path = '';
                if($value_1->icon_path!='')
                {
                    $icon_path=url('').'/'.$value_1->icon_path;
                }
                else
                {
                    $icon_path='frontend/images/soccer_jackpot.png';
                }

                            
                    
                    
                    
                    
                    $perBetAmount=$value_1->perBetAmount;
                    $basePrice=$value_1->basePrice;
                    $group1TotalPrize=$value_1->group1TotalPrize;
                    $group2TotalPrize=$value_1->group2TotalPrize;
                    $group3TotalPrize=$value_1->group3TotalPrize;
                    $endTime=$value_1->endTime;
                    $endTimearray= explode(' ',$endTime);


                    $total_price=$basePrice+$group1TotalPrize+$group2TotalPrize+$group3TotalPrize;

                  
               
                    
                    $jackpot[]=array('megajackpot_Prize'=>$megajackpot_Prize,'id'=>$value_1->id,'perBetAmount'=>$perBetAmount,'total_price'=>floor($total_price),'endTimedate'=>$endTimearray[0],'endTimetime'=>$endTimearray[1],'icon_path'=>$icon_path,'name'=>$value_1->name,'isJackpotPool'=>$value_1->isJackpotPool,'match_details'=>$match_details);
                }
             }
             
             //id name isJackpotPool
             return response()->json($jackpot);
       
        
    }
public function getalljackpot(Request $request)
    {
         
                $megajackpot =  DB::table('mega_jackpot')->where('status','Active')->first();
                $megajackpot_accumulatedPrize = $megajackpot->accumulatedPrize;
                $megajackpot_basePrize = $megajackpot->basePrize;
                 $megajackpot_Prize = $megajackpot_accumulatedPrize + $megajackpot_basePrize;
                $megajackpot_Prize = floor($megajackpot_Prize);

       
            //return response()->json($request->user());
            $jackpot = [];

             $result_1 =  Pool:: select('pools.id','pools.name','pools.isJackpotPool','pools.icon_path','pools.perBetAmount','pools.basePrice','pools.group1TotalPrize','pools.group2TotalPrize','pools.group3TotalPrize','pools.endTime','pools.status')->orderBy('endTime','desc')->get();
             if(!empty($result_1))
             {
                foreach ($result_1 as $key_1 => $value_1) 
                {                  
               
                    $icon_path = '';
                    if($value_1->icon_path!='')
                    {
                        $icon_path=url('').'/'.$value_1->icon_path;
                    }
                    else
                    {
                        $icon_path='frontend/images/soccer_jackpot.png';
                    }
                    
                    
                    $perBetAmount=$value_1->perBetAmount;
                    $basePrice=$value_1->basePrice;
                    $group1TotalPrize=$value_1->group1TotalPrize;
                    $group2TotalPrize=$value_1->group2TotalPrize;
                    $group3TotalPrize=$value_1->group3TotalPrize;
                    $endTime=$value_1->endTime;
                    $endTimearray= explode(' ',$endTime);


                    $total_price=$basePrice+$group1TotalPrize+$group2TotalPrize+$group3TotalPrize;

                  
               
                    
                    $jackpot[]=array('megajackpot_Prize'=>$megajackpot_Prize,'id'=>$value_1->id,'perBetAmount'=>$perBetAmount,'total_price'=>floor($total_price),'endTimedate'=>$endTimearray[0],'endTimetime'=>$endTimearray[1],'icon_path'=>$icon_path,'name'=>$value_1->name,'isJackpotPool'=>$value_1->isJackpotPool,'status'=>$value_1->status);
                }
             }
             
             //id name isJackpotPool
             return response()->json($jackpot);
       
        
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
      'message' => 'Unauthorized',
      'loginStatus'=>false,
      'user'=>null,
  ],200);
  }

  $user = $request->user();
  $tokenResult = $user->createToken('LaravelSanctumAuth');
  $token = $tokenResult->plainTextToken;

  return response()->json([
  'accessToken' =>$token,
  'user' =>$user,
  'token_type' => 'Bearer',
  'loginStatus'=>true

  ]);
}
 public function forgot(Request $request)
{
  $request->validate([
  'email' => 'required|string|email',
 
  ]);
  $user =  User:: where('email',$request->email)->first();
  if($user)
  {
    //exist , update users table two_factor_recovery_codes with 12 digit number
    $two_factor_recovery_codes = rand(10000,99999).rand(10000,99999);

    $user->two_factor_recovery_codes = $two_factor_recovery_codes;
    $user->save(); 

    // mail to user with this two_factor_recovery_codes code for reset his account

    $details = [
        'title' => 'Tipster 17 Reset Code forForgot Password',
        'body' => 'Hello '.$request->email.',<br>Your code is '.$two_factor_recovery_codes
    ];
   
      \Mail::to($request->email)->send(new \App\Mail\MyTestMail($details));

     return response()->json([
      'two_factor_recovery_codes' =>$two_factor_recovery_codes,      
      'forgotStatus'=>true

      ]);
  }
  else 
  {
    // no user exist
     return response()->json([
      'two_factor_recovery_codes' =>null,      
      'forgotStatus'=>false

      ]);
  }

 
}
public function user(Request $request)
{
    if($request->user())
    {
        return response()->json($request->user());
    }
    else 
    {
        return response()->json([]);
    }
    
}


public function getdeposit(Request $request)
{
    $user_id = Auth::id();
    if($user_id > 0)
    {
        //return response()->json($request->user());

         $deposit =  Deposit:: where('user_id',$user_id)->orderBy('deposit_time','desc')->whereIn('status',['Pending','Approved','Reject'])->get();
         return response()->json($deposit);
    }
    else 
    {
        return response()->json([]);
    }
    
}


public function emailchange(Request $request)
{
    
    

    $user =  User:: where('email',$request->email)->first();
    
      if($user)
      {
        

        $user_2 =  User:: where('email',$request->new_email)->first();

        

        if($user_2)
          {
            

             return response()->json([
              'error' =>'This email is already exist for other user',      
              'updateStatus'=>false

              ]);
          }
          else 
          {

            

            $user->email = $request->new_email;
           
            $user->save(); 

            return response()->json([
              'error' =>'your email is successfully updated',      
              'updateStatus'=>true

              ]);

          }
       
      }
      else 
      {
        
        return response()->json([
              'error' =>'Your current email is wrong',      
              'updateStatus'=>false

              ]);
      }
}
public function passwordchange(Request $request)
{
    $user = $request->user();
    
    if (Hash::check($request->password, $user->password)) {
        // Success

         $user->password = bcrypt($request->new_password);
        $user->save(); 

         return response()->json([
              'error' =>'Current Password is Correct',      
              'updateStatus'=>true

              ]);
    }
    else
    {
         return response()->json([
              'error' =>'Current Password is wrong',      
              'updateStatus'=>false

              ]);
    }
    
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
