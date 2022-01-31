@extends('layouts/contentLayoutMaster')

@section('title', 'Match List')

@section('vendor-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css')) }}">

  <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">



@endsection

@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
@endsection

@section('content')
<!-- matchs list start -->


<section class="app-match-list">
  <div class="row">
    <div class="col-lg-3 col-sm-6">
      <div class="card">
        <div class="card-body d-flex align-items-center justify-content-between">
          <div>
            <h3 class="fw-bolder mb-75">21,459</h3>
            <span>Total Matches</span>
          </div>
          <div class="avatar bg-light-primary p-50">
            <span class="avatar-content">
              <i data-feather="match" class="font-medium-4"></i>
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
            <span>Paid Matches</span>
          </div>
          <div class="avatar bg-light-danger p-50">
            <span class="avatar-content">
              <i data-feather="match-plus" class="font-medium-4"></i>
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
            <span>Active Matches</span>
          </div>
          <div class="avatar bg-light-success p-50">
            <span class="avatar-content">
              <i data-feather="match-check" class="font-medium-4"></i>
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
            <span>Pending Matches</span>
          </div>
          <div class="avatar bg-light-warning p-50">
            <span class="avatar-content">
              <i data-feather="match-x" class="font-medium-4"></i>
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
        <div class="col-md-4 match_role"></div>
        <div class="col-md-4 match_plan"></div>
        <div class="col-md-4 match_status"></div>
      </div>
    </div>
    <div class="card-datatable table-responsive pt-0">
      <table class="match-list-table table">
        <thead class="table-light">
          <tr>
            <th></th>
            <th>ID</th>           
            <th>Home Team</th> 
             <th>Away Team</th>   
             <th>Start Time</th>
             <th>End Time</th>
             <th>League</th>
             <th>Result</th>                
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
      </table>


    </div>

    <div class="d-flex justify-content-between mx-0 row dataTables_wrapper "><div class="col-sm-12 col-md-4"><div class="dataTables_info" id="DataTables_Table_1_info" >Showing <span id="pagination_start_no"></span> to <span id="pagination_end_no"></span> of <span id="pagination_total_entries"></span> entries</div></div><div class="col-sm-12 col-md-8"><div class="dataTables_paginate paging_simple_numbers" id="dataTables_paginate_id" ><div class="pagination" >
          
        </div></div></div></div>

 
    <!-- Modal to add new match starts-->
    <div class="modal modal-slide-in new-match-modal fade" id="modals-slide-in">
      <div class="modal-dialog">
        <form class="add-new-match modal-content pt-0"  method="POST" id="postForm" name="postForm" enctype="multipart/form-data" >
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
          <div class="modal-header mb-1">
            <h5 class="modal-title" id="exampleModalLabel">Add Match</h5>
          </div>
          <div class="modal-body flex-grow-1">
              <div class="mb-1">
              <label class="form-label" for="basic-icon-default-fullname">League</label>
              <select 
                class="form-control select2"
                id="basic-icon-default-league"
               required
                name="league"
              ></select>
            </div>
            <div class="mb-1">
              <label class="form-label" for="basic-icon-default-fullname">Home Team</label>
             
              <select 
                class="form-control select2"
                id="basic-icon-default-homeTeam"
               required
                name="homeTeam"
              ></select>
            </div>

            <div class="mb-1">
              <label class="form-label" for="basic-icon-default-fullname">Away Team</label>
              
              <select 
                class="form-control select2"
                id="basic-icon-default-awayTeam"
                required 
                name="awayTeam"
              ></select>
            </div>

            <div class="mb-1">
              <div class="row">
                 <div class="col-sm-6">
                  <label class="form-label" for="basic-icon-default-fullname">Start Date</label>
                    <input
                      type="text"
                     
                      class="form-control flatpickr-basic"
                       placeholder="YYYY-MM-DD"
                      id="basic-icon-default-startTimedate"
                     
                      name="startTimedate"
                    />
                 </div>
                  <div class="col-sm-6">
                    <label class="form-label" for="basic-icon-default-fullname">Start Time</label>
                      <input
                        type="text"
                       
                        class="form-control flatpickr-time text-start" 
                        placeholder="HH:MM"
                       
                        id="basic-icon-default-startTimetime"
                       
                        name="startTimetime"
                      />
                 </div>
               </div>
              
            </div>
            <div class="mb-1">
              <div class="row">
                 <div class="col-sm-6">
                  <label class="form-label" for="basic-icon-default-fullname">End Date</label>
                    <input
                      type="text"
                     
                      class="form-control flatpickr-basic"
                       placeholder="YYYY-MM-DD"
                      id="basic-icon-default-endTimedate"
                     
                      name="endTimedate"
                    />
                 </div>
                  <div class="col-sm-6">
                    <label class="form-label" for="basic-icon-default-fullname">End Time</label>
                      <input
                        type="text"
                       
                        class="form-control flatpickr-time text-start" 
                        placeholder="HH:MM"
                       
                        id="basic-icon-default-endTimetime"
                       
                        name="endTimetime"
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
    <!-- Modal to add new match Ends-->
     <!-- Modal to edit match starts-->
    <div class="modal modal-slide-in edit-match-modal fade" id="modals-slide-in-edit">
      <div class="modal-dialog">
        <form class="edit-new-match modal-content pt-0" method="POST"  id="postForm_edit" name="postForm_edit" enctype="multipart/form-data">
          <input type="hidden" id="edit_id" name="edit_id" value="" />
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
          <div class="modal-header mb-1">
            <h5 class="modal-title" id="exampleModalLabel_edit">Edit Match</h5>
          </div>
          <div class="modal-body flex-grow-1">
            
              <div class="mb-1">
              <label class="form-label" for="basic-icon-default-fullname">League</label>            
               <select 
                class="form-control select2"
                id="basic-icon-default-league_edit"
               required
                name="league"
              ></select>
            </div>
             <div class="mb-1">
              <label class="form-label" for="basic-icon-default-fullname">Home Team</label>
          
               <select 
                class="form-control select2"
                id="basic-icon-default-homeTeam_edit"
               required
                name="homeTeam"
              ></select>
            </div>

            <div class="mb-1">
              <label class="form-label" for="basic-icon-default-fullname">Away Team</label>
               <select 
                class="form-control select2"
                id="basic-icon-default-awayTeam_edit"
               required
                name="awayTeam"
              ></select>
            </div>

           <div class="mb-1">
              <div class="row">
                 <div class="col-sm-6">
                  <label class="form-label" for="basic-icon-default-fullname">Start Date</label>
                    <input
                      type="text"
                     
                      class="form-control flatpickr-basic"
                       placeholder="YYYY-MM-DD"
                      id="basic-icon-default-startTimedate_edit"
                     
                      name="startTimedate"
                    />
                 </div>
                  <div class="col-sm-6">
                    <label class="form-label" for="basic-icon-default-fullname">Start Time</label>
                      <input
                        type="text"
                       
                        class="form-control flatpickr-time text-start" 
                        placeholder="HH:MM"
                       
                        id="basic-icon-default-startTimetime_edit"
                       
                        name="startTimetime"
                      />
                 </div>
               </div>
              
            </div>
            <div class="mb-1">
              <div class="row">
                 <div class="col-sm-6">
                  <label class="form-label" for="basic-icon-default-fullname">End Date</label>
                    <input
                      type="text"
                     
                      class="form-control flatpickr-basic"
                       placeholder="YYYY-MM-DD"
                      id="basic-icon-default-endTimedate_edit"
                     
                      name="endTimedate"
                    />
                 </div>
                  <div class="col-sm-6">
                    <label class="form-label" for="basic-icon-default-fullname">End Time</label>
                      <input
                        type="text"
                       
                        class="form-control flatpickr-time text-start" 
                        placeholder="HH:MM"
                       
                        id="basic-icon-default-endTimetime_edit"
                       
                        name="endTimetime"
                      />
                 </div>
               </div>
              
            </div>

          
         
             <div class="mb-1">
              <label class="form-label" for="basic-icon-default-result_edit">Result</label>
              <select
                id="basic-icon-default-result_edit"
                class="form-control select2"
                name="result"
               >
               <option value="home">Home</option>
               <option value="draw">Draw</option>
               <option value="away">Away</option>
             </select>
            </div>    
           
            <div class="mb-1">
              <label class="form-label" for="basic-icon-default-home_score_edit">Home Score</label>
              <input type="text"
                id="basic-icon-default-home_score_edit"
                class="form-control"
                name="home_score"
               />
              
            </div> 

            <div class="mb-1">
              <label class="form-label" for="basic-icon-default-away_score_edit">Away Score</label>
              <input type="text"
                id="basic-icon-default-away_score_edit"
                class="form-control"
                name="away_score"
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
    <!-- Modal to add edit match Ends-->

    <!-- Modal to delete match start-->
    <div class="modal fade" id="myModal_delete" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-transparent">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body p-3 pt-0">
            <div class="text-center mb-2">
              <h1 class="mb-1">Delete Match</h1>
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
    <!-- Modal to delete match Ends-->

    <!-- Modal to view match starts-->
    <div class="modal modal-slide-in edit-match-modal fade" id="modals-slide-in-view">
      <div class="modal-dialog">
       
          <form class="edit-new-match modal-content pt-0"  id="postForm_view" name="postForm_view" >
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
          <div class="modal-header mb-1">
            <h5 class="modal-title" id="exampleModalLabel_view">Match Details</h5>
          </div>
          <div class="modal-body flex-grow-1">
            <div  id="details_modal_body_content">
             
            </div>
           
            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
    <!-- Modal to add edit match Ends-->

  </div>
  <!-- list and filter end -->
</section>
<!-- matchs list ends -->
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

  
 <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>



@endsection

@section('page-script')
  {{-- Page js files --}}

   <script src="{{ asset(mix('js/scripts/forms/pickers/form-pickers.js')) }}"></script>
   
<script> 
var league_obj = <?php echo json_encode($league); ?>; 
var custom_get_all_permissions_access_Array = <?php echo json_encode($custom_get_all_permissions_access); ?>; 
</script>

  <script src="{{ asset('js/scripts/pages/app-match-list.js') }}"></script>
  }
@endsection

