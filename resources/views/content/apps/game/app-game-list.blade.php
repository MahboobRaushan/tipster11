@extends('layouts/contentLayoutMaster')

@section('title', 'Game List')

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
<!-- games list start -->


<section class="app-game-list">
  <div class="row">
    <div class="col-lg-3 col-sm-6">
      <div class="card">
        <div class="card-body d-flex align-items-center justify-content-between">
          <div>
            <h3 class="fw-bolder mb-75">21,459</h3>
            <span>Total Games</span>
          </div>
          <div class="avatar bg-light-primary p-50">
            <span class="avatar-content">
              <i data-feather="game" class="font-medium-4"></i>
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
            <span>Paid Games</span>
          </div>
          <div class="avatar bg-light-danger p-50">
            <span class="avatar-content">
              <i data-feather="game-plus" class="font-medium-4"></i>
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
            <span>Active Games</span>
          </div>
          <div class="avatar bg-light-success p-50">
            <span class="avatar-content">
              <i data-feather="game-check" class="font-medium-4"></i>
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
            <span>Pending Games</span>
          </div>
          <div class="avatar bg-light-warning p-50">
            <span class="avatar-content">
              <i data-feather="game-x" class="font-medium-4"></i>
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
        <div class="col-md-4 game_role"></div>
        <div class="col-md-4 game_plan"></div>
        <div class="col-md-4 game_status"></div>
      </div>
    </div>
    <div class="card-datatable table-responsive pt-0">
      <table class="game-list-table table">
        <thead class="table-light">
          <tr>
            <th></th>
            <th>ID</th>
            <th>Icon</th>
            <th>Name</th>                    
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
      </table>
    </div>
    <!-- Modal to add new game starts-->
    <div class="modal modal-slide-in new-game-modal fade" id="modals-slide-in">
      <div class="modal-dialog">
        <form class="add-new-game modal-content pt-0"  method="POST" id="postForm" name="postForm" enctype="multipart/form-data" >
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
          <div class="modal-header mb-1">
            <h5 class="modal-title" id="exampleModalLabel">Add Game</h5>
          </div>
          <div class="modal-body flex-grow-1">
            <div class="mb-1">
              <label class="form-label" for="basic-icon-default-fullname">Name</label>
              <input
                type="text"
                class="form-control dt-full-name"
                id="basic-icon-default-fullname"
                placeholder="Football"
                name="name"
              />
            </div>
           

            <div class="mb-1">
              <label class="form-label" for="basic-icon-default-icon">Icon</label>
               <input  class="form-label" type="file" name="image" placeholder="Choose image" id="basic-icon-default-icon">

               <img id="preview-image-before-upload" src="images/icons/file-icons/onedrive.png"
alt="preview image" style="max-height: 100px;">
              
            </div>
           
            <button type="submit" id="btn-save" class="btn btn-primary me-1 data-submit">Save</button>
            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
    <!-- Modal to add new game Ends-->
     <!-- Modal to edit game starts-->
    <div class="modal modal-slide-in edit-game-modal fade" id="modals-slide-in-edit">
      <div class="modal-dialog">
        <form class="edit-new-game modal-content pt-0" method="POST"  id="postForm_edit" name="postForm_edit" enctype="multipart/form-data">
          <input type="hidden" id="edit_id" name="edit_id" value="" />
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
          <div class="modal-header mb-1">
            <h5 class="modal-title" id="exampleModalLabel_edit">Edit Game</h5>
          </div>
          <div class="modal-body flex-grow-1">
            <div class="mb-1">
              <label class="form-label" for="basic-icon-default-fullname_edit">Name</label>
              <input
                type="text"
                class="form-control dt-full-name"
                id="basic-icon-default-fullname_edit"
                placeholder="Football"
                name="name"
              />
            </div>


         

             <div class="mb-1">
              <label class="form-label" for="basic-icon-default-icon">Icon</label>
               <input  class="form-label" type="file" name="image" placeholder="Choose image" id="basic-icon-default-icon_edit">
              
               <img id="preview-image-before-upload_edit" src="images/icons/file-icons/onedrive.png"
alt="preview image" style="max-height: 100px;">
              
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
    <!-- Modal to add edit game Ends-->

    <!-- Modal to delete game start-->
    <div class="modal fade" id="myModal_delete" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-transparent">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body p-3 pt-0">
            <div class="text-center mb-2">
              <h1 class="mb-1">Delete Game</h1>
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
    <!-- Modal to delete game Ends-->

    <!-- Modal to view game starts-->
    <div class="modal modal-slide-in edit-game-modal fade" id="modals-slide-in-view">
      <div class="modal-dialog">
       
          <form class="edit-new-game modal-content pt-0"  id="postForm_view" name="postForm_view" >
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
          <div class="modal-header mb-1">
            <h5 class="modal-title" id="exampleModalLabel_view">Game Details</h5>
          </div>
          <div class="modal-body flex-grow-1">
            <div  id="details_modal_body_content">
             
            </div>
           
            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
    <!-- Modal to add edit game Ends-->

  </div>
  <!-- list and filter end -->
</section>
<!-- games list ends -->
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
</script>

  <script src="{{ asset('js/scripts/pages/app-game-list.js') }}"></script>
  }
@endsection

