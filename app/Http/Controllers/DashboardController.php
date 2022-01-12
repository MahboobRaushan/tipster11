<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\CustomPermissionController;

use Auth;

class DashboardController extends Controller
{
  // Dashboard - Analytics
  public function dashboardAnalytics()
  {   

    $pageConfigs = ['pageHeader' => false];
    $custom_permission_controller = new CustomPermissionController;
    $custom_get_all_permissions_access = $custom_permission_controller->custom_get_all_permissions();

    if(Auth::check())
      {
        return view('/content/dashboard/dashboard-analytics', ['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access]);
      }
      else 
      {
        return view('/content/dashboard/dashboard-ecommerce-not-login', ['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access]);
      }

  }

  // Dashboard - Ecommerce
  public function dashboardEcommerce()
  {
    $pageConfigs = ['pageHeader' => false];
    $custom_permission_controller = new CustomPermissionController;
    $custom_get_all_permissions_access = $custom_permission_controller->custom_get_all_permissions();

    if(Auth::check())
      {
        return view('/content/dashboard/dashboard-ecommerce', ['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access]);
      }
      else 
      {
        return view('/content/dashboard/dashboard-ecommerce-not-login', ['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access]);
      }
    
  }
}
