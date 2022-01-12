<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\CustomPermissionController;

use Auth;

class CommissionController extends Controller
{
    public function direct()
    { 
        
        $custom_permission_controller = new CustomPermissionController; 

         $custom_permission_access = $custom_permission_controller->custom_permission('commission.direct');
        if(!$custom_permission_access)
        {
            abort(401,'Not authorised');
        }     

        
        $custom_get_all_permissions_access = $custom_permission_controller->custom_get_all_permissions();        

        $pageConfigs = ['pageHeader' => false];
        //return view('/content/apps/user/app-user-list', ['pageConfigs' => $pageConfigs]);
    
        return view('/content/apps/commission/direct',['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access]);
    }

    public function indirect()
    { 
        
        $custom_permission_controller = new CustomPermissionController;

         $custom_permission_access = $custom_permission_controller->custom_permission('commission.indirect');
        if(!$custom_permission_access)
        {
            abort(401,'Not authorised');
        }       

        
        $custom_get_all_permissions_access = $custom_permission_controller->custom_get_all_permissions();        

        $pageConfigs = ['pageHeader' => false];
        //return view('/content/apps/user/app-user-list', ['pageConfigs' => $pageConfigs]);
    
        return view('/content/apps/commission/indirect',['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access]);
    }

}
