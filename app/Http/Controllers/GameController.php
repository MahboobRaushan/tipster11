<?php

namespace App\Http\Controllers;
use App\Models\Game;

use Validator;
use Illuminate\Http\Request;

use App\Http\Controllers\CustomPermissionController;
use DB;


class GameController extends Controller
{
    public function index()
    {
        //request()->user()->revokePermissionTo('game.edit');

        $custom_permission_controller = new CustomPermissionController;
        $custom_permission_access = $custom_permission_controller->custom_permission('game.list');
        if(!$custom_permission_access)
        {
            abort(401,'Not authorised');
        }

        
        $custom_get_all_permissions_access = $custom_permission_controller->custom_get_all_permissions();

        $pageConfigs = ['pageHeader' => false];

        return view('/content/apps/game/app-game-list',['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access]);
    }


    
    public function ajaxlist()
    {
        $data = Game::get();
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
            'name' => 'required|unique:games',
            'image' => 'image|mimes:jpg,png,jpeg',
            
        ]);

        if ($v->fails())
        {
            return json_encode(array('status'=>'notok','message'=>$v->errors()));
        }
        else
        {
            $name = $request->name;
            $status = $request->status;
           

            $file = $request->file('image');

            $uploadstatus = false;

            if(!$request->image) {
                $gameData = array('name'=>$name,'status'=>$status);
            }
            else{
                $time =time();
                 $input['image'] = $time.'.'.$request->image->extension();
                $request->image->move(public_path('images/game'), $input['image']);
                

                $gameData = array('name'=>$name,'status'=>$status,'icon_path'=>'images/game/'.$input['image']);

            }
            

          
            $game = Game::create($gameData);          

            return json_encode(array('status'=>'ok','message'=>'Successfully added!','res'=>$gameData));
         
          
        }
        
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function details($id)
    {
        $game = Game::where('id',$id)->first();
        return $game->toJson();
    }

  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Game $game)
    {
         $v = Validator::make($request->all(),[
            'name' => 'required|unique:games,name,'.$request->edit_id,          
           
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
           


            $game = Game::where('id',$request->edit_id)->first();

            if(!$request->image) {
                
            }
            else{

                $time =time();
                 $input['image'] = $time.'.'.$request->image->extension();
                   $request->image->move(public_path('images/game'), $input['image']);


                 if($game->icon_path)
                {
                    unlink($game->icon_path);
                }

                 $game->icon_path = 'images/game/'.$input['image'];

            }

            $game->name = $name;
            $game->status = $status;
                      
            $game->save();

            return json_encode(array('status'=>'ok','message'=>'Successfully updated!','gm'=>$game));
         
          
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    
    public function destroy($id){

        $dataexist = 0;

        if(DB::table('leagues')
             ->where('game_id',$id)
            ->count() > 0 )
        {
              $league_id = DB::table('leagues')
             ->where('game_id',$id)
            ->first()->id;

             $dataexist = DB::table('match')
             ->where('league',$league_id)
            ->count(); 
        }

        

          if($dataexist > 0) 
            {
                return json_encode(array('status'=>'notok','message'=>'You can\'t delete this game, because it is already assign with some matches'));
            }
            else
            {   
       
                $game = Game::where('id',$id);
                if($game->first()->icon_path)
                {
                    unlink($game->first()->icon_path);
                }
                
                if($game)
                {
                    $game->delete();
                }
                     
                return json_encode(array('status'=>'ok','message'=>'Successfully deleted !'));
            }
    }
}
