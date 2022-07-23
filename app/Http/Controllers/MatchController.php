<?php

namespace App\Http\Controllers;


use Validator;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\League;
use App\Models\Tim;
use App\Models\Pool;
use App\Models\Betdetails;
use App\Models\Megajackpot;
use App\Models\Megajackpotdetails;
use App\Models\Bet;
use App\Models\Match;


class MatchController extends Controller
{
    /**
     * Display a listing of the details.
     *
     * @return \Illuminate\Http\Response
     */
    public $per_page;
    function __construct() {
        $this->per_page = 10;
      }

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
    
    public function handle_pagination($total, $page, $shown, $url) {  
          $pages = ceil( $total / $shown ); 
          $range_start = ( ($page >= 5) ? ($page - 3) : 1 );
          $range_end = ( (($page + 5) > $pages ) ? $pages : ($page + 5) );

          if ( $page >= 1 ) {
            $r[] = '<li class="page-item"><a class="page-link" href="'. $url .'1">&laquo; </a></li>';
            $r[] = '<li class="page-item"><a class="page-link" href="'. $url . ( $page ) .'">&lsaquo; </a></li>';
            $r[] = ( ($range_start > 1) ? ' ... ' : '' ); 
          }

          if ( $range_end > 1 ) {
            foreach(range($range_start, $range_end) as $key => $value) {
              if ( $value == ($page + 1) ) $r[] = '<li class="page-item active" aria-current="page"><span class="page-link">'. $value .'</span></li>'; 
              else $r[] = '<li class="page-item"><a class="page-link" href="'. $url . ($value ) .'">'. $value .'</a></li>'; 
            }
          }

          if ( ( $page + 1 ) < $pages ) {
            $r[] = ( ($range_end < $pages) ? ' ... ' : '' );
            $r[] = '<li class="page-item"><a class="page-link" href="'. $url . ( $page + 2 ) .'"> &rsaquo;</a></li>';
            $r[] = '<li class="page-item"><a class="page-link" href="'. $url . ( $pages  ) .'"> &raquo;</a></li>';
          }

          return ( (isset($r)) ? '<div class="pagination" style="float:right;"><nav><ul class="pagination">'. implode("", $r) .'</ul></nav></div>' : '');
        }     
     public function ajaxlist($page_no)
    {
       // Paginator::setCurrentPage($page_no);
        $per_page = $this->per_page;
        $offset=($page_no -1 ) * $per_page ;
        $limit=$per_page;

        $data = DB::table('match')
            ->select('match.*','leagues.name as league_name','t1.name as homeTeam_name','t2.name as awayTeam_name')
            ->leftJoin('leagues', 'leagues.id', '=', 'match.league')
            ->leftJoin('tims as t1', 't1.id', '=', 'match.homeTeam')
            ->leftJoin('tims as t2', 't2.id', '=', 'match.awayTeam')
            ->offset($offset)
            ->limit($limit)
            ->get();

            $totalcount = DB::table('match')
            ->select('match.*','leagues.name as league_name','t1.name as homeTeam_name','t2.name as awayTeam_name')
            ->leftJoin('leagues', 'leagues.id', '=', 'match.league')
            ->leftJoin('tims as t1', 't1.id', '=', 'match.homeTeam')
            ->leftJoin('tims as t2', 't2.id', '=', 'match.awayTeam')          
            ->count();

           $links = $this->handle_pagination($totalcount, ($page_no-1), $this->per_page, url('/match?page='));
           $page_link = array('links'=>$links,'offset'=>$offset,'totalcount'=>$totalcount);
           
        return json_decode(json_encode(array('per_page'=>$per_page,'offset'=>$offset,'totalcount'=>$totalcount,'page_links'=>$links,'data'=>$data,'page_no'=>$page_no)));
        
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

        /*
           $matchexist = DB::table('match')                   
            ->where('homeTeam',$request->homeTeam)
            ->where('awayTeam',$request->awayTeam)
            ->count();
         if($matchexist > 0)
         {
            return json_encode(array('status'=>'notok','message'=>'These Home Team and Away Team combination already exist.'));
         }
         */

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
           

           //$matchData = [];
            $matchData = array('homeTeam'=>$homeTeam,'awayTeam'=>$awayTeam,'startTime'=>$startTime,'endTime'=>$endTime,'league'=>$league,'createdBy'=>$createdBy);
            //$match = Match::create($matchData);   
           //$match = New Match();  
           //$match->create($matchData) ; 

            $match = DB::table('match')->insert(
                            $matchData
                        );   

             

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
    public function update(Request $request)
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

        /*
        $matchexist = DB::table('match')                   
            ->where('homeTeam',$request->homeTeam)
            ->where('awayTeam',$request->awayTeam)
            ->where('id','!=',$request->edit_id)
            ->count();
         if($matchexist > 0)
         {
            return json_encode(array('status'=>'notok','message'=>'These Home Team and Away Team combination already exist in another match.'));
         }

         */

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

             $home_score = $request->home_score;
              $away_score = $request->away_score;
            


            $match = DB::table('match')->where('id',$request->edit_id)->first();
            $originalstartTime=$match->startTime;

            $updatedBy = Auth::user()->id;

            //updatedBy

            $match->homeTeam = $homeTeam;
            $match->awayTeam = $awayTeam;
            $match->startTime = $startTime;
            $match->endTime = $endTime;
            $match->league = $league;
            $match->result = $result;

            $match->home_score = $home_score;
            $match->away_score = $away_score;

            if($status=='Void')
            {
                $status = 'Void';
            }
            else
            {
                if($result!='')
                {
                    $status = 'Finished';

                    

                }
                else
                {
                    $status = 'Running';
                }
            }
            $match->status = $status;

            $match->updatedBy = $updatedBy;
                      
            $match_save_result = $match->save();


            

            if($match_save_result)
            {

              
                // bet_details table match_result and result column should update
                $matchall = DB::table('bet_details')->select('id','match_id','match_result','player_result')->where('match_id',$request->edit_id)->get();
                if(!empty($matchall))
                    {
                        foreach($matchall as $thismatch)
                        {
                            

                            $this_id = $thismatch->id;
                            $this_match_id = $thismatch->match_id;
                            $this_match_result = $thismatch->match_result;
                            $this_player_result = $thismatch->player_result;

                           // $description = 'this_id='.$this_id.' :: '.'this_match_id='.$this_match_id.' :: '.'this_match_result='.$this_match_result.' :: '.'this_player_result='.$this_player_result.' :: '  ;


                           

                            $final_result = 'void';

                           

                             if($status == 'Finished')
                             {
                                if($result==$this_player_result)
                                {
                                   $final_result = 'win'; 
                                }
                                else 
                                {
                                    $final_result = 'loss';
                                }
                             }
                             $final_match_result = $result;

                            



                              //$currentbetdetailsmatch = Betdetails::where('id',$this_id)->first();
                              //$currentbetdetailsmatch = DB::table('bet_details')
                              // ->where('id',$this_id)               
                              //  ->first();


                              //$currentbetdetailsmatch->save();

                            
                              DB::table('bet_details')
                                ->where('id',$this_id)
                                ->update(['result' => $final_result, 'match_result' => $final_match_result]);


                            
                        }
                    }
                    if(($status=='Void') || ($status=='Finished'))
                    {
                        $this->recalculatePoolResultByMatchId($request->edit_id); 
                    }

            }

            if($originalstartTime!=$startTime)
            {
                // every pool where match_id exist and status != Finished to update  endTime <1 hour
                $match_id = $request->edit_id;

                $pools = DB::table('pools')
                    ->select('pools.id')
                    ->leftJoin('pool_match', 'pools.id', '=', 'pool_match.pool_id')                   
                    ->where('pool_match.match_id',$match_id)
                    ->get();
                    if(!empty($pools))
                    {
                        foreach($pools as $pool)
                        {
                            $pool_id = $pool->id;
                            $this->recalculatePoolEndtime($pool_id);
                        }
                    }
                    

            }

            return json_encode(array('status'=>'ok','message'=>'Successfully updated!','gm'=>$match));
         
          
        }
    }

    public function recalculatePoolEndtime($pool_id){

        $beforeOneHour = null;

        $allcount = DB::table('pool_match')
                ->leftJoin('match', 'match.id', '=', 'pool_match.match_id')
                ->select('match.startTime')
                ->orderBy('match.startTime','asc')
                ->limit(1)
                ->where('pool_match.pool_id',$pool_id)
                 ->count();
                 if($allcount > 0){
                     $matchs = DB::table('pool_match')
                            ->leftJoin('match', 'match.id', '=', 'pool_match.match_id')
                            ->select('match.startTime')
                            ->orderBy('match.startTime','asc')
                            ->limit(1)
                            ->where('pool_match.pool_id',$pool_id)               
                            ->get();

                            $end_time = $matchs[0]->startTime;
                            
                            $time   = strtotime($end_time);
                            $time   = $time - (60*60); //one hour
                            $beforeOneHour = date("Y-m-d H:i:s", $time);
                        }
                
                $pool = Pool::where('id',$pool_id)->first();
                $pool->endTime = $beforeOneHour;
                $pool->save();

     }

     
     public function recalculatePoolResultByMatchId($match_id){
        // all pools call for recalculatePoolResultByPoolId

         $pools = DB::table('pools')
            ->select('pools.id','pools.perBetAmount')
            ->leftJoin('pool_match', 'pools.id', '=', 'pool_match.pool_id')                   
            ->where('pool_match.match_id',$match_id)
            //->whereIn('pools.status',['Active'])
            ->get();

            if(!empty($pools))
            {
                foreach($pools as $pool)
                {
                    $pool_id = $pool->id;
                    $perBetAmount = $pool->perBetAmount;



                     $mega_jackpot_round_exist_1 = DB::table('mega_jackpot_round')                
                    ->where('pool_1_id',$pool_id)                 
                     ->count();
                      if($mega_jackpot_round_exist_1 > 0)
                     {
                         $mega_jackpot_round_update= DB::table('mega_jackpot_round')                
                        ->where('pool_1_id',$pool_id)                 
                         ->first();
                         $mega_jackpot_round_update->pool_1_status='Finished';
                         $mega_jackpot_round_update->save();
                     }

                      $mega_jackpot_round_exist_2 = DB::table('mega_jackpot_round')                
                    ->where('pool_2_id',$pool_id)                 
                     ->count();
                      if($mega_jackpot_round_exist_2 > 0)
                     {
                         $mega_jackpot_round_update= DB::table('mega_jackpot_round')                
                        ->where('pool_2_id',$pool_id)                 
                         ->first();
                         $mega_jackpot_round_update->pool_2_status='Finished';
                         $mega_jackpot_round_update->save();
                     }

                      $mega_jackpot_round_exist_3 = DB::table('mega_jackpot_round')                
                    ->where('pool_3_id',$pool_id)                 
                     ->count();
                      if($mega_jackpot_round_exist_3 > 0)
                     {
                         $mega_jackpot_round_update= DB::table('mega_jackpot_round')                
                        ->where('pool_3_id',$pool_id)                 
                         ->first();
                         $mega_jackpot_round_update->pool_3_status='Finished';
                         $mega_jackpot_round_update->save();
                     }


                    $this->recalculatePoolResultByPoolId($pool_id,$perBetAmount);
                    $this->recalculateMegaJackpotResultByPoolId($pool_id);
                }
            }
            

     }

      public function recalculateMegaJackpotResultByPoolId($pool_id){
        if(Megajackpot::where('status','Active')->count() > 0)
        {
             $megajackpot = Megajackpot::where('status','Active')->first();
             $mega_jackpot_id = $megajackpot->id;

           

           $isapplicablecount =   DB::table("mega_jackpot_round")
            ->whereRaw('is_running=1 and pool_1_status="Finished" and pool_2_status="Finished" and pool_3_status="Finished" and (pool_1_id="'.$pool_id.'"  or pool_2_id="'.$pool_id.'"  or pool_3_id="'.$pool_id.'" ) ')
            ->count();
            if($isapplicablecount > 0)
            {
                 $isapplicableexist =   DB::table("mega_jackpot_round")
                ->whereRaw('is_running=1 and pool_1_status="Finished" and pool_2_status="Finished" and pool_3_status="Finished" ')
                ->first();
                $pool_1_id = $isapplicableexist->pool_1_id;
                $pool_2_id = $isapplicableexist->pool_2_id;
                $pool_3_id = $isapplicableexist->pool_3_id;

                $group_1_result = Bet::select('user_id')->where(['pool_id'=>$pool_1_id,'losswinType'=>'Win','isGroup1'=>'1'])->get();
                $group_1_array=[];
                if(!empty($group_1_result))
                {
                    foreach($group_1_result as $group_1)
                    {
                        $group_1_array[]=$group_1->user_id;
                    }
                }

                $group_2_result = Bet::select('user_id')->where(['pool_id'=>$pool_2_id,'losswinType'=>'Win','isGroup2'=>'1'])->get();
                $group_2_array=[];
                if(!empty($group_2_result))
                {
                    foreach($group_2_result as $group_2)
                    {
                        $group_2_array[]=$group_2->user_id;
                    }
                }

                $group_3_result = Bet::select('user_id')->where(['pool_id'=>$pool_3_id,'losswinType'=>'Win','isGroup3'=>'1'])->get();
                $group_3_array=[];
                if(!empty($group_3_result))
                {
                    foreach($group_3_result as $group_3)
                    {
                        $group_3_array[]=$group_3->user_id;
                    }
                }

                sort($group_1_array);
                sort($group_2_array);
                sort($group_3_array);

                $final_winner_array=[];

                $ar1 = $group_1_array;
                $ar2 = $group_2_array;
                $ar3 = $group_3_array;

                $n1 = count($ar1); 
                $n2 = count($ar2); 
                $n3 = count($ar3); 

                 $i = 0; $j = 0; $k = 0; 
  
                    // Iterate through three arrays while 
                    // all arrays have elements 
                    while ($i < $n1 && $j < $n2 && $k < $n3) 
                    { 
                          
                        // If x = y and y = z, print any 
                        // of them and move ahead in all  
                        // arrays 
                        if ($ar1[$i] == $ar2[$j] &&   $ar2[$j] == $ar3[$k]) 
                        { 
                            $final_winner_array[]= $ar1[$i] ; 
                            $i++; 
                            $j++; 
                            $k++;  
                        } 
                  
                        // x < y 
                        else if ($ar1[$i] < $ar2[$j]) 
                            $i++; 
                  
                        // y < z 
                        else if ($ar2[$j] < $ar3[$k]) 
                            $j++; 
                  
                        // We reach here when x > y and 
                        // z < y, i.e., z is smallest 
                        else
                            $k++; 
                    } 

                    if(count($final_winner_array) > 0)
                    {
                        //winner
                        $megajackpot->status='Finished';
                        $megajackpot->winner_user_ids=implode(',',$final_winner_array);
                        $megajackpot->endTime=date('Y-m-d H:i:s');
                        $megajackpot->save();

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
                    else
                    {
                        //no winner
                    }

                $isapplicableexist->is_running=2;
                $isapplicableexist->save();



            }


         }

      }

      public function recalculatePoolResultByPoolId($pool_id,$perBetAmount){

        



        DB::table('pools')
            ->where('id',$pool_id)
            ->update([
                'status' => 'Calculating'
             ]);

       

        // for every match of this pool status should be Void / Finished
         $matchs = DB::table('pool_match')
            ->leftJoin('match', 'match.id', '=', 'pool_match.match_id')
            ->select('match.status')
            ->orderBy('match.id','asc')
            ->where('pool_match.pool_id',$pool_id)               
            ->get();

            $allmatchresultneeupdate = 0;

            $no_of_matches_of_pool = 0;
           
            
            if(!empty($matchs))
            {
                foreach($matchs as $match)
                {
                    
                    $no_of_matches_of_pool++;
                   
                    $match_status = $match->status;

                    if(($match_status=='Void') || ($match_status=='Finished'))
                    {
                        // this match result is updated

                       
                    }
                    else
                    {
                       

                        $allmatchresultneeupdate++;
                    }

                }
            }

            if($allmatchresultneeupdate==0)
            {
                //pool / jackpot results to calculate

                //A

               

                $bets_A = DB::table('bets')
                    ->select('id')
                    ->orderBy('id','asc')
                    ->where('pool_id',$pool_id)               
                    ->get();

                    if(!empty($bets_A))
                    {
                        foreach($bets_A as $bet)
                        {                           
                            $bet_id = $bet->id;

                             $total_win = DB::table('bet_details')                   
                            ->where('bet_id',$bet_id)
                            ->where('pool_id',$pool_id)
                            ->where('result','win')
                            ->count();

                            DB::table('bets')
                                ->where('id',$bet_id)
                                ->update(['total_win' => $total_win]);

                        }
                    }

                //B

                   
                     $bets_B = DB::table('bets')
                    ->select('total_win')
                    ->orderBy('total_win','desc')
                    ->where('pool_id',$pool_id)               
                    ->get();

                    $total_win_array = [];

                    if(!empty($bets_B))
                    {
                        foreach($bets_B as $bet)
                        {  
                            $total_win = $bet->total_win;
                            if(!in_array($total_win,$total_win_array))
                            {
                                 
                                $total_win_array[]=$total_win;
                            }

                        }
                    }

                    
                    


                  
                    $group1maxwin = 0;
                    $group2maxwin = 0;
                    $group3maxwin = 0;
                    if(count($total_win_array) >= 3)
                    {
                        

                        $group1maxwin = $total_win_array[0];
                        $group2maxwin = $total_win_array[1];
                        $group3maxwin = $total_win_array[2];

                        
                    }
                    else if(count($total_win_array) == 2)
                    {
                       

                        $group1maxwin = $total_win_array[0];
                        $group2maxwin = $total_win_array[1];
                        $group3maxwin = $no_of_matches_of_pool;

                        
                    }
                    else if(count($total_win_array) == 1)
                    {
                        

                        $group1maxwin = $total_win_array[0];
                        $group2maxwin = $no_of_matches_of_pool;
                        $group3maxwin = $no_of_matches_of_pool;

                        

                    }
                     else 
                    {
                         

                        $group1maxwin = $no_of_matches_of_pool;
                        $group2maxwin = $no_of_matches_of_pool;
                        $group3maxwin = $no_of_matches_of_pool;

                       
                    }

                   

                //C
                     $bets_C = DB::table('bets')
                    ->select('total_win','id')
                    ->orderBy('id','asc')
                    ->where('pool_id',$pool_id)               
                    ->get();

                   

                    if(!empty($bets_C))
                    {
                        foreach($bets_C as $bet)
                        {

                       

                            $isGroup1=0;
                            $isGroup2=0;
                            $isGroup3=0;
                            $losswinType='Loss';

                            $bet_id = $bet->id;
                            $total_win = $bet->total_win;

                            if($total_win==$group1maxwin)
                            {
                                $isGroup1=1;
                                $losswinType='Win';
                            }
                            else if($total_win==$group2maxwin)
                            {
                                $isGroup2=1;
                                $losswinType='Win';
                            }
                            else if($total_win==$group3maxwin)
                            {
                                $isGroup3=1;
                                $losswinType='Win';
                            }

                            if($losswinType=='Win')
                            {

                                

                             

                                     $query5 = "UPDATE `bets` SET 
                                      `isGroup1` = '".$isGroup1."'
                                     ,`isGroup2` = '".$isGroup2."'
                                     ,`isGroup3` = '".$isGroup3."'
                                     ,`losswinType` = '".$losswinType."'
                                     ,`losswinValue` = '".$perBetAmount."'
                                    

                                      where `id` = '".$bet_id."' ";
                                       

                                    DB::statement($query5);                                


                                   
                            }
                            else 
                            {
                                 $query6 = "UPDATE `bets` SET 
                                      
                                     `losswinType` = '".$losswinType."'
                                     ,`losswinValue` = '".$perBetAmount."'
                                    

                                      where `id` = '".$bet_id."' ";
                                       

                                    DB::statement($query6);
                            }

                        }
                    }

                //D

                   

                                     
                
                    $group1TotalPlayer = DB::table("bets")->where('pool_id', '=',$pool_id)->where('isGroup1', '=','1')->count();

                    $group2TotalPlayer = DB::table("bets")->where('pool_id', '=',$pool_id)->where('isGroup2', '=','1')->count();

                    $group3TotalPlayer = DB::table("bets")->where('pool_id', '=',$pool_id)->where('isGroup3', '=','1')->count();

                  
                  
                    

                       

                     DB::table('pools')
                                ->where('id',$pool_id)
                                ->update([
                                    'group1TotalPlayer' => $group1TotalPlayer,
                                    'group2TotalPlayer' => $group2TotalPlayer,
                                    'group3TotalPlayer' => $group3TotalPlayer
                                 ]);


                   

                //E
                        
                        
                        
                        


                        $pool_E = DB::table('pools')
                        ->select('group1TotalPrize','group2TotalPrize','group3TotalPrize','basePrice','group1Percentage','group2Percentage','group3Percentage')
                         ->where('id',$pool_id)
                        ->get();
                        $group1TotalPrize = $pool_E[0]->group1TotalPrize;
                        $group2TotalPrize = $pool_E[0]->group2TotalPrize;
                        $group3TotalPrize = $pool_E[0]->group3TotalPrize;

                        $thisbasePrice = $pool_E[0]->basePrice;
                        $thisgroup1Percentage = $pool_E[0]->group1Percentage;
                        $thisgroup2Percentage = $pool_E[0]->group2Percentage;
                        $thisgroup3Percentage = $pool_E[0]->group3Percentage;

                        $group1baseprice = ($thisbasePrice * $thisgroup1Percentage)/100;
                        $group1TotalPrize = $group1TotalPrize + $group1baseprice;

                         $group2baseprice = ($thisbasePrice * $thisgroup2Percentage)/100;
                        $group2TotalPrize = $group2TotalPrize + $group2baseprice;

                         $group3baseprice = ($thisbasePrice * $thisgroup3Percentage)/100;
                        $group3TotalPrize = $group3TotalPrize + $group3baseprice;


                        $group1winValue = 0;
                        $group2winValue = 0;
                        $group3winValue = 0;

                        if($group1TotalPlayer > 0)
                        {
                            $group1winValue = $group1TotalPrize / $group1TotalPlayer;
                        }

                        if($group2TotalPlayer > 0)
                        {
                            $group2winValue = $group2TotalPrize / $group2TotalPlayer;
                        }

                        if($group3TotalPlayer > 0)
                        {
                            $group3winValue = $group3TotalPrize / $group3TotalPlayer;
                        }

                       /*
                        $description='just insert = 17';
                        DB::table('testing')->insert(
                            [ 'description'=>$description]
                        );
                        */

                //F

                        DB::table('bets')
                                ->where('pool_id',$pool_id)
                                ->where('isGroup1', '=','1')
                                ->update([
                                    'losswinValue' => $group1winValue
                                 ]);

                        


                        DB::table('bets')
                                ->where('pool_id',$pool_id)
                                ->where('isGroup2', '=','1')
                                ->update([
                                    'losswinValue' => $group2winValue
                                 ]);
                        DB::table('bets')
                                ->where('pool_id',$pool_id)
                                ->where('isGroup3', '=','1')
                                ->update([
                                    'losswinValue' => $group3winValue
                                 ]);

                //G

                       


                                DB::table('pools')
                                ->where('id',$pool_id)
                                ->update([
                                    'status' => 'Finished',
                                    'currentStatus' => 'Finished'
                                 ]);

                       
               

            }
            /* calculate for mega jackpot winner */


      }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Match  $match
     * @return \Illuminate\Http\Response
     */
    
    public function destroy($id){
       
        $match = DB::table('match')->where('id',$id);
        
         $dataexist = DB::table('pool_match')
             ->where('match_id',$id)
            ->count();
        if($dataexist > 0)
        {
            return json_encode(array('status'=>'notok','message'=>'You can\'t delete this match, because it is already with Jackpot / Pool'));
        }
        else
        {
            if($match)
            {
                $match->delete();
            }
                 
            return json_encode(array('status'=>'ok','message'=>'Successfully deleted !'));
        }


        
    }
}
