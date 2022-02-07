<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Team;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Illuminate\Support\Facades\Hash;
use Validator;

use Illuminate\Http\Request;

use App\Http\Controllers\CustomPermissionController;

use Auth;
use DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 

        /*
        $permission = Permission::create(['name' => 'league.list']);
        $permission = Permission::create(['name' => 'league.team']);
        $permission = Permission::create(['name' => 'league.view']);
        $permission = Permission::create(['name' => 'league.create']);
        $permission = Permission::create(['name' => 'league.edit']);
        $permission = Permission::create(['name' => 'league.delete']);
       
        $role = User::createRole('Super Admin');        
        $role->givePermissionTo('league.list');
        $role->givePermissionTo('league.team');         
        $role->givePermissionTo('league.view');
       $role->givePermissionTo('league.create');
        $role->givePermissionTo('league.edit');
        $role->givePermissionTo('league.delete');
        

       


        return 1;

        */
        

       // $roles = request()->user()->getRoleNames()->toJson();
       // $permissions = request()->user()->getAllPermissions()->pluck('name')->toJson();
       // print_r($permissions);

        //$role = User::createRole('Agent');
       // $role->givePermissionTo('commission.direct');
       // $role->givePermissionTo('commission.indirect');

        //$user = User:::with('roles')->role('Admin')->get()->toJson();
        


     


       // return 777;
        
        $custom_permission_controller = new CustomPermissionController;
        $custom_permission_access = $custom_permission_controller->custom_permission('user.list');
        if(!$custom_permission_access)
        {
            abort(401,'Not authorised');
        }

        
        $custom_get_all_permissions_access = $custom_permission_controller->custom_get_all_permissions();

       
        

        $pageConfigs = ['pageHeader' => false];
        //return view('/content/apps/user/app-user-list', ['pageConfigs' => $pageConfigs]);

         $current_user_id = Auth::id();
        
    
        return view('/content/apps/user/app-user-list',['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access,'current_user_id'=>$current_user_id]);
    }

    public function userphoto()
    { 

     
        $pageConfigs = ['pageHeader' => false];
         $current_user_id = Auth::id();
         $user = User::where('id',$current_user_id)->first();


           $custom_permission_controller = new CustomPermissionController;
        $custom_get_all_permissions_access = $custom_permission_controller->custom_get_all_permissions();
        
    
        return view('/content/apps/user/photo',['pageConfigs' => $pageConfigs,'user'=>$user,'current_user_id'=>$current_user_id,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access]);
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

    
    public function ajaxlist()
    {
       

         $data =User::whereIn('user_type',array('super_admin','admin','agent'))->with('roles')->get();
        return json_decode(json_encode(array('data'=>$data)));
        
    }


  

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
         $v = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'user_type' => 'required',
        ]);

        if ($v->fails())
        {
            return json_encode(array('status'=>'notok','message'=>$v->errors()));
        }
        else
        {
             $name = $request->name;
            $email = $request->email;
            $user_type = $request->user_type;
            $password = Hash::make($request->password);

            $userData = array('name'=>$name,'email'=>$email,'password'=>$password,'user_type'=>$user_type);

          
            $user = User::create($userData);

            $teamData = array('name'=>'Admin\'s Team','personal_team'=>1,'user_id'=>$user->id);
            Team::create($teamData);

            return json_encode(array('status'=>'ok','message'=>'Successfully added!'));
         
          
        }
        
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function details($id)
    {
        $user = User::where('id',$id)->first();
        return $user->toJson();
    }

  
   public function permissiondetails($id)
    {
        $user = User::where('id',$id)->first();
        $userdetails = $user->toJson();        
        $allroledetails = Role::pluck('name');
        $permissions = $user->getAllPermissions()->pluck('name');
        $rolenames = $user->getRoleNames();
        
        $group_name_dis = DB::select('select distinct(group_name)  from permissions');
        $group_name = array();
        foreach ($group_name_dis as $gn) {

             $group_name_detls = DB::select('select name,action_name  from permissions where group_name =:group_name', ['group_name' => $gn->group_name]);
             $group_name_details = array();
             foreach ($group_name_detls as $gd) {
                $group_name_details[]=array('name'=>$gd->name,'action_name'=>$gd->action_name);
             }

            $group_name[]= array('name'=>$gn->group_name,'children'=>$group_name_details);
        }

        return json_encode(array('group_name'=>$group_name,'rolenames'=>json_decode($rolenames),'permissions'=>json_decode($permissions),'allroledetails'=>$allroledetails,'userdetails'=>json_decode($userdetails)));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
         $v = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$request->edit_id,           
            'status' => 'required',
            'user_type' => 'required',
        ]);

        if ($v->fails())
        {
            return json_encode(array('status'=>'notok','message'=>$v->errors()));
        }
        else
        {
             $name = $request->name;
            $email = $request->email;
             $status = $request->status;
              $user_type = $request->user_type;


            $user = User::where('id',$request->edit_id)->first();

             if($request->password!='')
             {
                $password = Hash::make($request->password);

                $user->name = $name;
                $user->email = $email;
                $user->status = $status;
                $user->password = $password;
                 $user->user_type = $user_type;

              
                $user->save();
             }
             else 
             {
                $user->name = $name;
                $user->email = $email;
                $user->status = $status;
                 $user->user_type = $user_type;
              
                $user->save();
             }

           

            

            return json_encode(array('status'=>'ok','message'=>'Successfully updated!'));
         
          
        }
    }

    public function permission(Request $request, User $user)
    {
         $v = Validator::make($request->all(),[
            'name' => 'required'
        ]);

        if ($v->fails())
        {
            return json_encode(array('status'=>'notok','message'=>$v->errors()));
        }
        else
        {
             $user_id = $request->permission_id;
             $role = $request->role;
             $permissions = $request->permissions;


            $user = User::where('id',$user_id)->first();
            $user->syncPermissions($permissions);

            $user->syncRoles($role);

                        

            

            return json_encode(array('status'=>'ok','message'=>'Successfully updated!','request'=>$request->all()));
         
          
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    
    public function destroy($id){
       
        $user = User::where('id',$id);
        if($user)
        {
            $user->delete();
        }
        $team = Team::where('user_id',$id);
        if($team)
        {
            $team->delete();
        }
      
        return json_encode(array('status'=>'ok','message'=>'Successfully deleted !'));
    }

}
