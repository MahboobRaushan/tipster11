<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\CustomPermissionController;

use App\Models\Companysettings;


use Auth;

class SettingsController extends Controller
{
     public function company()
    { 
        
        $custom_permission_controller = new CustomPermissionController;  

         $custom_permission_access = $custom_permission_controller->custom_permission('settings.company');
        if(!$custom_permission_access)
        {
            abort(401,'Not authorised');
        }      

        
        $custom_get_all_permissions_access = $custom_permission_controller->custom_get_all_permissions();        

        $pageConfigs = ['pageHeader' => false];
        //return view('/content/apps/user/app-user-list', ['pageConfigs' => $pageConfigs]);

        $companysettings = Companysettings::get()->first();
    
        return view('/content/apps/settings/company',['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access,'companysettings'=>$companysettings]);
    }

    public function companysave(Request $request, Companysettings $companysettings)
    { 


      
         $companysettings = Companysettings::get()->first();

         $companysettings->name = $request->name;
         $companysettings->email = $request->email;
         $companysettings->phone = $request->phone;
         $companysettings->address = $request->address;
         $companysettings->website = $request->website;
          $companysettings->save();
        
    
        if(!$request->logo) {
                
            }
            else{

                $time ='1'.time();
                 $input['logo'] = $time.'.'.$request->logo->extension();
                   $request->logo->move(public_path('images/company-photo'), $input['logo']);


                 if($companysettings->logo)
                {
                    unlink($companysettings->logo);
                }

                 $companysettings->logo = 'images/company-photo/'.$input['logo'];
                 $companysettings->save();

            }

             if(!$request->favicon) {
                
            }
            else{

                $time ='2'.time();
                 $input['favicon'] = $time.'.'.$request->favicon->extension();
                   $request->favicon->move(public_path('images/company-photo'), $input['favicon']);


                 if($companysettings->favicon)
                {
                    unlink($companysettings->favicon);
                }

                 $companysettings->favicon = 'images/company-photo/'.$input['favicon'];
                 $companysettings->save();

            }

             return redirect()->back();  
            
    }
}
