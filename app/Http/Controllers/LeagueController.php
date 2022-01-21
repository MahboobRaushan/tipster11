<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\League;
use App\Models\Tim;
use App\Models\Game;

class LeagueController extends Controller
{
    public function getTimbyLeague($id)
    {
        $tims = League::find($id)->tims;
        return $tims;
    }
     public function index()
    {
        //request()->user()->revokePermissionTo('league.edit');

        $custom_permission_controller = new CustomPermissionController;
        $custom_permission_access = $custom_permission_controller->custom_permission('league.list');
        if(!$custom_permission_access)
        {
            abort(401,'Not authorised');
        }

        
        $custom_get_all_permissions_access = $custom_permission_controller->custom_get_all_permissions();

        $pageConfigs = ['pageHeader' => false];

        $game = Game::orderBy('name','asc')->get();

        return view('/content/apps/league/app-league-list',['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access,'game'=>$game]);
    }


    
    public function ajaxlist()
    {
        $data = League::get();
        $game = Game::get();
        return json_decode(json_encode(array('data'=>$data,'game'=>$game)));
        
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
            'name' => 'required|unique:leagues',
            'game_id' => 'required',
           
            
        ]);

        if ($v->fails())
        {
            return json_encode(array('status'=>'notok','message'=>$v->errors()));
        }
        else
        {
            $name = $request->name;
            $game_id = $request->game_id;
            $status = $request->status;
          

           
             $leagueData = array('name'=>$name,'game_id'=>$game_id,'status'=>$status);
            
            

          
            $league = League::create($leagueData);          

            return json_encode(array('status'=>'ok','message'=>'Successfully added!','res'=>$leagueData));
         
          
        }
        
       
    }

    public function storetim(Request $request)
    {
        
         $v = Validator::make($request->all(),[
            'type' => 'required',
            'league_id' => 'required',
            
        ]);

        if ($v->fails())
        {
            return json_encode(array('status'=>'notok','message'=>$v->errors()));
        }
        else
        {
            $name = $request->name;
            $type = $request->type;
            $id = $request->id;
            $league_id = $request->league_id;
          

            if($type=='add')
            {
             $timData = array('name'=>$name,'league_id'=>$league_id);
              $team = Tim::create($timData); 
              return json_encode(array('status'=>'ok','message'=>'Successfully added!')); 
            }
            if($type=='edit')
            {
                $tim = Tim::where('id',$id)->first();
                $tim->name = $name;
                $tim->save(); 
                return json_encode(array('status'=>'ok','message'=>'Successfully updated!'));
            }
            if($type=='delete')
            {
                $tim = Tim::where('id',$id)->first();               
                $tim->delete(); 
                return json_encode(array('status'=>'ok','message'=>'Successfully deleted!'));
            }
            
                 

            
         
          
        }
        
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\League  $league
     * @return \Illuminate\Http\Response
     */
    public function details($id)
    {
        

        $data =League::with('tims')->where('id',$id)->get();
        return $data->toJson();
    }

  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\League  $league
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, League $league)
    {
         $v = Validator::make($request->all(),[
            'name' => 'required|unique:leagues,name,'.$request->edit_id,          
           'game_id' => 'required',
            'status' => 'required',
        ]);

        // return json_encode(array('status'=>'ok','message'=>'Successfully updated!','request'=> $request->name));

        if ($v->fails())
        {
            return json_encode(array('status'=>'notok','message'=>$v->errors()));
        }
        else
        {
            $name = $request->name;
            $status = $request->status;
           $game_id = $request->game_id;


            $league = League::where('id',$request->edit_id)->first();

           

            $league->name = $name;
            $league->status = $status;
            $league->game_id = $game_id;
                        
            $league->save();

            return json_encode(array('status'=>'ok','message'=>'Successfully updated!','gm'=>$league));
         
          
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\League  $league
     * @return \Illuminate\Http\Response
     */
    
    public function destroy($id){
        
        $tim =Tim::where('league_id',$id);
        if($tim)
        {
            $tim->delete();
        }

        $league = League::where('id',$id);
               
        if($league)
        {
            $league->delete();
        }


             
        return json_encode(array('status'=>'ok','message'=>'Successfully deleted !'));
    }
}