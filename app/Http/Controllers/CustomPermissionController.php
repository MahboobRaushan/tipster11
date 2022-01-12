<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Team;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Auth;




class CustomPermissionController extends Controller
{
    public function custom_permission($permission)
    {  
        if(request()->user()->hasPermissionTo($permission))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function custom_get_all_permissions()
    { 
        //$user = Auth::user();
        //dd($user);
        if(!empty(request()->user()))
        {
            return request()->user()->getAllPermissions()->pluck('name');
        }
        else 
        {
            return []; 
        }
        
        //return $user->getAllPermissions()->pluck('name');
    }

}
