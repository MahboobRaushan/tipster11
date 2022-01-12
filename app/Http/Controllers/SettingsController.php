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

    public function photoupdate(Request $request, User $user)
    { 


         $current_user_id = Auth::id();
         $user = User::where('id',$current_user_id)->first();
        
    
        if(!$request->image) {
                
            }
            else{

                $time =time();
                 $input['image'] = $time.'.'.$request->image->extension();
                   $request->image->move(public_path('images/profile-photo'), $input['image']);


                 if($user->profile_photo_path)
                {
                    unlink($user->profile_photo_path);
                }

                 $user->profile_photo_path = 'images/profile-photo/'.$input['image'];
                 $user->save();

            }

             return redirect()->back();  
            
    }
}
