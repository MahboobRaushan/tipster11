<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use App\Models\Megajackpot;

class MegajackpotController extends Controller
{
    /**
     * Display a listing of the details.
     *
     * @return \Illuminate\Http\Response
     */
    public function megajackpots_list()
    { 
         $custom_permission_controller = new CustomPermissionController;
        $custom_permission_access = $custom_permission_controller->custom_permission('megajackpot.list');
        if(!$custom_permission_access)
        {
            abort(401,'Not authorised');
        }

        
        $custom_get_all_permissions_access = $custom_permission_controller->custom_get_all_permissions();


        $pageConfigs = ['pageHeader' => false];  
        //return view('/comming-soon',['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access]);

        $mega_jackpot_id = 0;
        $mega_jackpot_basePrize=0;
        $mega_jackpot_accumulatedPrize=0;

        $mega_jackpot_round = [];
        $pool_1_details = [];
         $pool_2_details = [];
          $pool_3_details = [];



        if(Megajackpot::where('status','Active')->count() > 0)
        {
             $megajackpot = Megajackpot::where('status','Active')->first();

             $mega_jackpot_id = $megajackpot->id;
            $mega_jackpot_basePrize=$megajackpot->basePrize;
            $mega_jackpot_accumulatedPrize=$megajackpot->accumulatedPrize;

            $mega_jackpot_round_exist = DB::table('mega_jackpot_round')                
                ->where('mega_jackpot_id',$mega_jackpot_id)                 
                 ->count();

                 if($mega_jackpot_round_exist > 0)
                 {

                    $mega_jackpot_round = DB::table('mega_jackpot_round')                
                    ->where('mega_jackpot_id',$mega_jackpot_id)                 
                     ->first();

                    if($mega_jackpot_round->pool_1_id > 0)
                    {
                        $pool_1_details = DB::table('pools')                
                        ->where('id',$mega_jackpot_round->pool_1_id)                 
                         ->first();

                    }

                    if($mega_jackpot_round->pool_2_id > 0)
                    {
                        $pool_2_details = DB::table('pools')                
                        ->where('id',$mega_jackpot_round->pool_2_id)                 
                         ->first();

                    }

                     if($mega_jackpot_round->pool_3_id > 0)
                    {
                        $pool_3_details = DB::table('pools')                
                        ->where('id',$mega_jackpot_round->pool_3_id)                 
                         ->first();

                    }


                 }
        }

        
        $mega_jackpot_id = intval($mega_jackpot_id);
        $mega_jackpot_basePrize = intval($mega_jackpot_basePrize);
        $mega_jackpot_accumulatedPrize = intval($mega_jackpot_accumulatedPrize);

        
        $mega_jackpot_details_array = DB::table('mega_jackpot_details')   
                    ->pluck('pool_id')             
                     ->toArray();

        $pooldetails = DB::table('pools')   
                    ->whereIn('status',['Active','Inactive'])
                    ->whereNotIn('id',$mega_jackpot_details_array)
                     ->get();             

       // echo "<pre>";
       //  print_r($pooldetails);
       //  die();
       

        return view('/content/apps/megajackpots/app-megajackpots-list',['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access,'mega_jackpot_id'=>$mega_jackpot_id,'mega_jackpot_basePrize'=>$mega_jackpot_basePrize,'mega_jackpot_accumulatedPrize'=>$mega_jackpot_accumulatedPrize,'mega_jackpot_round'=>$mega_jackpot_round,'pool_1_details'=>$pool_1_details,'pool_2_details'=>$pool_2_details,'pool_3_details'=>$pool_3_details,'pooldetails'=>$pooldetails]);
    }

    public function baseprize(Request $request)
    {
       
        $id = $request->mega_jackpot_id;
        $basePrize = $request->amount;

        $megajackpot =  Megajackpot:: where('id',$id)->first();
        $megajackpot->basePrize = $basePrize;            
        $megajackpot->save();           
        

        
        return json_encode(array('status'=>'ok','message'=>'Successfully Updated!'));
    }

    
    public function poolround(Request $request)
    {
       
        $pool_id = $request->pool_id;
        $mega_jackpot_id = $request->mega_jackpot_id;   
        $type = $request->type;
        $pool_no = $request->pool_no;  
        $mega_jackpot_round_id = $request->mega_jackpot_round_id;  




        $mega_jackpot_details_exist = DB::table('mega_jackpot_details')   
                    ->where('pool_id',$pool_id)             
                     ->count();

        

        if($type=='Add')
        {
            if($mega_jackpot_details_exist > 0)
            {
                return json_encode(array('status'=>'notok','message'=>'You can\'t add this pool!'));
            }
            else 
            {
                if($pool_no==1)
                {
                     DB::table('mega_jackpot_round')
                    ->where(['id'=> $mega_jackpot_round_id,'mega_jackpot_id'=>$mega_jackpot_id])
                    ->update(['pool_1_id'=>$pool_id,'pool_1_status' => 'Active']);
                }
                else if($pool_no==2)
                {
                     DB::table('mega_jackpot_round')
                    ->where(['id'=> $mega_jackpot_round_id,'mega_jackpot_id'=>$mega_jackpot_id])
                    ->update(['pool_2_id'=>$pool_id,'pool_2_status' => 'Active']);
                }
                else if($pool_no==3)
                {
                     DB::table('mega_jackpot_round')
                    ->where(['id'=> $mega_jackpot_round_id,'mega_jackpot_id'=>$mega_jackpot_id])
                    ->update(['pool_3_id'=>$pool_id,'pool_3_status' => 'Active']);
                }

                
                 DB::table('mega_jackpot_details')
                    ->insert(['mega_jackpot_id'=>$mega_jackpot_id, 'pool_id'=>$pool_id,'accumulatedPrize' => 0,'created_at'=>date('Y-m-d H:i:s')]);

                 DB::table('pools')
                    ->where(['id'=> $pool_id])
                    ->update(['isJackpotPool'=>1]);

                return json_encode(array('status'=>'ok','message'=>'Successfully Added !'));
            }

        }
        else  if($type=='Remove')
        {
            if($mega_jackpot_details_exist == 0)
            {
                return json_encode(array('status'=>'notok','message'=>'You can\'t remove this pool!'));
            }
            else 
            {
                if($pool_no==1)
                {
                     DB::table('mega_jackpot_round')
                    ->where(['id'=> $mega_jackpot_round_id,'mega_jackpot_id'=>$mega_jackpot_id])
                    ->update(['pool_1_id'=>0,'pool_1_status' => 'Inactive']);
                }
                else if($pool_no==2)
                {
                     DB::table('mega_jackpot_round')
                    ->where(['id'=> $mega_jackpot_round_id,'mega_jackpot_id'=>$mega_jackpot_id])
                    ->update(['pool_2_id'=>0,'pool_2_status' => 'Inactive']);
                }
                else if($pool_no==3)
                {
                     DB::table('mega_jackpot_round')
                    ->where(['id'=> $mega_jackpot_round_id,'mega_jackpot_id'=>$mega_jackpot_id])
                    ->update(['pool_3_id'=>0,'pool_3_status' => 'Inactive']);
                }

                
                 DB::table('mega_jackpot_details')
                    ->where(['mega_jackpot_id'=>$mega_jackpot_id, 'pool_id'=>$pool_id])
                    ->delete();

                 DB::table('pools')
                    ->where(['id'=> $pool_id])
                    ->update(['isJackpotPool'=>0]);

                return json_encode(array('status'=>'ok','message'=>'Successfully Deleted !'));
            }

        }
        

        
       // return json_encode(array('status'=>'ok','message'=>'Successfully Updated!  pool_id='.$pool_id. ' mega_jackpot_id='.$mega_jackpot_id. ' type='.$type. ' pool_no='.$pool_no));
       
    }

}
