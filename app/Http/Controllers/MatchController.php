<?php

namespace App\Http\Controllers;
use App\Models\Match;

use Validator;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\League;
use App\Models\Tim;

class MatchController extends Controller
{
    /**
     * Display a listing of the details.
     *
     * @return \Illuminate\Http\Response
     */
    public function match_list()
    { 
          $custom_permission_controller = new CustomPermissionController;
        $custom_permission_access = $custom_permission_controller->custom_permission('match.list');
        if(!$custom_permission_access)
        {
            abort(401,'Not authorised');
        }

        
        $custom_get_all_permissions_access = $custom_permission_controller->custom_get_all_permissions();


        $pageConfigs = ['pageHeader' => false];  
        $league = League::where('status',1)->orderBy('name','asc')->get();
        return view('/content/apps/match/app-match-list',['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access,'league'=>$league]);
    }

     public function ajaxlist()
    {
        
        $data = DB::table('match')
            ->select('match.*','leagues.name as league_name','t1.name as homeTeam_name','t2.name as awayTeam_name')
            ->leftJoin('leagues', 'leagues.id', '=', 'match.league')
            ->leftJoin('tims as t1', 't1.id', '=', 'match.homeTeam')
            ->leftJoin('tims as t2', 't2.id', '=', 'match.awayTeam')
            ->get();

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
            'homeTeam' => 'required',
            'awayTeam' => 'required',
            'startTimedate' => 'required',
            'startTimetime' => 'required',
            'endTimedate' => 'required',
            'endTimetime' => 'required',
            'league' => 'required',                       
            
        ]);

           $matchexist = DB::table('match')                   
            ->where('homeTeam',$request->homeTeam)
            ->where('awayTeam',$request->awayTeam)
            ->count();
         if($matchexist > 0)
         {
            return json_encode(array('status'=>'notok','message'=>'These Home Team and Away Team combination already exist.'));
         }

        if ($v->fails())
        {
            return json_encode(array('status'=>'notok','message'=>$v->errors()));
        }
        else
        {
            $homeTeam = $request->homeTeam;
            $awayTeam = $request->awayTeam;
            $startTime = $request->startTimedate.' '.$request->startTimetime;
            $endTime = $request->endTimedate.' '.$request->endTimetime;
            $league = $request->league;

            $createdBy = Auth::user()->id;

            //updatedBy
           

           
            $matchData = array('homeTeam'=>$homeTeam,'awayTeam'=>$awayTeam,'startTime'=>$startTime,'endTime'=>$endTime,'league'=>$league,'createdBy'=>$createdBy);
            

          
            $match = Match::create($matchData);          

            return json_encode(array('status'=>'ok','message'=>'Successfully added!','res'=>$matchData));
         
          
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
        //$match = Match::where('id',$id)->first();

        $match = DB::table('match')
            ->select('match.*','leagues.name as league_name','t1.name as homeTeam_name','t2.name as awayTeam_name')
            ->leftJoin('leagues', 'leagues.id', '=', 'match.league')
            ->leftJoin('tims as t1', 't1.id', '=', 'match.homeTeam')
            ->leftJoin('tims as t2', 't2.id', '=', 'match.awayTeam')
            ->where('match.id',$id)
            ->get();
            $league_id = $match[0]->league;
            $tims = DB::table('tims')
                ->select('id','name')
                ->where('league_id',$league_id)
                ->get();


        //return $match->toJson();
        return json_encode(array('match'=>$match,'tims'=>$tims));
    }

  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Match  $match
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Match $match)
    {
         $v = Validator::make($request->all(),[
             'homeTeam' => 'required',
            'awayTeam' => 'required',
            'startTimedate' => 'required',
            'startTimetime' => 'required',
            'endTimedate' => 'required',
            'endTimetime' => 'required',
            'league' => 'required',  
        ]);

        // return json_encode(array('status'=>'ok','message'=>'Successfully updated!','request'=> $request->name));

        $matchexist = DB::table('match')                   
            ->where('homeTeam',$request->homeTeam)
            ->where('awayTeam',$request->awayTeam)
            ->where('id','!=',$request->edit_id)
            ->count();
         if($matchexist > 0)
         {
            return json_encode(array('status'=>'notok','message'=>'These Home Team and Away Team combination already exist in another match.'));
         }

        if ($v->fails())
        {
            return json_encode(array('status'=>'notok','message'=>$v->errors()));
        }
        else
        {
             $homeTeam = $request->homeTeam;
            $awayTeam = $request->awayTeam;
             $startTime = $request->startTimedate.' '.$request->startTimetime;
            $endTime = $request->endTimedate.' '.$request->endTimetime;
            $league = $request->league;
            $result = $request->result;
            $status = $request->status;
            


            $match = Match::where('id',$request->edit_id)->first();

            $updatedBy = Auth::user()->id;

            //updatedBy

            $match->homeTeam = $homeTeam;
            $match->awayTeam = $awayTeam;
            $match->startTime = $startTime;
            $match->endTime = $endTime;
            $match->league = $league;
            $match->result = $result;

            $match->status = $status;

            $match->updatedBy = $updatedBy;
                      
            $match->save();

            return json_encode(array('status'=>'ok','message'=>'Successfully updated!','gm'=>$match));
         
          
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Match  $match
     * @return \Illuminate\Http\Response
     */
    
    public function destroy($id){
       
        $match = Match::where('id',$id);
        
        
        if($match)
        {
            $match->delete();
        }
             
        return json_encode(array('status'=>'ok','message'=>'Successfully deleted !'));
    }
}
