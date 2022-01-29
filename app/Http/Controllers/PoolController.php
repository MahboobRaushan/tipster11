<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;

use Auth;
use DB;
use App\Models\Pool;

class PoolController extends Controller
{
    /**
     * Display a listing of the details.
     *
     * @return \Illuminate\Http\Response
     */
    public function pool_list()
    { 
         $custom_permission_controller = new CustomPermissionController;
        $custom_permission_access = $custom_permission_controller->custom_permission('pool.list');
        if(!$custom_permission_access)
        {
            abort(401,'Not authorised');
        }

        
        $custom_get_all_permissions_access = $custom_permission_controller->custom_get_all_permissions();


        $pageConfigs = ['pageHeader' => false];  
        //return view('/comming-soon',['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access]);
         return view('/content/apps/pools/app-pools-list',['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access]);
    }
     public function ajaxlist()
    {
        
        $data = DB::table('pools')->get();

        return json_decode(json_encode(array('data'=>$data)));
        
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
         $v = Validator::make($request->all(),[
            'name' => 'required',           
            'startTimedate' => 'required',
            'startTimetime' => 'required',
            'endTimedate' => 'required',
            'endTimetime' => 'required',

            'perBetAmount' => 'required',
            'basePrice' => 'required',
            'megaPercentage' => 'required',
            'poolPercentage' => 'required',
            'comPercentage' => 'required',
            'agentPercentage' => 'required',

            'group1Percentage' => 'required',
            'group2Percentage' => 'required',
            'group3Percentage' => 'required',

            'isJackpotPool' => 'required'           
                                
            
        ]);

         

        if ($v->fails())
        {
            return json_encode(array('status'=>'notok','message'=>$v->errors()));
        }
        else
        {
            $name = $request->name;          
            $startTime = $request->startTimedate.' '.$request->startTimetime;
            $endTime = $request->endTimedate.' '.$request->endTimetime;
            $perBetAmount = $request->perBetAmount;
            $basePrice = $request->basePrice;
            $megaPercentage = $request->megaPercentage;
            $poolPercentage = $request->poolPercentage;
            $comPercentage = $request->comPercentage;
            $agentPercentage = $request->agentPercentage;
            $group1Percentage = $request->group1Percentage;
            $group2Percentage = $request->group2Percentage;
            $group3Percentage = $request->group3Percentage;

            $isJackpotPool = $request->isJackpotPool;

            $createdBy = Auth::user()->id;

            //updatedBy
           

           
            $poolData = array('name'=>$name,'startTime'=>$startTime,'endTime'=>$endTime,'perBetAmount'=>$perBetAmount  ,'basePrice'=>$basePrice  ,'megaPercentage'=>$megaPercentage  ,'poolPercentage'=>$poolPercentage  ,'comPercentage'=>$comPercentage  ,'agentPercentage'=>$agentPercentage
                ,'group1Percentage'=>$group1Percentage ,'group2Percentage'=>$group2Percentage   ,'group3Percentage'=>$group3Percentage   ,'createdBy'=>$createdBy,'isJackpotPool'=>$isJackpotPool);
            

          
            $pool = Pool::create($poolData);          

            return json_encode(array('status'=>'ok','message'=>'Successfully added!','res'=>$poolData));
         
          
        }
        
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Match  $match
     * @return \Illuminate\Http\Response
     */
    public function details($id)
    {
        //$pool = Pool::where('id',$id)->first();

          $pool = DB::table('pools')           
            ->where('pools.id',$id)
            ->get();

            $match = DB::table('pool_match')
                ->leftJoin('match', 'pool_match.match_id', '=', 'match.id')
                ->leftJoin('tims as t1', 'match.homeTeam', '=', 't1.id')
                ->leftJoin('leagues as l', 't1.league_id', '=', 'l.id')
                ->leftJoin('tims as t2', 'match.awayTeam', '=', 't2.id')
                ->select('pool_match.id','pool_match.match_id','pool_match.pool_id','l.name as league_name','t1.name as homeTeam_name','t2.name as awayTeam_name','match.result')
                ->where('pool_match.pool_id',$id)
                ->get();

            $league = DB::table('leagues')  
             ->select('id','name')         
            ->where('status',1)
            ->get();

        return json_encode(array('pool'=>$pool,'match'=>$match,'league'=>$league));
    }

    
    public function matchbyleaguedetails($league_id)
    {
        //$pool = Pool::where('id',$id)->first();

          

            $match = DB::table('match')
                ->leftJoin('tims as t1', 't1.id', '=', 'match.homeTeam')
                ->select('match.id','t1.name as homeTeam_name','t2.name as awayTeam_name')
                ->leftJoin('tims as t2', 't2.id', '=', 'match.awayTeam')
                ->where('match.league',$league_id)
                ->where('match.status',1)
                ->get();

            

        return json_encode(array('match'=>$match));
    }

  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Match  $match
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pool $pool)
    {
         $v = Validator::make($request->all(),[
            'name' => 'required',  
            'status' => 'required',          
            'startTimedate' => 'required',
            'startTimetime' => 'required',
            'endTimedate' => 'required',
            'endTimetime' => 'required',

            'perBetAmount' => 'required',
            'basePrice' => 'required',
            'megaPercentage' => 'required',
            'poolPercentage' => 'required',
            'comPercentage' => 'required',
            'agentPercentage' => 'required',

            'group1Percentage' => 'required',
            'group2Percentage' => 'required',
            'group3Percentage' => 'required' ,

             'isJackpotPool' => 'required' 

            
        ]);

      

        if ($v->fails())
        {
            return json_encode(array('status'=>'notok','message'=>$v->errors()));
        }
        else
        {
            $name = $request->name;          
            $startTime = $request->startTimedate.' '.$request->startTimetime;
            $endTime = $request->endTimedate.' '.$request->endTimetime;
            $perBetAmount = $request->perBetAmount;
            $basePrice = $request->basePrice;
            $megaPercentage = $request->megaPercentage;
            $poolPercentage = $request->poolPercentage;
            $comPercentage = $request->comPercentage;
            $agentPercentage = $request->agentPercentage;
            $group1Percentage = $request->group1Percentage;
            $group2Percentage = $request->group2Percentage;
            $group3Percentage = $request->group3Percentage;

            $isJackpotPool = $request->isJackpotPool;

            

            $status = $request->status;
            


            $pool = Pool::where('id',$request->edit_id)->first();

            $updatedBy = Auth::user()->id;

            //updatedBy

            $pool->name = $name;          
            $pool->startTime = $startTime;
            $pool->endTime = $endTime;
            $pool->perBetAmount = $perBetAmount;
            $pool->basePrice = $basePrice;

            $pool->megaPercentage = $megaPercentage;
            $pool->poolPercentage = $poolPercentage;
            $pool->comPercentage = $comPercentage;
            $pool->agentPercentage = $agentPercentage;
            $pool->group1Percentage = $group1Percentage;
            $pool->group2Percentage = $group2Percentage;
            $pool->group3Percentage = $group3Percentage;

            $pool->isJackpotPool = $isJackpotPool;

            

            $pool->status = $status;

            $pool->updatedBy = $updatedBy;
                      
            $pool->save();

            return json_encode(array('status'=>'ok','message'=>'Successfully updated!','gm'=>$pool));
         
          
        }
    }

    
    public function updateteam(Request $request)
    {
         $v = Validator::make($request->all(),[
            'pool_id' => 'required'

            
        ]);

        
        if ($v->fails())
        {
            
        }
        else
        {
            $message = [];
            $pool_id = $request->pool_id;          
            $match_ids = $request->match_id;
            foreach($match_ids as $match_id)
            {

                 $pool_match_total_count = DB::table('pool_match')           
                ->where('pool_id',$pool_id)               
                ->count();
                if($pool_match_total_count >= 10)
                {
                    return json_encode(array('status'=>'notok','message'=>'Maximum match on a Pool , you reached !')); 
                }
                else
                {
                     $pool_match_exist = DB::table('pool_match')           
                    ->where('pool_id',$pool_id)
                    ->where('match_id',$match_id)
                    ->count();

                    $message[]=$pool_id.'aaa'.$match_id;
                    if($pool_match_exist==0)
                    {
                        //insert
                        $createdBy = Auth::user()->id;
                        $message[]=$pool_match_exist.'bbb'.$createdBy;

                       DB::table('pool_match')
                            ->insert(array('pool_id' => $pool_id, 'match_id' => $match_id,'createdBy'=>$createdBy,'created_at'=>date('Y-m-d H:i:s')));
                    }
                }

               


            }
            
            return json_encode(array('status'=>'ok','message'=>'Successfully added !'));       
          
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Match  $match
     * @return \Illuminate\Http\Response
     */
    
    public function destroy($id){
       
        $pool = Pool::where('id',$id);
        
        
        if($pool)
        {
            $pool->delete();
        }

        $pool_match = DB::table('pool_match')->where('pool_id',$id);       
        
        if($pool_match->count() > 0)
        {
            $pool_match->delete();
        }
             
        return json_encode(array('status'=>'ok','message'=>'Successfully deleted !'));
    }

     public function matchdestroy($id,$pullid){
       
        $pool_match = DB::table('pool_match')->where('id',$id);
        
        
        if($pool_match->count() > 0)
        {
            $pool_match->delete();
        } 

         $match_details = DB::table('pool_match')
                ->leftJoin('match', 'pool_match.match_id', '=', 'match.id')
                ->leftJoin('tims as t1', 'match.homeTeam', '=', 't1.id')
                ->leftJoin('leagues as l', 't1.league_id', '=', 'l.id')
                ->leftJoin('tims as t2', 'match.awayTeam', '=', 't2.id')
                ->select('pool_match.id','pool_match.match_id','pool_match.pool_id','l.name as league_name','t1.name as homeTeam_name','t2.name as awayTeam_name','match.result')
                ->where('pool_match.pool_id',$pullid)
                ->get();
                    
        return json_encode(array('status'=>'ok','message'=>'Successfully deleted !','match_details'=>$match_details));
    }

    

}
