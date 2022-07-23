<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use App\Models\Megajackpot;
use App\Models\Megajackpotdetails;

class MegajackpotController extends Controller
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

           $mega_jackpot_history = Megajackpot::orderBy('id','desc')->get();



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


       

        return view('/content/apps/megajackpots/app-megajackpots-list',['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access,'mega_jackpot_id'=>$mega_jackpot_id,'mega_jackpot_basePrize'=>$mega_jackpot_basePrize,'mega_jackpot_accumulatedPrize'=>$mega_jackpot_accumulatedPrize,'mega_jackpot_round'=>$mega_jackpot_round,'pool_1_details'=>$pool_1_details,'pool_2_details'=>$pool_2_details,'pool_3_details'=>$pool_3_details,'pooldetails'=>$pooldetails,'mega_jackpot_history'=>$mega_jackpot_history]);
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

        $data = DB::table('mega_jackpot_details')
            //->select('pools.*','mega_jackpot.name as mega_jackpot_name')
             ->select('pools.*','mega_jackpot.name as mega_jackpot_name','mega_jackpot_round.round_title')           
            ->leftJoin('pools', 'pools.id', '=', 'mega_jackpot_details.pool_id')
            ->leftJoin('mega_jackpot', 'mega_jackpot.id', '=', 'mega_jackpot_details.mega_jackpot_id')
            //->leftJoin('mega_jackpot_round as mjr_1', 'mjr_1.pool_1_id', '=', 'pools.id')
            //->leftJoin('mega_jackpot_round as mjr_2', 'mjr_1.pool_2_id', '=', 'pools.id')
            //->leftJoin('mega_jackpot_round as mjr_3', 'mjr_1.pool_3_id', '=', 'pools.id')
            ->leftJoin('mega_jackpot_round', function ($join) {
                $join->on('mega_jackpot_round.pool_1_id', '=', 'mega_jackpot_details.pool_id')->orOn('mega_jackpot_round.pool_2_id', '=', 'mega_jackpot_details.pool_id')->orOn('mega_jackpot_round.pool_3_id', '=', 'mega_jackpot_details.pool_id');
            })
            ->offset($offset)
            ->limit($limit)
            ->get();

           
            $totalcount = DB::table('mega_jackpot_details')
            ->select('mega_jackpot_details.*')
            //->leftJoin('leagues', 'leagues.id', '=', 'match.league')
            //->leftJoin('tims as t1', 't1.id', '=', 'match.homeTeam')
            //->leftJoin('tims as t2', 't2.id', '=', 'match.awayTeam')          
            ->count();

           $links = $this->handle_pagination($totalcount, ($page_no-1), $this->per_page, url('/megajackpots?page='));
           $page_link = array('links'=>$links,'offset'=>$offset,'totalcount'=>$totalcount);
           
        return json_decode(json_encode(array('per_page'=>$per_page,'offset'=>$offset,'totalcount'=>$totalcount,'page_links'=>$links,'data'=>$data,'page_no'=>$page_no)));
        
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
