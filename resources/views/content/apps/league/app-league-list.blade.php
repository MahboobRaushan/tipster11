@extends('layouts/contentLayoutMaster')

@section('title', 'League List')

@section('vendor-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css')) }}">



@endsection

@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
@endsection

@section('content')
<!-- leagues list start -->


<section class="app-league-list">
  <div class="row">
    <div class="col-lg-3 col-sm-6">
      <div class="card">
        <div class="card-body d-flex align-items-center justify-content-between">
          <div>
            <h3 class="fw-bolder mb-75">21,459</h3>
            <span>Total Leagues</span>
          </div>
          <div class="avatar bg-light-primary p-50">
            <span class="avatar-content">
              <i data-feather="league" class="font-medium-4"></i>
            </span>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-sm-6">
      <div class="card">
        <div class="card-body d-flex align-items-center justify-content-between">
          <div>
            <h3 class="fw-bolder mb-75">4,567</h3>
            <span>Paid Leagues</span>
          </div>
          <div class="avatar bg-light-danger p-50">
            <span class="avatar-content">
              <i data-feather="league-plus" class="font-medium-4"></i>
            </span>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-sm-6">
      <div class="card">
        <div class="card-body d-flex align-items-center justify-content-between">
          <div>
            <h3 class="fw-bolder mb-75">19,860</h3>
            <span>Active Leagues</span>
          </div>
          <div class="avatar bg-light-success p-50">
            <span class="avatar-content">
              <i data-feather="league-check" class="font-medium-4"></i>
            </span>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-sm-6">
      <div class="card">
        <div class="card-body d-flex align-items-center justify-content-between">
          <div>
            <h3 class="fw-bolder mb-75">237</h3>
            <span>Pending Leagues</span>
          </div>
          <div class="avatar bg-light-warning p-50">
            <span class="avatar-content">
              <i data-feather="league-x" class="font-medium-4"></i>
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- list and filter start -->
  <div class="card">
    <div class="card-body border-bottom">
      <h4 class="card-title">Search & Filter</h4>
      <div class="row">
        <div class="col-md-4 league_role"></div>
        <div class="col-md-4 league_plan"></div>
        <div class="col-md-4 league_status"></div>
      </div>
    </div>
    <div class="card-datatable table-responsive pt-0">
      <table class="league-list-table table">
        <thead class="table-light">
          <tr>
            <th></th>
            <th>ID</th>
           
            <th>Name</th>
            <th>Game</th>                    
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
      </table>
    </div>
    <!-- Modal to add new league starts-->
    <div class="modal modal-slide-in new-league-modal fade" id="modals-slide-in">
      <div class="modal-dialog">
        <form class="add-new-league modal-content pt-0"  method="POST" id="postForm" name="postForm" enctype="multipart/form-data" >
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
          <div class="modal-header mb-1">
            <h5 class="modal-title" id="exampleModalLabel">Add League</h5>
          </div>
          <div class="modal-body flex-grow-1">
             <div class="mb-1">
              <label class="form-label" for="basic-icon-default-fullname">Game</label>
              

              <select
               
                class="form-control dt-full-name select2"
                id="basic-icon-default-game_id"
                required
                name="game_id"
              >
              <option value="">Select</option>
             
              @foreach ($game as $ggg)
              <option value="{{$ggg->id}}">{{$ggg->name}}</option>
              @endforeach
             
            </select>
           
            </div>
            <div class="mb-1">
              <label class="form-label" for="basic-icon-default-fullname">Name</label>
              <input
                type="text"
                class="form-control dt-full-name"
                id="basic-icon-default-fullname"
                placeholder="Word Cup"
                name="name"
              />
            </div>
           

           
           
            <button type="submit" id="btn-save" class="btn btn-primary me-1 data-submit">Save</button>
            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
    <!-- Modal to add new league Ends-->
     <!-- Modal to edit league starts-->
    <div class="modal modal-slide-in edit-league-modal fade" id="modals-slide-in-edit">
      <div class="modal-dialog">
        <form class="edit-new-league modal-content pt-0" method="POST"  id="postForm_edit" name="postForm_edit" enctype="multipart/form-data">
          <input type="hidden" id="edit_id" name="edit_id" value="" />
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
          <div class="modal-header mb-1">
            <h5 class="modal-title" id="exampleModalLabel_edit">Edit League</h5>
          </div>
          <div class="modal-body flex-grow-1">

             <div class="mb-1">
              <label class="form-label" for="basic-icon-default-fullname">Game</label>
              

              <select
               
                class="form-control dt-full-name select2"
                id="basic-icon-default-game_id_edit"
                required
                name="game_id"
              >
              <option value="">Select</option>
             
              @foreach ($game as $ggg)
              <option value="{{$ggg->id}}">{{$ggg->name}}</option>
              @endforeach
             
            </select>
           
            </div>

            <div class="mb-1">
              <label class="form-label" for="basic-icon-default-fullname_edit">Name</label>
              <input
                type="text"
                class="form-control dt-full-name"
                id="basic-icon-default-fullname_edit"
                 placeholder="Word Cup"
                name="name"
              />
            </div>



          
          

             <div class="mb-1">
              <label class="form-label" for="basic-icon-default-status_edit">Status</label>
              <select
                id="basic-icon-default-status_edit"
                class="form-control select2"
                name="status"
               >
               <option value="1">Active</option>
               <option value="0">Inactive</option>
             </select>
            </div>    

             
          
            
          
           
            <button type="submit" id="btn-save_edit" class="btn btn-primary me-1 data-submit">Update</button>
            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
    <!-- Modal to add edit league Ends-->

    <!-- Modal to team league starts-->
    <div class="modal modal-slide-in team-league-modal fade" id="modals-slide-in-team">
      <div class="modal-dialog">
        <form class="team-new-league modal-content pt-0" method="POST"  id="postForm_team" name="postForm_team" enctype="multipart/form-data">
          @csrf

          <input type="hidden" id="team_id" name="team_id" value="" />
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
          <div class="modal-header mb-1">
            <h5 class="modal-title" id="exampleModalLabel_edit"><span id="league_team_name_div"></span> - Team List</h5>
                        
          </div>
         
          <div class="modal-body flex-grow-1">
             <div class="col-md-12 col-12 mb-1">
              <div class="input-group">
               
               <input type="text" name="league_team_name" id="league_team_name" class="form-control" placeholder="Singapore" aria-label="" value=""/>
                 
               <button class="btn btn-success" id="league_team_add"  type="button">Add</button>
              </div>
          </div>

             <div id="all_team_content"></div>



          
          

                         
          
            
          
           
          
            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
    <!-- Modal to add edit league Ends-->

    <!-- Modal to delete league start-->
    <div class="modal fade" id="myModal_delete" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-transparent">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body p-3 pt-0">
            <div class="text-center mb-2">
              <h1 class="mb-1">Delete League</h1>
              <p>Are you sure?</p>
            </div>

            <div class="alert alert-warning" role="alert">
              <h6 class="alert-heading">Warning!</h6>
              <div class="alert-body">
                Do you really want to delete this record? This process cannot be undone.
              </div>
            </div>

         
            
              <div class="col-sm-12 ps-sm-0">
                <input type="hidden" id="delete_id" value="" />
                <button type="submit" id="btn-save_delete" class="btn btn-warning data-delete">Delete</button>
                 <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
              </div>
             
           
          </div>
        </div>
      </div>
    </div>
    <!-- Modal to delete league Ends-->

    <!-- Modal to view league starts-->
    <div class="modal modal-slide-in edit-league-modal fade" id="modals-slide-in-view">
      <div class="modal-dialog">
       
          <form class="edit-new-league modal-content pt-0"  id="postForm_view" name="postForm_view" >
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
          <div class="modal-header mb-1">
            <h5 class="modal-title" id="exampleModalLabel_view">League Details</h5>
          </div>
          <div class="modal-body flex-grow-1">
            <div  id="details_modal_body_content">
             
            </div>
           
            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
    <!-- Modal to add edit league Ends-->

  </div>
  <!-- list and filter end -->
</section>
<!-- leagues list ends -->
@endsection

@section('vendor-script')
  {{-- Vendor js files --}}
  <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/jszip.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/pdfmake.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/vfs_fonts.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.html5.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.print.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.rowGroup.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/forms/cleave/cleave.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/forms/cleave/addons/cleave-phone.us.js')) }}"></script>

  
 



@endsection

@section('page-script')
  {{-- Page js files --}}
   
<script> 

var custom_get_all_permissions_access_Array = <?php echo json_encode($custom_get_all_permissions_access); ?>; 
var game_obj = <?php echo json_encode($game); ?>; 
//alert(JSON.stringify(game_obj));
</script>

  <script src="{{ asset('js/scripts/pages/app-league-list.js') }}"></script>
  }
@endsection

