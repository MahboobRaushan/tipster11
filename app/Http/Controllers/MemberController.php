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
