<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use App\Models\Pool;
use Carbon\Carbon;
use App\Models\Megajackpot;

use Mail;

class SchedulingController extends Controller
{
     public function scheduling()
    {
        //return 0;
        /*
        DB::table('testing')->insert(
            ['description'=>date('Y-m-d H:i:s')]
        );
        */

               

        $current_date_time = Carbon::now()->toDateTimeString();
        $currentTime = strtotime($current_date_time);
        $pools = DB::table('pools')->whereIn('status',['Inactive','Active'])->get();

        //echo "<pre>";
       // print_r($pools);
        //echo "</pre>";

        foreach($pools as $pool)
        {
            $startT = $pool->startTime;
            $startTime = strtotime($startT);
            $endT = $pool->endTime;
            if($endT!='')
            {
                $endTime = strtotime($endT);
                $id = $pool->id;
                $status = $pool->status;
                if($currentTime < $startTime)
                {
                    //status = 0 inactive
                    if($status!='Inactive')
                    {                  
                        DB::table('pools')
                        ->where('id', $id)
                        ->update(['status' => 'Inactive']);

                    }
                }
                if(($currentTime > $startTime) && ($currentTime < $endTime))
                {
                     //status = 1 active
                    if($status!='Active')
                    {
                         DB::table('pools')
                        ->where('id', $id)
                        ->update(['status' => 'Active']);
                    }
                }
                if($currentTime > $endTime){
                    $matchscount = DB::table('pool_match')
                    ->leftJoin('match', 'match.id', '=', 'pool_match.match_id')
                    ->select('match.result')
                    ->whereNull('match.result')
                    ->where('match.status','!=','Void')                 
                    ->where('pool_match.pool_id',$id)               
                    ->count();
                    if($matchscount > 0)
                    {
                        //status = 0 inactive
                        if($status!='Inactive')
                        {
                             DB::table('pools')
                            ->where('id', $id)
                            ->update(['status' => 'Inactive']);
                        }
                    }
                    else 
                    {
                        //status = 2 finished
                        if($status!='Finished')
                        {
                             DB::table('pools')
                            ->where('id', $id)
                            ->update(['status' => 'Finished']);
                        }
                    }

                }
            }
        }

     //mega jackpot round exist check  start 
        $current_mega_jackpot_id = 0;

        $mega_jackpotcount_initial = DB::table('mega_jackpot')->count();
        if($mega_jackpotcount_initial==0)
        {
             $new_name = 'Mega Jackpot 1';

                        $megajackpotData = array(
                            'name'=>$new_name,
                            'basePrize'=>0.0,
                            'accumulatedPrize'=>0.0,
                            'startTime'=>date('Y-m-d H:i:s'),
                            'status'=>'Active',
                            'created_at'=>date('Y-m-d H:i:s')
                        );
                        Megajackpot::create($megajackpotData); 
        }
        
         $mega_jackpotcount = DB::table('mega_jackpot')                
                ->where('status','Active')                 
                 ->count();
         if($mega_jackpotcount > 0 )
         {
               $current_mega_jackpot_id = DB::table('mega_jackpot')                
                ->where('status','Active')                 
                 ->first()->id; 

                 $mega_jackpot_round_exist = DB::table('mega_jackpot_round')                
                ->where('mega_jackpot_id',$current_mega_jackpot_id)                 
                 ->count();

                 if($mega_jackpot_round_exist==0)
                 {
                    DB::table('mega_jackpot_round')                    
                    ->insert(['mega_jackpot_id' => $current_mega_jackpot_id,'round_title'=>'Round#1','is_running'=>'1','is_applicable_for_mega_jackpot'=>'1']);
                 }
                 //mega jackpot round exist check   end



                 $mega_jackpot_id = $current_mega_jackpot_id;
    // echo 'mega_jackpot_id='.$mega_jackpot_id;

     $mega_jackpot_round_pool_1 = DB::table('mega_jackpot_round')                
      ->where('mega_jackpot_id',$mega_jackpot_id) 
       ->where(['is_running'=>1,'pool_1_status'=>'Inactive'])               
       ->count();

       $all_warning_message  = [];
       if($mega_jackpot_round_pool_1 > 0){
                 $all_warning_message[]= 'You should assign Jackpot/ Pool to current mega jackpot round Pool 1';
              }

              $mega_jackpot_round_pool_2 = DB::table('mega_jackpot_round')                
              ->where('mega_jackpot_id',$mega_jackpot_id) 
               ->where(['is_running'=>1,'pool_2_status'=>'Inactive'])               
               ->count();
               if($mega_jackpot_round_pool_2 > 0){
                    $all_warning_message[]= 'You should assign Jackpot/ Pool to current mega jackpot round Pool 2';
              }

              $mega_jackpot_round_pool_3 = DB::table('mega_jackpot_round')                
              ->where('mega_jackpot_id',$mega_jackpot_id) 
               ->where(['is_running'=>1,'pool_3_status'=>'Inactive'])               
               ->count();
               if($mega_jackpot_round_pool_3 > 0){
                $all_warning_message[]= 'You should assign Jackpot/ Pool to current mega jackpot round Pool 3'; 
              }
            //$details = implode(',<br> ',$all_warning_message);

            //Mail::to('mahboob.raushan@gmail.com')->send($details);
            $to_email =env('MAIL_ADDRESS_FOR_SCHEDULING','mahboob.raushan@gmail.com');
            $data=['email'=>$to_email, 'all_warning_message'=> $all_warning_message];
            $user['to']=$to_email;
            Mail::send('emails.schedulingwarningmegajackporounpoolmail',$data,function ($messages) use ($user){
                $messages->to($user['to']);
                $messages->subject('Warning for Mega Jackpot Round - Pool setup - urgent');
            });

         }
         else
         {
             // add new entry mega jackpot 
                        $allmega_jackpot = DB::table('mega_jackpot')->select('name')->get();
                        $max_num=0;
                        if(!empty($allmega_jackpot))
                        {
                            foreach($allmega_jackpot as $vv)
                            {
                                $tempstr = $vv->name;
                              
                                $temparray = explode(' ',$tempstr);
                              
                                if(!empty($temparray))
                                {
                                    foreach($temparray as $tempval)
                                    {
                                        $tempval=intval($tempval);
                                        
                                            if($tempval > $max_num)
                                            {
                                                $max_num = $tempval;
                                            }
                                     
                                    }
                                }
                            }
                        }
                        $max_num++;
                        $new_name = 'Mega Jackpot '.$max_num;

                        $megajackpotData = array(
                            'name'=>$new_name,
                            'basePrize'=>0.0,
                            'accumulatedPrize'=>0.0,
                            'startTime'=>date('Y-m-d H:i:s'),
                            'status'=>'Active',
                            'created_at'=>date('Y-m-d H:i:s')
                        );
                        Megajackpot::create($megajackpotData); 
         }
          
    }
}
