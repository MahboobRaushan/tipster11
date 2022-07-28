@extends('layouts/contentLayoutMaster')

@section('title', 'Announcement List')

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
<!-- announcements list start -->


<section class="app-announcement-list">
  <div class="row">
    <div class="col-lg-3 col-sm-6">
      <div class="card">
        <div class="card-body d-flex align-items-center justify-content-between">
          <div>
            <h3 class="fw-bolder mb-75">21,459</h3>
            <span>Total Announcementes</span>
          </div>
          <div class="avatar bg-light-primary p-50">
            <span class="avatar-content">
              <i data-feather="announcement" class="font-medium-4"></i>
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
            <span>Paid Announcementes</span>
          </div>
          <div class="avatar bg-light-danger p-50">
            <span class="avatar-content">
              <i data-feather="announcement-plus" class="font-medium-4"></i>
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
            <span>Active Announcementes</span>
          </div>
          <div class="avatar bg-light-success p-50">
            <span class="avatar-content">
              <i data-feather="announcement-check" class="font-medium-4"></i>
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
            <span>Pending Announcementes</span>
          </div>
          <div class="avatar bg-light-warning p-50">
            <span class="avatar-content">
              <i data-feather="announcement-x" class="font-medium-4"></i>
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
        <div class="col-md-4 announcement_role"></div>
        <div class="col-md-4 announcement_plan"></div>
        <div class="col-md-4 announcement_status"></div>
      </div>
    </div>
    <div class="card-datatable table-responsive pt-0">
      <table class="announcement-list-table table">
        <thead class="table-light">
          <tr>
            <th></th>
            <th>ID</th>           
            <th>Title</th>                          
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
      </table>


    </div>

    <div class="d-flex justify-content-between mx-0 row dataTables_wrapper "><div class="col-sm-12 col-md-4"><div class="dataTables_info" id="DataTables_Table_1_info" >Showing <span id="pagination_start_no"></span> to <span id="pagination_end_no"></span> of <span id="pagination_total_entries"></span> entries</div></div><div class="col-sm-12 col-md-8"><div class="dataTables_paginate paging_simple_numbers" id="dataTables_paginate_id" ><div class="pagination" >
          
        </div></div></div></div>

 
    <!-- Modal to add new announcement starts-->
    <div class="modal modal-slide-in new-announcement-modal fade" id="modals-slide-in">
      <div class="modal-dialog">
        <form class="add-new-announcement modal-content pt-0"  method="POST" id="postForm" name="postForm" enctype="multipart/form-data" >
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
          <div class="modal-header mb-1">
            <h5 class="modal-title" id="exampleModalLabel">Add Announcement</h5>
          </div>
          <div class="modal-body flex-grow-1">
            
           
          

            
            <div class="mb-1">
              <div class="row">
                 <div class="col-sm-12">
                  <label class="form-label" for="title">Title</label>
                    <input
                      type="text"
                     
                      class="form-control"
                       placeholder="Title"
                      id="title"
                     
                      name="title"
                    />
                 </div>
                 
               </div>
              
            </div>

          
            

         
           
            <button type="submit" id="btn-save" class="btn btn-primary me-1 data-submit">Save</button>
            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
    <!-- Modal to add new announcement Ends-->
     <!-- Modal to edit announcement starts-->
    <div class="modal modal-slide-in edit-announcement-modal fade" id="modals-slide-in-edit">
      <div class="modal-dialog">
        <form class="edit-new-announcement modal-content pt-0" method="POST"  id="postForm_edit" name="postForm_edit" enctype="multipart/form-data">
          <input type="hidden" id="edit_id" name="edit_id" value="" />
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
          <div class="modal-header mb-1">
            <h5 class="modal-title" id="exampleModalLabel_edit">Edit Announcement</h5>
          </div>
          <div class="modal-body flex-grow-1">
            
              
           

         

          
            <div class="mb-1">
              <div class="row">
                 <div class="col-sm-12">
                  <label class="form-label" for="title_edit">Title</label>
                    <input
                      type="text"
                     
                      class="form-control"
                       placeholder="Title"
                      id="title_edit"
                     
                      name="title"
                    />
                 </div>
                 
               </div>
              
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
    <!-- Modal to add edit announcement Ends-->

    <!-- Modal to delete announcement start-->
    <div class="modal fade" id="myModal_delete" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-transparent">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body p-3 pt-0">
            <div class="text-center mb-2">
              <h1 class="mb-1">Delete Announcement</h1>
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
    <!-- Modal to delete announcement Ends-->

    <!-- Modal to view announcement starts-->
    <div class="modal modal-slide-in edit-announcement-modal fade" id="modals-slide-in-view">
      <div class="modal-dialog">
       
          <form class="edit-new-announcement modal-content pt-0"  id="postForm_view" name="postForm_view" >
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
          <div class="modal-header mb-1">
            <h5 class="modal-title" id="exampleModalLabel_view">Announcement Details</h5>
          </div>
          <div class="modal-body flex-grow-1">
            <div  id="details_modal_body_content">
             
            </div>
           
            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
    <!-- Modal to add edit announcement Ends-->

  </div>
  <!-- list and filter end -->
</section>
<!-- announcements list ends -->
@endsection

@section('vendor-script')
  {{-- Vendor js files --}}

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
var announcement_obj = <?php echo json_encode($announcements); ?>; 
var custom_get_all_permissions_access_Array = <?php echo json_encode($custom_get_all_permissions_access); ?>; 
</script>

  <script src="{{ asset('js/scripts/pages/app-announcement-list.js') }}"></script>
  }
@endsection

