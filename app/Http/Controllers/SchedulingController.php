<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use App\Models\Pool;
use Carbon\Carbon;

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

     //mega jackpot round exist check  start 
        $current_mega_jackpot_id = 0;

        
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
         }
          //mega jackpot round exist check   end
    }
}
