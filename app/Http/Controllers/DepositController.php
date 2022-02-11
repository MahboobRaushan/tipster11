<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Deposit;
use App\Models\Credit;
use Validator;
use Auth;
use DB;

use Illuminate\Support\Facades\Hash;

use Carbon\Carbon;


class DepositController extends Controller
{
    public $per_page;
    public function __construct() {
        $this->per_page = 4;
      }
     /**
     * Display a listing of the details.
     *
     * @return \Illuminate\Http\Response
     */
    public function deposit_list()
    { 
        

          $custom_permission_controller = new CustomPermissionController;
        $custom_permission_access = $custom_permission_controller->custom_permission('deposit.list');
        if(!$custom_permission_access)
        {
            abort(401,'Not authorised');
        }

        
        $custom_get_all_permissions_access = $custom_permission_controller->custom_get_all_permissions();


        $pageConfigs = ['pageHeader' => false];  

         $agents = User::where('user_type','agent')->Where('status',1)->orderBy('name','asc')->get();


        $data = Deposit::whereIn('deposits.status',['Pending','Approved','Reject'])->leftJoin('users as player','deposits.user_id', '=', 'player.id')->leftJoin('users as agent','player.agent_id', '=', 'agent.id')->select('deposits.*','player.name as player_name','player.email as player_email','player.id as player_id','agent.name as agent_name','player.credits' )->orderBy('deposits.id','desc')->paginate($this->per_page);

        //return view('/comming-soon',['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access]);
         return view('/content/apps/deposit/app-deposit-list',['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access,'data'=>$data,'agents'=>$agents]);
    }

     public function deposit_data_list(Request $request)
    { 
        if($request->ajax())
         {
              $custom_permission_controller = new CustomPermissionController;
            $custom_permission_access = $custom_permission_controller->custom_permission('deposit.list');
            if(!$custom_permission_access)
            {
                abort(401,'Not authorised');
            }

            
            $custom_get_all_permissions_access = $custom_permission_controller->custom_get_all_permissions();


            $pageConfigs = ['pageHeader' => false];
             $agent_id = $request->agent_id;
             $daterange = $request->daterange;
             $status = $request->status;  

             

            $agents = User::where('user_type','agent')->Where('status',1)->orderBy('name','asc')->get();


           

             

            if($status !='')
            {
                $data = Deposit::where('deposits.status',$status);
            }
            else
            {
                $data = Deposit::whereIn('deposits.status',['Pending','Approved','Reject']);
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

                $data = $data->where('deposits.deposit_time', '>=', $start_date);
                $data = $data->where('deposits.deposit_time', '<=', $end_date);
            }
            $data = $data->leftJoin('users as player','deposits.user_id', '=', 'player.id')->leftJoin('users as agent','player.agent_id', '=', 'agent.id')->select('deposits.*','player.name as player_name','player.email as player_email','player.id as player_id','agent.name as agent_name','player.credits' )->orderBy('deposits.id','desc')->paginate($this->per_page);


            //return view('/comming-soon',['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access]);
             return view('/content/apps/deposit/app-details-list-data',['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access,'data'=>$data])->render();
        }
    }

    
     public function detailsview(Request $request)
    { 
            $id = $request->id;
            $data = Deposit::leftJoin('users as player','deposits.user_id', '=', 'player.id')->leftJoin('users as agent','player.agent_id', '=', 'agent.id')->where('deposits.id',$id)->select('deposits.*','player.name as player_name','player.email as player_email','player.id as player_id','agent.name as agent_name','player.credits' )->first();
            /*
             $data = Deposit::where('id',$id)->where('deposits.status','Pending');

       
            
            $data = $data->leftJoin('users as player','deposits.user_id', '=', 'player.id')->leftJoin('users as agent','player.agent_id', '=', 'agent.id')->select('deposits.*','player.name as player_name','agent.name as agent_name','player.credits' )->first();
            
            */

            return json_encode(array('status'=>'ok','result'=>$data));
       
    }

    public function approvalsubmit(Request $request)
    {
        //$deposit =  Deposit:: where('id',$request->deposit_id)->first();
        //return json_encode(array('status'=>'ok','message'=>$request->all()));
        
        //$user->password = bcrypt($request->password);
        //$user->save();        
        //return json_encode(array('status'=>'ok','message'=>'Successfully changed!'));

        $responsedBy = Auth::id();

        $deposit_id = $request->deposit_id;
        $user_id = $request->user_id;
        $amount = $request->amount;
        $status = $request->status;
        $status_change_message = $request->status_change_message;

        

        if($status=='Reject')
        {
            $deposit =  Deposit:: where('id',$deposit_id)->first();
            $deposit->status = $status;
            $deposit->status_change_message = $status_change_message;
            $deposit->responsedBy = $responsedBy;
            $deposit->save();  

        }
        else if($status=='Approved')
        {
            $user_2 =  User:: where('id',$user_id)->first();
            $credits = $user_2->credits;
            $final_credits = $amount + $credits;

            $deposit =  Deposit:: where('id',$deposit_id)->first();
            $deposit->status = $status;
            $deposit->status_change_message = $status_change_message;
            $deposit->responsedBy = $responsedBy;
            $deposit->amount = $amount;
            $deposit->before_deposit_amount = $credits;
            $deposit->current_balance = $final_credits;
            $deposit->save(); 

            $user_2->credits = $final_credits;
            $user_2->save(); 

             $credit = new Credit([
                'user_id'  => $user_id,
                'before_deposit_withdraw_amount' => $credits,
                'amount' => $amount,
                'current_balance' => $final_credits,
                'type'=>'Deposit',
                'reference_by'=>'Self',
                'deposit_withdraw_id' => $deposit_id,               
                'createdBy'=>$responsedBy
            ]);
            $credit->save();


        }
        return json_encode(array('status'=>'ok','message'=>'Successfully changed!'));

    }
    public function destroy(Request $request)
    {
        $id = $request->id;
        $deposit =  Deposit:: where('id',$id)->first();
        $deposit->delete();
        return json_encode(array('status'=>'ok','message'=>'Successfully Deleted!'));
    }


}
