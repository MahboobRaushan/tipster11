<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use DB;

class MemberController extends Controller
{
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

        
        $data = User::where('user_type','user')->paginate(10);

         return view('/content/apps/member/app-details-list',['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access,'data'=>$data]);
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

       $data = User::where('user_type','user')->paginate(10);
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

        
       

         return view('/content/apps/member/app-details-add',['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access]);
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

         return view('/content/apps/member/app-details-edit',['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access,'data'=>$data]);
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
        //return view('/comming-soon',['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access]);
        return view('/content/apps/member/app-adjustcredit',['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access]);
    }

}
