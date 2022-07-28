<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;

use App\Models\Announcement;
use Auth;
use DB;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the details.
     *
     * @return \Illuminate\Http\Response
     */
     public $per_page;
    function __construct() {
        $this->per_page = 10;
      }
    public function announcement_list()
    { 
           $custom_permission_controller = new CustomPermissionController;
        $custom_permission_access = $custom_permission_controller->custom_permission('announcement.list');
        if(!$custom_permission_access)
        {
            abort(401,'Not authorised');
        }

        
        $custom_get_all_permissions_access = $custom_permission_controller->custom_get_all_permissions();


        $pageConfigs = ['pageHeader' => false];  
        //return view('/comming-soon',['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access]);
        // return view('/content/table/table-datatable/table-datatable-advance',['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access]);
        //return view('/content/forms/form-elements/form-number-input',['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access]);
       // return view('/content/components/component-modals',['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access]);

        $announcements = Announcement::orderBy('created_at','desc')->get();
        return view('/content/apps/announcement/app-announcement-list',['pageConfigs' => $pageConfigs,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access,'announcements'=>$announcements]);
        
    }
     public function handle_pagination($total, $page, $shown, $url) {  
          $pages = ceil( $total / $shown ); 
          $range_start = ( ($page >= 5) ? ($page - 3) : 1 );
          $range_end = ( (($page + 5) > $pages ) ? $pages : ($page + 5) );

          if ( $page >= 1 ) {
            $r[] = '<li class="page-item"><a class="page-link" href="'. $url .'1">&laquo; </a></li>';
            $r[] = '<li class="page-item"><a class="page-link" href="'. $url . ( $page ) .'">&lsaquo; </a></li>';
            $r[] = ( ($range_start > 1) ? ' ... ' : '' ); 
          }

          if ( $range_end > 1 ) {
            foreach(range($range_start, $range_end) as $key => $value) {
              if ( $value == ($page + 1) ) $r[] = '<li class="page-item active" aria-current="page"><span class="page-link">'. $value .'</span></li>'; 
              else $r[] = '<li class="page-item"><a class="page-link" href="'. $url . ($value ) .'">'. $value .'</a></li>'; 
            }
          }

          if ( ( $page + 1 ) < $pages ) {
            $r[] = ( ($range_end < $pages) ? ' ... ' : '' );
            $r[] = '<li class="page-item"><a class="page-link" href="'. $url . ( $page + 2 ) .'"> &rsaquo;</a></li>';
            $r[] = '<li class="page-item"><a class="page-link" href="'. $url . ( $pages  ) .'"> &raquo;</a></li>';
          }

          return ( (isset($r)) ? '<div class="pagination" style="float:right;"><nav><ul class="pagination">'. implode("", $r) .'</ul></nav></div>' : '');
        }     
     public function ajaxlist($page_no)
    {
       // Paginator::setCurrentPage($page_no);
        $per_page = $this->per_page;
        $offset=($page_no -1 ) * $per_page ;
        $limit=$per_page;

        $data = DB::table('announcements')            
            ->orderBy('created_at','desc')
            ->offset($offset)
            ->limit($limit)
            ->get();

            $totalcount = DB::table('announcements')                     
            ->count();

           $links = $this->handle_pagination($totalcount, ($page_no-1), $this->per_page, url('/announcements?page='));
           $page_link = array('links'=>$links,'offset'=>$offset,'totalcount'=>$totalcount);
           
        return json_decode(json_encode(array('per_page'=>$per_page,'offset'=>$offset,'totalcount'=>$totalcount,'page_links'=>$links,'data'=>$data,'page_no'=>$page_no)));
        
    }
    public function store(Request $request)
    {
        
         $v = Validator::make($request->all(),[
            'title' => 'required', 
                                          
            
        ]);

       

        if ($v->fails())
        {
            return json_encode(array('status'=>'notok','message'=>$v->errors()));
        }
        else
        {
            $title = $request->title;
           
           
            //updatedBy
           

           //$announcementData = [];
            $announcementData = array('title'=>$title);
            //$announcement = Match::create($announcementData);   
           //$announcement = New Match();  
           //$announcement->create($announcementData) ; 

            $announcement = DB::table('announcements')->insert(
                            $announcementData
                        );   

             

            return json_encode(array('status'=>'ok','message'=>'Successfully added!','res'=>$announcementData));
         
          
        }
        
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Match  $announcement
     * @return \Illuminate\Http\Response
     */
    public function details($id)
    {
        //$announcement = Match::where('id',$id)->first();

        $announcement = DB::table('announcements')            
            ->where('id',$id)
            ->get();
           

        //return $announcement->toJson();
        return json_encode(array('announcement'=>$announcement));
    }

  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Match  $announcement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
         $v = Validator::make($request->all(),[
             'title' => 'required',
             
            
        ]);

       

         $mmssg = '';
         
        

         
         

         

        if ($v->fails())
        {
            return json_encode(array('status'=>'notok','message'=>$v->errors()));
        }
        else
        {


             $title = $request->title;
            
            
            
            $status = $request->status;

            
            


            $announcement = DB::table('announcements')->where('id',$id)->count();
           
          

          
           
          
            if($announcement > 0)
            {
                $announcement_save_result = DB::table('announcements')
                ->where('id', $id)
                ->update([
                    'title' => $title,
                                 
                    'status' => $status
                ]);
                
            }
                  
          
            

            return json_encode(array('status'=>'ok','message'=>'Successfully updated!','gm'=>$announcement));
         
          
        }
    }
     public function destroy($id){
       
        $announcement = DB::table('announcements')->where('id',$id)->first();
        
       $announcement->delete();
                 
            return json_encode(array('status'=>'ok','message'=>'Successfully deleted !'));
       


        
    }
}
