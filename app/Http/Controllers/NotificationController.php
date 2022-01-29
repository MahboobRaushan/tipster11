<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

class NotificationController extends Controller
{
    /**
     * Display a listing of the details.
     *
     * @return \Illuminate\Http\Response
     */
    public function notification_list()
    { 
           $custom_permission_controller = new CustomPermissionController;
        $custom_permission_access = $custom_permission_controller->custom_permission('notification.list');
        if(!$custom_permission_access)
        {
            abort(401,'Not authorised');
        }

        
        $custom_get_all_permissions_access = $custom_permission_controller->custom_get_all_permissions();


        $pageConfigs = ['pageHeader' => false];  
        return view('/comming-soon',['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access]);

        //return view('/content/table/table-bootstrap/table-bootstrap',['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access]);



    }

    public function testingpagination()
    {
         $custom_permission_controller = new CustomPermissionController;
        $custom_permission_access = $custom_permission_controller->custom_permission('notification.list');
        if(!$custom_permission_access)
        {
            abort(401,'Not authorised');
        }

        
        $custom_get_all_permissions_access = $custom_permission_controller->custom_get_all_permissions();


        $pageConfigs = ['pageHeader' => false];  


     $data = DB::table('testing')->paginate(10);
     return view('/content/testing/testing_pagination', ['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access,'data'=>$data]);
    }

    public function testingpagination_fetch_data(Request $request)
    {
     if($request->ajax())
     {
         $custom_permission_controller = new CustomPermissionController;
        $custom_permission_access = $custom_permission_controller->custom_permission('notification.list');
        if(!$custom_permission_access)
        {
            abort(401,'Not authorised');
        }

        
        $custom_get_all_permissions_access = $custom_permission_controller->custom_get_all_permissions();


        $pageConfigs = ['pageHeader' => false];  

      $data = DB::table('testing')->paginate(10);
      return view('/content/testing/testing_pagination_data', ['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access,'data'=>$data])->render();
     }
    }
}
