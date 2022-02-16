<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;

use Illuminate\Support\Facades\Hash;
use Validator;

use Illuminate\Http\Request;

use App\Http\Controllers\CustomPermissionController;

use App\Models\User;
use App\Models\Deposit;
use App\Models\Withdraw;
use App\Models\Credit;

use Carbon\Carbon;
use Auth;
use DB;

class AgentController extends Controller
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
             $user = new User([
                'name'  => $request->name,
                'email' => $request->email,
                'status' => $request->status,
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
                        'reference_by'=>'Company',
                        'deposit_withdraw_id' => $withdraw_id,               
                        'createdBy'=>$responsedBy
                    ]);
                    $credit->save();
            }

        }
        return json_encode(array('status'=>'ok','message'=>'Successfully Approved '.$type.'!'));
    }

    public function statement_list()
    { 
         $custom_permission_controller = new CustomPermissionController;
        $custom_permission_access = $custom_permission_controller->custom_permission('agent.statement.list');
        if(!$custom_permission_access)
        {
            abort(401,'Not authorised');
        }

        
        $custom_get_all_permissions_access = $custom_permission_controller->custom_get_all_permissions();
        
        $pageConfigs = ['pageHeader' => false];  
        //return view('/comming-soon',['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access]);
        return view('/content/apps/agent/app-statement-list',['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access]);
    }

    public function settlement_list()
    { 
          $custom_permission_controller = new CustomPermissionController;
        $custom_permission_access = $custom_permission_controller->custom_permission('agent.settlement.list');
        if(!$custom_permission_access)
        {
            abort(401,'Not authorised');
        }

        
        $custom_get_all_permissions_access = $custom_permission_controller->custom_get_all_permissions();
        
        $pageConfigs = ['pageHeader' => false];  
        //return view('/comming-soon',['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access]);
         return view('/content/apps/agent/app-settlement-list',['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access]);
    }
}
