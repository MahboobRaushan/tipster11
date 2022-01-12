@extends('layouts/contentLayoutMaster')

@section('title', 'User List')

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

<?php 
 //print_r($custom_get_all_permissions_access);
 // die();
  ?>

   


<!-- users list start -->
<section class="app-user-list">
  <div class="row">
    <div class="col-lg-3 col-sm-6">
      <div class="card">
        <div class="card-body d-flex align-items-center justify-content-between">
          <div>
            <h3 class="fw-bolder mb-75">21,459</h3>
            <span>Total Users</span>
          </div>
          <div class="avatar bg-light-primary p-50">
            <span class="avatar-content">
              <i data-feather="user" class="font-medium-4"></i>
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
            <span>Paid Users</span>
          </div>
          <div class="avatar bg-light-danger p-50">
            <span class="avatar-content">
              <i data-feather="user-plus" class="font-medium-4"></i>
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
            <span>Active Users</span>
          </div>
          <div class="avatar bg-light-success p-50">
            <span class="avatar-content">
              <i data-feather="user-check" class="font-medium-4"></i>
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
            <span>Pending Users</span>
          </div>
          <div class="avatar bg-light-warning p-50">
            <span class="avatar-content">
              <i data-feather="user-x" class="font-medium-4"></i>
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
        <div class="col-md-4 user_role"></div>
        <div class="col-md-4 user_plan"></div>
        <div class="col-md-4 user_status"></div>
      </div>
    </div>
    <div class="card-datatable table-responsive pt-0">
      <table class="user-list-table table">
        <thead class="table-light">
          <tr>
            <th></th>
            <th>ID</th>
            <th>Photo</th>
            <th>Name</th>
            <th>Email</th>           
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
      </table>
    </div>
    <!-- Modal to add new user starts-->
    <div class="modal modal-slide-in new-user-modal fade" id="modals-slide-in">
      <div class="modal-dialog">
        <form class="add-new-user modal-content pt-0"  id="postForm" name="postForm" >
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
          <div class="modal-header mb-1">
            <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
          </div>
          <div class="modal-body flex-grow-1">
            <div class="mb-1">
              <label class="form-label" for="basic-icon-default-fullname">Name</label>
              <input
                type="text"
                class="form-control dt-full-name"
                id="basic-icon-default-fullname"
                placeholder="John Doe"
                name="name"
              />
            </div>
            
            <div class="mb-1">
              <label class="form-label" for="basic-icon-default-email">Email</label>
              <input
                type="text"
                id="basic-icon-default-email"
                class="form-control dt-email"
                placeholder="john.doe@example.com"
                name="email"
              />
            </div>   

            <div class="mb-1">
              <label class="form-label" for="basic-icon-default-password">Password</label>
              <input
                type="password"
                class="form-control dt-full-name"
                id="basic-icon-default-password"
                placeholder="******"
                name="password" value=""
              />
            </div>        
          
            
          
           
            <button type="submit" id="btn-save" class="btn btn-primary me-1 data-submit">Save</button>
            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
    <!-- Modal to add new user Ends-->
     <!-- Modal to edit user starts-->
    <div class="modal modal-slide-in edit-user-modal fade" id="modals-slide-in-edit">
      <div class="modal-dialog">
        <form class="edit-new-user modal-content pt-0"  id="postForm_edit" name="postForm_edit" >
          <input type="hidden" id="edit_id" name="edit_id" value="" />
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
          <div class="modal-header mb-1">
            <h5 class="modal-title" id="exampleModalLabel_edit">Edit User</h5>
          </div>
          <div class="modal-body flex-grow-1">
            <div class="mb-1">
              <label class="form-label" for="basic-icon-default-fullname_edit">Name</label>
              <input
                type="text"
                class="form-control dt-full-name"
                id="basic-icon-default-fullname_edit"
                placeholder="John Doe"
                name="name"
              />
            </div>
            
            <div class="mb-1">
              <label class="form-label" for="basic-icon-default-email_edit">Email</label>
              <input
                type="text"
                id="basic-icon-default-email_edit"
                class="form-control dt-email"
                placeholder="john.doe@example.com"
                name="email"
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

            <div class="mb-1">
              <label class="form-label" for="basic-icon-default-password_edit">Password</label>
              <input
                type="password"
                class="form-control"
                id="basic-icon-default-password_edit"
               
                name="password" value=""
              />
            </div>        
          
            
          
           
            <button type="submit" id="btn-save_edit" class="btn btn-primary me-1 data-submit">Update</button>
            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
    <!-- Modal to add edit user Ends-->
     <!-- Modal to permission user starts-->
    <div class="modal modal-slide-in permission-user-modal fade" id="modals-slide-in-permission">
      <div class="modal-dialog">
        <form class="permission-new-user modal-content pt-0"  id="postForm_permission" name="postForm_permission" >
          <input type="hidden" id="permission_id" name="permission_id" value="" />
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
          <div class="modal-header mb-1">
            <h5 class="modal-title" id="exampleModalLabel_permission">Edit User Permission</h5>
          </div>
          <div class="modal-body flex-grow-1">
            <div class="mb-1">
              <label class="form-label" for="basic-icon-default-fullname_permission">Name</label>
              <input
                type="text"
                class="form-control dt-full-name"
                id="basic-icon-default-fullname_permission"
                placeholder="John Doe"
                name="name" readonly
              />
            </div>

             <div class="mb-1">
              <label class="form-label" for="basic-icon-default-fullname_role">Role</label>
              <select 
                class="select2"
                id="basic-icon-default-fullname_role"
                
                name="role" 
              ></select>
            </div>
            <div class="mb-1">
              <label class="form-label" for="basic-icon-default-fullname_permission">Permissions</label>
              <div
                id="basic-icon-default-fullname_permission_details"
              ></div>
            </div>
            
          
            
          
           
            <button type="submit" id="btn-save_permission" class="btn btn-primary me-1 data-submit">Update</button>
            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
    <!-- Modal to add permission user Ends-->

    <!-- Modal to delete user start-->
    <div class="modal fade" id="myModal_delete" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-transparent">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body p-3 pt-0">
            <div class="text-center mb-2">
              <h1 class="mb-1">Delete User</h1>
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
    <!-- Modal to delete user Ends-->

    <!-- Modal to view user starts-->
    <div class="modal modal-slide-in edit-user-modal fade" id="modals-slide-in-view">
      <div class="modal-dialog">
       
          <form class="edit-new-user modal-content pt-0"  id="postForm_view" name="postForm_view" >
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
          <div class="modal-header mb-1">
            <h5 class="modal-title" id="exampleModalLabel_view">User Details</h5>
          </div>
          <div class="modal-body flex-grow-1">
            <div  id="details_modal_body_content">
             
            </div>
           
            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
    <!-- Modal to add edit user Ends-->

  </div>
  <!-- list and filter end -->
</section>
<!-- users list ends -->
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
var current_user_id = "<?php echo $current_user_id ;?>";
var custom_get_all_permissions_access_Array = <?php echo json_encode($custom_get_all_permissions_access); ?>; 
</script>


  <script src="{{ asset(mix('js/scripts/pages/app-user-list.js')) }}"></script>
  }
@endsection

