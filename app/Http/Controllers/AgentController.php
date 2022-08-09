<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;

use Illuminate\Support\Facades\Hash;
use Validator;

use Illuminate\Http\Request;

use App\Http\Controllers\CustomPermissionController;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;


use App\Models\User;
use App\Models\Deposit;
use App\Models\Withdraw;
use App\Models\Credit;
use App\Models\Bet;

use Carbon\Carbon;
use Auth;
use DB;

class AgentController extends Controller
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
        $custom_permission_access = $custom_permission_controller->custom_permission('agent.details.list');
        if(!$custom_permission_access)
        {
            abort(401,'Not authorised');
        }

        
        $custom_get_all_permissions_access = $custom_permission_controller->custom_get_all_permissions();


        $pageConfigs = ['pageHeader' => false];  
        //return view('/comming-soon',['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access]);

               
       $data = User::where('users.user_type','agent')->select('users.*')->orderBy('users.id','desc')->paginate($this->per_page);

         return view('/content/apps/agent/app-details-list',['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access,'data'=>$data]);
    }

    
    public function details_data_list(Request $request)
    {
     if($request->ajax())
     {
          $custom_permission_controller = new CustomPermissionController;
        $custom_permission_access = $custom_permission_controller->custom_permission('agent.details.list');
        if(!$custom_permission_access)
        {
            abort(401,'Not authorised');
        }

        
        $custom_get_all_permissions_access = $custom_permission_controller->custom_get_all_permissions();


        $pageConfigs = ['pageHeader' => false];  
        $daterange = $request->daterange;

        


      
       $data = User::where('users.user_type','agent');

       
       
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
        $data = $data->select('users.*' )->orderBy('users.id','desc')->paginate($this->per_page);

      return view('/content/apps/agent/app-details-list-data', ['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access,'data'=>$data])->render();
     }
    }

    

    public function details_add()
    { 
         $custom_permission_controller = new CustomPermissionController;
        $custom_permission_access = $custom_permission_controller->custom_permission('agent.details.create');
        if(!$custom_permission_access)
        {
            abort(401,'Not authorised');
        }

        
        $custom_get_all_permissions_access = $custom_permission_controller->custom_get_all_permissions();


        $pageConfigs = ['pageHeader' => false];  
        //return view('/comming-soon',['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access]);

        
        
         return view('/content/apps/agent/app-details-add',['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access]);
    }
    public function details_edit($id)
    { 
         $custom_permission_controller = new CustomPermissionController;
        $custom_permission_access = $custom_permission_controller->custom_permission('agent.details.edit');
        if(!$custom_permission_access)
        {
            abort(401,'Not authorised');
        }

        
        $custom_get_all_permissions_access = $custom_permission_controller->custom_get_all_permissions();


        $pageConfigs = ['pageHeader' => false];  
        //return view('/comming-soon',['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access]);

        
        $data = User::where('id',$id)->first();

        
         $data_credits = Credit::where('user_id',$id)->orderBy('id','desc')->paginate($this->per_page);

         return view('/content/apps/agent/app-details-edit',['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access,'data'=>$data,'data_credits'=>$data_credits]);
    }


     public function details_edit_data_list(Request $request)
        {
         $id = $request->user_id;
         if($request->ajax())
         {
             $custom_permission_controller = new CustomPermissionController;
            $custom_permission_access = $custom_permission_controller->custom_permission('agent.details.edit');
            if(!$custom_permission_access)
            {
                abort(401,'Not authorised');
            }

            
            $custom_get_all_permissions_access = $custom_permission_controller->custom_get_all_permissions();


            $pageConfigs = ['pageHeader' => false]; 
             $data_credits = Credit::where('user_id',$id)->orderBy('id','desc')->paginate($this->per_page);

              return view('/content/apps/agent/app-details-edit-list-data', ['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access,'data_credits'=>$data_credits])->render();

         }
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
         $user->status = $request->status;
        $user->commission_percentage = $request->commission_percentage;
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
            $unique_id = "A".rand(100000,999999);
             $user = new User([
                'name'  => $request->name,
                'email' => $request->email,
                'status' => $request->status,
                'commission_percentage' => $request->commission_percentage,
                'unique_id'=>$unique_id,
                'user_type'=>'agent',
               
                'password' => bcrypt($request->password),
                'createdBy'=>$user_id
            ]);
             if($user->save())
             {
                return json_encode(array('status'=>'ok','message'=>'Successfully added a new Agent!'));
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
                'current_balance' => $final_credits,
                'type'=>'Deposit',
                'remarks' => $remarks,
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
                        'current_balance' => $final_credits,
                        'type'=>'Withdraw',
                        'remarks' => $remarks,
                        'reference_by'=>'Company',
                        'deposit_withdraw_id' => $withdraw_id,               
                        'createdBy'=>$responsedBy
                    ]);
                    $credit->save();
            }

        }
        return json_encode(array('status'=>'ok','message'=>'Successfully Approved '.$type.'!'));
    }

    public function is_in_array($array, $key, $key_value)
    {
          $within_array = false;
          foreach( $array as $k=>$v ){
            if( is_array($v) ){
                $within_array = is_in_array($v, $key, $key_value);
                if( $within_array == true ){
                    break;
                }
            } else {
                    if( $v == $key_value && $k == $key ){
                            $within_array = true;
                            break;
                    }
            }
          }
          return $within_array;
    }

    public function statementdetails(Request $request,$id,$date)
    {
        
         $custom_permission_controller = new CustomPermissionController;
        $custom_permission_access = $custom_permission_controller->custom_permission('agent.statement.list');
        if(!$custom_permission_access)
        {
            abort(401,'Not authorised');
        }


        
        $custom_get_all_permissions_access = $custom_permission_controller->custom_get_all_permissions();
         $pageConfigs = ['pageHeader' => false]; 

         $round_1 = DB::table('bets');
          $round_1 = $round_1
            ->leftJoin('users as u1', 'bets.user_id', '=', 'u1.id')
            ->leftJoin('users as u2', 'u1.agent_id', '=', 'u2.id');
         $start_date = $date.' 00:00:00';
         $end_date = $date.' 23:59:59';

        $round_1 = $round_1->where('bets.created_at', '>=', $start_date);
        $round_1 = $round_1->where('bets.created_at', '<=', $end_date);

         $round_1 = $round_1->where('u1.agent_id', $id);
        
            
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

            $data = $this->paginatedetails($thearray,$id,$date);

               if($request->ajax()){
                   return view('/content/apps/agent/app-statement-list-details-pagination', compact('pageConfigs','custom_get_all_permissions_access','data'));
                } 
                 return view('/content/apps/agent/app-statement-list-details', compact('pageConfigs','custom_get_all_permissions_access','data'));
           

    }
     public function paginatedetails($items, $id,$date,$perPage = 10, $page = null, $options = [])
    {
        $options = ['path' => Route('statementdetails',['id'=>$id,'date'=>$date])] ;

        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    } 
    public function statement_list(Request $request)
    { 
         $custom_permission_controller = new CustomPermissionController;
        $custom_permission_access = $custom_permission_controller->custom_permission('agent.statement.list');
        if(!$custom_permission_access)
        {
            abort(401,'Not authorised');
        }

        
        $custom_get_all_permissions_access = $custom_permission_controller->custom_get_all_permissions();
        
        $pageConfigs = ['pageHeader' => false];  
        //$statements = Bet::orderBy('id','desc')->get();

        $round_1 = DB::table('bets');

        $agents = DB::table('users')->where(['user_type'=>'agent','status'=>1])->orderBy('unique_id','asc')->get();

        $start_date_form ='';
        $end_date_form ='';

        $agent_id_form ='';


        
      
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

                     $start_date_form = $start_date;
                     $end_date_form = $end_date;

                     $start_date = $start_date.' 00:00:00';
                     $end_date = $end_date.' 23:59:59';

                    //$round_1 = $round_1->where('bets.created_at', '>=', $start_date);
                    //$round_1 = $round_1->where('bets.created_at', '<=', $end_date);

                    return $q->where('bets.created_at', '>=', $start_date)->where('bets.created_at', '<=', $end_date);

                }
                else if((count($daterangearray)==1) || (count($daterangearray)==0))
                {
                     $start_date = $daterange;
                     $end_date = $daterange;

                     $start_date_form = $start_date;
                     $end_date_form = $end_date;

                     $start_date = $start_date.' 00:00:00';
                     $end_date = $end_date.' 23:59:59';

                    //$round_1 = $round_1->where('bets.created_at', '>=', $start_date);
                    //$round_1 = $round_1->where('bets.created_at', '<=', $end_date);
                     return $q->where('bets.created_at', '>=', $start_date)->where('bets.created_at', '<=', $end_date);

                }
                 
            }
             

        });

           

           $round_1 = $round_1
            ->leftJoin('users as u1', 'bets.user_id', '=', 'u1.id')
            ->leftJoin('users as u2', 'u1.agent_id', '=', 'u2.id');

          
           $round_1=$round_1->when($request->has("agent_id"),function($q)use($request)
            {
                $agent_id  = $request->get("agent_id");
                if($agent_id > 0){
                    $agent_id_form = $agent_id;
                    //$round_1 = $round_1->where('u2.id', $agent_id_form);
                     return $q->where('u2.id', $agent_id_form);
                }
                
            });
            
           $round_1 = $round_1->where('u2.id', '!=', '')
            //->select('bets.user_id','bets.bet_amount','bets.created_at') 
             ->select(DB::raw('DATE_FORMAT(bets.created_at, "%Y-%m-%d") as date'),'u2.id as agent_id','bets.user_id','bets.bet_amount','u1.unique_id as player_unique_id','u2.unique_id as agent_unique_id','u2.commission_percentage')        
            ->get();
            

         
            //echo "<pre>";
          
            $final_array = [];

            
            if(!empty($round_1))
            {
               
                foreach($round_1 as $round_1_results)
                {

                    $final_array[]=array('agent_id'=>$round_1_results->agent_id,'user_id'=>$round_1_results->user_id,'individualAgentIdanddate'=>$round_1_results->agent_unique_id.'anddate'.$round_1_results->date,'individualAgentId'=>$round_1_results->agent_unique_id,'date'=>$round_1_results->date,'todaybetAmount'=>$round_1_results->bet_amount,'percentage'=>$round_1_results->commission_percentage,'commission'=>(($round_1_results->bet_amount * $round_1_results->commission_percentage)/100));

                   
                    

                }
            }
            // echo "<br>================<br>";
             //print_r($final_array);

             $results = array();
                foreach ($final_array as $value)
                {
                  if( ! isset($results[$value['individualAgentIdanddate']]) )
                  {
                     $results[$value['individualAgentIdanddate']] = 0;
                  }


                  $results[$value['individualAgentIdanddate']] += $value['todaybetAmount'];

                }

           // echo "<br>================<br>";
           //  print_r($results);

             $thearray = [];
             if(count($results) > 0)                
             {
                foreach($results as $k1=>$v1)
                {
                    $individualAgentIdanddate= $k1;
                    $totalvalue= $v1;
                    foreach ($final_array as $k2=>$v2)
                    {
                         $individualAgentIdanddatetemp= $v2['individualAgentIdanddate'];
                         if($individualAgentIdanddate==$individualAgentIdanddatetemp)
                         {
                            $thearray[]=array('individualAgentIdanddate'=>$v2['individualAgentIdanddate']
                                ,'individualAgentId'=>$v2['individualAgentId']
                                ,'date'=>$v2['date']
                                
                                ,'agent_id'=>$v2['agent_id']
                                 ,'todaybetAmount'=>$totalvalue
                                 ,'percentage'=>$v2['percentage']
                                 ,'user_id'=>$v2['user_id']                                 
                                  ,'commission'=>(($v2['percentage'] * $totalvalue) / 100)
                            );
                            break;
                         }

                    }
                }
             }

            // echo "<br>================<br>";
            // print_r($thearray);

              /*
               array('individualAgentId'=>'111',
                'date'=>'123',
                'todaybetAmount'=>'56',
                'percentage'=>'6',
                'commission'=>'56'
                 )
                 */

           // die();

        //return view('/content/table/table-bootstrap/table-bootstrap',['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access]);
        //return view('/content/apps/agent/app-statement-list',['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access,'statements'=>$data]);

        $data = $this->paginate($thearray);
   
       
        if($request->ajax()){
           return view('/content/apps/agent/app-statement-list-pagination', compact('pageConfigs','custom_get_all_permissions_access','data','start_date_form','end_date_form','agents','agent_id_form'));
        } 
        return view('/content/apps/agent/app-statement-list', compact('pageConfigs','custom_get_all_permissions_access','data','start_date_form','end_date_form','agents','agent_id_form'));
    }

     public function paginate($items, $perPage = 10, $page = null, $options = [])
    {
        $options = ['path' => Route('statement')] ;

        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    } 
    

    public function settlement_list(Request $request)
    { 
          $custom_permission_controller = new CustomPermissionController;
        $custom_permission_access = $custom_permission_controller->custom_permission('agent.settlement.list');
        if(!$custom_permission_access)
        {
            abort(401,'Not authorised');
        }

        
        $custom_get_all_permissions_access = $custom_permission_controller->custom_get_all_permissions();
        
        $pageConfigs = ['pageHeader' => false];  
       //  return view('/content/apps/agent/app-settlement-list',['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access]);

         $round_1 = DB::table('agent_settlements');
         
        
       $agents = DB::table('users')->where(['user_type'=>'agent','status'=>1])->orderBy('unique_id','asc')->get();

        
               
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

                  

                   return $q->where('agent_settlements.from_date', '>=', $start_date)->where('agent_settlements.to_date', '<=', $end_date);

               }
               else if((count($daterangearray)==1) || (count($daterangearray)==0))
               {
                    $start_date = $daterange;
                    $end_date = $daterange;

                  

                    $start_date = $start_date.' 00:00:00';
                    $end_date = $end_date.' 23:59:59';

                  
                    return $q->where('agent_settlements.from_date', '>=', $start_date)->where('agent_settlements.to_date', '<=', $end_date);

               }
                
           }
            

       });

          $round_1=$round_1->when($request->has("agent_id"),function($q)use($request)
            {
                $agent_id  = $request->get("agent_id");
                if($agent_id > 0){
                    //$round_1 = $round_1->where('u2.id', $agent_id_form);
                     return $q->where('agent_settlements.user_id', $agent_id);
                }
                
            });

        
            
           $data7 = $round_1->orderBy('agent_settlements.id','desc')        
            ->select('agent_settlements.*','u1.unique_id as admin_name')  
            ->leftJoin('users as u1', 'agent_settlements.user_id', '=', 'u1.id')
            ->get();

            //echo $data7;

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
                                 ,'admin_name'=>$v2->admin_name

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
                return view('/content/apps/agent/app-settlement-list-pagination', compact('pageConfigs','data','custom_get_all_permissions_access','agents'));
            } 
            return view('/content/apps/agent/app-settlement-list', compact('pageConfigs','data','custom_get_all_permissions_access','agents'));

    }
     public function paginate_settlementlist($items, $perPage = 1, $page = null, $options = [])
    {
        $options = ['path' => Route('settlementlistall')] ;

        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    } 

     public function settlement_approved(Request $request,$id)
    { 
         $pageConfigs = ['pageHeader' => false];  
         
         $transaction_no = $request->input('transaction_no');
         $transaction_date = $request->input('transaction_date');
         $settlement_amount = $request->input('settlement_amount');
         $company_status = $request->input('company_status');
         $transaction_details = $request->input('transaction_details');
         $company_comments = $request->input('company_comments');
         $company_action_date = date('Y-m-d H:i:s');
         $approved_by =  Auth::id();


         $data = array('tansaction_no'=>$transaction_no,'tansaction_date'=>$transaction_date,'settlement_amount'=>$settlement_amount,'company_status'=>$company_status,'tansaction_details'=>$transaction_details,'company_comments'=>$company_comments,'company_action_date'=>$company_action_date,'approved_by'=>$approved_by);

          $update_status = DB::table('agent_settlements')->where('id',$id)->update($data); 
        
          return json_encode(array('status'=>'ok','data'=>$data,'update_status'=>$update_status));

     }
}
