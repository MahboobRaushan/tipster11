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

class WithdrawalController extends Controller
{
    public $per_page;
    public function __construct() {
        $this->per_page = 2;
      }
     /**
     * Display a listing of the details.
     *
     * @return \Illuminate\Http\Response
     */
    public function withdrawal_list()
    { 
          $custom_permission_controller = new CustomPermissionController;
        $custom_permission_access = $custom_permission_controller->custom_permission('withdrawal.list');
        if(!$custom_permission_access)
        {
            abort(401,'Not authorised');
        }

        
        $custom_get_all_permissions_access = $custom_permission_controller->custom_get_all_permissions();


        $pageConfigs = ['pageHeader' => false];  
        
        //return view('/content/apps/withdrawal/app-withdrawal-list',['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access]);

        $agents = User::where('user_type','agent')->Where('status',1)->orderBy('name','asc')->get();


        $data = Withdraw::whereIn('withdraws.status',['Pending','Approved'])->leftJoin('users as player','withdraws.user_id', '=', 'player.id')->leftJoin('users as agent','player.agent_id', '=', 'agent.id')->select('withdraws.*','player.name as player_name','player.email as player_email','player.id as player_id','agent.name as agent_name','player.credits' )->orderBy('withdraws.id','desc')->paginate($this->per_page);

        //return view('/comming-soon',['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access]);
         return view('/content/apps/withdrawal/app-withdrawal-list',['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access,'data'=>$data,'agents'=>$agents]);
    }

     public function withdrawal_data_list(Request $request)
    { 
        if($request->ajax())
         {
              $custom_permission_controller = new CustomPermissionController;
            $custom_permission_access = $custom_permission_controller->custom_permission('withdrawal.list');
            if(!$custom_permission_access)
            {
                abort(401,'Not authorised');
            }

            
            $custom_get_all_permissions_access = $custom_permission_controller->custom_get_all_permissions();


            $pageConfigs = ['pageHeader' => false];
             $agent_id = $request->agent_id;
             $daterange = $request->daterange;  
              $status = $request->status;
               $is_transferred = $request->is_transferred;



            $agents = User::where('user_type','agent')->Where('status',1)->orderBy('name','asc')->get();

       

            if($status !='')
            {
                $data = Withdraw::where('withdraws.status',$status);
            }
            else
            {
                $data = Withdraw::whereIn('withdraws.status',['Pending','Approved']);
            }

             if($is_transferred !='')
            {
                 $data = $data->where('withdraws.is_transferred',$is_transferred);
            }

            if($agent_id > 0)
            {
                 $data = $data->where('player.agent_id',$agent_id);
            }
            if($daterange !='')
            {
                 $daterangearray = explode(' to ',$daterange);
                 $start_date = $daterangearray[0];
                 $end_date = $daterangearray[1];

                 $start_date = $start_date.' 00:00:00';
                 $end_date = $end_date.' 23:59:59';

                $data = $data->where('withdraws.withdraw_time', '>=', $start_date);
                $data = $data->where('withdraws.withdraw_time', '<=', $end_date);
            }
            $data = $data->leftJoin('users as player','withdraws.user_id', '=', 'player.id')->leftJoin('users as agent','player.agent_id', '=', 'agent.id')->select('withdraws.*','player.name as player_name','player.email as player_email','player.id as player_id','agent.name as agent_name','player.credits' )->orderBy('withdraws.id','desc')->paginate($this->per_page);


            //return view('/comming-soon',['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access]);
             return view('/content/apps/withdrawal/app-withdrawal-list-data',['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access,'data'=>$data])->render();
        }
    }

    
     public function detailsview(Request $request)
    { 
            $id = $request->id;
            $data = Withdraw::leftJoin('users as player','withdraws.user_id', '=', 'player.id')->leftJoin('users as agent','player.agent_id', '=', 'agent.id')->where('withdraws.id',$id)->select('withdraws.*','player.name as player_name','player.email as player_email','player.id as player_id','player.bank_account_name as player_bank_account_name','player.bank_country as player_bank_country','player.bank_name as player_bank_name','player.bank_account_number as player_bank_account_number','player.bank_account_type as player_bank_account_type','agent.name as agent_name','player.credits' )->first();
            /*
             $data = Withdraw::where('id',$id)->where('withdraws.status','Pending');

       
            
            $data = $data->leftJoin('users as player','withdraws.user_id', '=', 'player.id')->leftJoin('users as agent','player.agent_id', '=', 'agent.id')->select('withdraws.*','player.name as player_name','agent.name as agent_name','player.credits' )->first();
            
            */

            return json_encode(array('status'=>'ok','result'=>$data));
       
    }

    public function approvalsubmit(Request $request)
    {
        //$withdraw =  Withdraw:: where('id',$request->withdraw_id)->first();
        //return json_encode(array('status'=>'ok','message'=>$request->all()));
        
        //$user->password = bcrypt($request->password);
        //$user->save();        
        //return json_encode(array('status'=>'ok','message'=>'Successfully changed!'));

        $responsedBy = Auth::id();

        $withdraw_id = $request->withdraw_id;
        $user_id = $request->user_id;
        $amount = $request->amount;
        $status = $request->status;
        $status_change_message = $request->status_change_message;

         

        if($status=='Approved')
        {
            $user_2 =  User:: where('id',$user_id)->first();
            $credits = $user_2->credits;
            $final_credits =  $credits - $amount;
            if($final_credits >= 0)
            {

                $withdraw =  Withdraw:: where('id',$withdraw_id)->first();
                $withdraw->status = $status;
                $withdraw->status_change_message = $status_change_message;
                $withdraw->responsedBy = $responsedBy;
               
                $withdraw->save(); 

              
                return json_encode(array('status'=>'ok','message'=>'Successfully changed!'));
            }
            else 
            {
                return json_encode(array('status'=>'notok','message'=>'Can not '.$status));
            }


        }
        

    }
    public function transferredsubmit(Request $request)
    {
        

        $transferredBy = Auth::id();

        $withdraw_id = $request->withdraw_id;
        
        $is_transferred = $request->is_transferred;
       
        $current_date_time = Carbon::now()->toDateTimeString();

        

        $withdraw =  Withdraw:: where('id',$withdraw_id)->first();
        $withdraw->is_transferred = $is_transferred;
        $withdraw->transferredBy = $transferredBy;
        $withdraw->transferred_time = $current_date_time;
               
 


                $withdraw->save(); 

            
                return json_encode(array('status'=>'ok','message'=>'Successfully Transferred!'));
            
        

    }
    public function destroy(Request $request)
    {
        $id = $request->id;
        $withdraw =  Withdraw:: where('id',$id)->first();
        $withdraw->delete();
        return json_encode(array('status'=>'ok','message'=>'Successfully Deleted!'));
    }
}
