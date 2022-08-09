<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Deposit;
use App\Models\Withdraw;
use App\Models\Credit;
use Validator;
use Auth;
use DB;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

use Illuminate\Support\Facades\Hash;

use Carbon\Carbon;

class MemberController extends Controller
{
    public $per_page;
    public function __construct() {
        $this->per_page = 10;
      }

     /**
     * Display a listing of the details.
     *
     * @return \Illuminate\Http\Response
     */
    public function details_list()
    { 
         $custom_permission_controller = new CustomPermissionController;
        $custom_permission_access = $custom_permission_controller->custom_permission('member.details.list');
        if(!$custom_permission_access)
        {
            abort(401,'Not authorised');
        }

        
        $custom_get_all_permissions_access = $custom_permission_controller->custom_get_all_permissions();


        $pageConfigs = ['pageHeader' => false];  
        //return view('/comming-soon',['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access]);

        $agents = User::where('user_type','agent')->Where('status',1)->orderBy('unique_id','asc')->get();

        
       $data = User::where('users.user_type','user')->leftJoin('users as agent','users.agent_id', '=', 'agent.id')->select('users.*','agent.unique_id as agent_unique_id' )->orderBy('users.id','desc')->paginate($this->per_page);

         return view('/content/apps/member/app-details-list',['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access,'data'=>$data,'agents'=>$agents]);
    }

    public function agent_memberlist(Request $request)
    { 
        $user_id =  Auth::user()->id;
       // echo $user_unique_id;
       // die();

        $pageConfigs = ['pageHeader' => false];  
        $round_1 = DB::table('users');
       
        $round_1=$round_1->where('agent_id',$user_id);

        $round_1=$round_1->when($request->has("daterange"),function($q)use($request)
        {
       
           //$daterange = $request->daterange;
           $daterange  = $request->get("daterange");
           if($daterange!='')
           {
               $daterangearray = explode(' to ',$daterange);
               if(count($daterangearray)==2){
                   $start_date = $daterangearray[0];
                    $end_date = $daterangearray[1];

                   

                    $start_date = $start_date.' 00:00:00';
                    $end_date = $end_date.' 23:59:59';

                  

                   return $q->where('users.created_at', '>=', $start_date)->where('users.created_at', '<=', $end_date);

               }
               else if((count($daterangearray)==1) || (count($daterangearray)==0))
               {
                    $start_date = $daterange;
                    $end_date = $daterange;

                  

                    $start_date = $start_date.' 00:00:00';
                    $end_date = $end_date.' 23:59:59';

                  
                    return $q->where('users.created_at', '>=', $start_date)->where('users.created_at', '<=', $end_date);

               }
                
           }
            

       });

      

       $round_1=$round_1->when($request->has("name"),function($q)use($request)
       {   
            $name  = $request->get("name");       
            return $q->where('users.name','LIKE','%'.$name.'%');        
           
       });
       $round_1 = $round_1->get();
     
       

       $final_array = [];

            
       if(!empty($round_1))
       {
          
           foreach($round_1 as $round_1_results)
           {

               $final_array[]=array(
               'id'=>$round_1_results->id
               ,'created_at'=>$round_1_results->created_at
                ,'name'=>$round_1_results->name
               ,'email'=>$round_1_results->email
               ,'unique_id'=>$round_1_results->unique_id
                           
            
            );
  

           }
       }

       //echo "<pre>";
       //print_r($final_array);

       $data = $this->paginate_memberlist($final_array);
       if($request->ajax()){
            return view('/content/apps/agent/agent_memberlist-pagination', compact('pageConfigs','data'));
        } 
        return view('/content/apps/agent/agent_memberlist', compact('pageConfigs','data'));

        
    }
    public function agent_commissionlist(Request $request)
    {  
    $pageConfigs = ['pageHeader' => false];     
        $user_id =  Auth::user()->id;

        $round_2 = DB::table('users');
         $members=$round_2->where(['agent_id'=>$user_id])->get();

        $round_1 = DB::table('bets');
          $round_1 = $round_1
            ->leftJoin('users as u1', 'bets.user_id', '=', 'u1.id')
            ->leftJoin('users as u2', 'u1.agent_id', '=', 'u2.id');
        
         $round_1=$round_1->when($request->has("name"),function($q)use($request)
        {
       
           //$daterange = $request->daterange;
           $name  = $request->get("name");
           if($name!='')
           {
               return $q->where('u1.name', 'like', "%".$name."%");
           }
       });

         
        $round_1=$round_1->when($request->has("member_id"),function($q)use($request)
        {
       
           //$daterange = $request->daterange;
           $member_id  = $request->get("member_id");
           if($member_id > 0)
           {
               return $q->where('u1.unique_id', $member_id);
           }
       });

        
               
        $round_1=$round_1->when($request->has("daterange"),function($q)use($request)
        {
       
           //$daterange = $request->daterange;
           $daterange  = $request->get("daterange");
           if($daterange!='')
           {
               $daterangearray = explode(' to ',$daterange);
               if(count($daterangearray)==2){
                   $start_date = $daterangearray[0];
                    $end_date = $daterangearray[1];

                   

                    $start_date = $start_date.' 00:00:00';
                    $end_date = $end_date.' 23:59:59';

                  

                   return $q->where('bets.created_at', '>=', $start_date)->where('bets.created_at', '<=', $end_date);

               }
               else if((count($daterangearray)==1) || (count($daterangearray)==0))
               {
                    $start_date = $daterange;
                    $end_date = $daterange;

                  

                    $start_date = $start_date.' 00:00:00';
                    $end_date = $end_date.' 23:59:59';

                  
                    return $q->where('bets.created_at', '>=', $start_date)->where('bets.created_at', '<=', $end_date);

               }
                
           }
            

       });

         $round_1 = $round_1->where('u1.agent_id', $user_id);
        
            
           $data7 = $round_1->select(DB::raw('DATE_FORMAT(bets.created_at, "%Y-%m-%d") as date'),'bets.user_id','bets.bet_amount','u1.unique_id as player_unique_id','u2.unique_id as agent_unique_id','u2.commission_percentage','u1.unique_id as member_id','u1.name as member_name')        
            ->get();

            //toSql
            //get

            //echo "<pre>";
            //print_r($data7);
            //die();

             $thearray = [];
             if(count($data7) > 0)                
             {
                foreach($data7 as $k2=>$v2)
                {
                   
                        
                            $thearray[]=array('individualAgentId'=>$v2->agent_unique_id
                                ,'date'=>$v2->date
                                 ,'todaybetAmount'=>$v2->bet_amount
                                 ,'percentage'=>$v2->commission_percentage
                                 ,'user_id'=>$v2->user_id 
                                  ,'member_id'=>$v2->member_id 
                                   ,'member_name'=>$v2->member_name  

                                                               
                                  ,'commission'=>(($v2->bet_amount * $v2->commission_percentage) / 100)
                            );
                            
                }
             }
              $data = $this->paginate_commissionlist($thearray);
           if($request->ajax()){
                return view('/content/apps/agent/agent_commissionlist-pagination', compact('pageConfigs','data','members'));
            } 
            return view('/content/apps/agent/agent_commissionlist', compact('pageConfigs','data','members'));

    }

    
     public function agent_settlementlist_get(Request $request)
    { 
         $pageConfigs = ['pageHeader' => false];     
        $user_id =  Auth::user()->id;
         $from_date  = $request->get("from_date");
         $to_date  = $request->get("to_date");

         $self_details = DB::table('users');
         $self_details=$self_details->where(['id'=>$user_id])->first();

        $round_1 = DB::table('bets');
        $round_1 = $round_1
        ->leftJoin('users as u1', 'bets.user_id', '=', 'u1.id')
        ->leftJoin('users as u2', 'u1.agent_id', '=', 'u2.id');

        $from_date_t = $from_date.' 00:00:00';
        $to_date_t = $to_date.' 23:59:59';

   $round_1 = $round_1->where('bets.created_at', '>=', $from_date_t)->where('bets.created_at', '<=', $to_date_t);
   $round_1 = $round_1->where('u1.agent_id', $user_id);

    $data7 = $round_1->select(DB::raw('sum(bets.bet_amount) as total_bet','u2.commission_percentage as commission_percentage')) ;   

    $total_bet_amount='';
    $commission_percentage=0;
    $total_commission=0;
    if($data7->count() > 0)
    {
        $total_bet_amount = $data7->first()->total_bet;
        $commission_percentage=$self_details->commission_percentage;
        $total_commission = (($total_bet_amount * $commission_percentage)/100);

    }    
            

            //toSql
            //get

        $output_array = array('user_id'=>$user_id,'from_date'=>$from_date,'to_date'=>$to_date,'total_bet_amount'=>$total_bet_amount,'total_commission'=>$total_commission,'commission_percentage'=>$self_details->commission_percentage);
        return response()->json($output_array);

    }

    
     public function agent_settlement_save(Request $request)
    { 
         $pageConfigs = ['pageHeader' => false];     
        $user_id =  Auth::user()->id;
        //echo "<pre>";
        //echo $user_id;
        //echo "<br><br>";
        //print_r($_POST);
        $insert_data=array(
            'user_id'=>$user_id
            ,'from_date'=>$_POST['from_date']
            ,'to_date'=>$_POST['to_date']
            ,'total_commission'=>$_POST['total_commission']
            ,'agent_comments'=>$_POST['agent_comments']
            ,'agent_apply_date'=>date('Y-m-d H:i:s')
            ,'agent_status'=>'Submit'
    );
        DB::table('agent_settlements')->insert($insert_data);
        return redirect()->route('settlementlist')->with('success','Successfully saved');


    }

    
     public function settlement_details(Request $request,$id)
    { 
         $pageConfigs = ['pageHeader' => false];  
         $data = DB::table('agent_settlements')->where('id',$id)->first(); 

          return json_encode(array('status'=>'ok','data'=>$data));

     }


    public function settlement_delete(Request $request,$id)
    { 
         $pageConfigs = ['pageHeader' => false];  
         $data = DB::table('agent_settlements')->where('id',$id)->delete(); 
        
          return json_encode(array('status'=>'ok'));

     }


    public function agent_settlementlist(Request $request)
    { 
         $pageConfigs = ['pageHeader' => false];     
        $user_id =  Auth::user()->id;
        $pending_status=false;

        $round_2 = DB::table('agent_settlements');
         $to_date_set_result=$round_2->where(['user_id'=>$user_id])->whereIn('company_status',['Pending','Approved'])->orderBy('to_date','desc');
         if($to_date_set_result->count()==0)
         {
            $to_date_set='2022-01-01';
         }
         else
         {

            $to_date=$to_date_set_result->first()->to_date;
            $to_date_set_q = Carbon::createFromFormat('Y-m-d H:i:s', $to_date);
            $to_date_set_q->addDays(1);
            $to_date_set_q_a = explode(' ',$to_date_set_q);
            $to_date_set = $to_date_set_q_a[0];
         }

          $round_3 = DB::table('agent_settlements');
         $to_date_set_result_3=$round_3->where(['user_id'=>$user_id])->whereIn('company_status',['Pending'])->orderBy('to_date','desc');
         if($to_date_set_result_3->count()==0)
         {
            
         }
         else
         {
            $pending_status=true;

         }

         $round_1 = DB::table('agent_settlements');
         
        
       

        
               
        $round_1=$round_1->when($request->has("daterange"),function($q)use($request)
        {
       
           //$daterange = $request->daterange;
           $daterange  = $request->get("daterange");
           if($daterange!='')
           {
               $daterangearray = explode(' to ',$daterange);
               if(count($daterangearray)==2){
                   $start_date = $daterangearray[0];
                    $end_date = $daterangearray[1];

                   

                    $start_date = $start_date.' 00:00:00';
                    $end_date = $end_date.' 23:59:59';

                  

                   return $q->where('from_date', '>=', $start_date)->where('to_date', '<=', $end_date);

               }
               else if((count($daterangearray)==1) || (count($daterangearray)==0))
               {
                    $start_date = $daterange;
                    $end_date = $daterange;

                  

                    $start_date = $start_date.' 00:00:00';
                    $end_date = $end_date.' 23:59:59';

                  
                    return $q->where('from_date', '>=', $start_date)->where('to_date', '<=', $end_date);

               }
                
           }
            

       });

         $round_1 = $round_1->where('user_id', $user_id);
        
            
           $data7 = $round_1->orderBy('id','desc')        
            ->get();

            //toSql
            //get

            //echo "<pre>";
            //print_r($data7);
            //die();

             $thearray = [];
             if(count($data7) > 0)                
             {
                foreach($data7 as $k2=>$v2)
                {
                   
                        
                            $thearray[]=array('from_date'=>$v2->from_date
                                ,'to_date'=>$v2->to_date
                                ,'id'=>$v2->id
                                 ,'total_commission'=>$v2->total_commission
                                 ,'settlement_amount'=>$v2->settlement_amount
                                 ,'agent_comments'=>$v2->agent_comments 
                                  ,'company_comments'=>$v2->company_comments 
                                   ,'company_status'=>$v2->company_status  
                                   ,'agent_apply_date'=>$v2->agent_apply_date  
                                   ,'company_action_date'=>$v2->company_action_date  

                                                               
                                  
                            );
                            
                }
             }

           $data = $this->paginate_settlementlist($thearray);
           if($request->ajax()){
                return view('/content/apps/agent/agent_settlementlist-pagination', compact('pageConfigs','data','to_date_set','pending_status'));
            } 
            return view('/content/apps/agent/agent_settlementlist', compact('pageConfigs','data','to_date_set','pending_status'));
    }
    public function paginate_memberlist($items, $perPage = 10, $page = null, $options = [])
    {
        $options = ['path' => Route('memberlist')] ;

        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    } 
    public function paginate_commissionlist($items, $perPage = 5, $page = null, $options = [])
    {
        $options = ['path' => Route('commissionlist')] ;

        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    } 
    public function paginate_settlementlist($items, $perPage = 1, $page = null, $options = [])
    {
        $options = ['path' => Route('settlementlist')] ;

        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    } 
    public function details_data_list(Request $request)
    {
     if($request->ajax())
     {
          $custom_permission_controller = new CustomPermissionController;
        $custom_permission_access = $custom_permission_controller->custom_permission('member.details.list');
        if(!$custom_permission_access)
        {
            abort(401,'Not authorised');
        }

        
        $custom_get_all_permissions_access = $custom_permission_controller->custom_get_all_permissions();


        $pageConfigs = ['pageHeader' => false];  
        $agent_id = $request->agent_id;
        $daterange = $request->daterange;

        


        $agents = User::where('user_type','agent')->Where('status',1)->orderBy('unique_id','asc')->get();

       $data = User::where('users.user_type','user');

       
        if($agent_id > 0)
        {
             $data = $data->where('users.agent_id',$agent_id);
        }
        if($daterange !='')
        {
             $daterangearray = explode(' to ',$daterange);
             $start_date = $daterangearray[0];
             $end_date = $daterangearray[1];

             $start_date = $start_date.' 00:00:00';
             $end_date = $end_date.' 23:59:59';

            $data = $data->where('users.created_at', '>=', $start_date);
            $data = $data->where('users.created_at', '<=', $end_date);
        }
        $data = $data->leftJoin('users as agent','users.agent_id', '=', 'agent.id')->select('users.*','agent.unique_id as agent_unique_id' )->orderBy('users.id','desc')->paginate($this->per_page);

      return view('/content/apps/member/app-details-list-data', ['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access,'data'=>$data])->render();
     }
    }

    

    public function details_add()
    { 
         $custom_permission_controller = new CustomPermissionController;
        $custom_permission_access = $custom_permission_controller->custom_permission('member.details.create');
        if(!$custom_permission_access)
        {
            abort(401,'Not authorised');
        }

        
        $custom_get_all_permissions_access = $custom_permission_controller->custom_get_all_permissions();


        $pageConfigs = ['pageHeader' => false];  
        //return view('/comming-soon',['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access]);

        
        $agents = User::where('user_type','agent')->Where('status',1)->orderBy('unique_id','asc')->get();

         return view('/content/apps/member/app-details-add',['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access,'agents'=>$agents]);
    }
    public function details_edit($id)
    { 
         $custom_permission_controller = new CustomPermissionController;
        $custom_permission_access = $custom_permission_controller->custom_permission('member.details.edit');
        if(!$custom_permission_access)
        {
            abort(401,'Not authorised');
        }

        
        $custom_get_all_permissions_access = $custom_permission_controller->custom_get_all_permissions();


        $pageConfigs = ['pageHeader' => false];  
        //return view('/comming-soon',['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access]);

        
        $data = User::where('id',$id)->first();

         $agents = User::where('user_type','agent')->Where('status',1)->orderBy('unique_id','asc')->get();

         $data_credits = Credit::where('user_id',$id)->orderBy('id','desc')->paginate($this->per_page);

         return view('/content/apps/member/app-details-edit',['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access,'data'=>$data,'agents'=>$agents,'data_credits'=>$data_credits]);
    }


     public function details_edit_data_list(Request $request)
        {
         $id = $request->user_id;
         if($request->ajax())
         {
             $custom_permission_controller = new CustomPermissionController;
            $custom_permission_access = $custom_permission_controller->custom_permission('member.details.edit');
            if(!$custom_permission_access)
            {
                abort(401,'Not authorised');
            }

            
            $custom_get_all_permissions_access = $custom_permission_controller->custom_get_all_permissions();


            $pageConfigs = ['pageHeader' => false]; 
             $data_credits = Credit::where('user_id',$id)->orderBy('id','desc')->paginate($this->per_page);

              return view('/content/apps/member/app-details-edit-list-data', ['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access,'data_credits'=>$data_credits])->render();

         }
     }


     public function details_adjustcreditlog_list_data(Request $request)
        {
        
         if($request->ajax())
         {
             $custom_permission_controller = new CustomPermissionController;
            $custom_permission_access = $custom_permission_controller->custom_permission('member.adjust_credit.list');
            if(!$custom_permission_access)
            {
                abort(401,'Not authorised');
            }

            
            $custom_get_all_permissions_access = $custom_permission_controller->custom_get_all_permissions();


            $pageConfigs = ['pageHeader' => false]; 
            // $data_credits = Credit::where('reference_by','Company')->orderBy('id','desc')->paginate($this->per_page);

              $data_credits = Credit::where('credits.reference_by','Company')->leftJoin('users as player','credits.user_id', '=', 'player.id')->leftJoin('users as agent','player.agent_id', '=', 'agent.id')->leftJoin('users as admin','credits.createdBy', '=', 'admin.id')->select('credits.*','player.unique_id as player_unique_id','agent.unique_id as agent_unique_id','admin.name as admin_name')->orderBy('credits.id','desc')->paginate($this->per_page);

              return view('/content/apps/member/app-details-adjustcredit-list-data', ['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access,'data_credits'=>$data_credits])->render();

         }
     }
    
    public function winloss_list()
    { 
         $custom_permission_controller = new CustomPermissionController;
        $custom_permission_access = $custom_permission_controller->custom_permission('member.winloss.list');
        if(!$custom_permission_access)
        {
            abort(401,'Not authorised');
        }

        
        $custom_get_all_permissions_access = $custom_permission_controller->custom_get_all_permissions();


        $pageConfigs = ['pageHeader' => false];  
        //return view('/comming-soon',['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access]);
        return view('/content/apps/member/app-winloss-list',['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access]);
    }

    public function winloss_details_list(Request $request)
    { 
         $custom_permission_controller = new CustomPermissionController;
        $custom_permission_access = $custom_permission_controller->custom_permission('member.winloss.list');
        if(!$custom_permission_access)
        {
            abort(401,'Not authorised');
        }

        
        $custom_get_all_permissions_access = $custom_permission_controller->custom_get_all_permissions();


        $pageConfigs = ['pageHeader' => false];  
        
        //echo $request->id;
        return view('/content/apps/member/app-winloss-details-list',['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access]);
    }
    
    public function adjust_credit_list()
    { 
         $custom_permission_controller = new CustomPermissionController;
        $custom_permission_access = $custom_permission_controller->custom_permission('member.adjust_credit.list');
        if(!$custom_permission_access)
        {
            abort(401,'Not authorised');
        }

        
        $custom_get_all_permissions_access = $custom_permission_controller->custom_get_all_permissions();


        $pageConfigs = ['pageHeader' => false];  

        $data_credits = Credit::where('credits.reference_by','Company')->leftJoin('users as player','credits.user_id', '=', 'player.id')->leftJoin('users as agent','player.agent_id', '=', 'agent.id')->leftJoin('users as admin','credits.createdBy', '=', 'admin.id')->select('credits.*','player.unique_id as player_unique_id','agent.unique_id as agent_unique_id','admin.name as admin_name')->orderBy('credits.id','desc')->paginate($this->per_page);

        //return view('/comming-soon',['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access]);
        return view('/content/apps/member/app-adjustcredit',['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access,'data_credits'=>$data_credits]);
    }

    
    public function passwordchange(Request $request)
    {
        $user =  User:: where('id',$request->user_id)->first();
        $user->password = bcrypt($request->password);
        $user->save();        
        return json_encode(array('status'=>'ok','message'=>'Successfully changed!'));

    }

    
     public function basic_detailsupdate(Request $request)
    {
         //return json_encode(array('status'=>'ok','message'=>'Successfully updated Basic Details!','all'=>$request->all()));
        $user =  User:: where('id',$request->id)->first();
        $user->name = $request->name;
        $user->agent_id = $request->agent_id;
        $user->status = $request->status;
        $user->save();        
        return json_encode(array('status'=>'ok','message'=>'Successfully updated Basic Details!'));

    }

     public function basic_detailsadd(Request $request)
    {
        $v = Validator::make($request->all(),[
            'name' => 'required|string',
            'email'=>'required|string|unique:users',
            'password'=>'required|string',
            'password_confirmation' => 'required|same:password'
        ]);

         if ($v->fails())
         {
            return json_encode(array('status'=>'notok','message'=>'Provide proper details!'));
         }
         else 
         {
            $user_id = Auth::id();
            $unique_id = "P".rand(100000,999999);
             $user = new User([
                'name'  => $request->name,
                'email' => $request->email,
                'status' => $request->status,
                'agent_id' => $request->agent_id,
                'password' => bcrypt($request->password),
                 'unique_id'=>$unique_id,
                'createdBy'=>$user_id
            ]);
             if($user->save())
             {
                return json_encode(array('status'=>'ok','message'=>'Successfully added a new Player!'));
             }
             else 
             {
                 return json_encode(array('status'=>'notok','message'=>'Provide proper details!'));
             }

         }
        

    }

     public function bank_detailsupdate(Request $request)
    {
         //return json_encode(array('status'=>'ok','message'=>'Successfully updated Basic Details!','all'=>$request->all()));
        $user =  User:: where('id',$request->id)->first();
        $user->bank_account_name = $request->bank_account_name;
        $user->bank_country = $request->bank_country;
        $user->bank_name = $request->bank_name;
        $user->bank_account_number = $request->bank_account_number;
        $user->bank_account_type = $request->bank_account_type;
        $user->save();        
        return json_encode(array('status'=>'ok','message'=>'Successfully updated Bank Details!'));

    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $user =  User:: where('id',$id)->first();
        $user->delete();
        return json_encode(array('status'=>'ok','message'=>'Successfully Deleted!'));
    }

    
    public function directcredit(Request $request)
    {
        $responsedBy = Auth::id();
        $user_id = $request->user_id;
        $amount = $request->amount;
        $type = $request->type;
        $deposit_id = 999999;
        $withdraw_id = 999999;
        $status = 'Approved';

        $remarks = $request->remarks;
                
        

        if($type=='Deposit')
        {
            $user_2 =  User:: where('id',$user_id)->first();
            $credits = $user_2->credits;
            $final_credits = $amount + $credits;
            $user_2->credits = $final_credits;
            $user_2->save(); 

             $credit = new Credit([
                'user_id'  => $user_id,
                'before_deposit_withdraw_amount' => $credits,
                'amount' => $amount,
                'remarks' => $remarks,                
                'current_balance' => $final_credits,
                'type'=>'Deposit',
                'reference_by'=>'Company',
                'deposit_withdraw_id' => $deposit_id,               
                'createdBy'=>$responsedBy
            ]);
            $credit->save();
        }
        if($type=='Withdraw')
        {
             $user_2 =  User:: where('id',$user_id)->first();
            $credits = $user_2->credits;
            $final_credits =  $credits - $amount;
            if($final_credits >= 0)
            {

                

                    $user_2->credits = $final_credits;
                    $user_2->save(); 

                     $credit = new Credit([
                        'user_id'  => $user_id,
                        'before_deposit_withdraw_amount' => $credits,
                        'amount' => $amount,
                        'remarks' => $remarks,
                        'current_balance' => $final_credits,
                        'type'=>'Withdraw',
                        'reference_by'=>'Company',
                        'deposit_withdraw_id' => $withdraw_id,               
                        'createdBy'=>$responsedBy
                    ]);
                    $credit->save();
            }

        }
        return json_encode(array('status'=>'ok','message'=>'Successfully Approved '.$type.'!'));
    }

}
