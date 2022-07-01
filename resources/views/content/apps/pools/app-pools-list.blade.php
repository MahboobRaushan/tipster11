@extends('layouts/contentLayoutMaster')

@section('title', 'Jackpot List')

@section('vendor-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css')) }}">

  <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">


  <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">

@endsection

@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
   <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
<link rel="stylesheet" href="{{asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css'))}}">
@endsection

@section('content')

<?php 
 //print_r($custom_get_all_permissions_access);
 // die();
  ?>


 





<!-- poolss list start -->
<section class="app-pools-list">
  
  <!-- list and filter start -->
  <div class="card">
    
    <div class="card-datatable table-responsive pt-0">
      <table class="pools-list-table table">
        <thead class="table-light">
          <tr>
            <th></th>
            <th>ID</th>
            <th>Icon</th>
            <th>Name</th>
            <th>Start Time</th>           
            <th>End Time</th>
            <th>Per Bet Amount</th>
            <th>Base Price</th>
            <th>Commission</th>
            <th>Percentage</th>
            <th>Status</th>
            <th>Is Jackpot Pool</th>
            <th>Actions</th>
          </tr>
        </thead>
      </table>
    </div>
    <!-- Modal to add new pools starts-->
    <div class="modal modal-slide-in new-pools-modal fade" id="modals-slide-in">
      <div class="modal-dialog">
        <form class="add-new-pools modal-content pt-0"  id="postForm" name="postForm" enctype="multipart/form-data">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
          <div class="modal-header mb-1">
            <h5 class="modal-title" id="exampleModalLabel">Add New Jackpot</h5>
          </div>
          <div class="modal-body flex-grow-1">
            <div class="mb-1">
              <label class="form-label" for="basic-icon-default-fullname">Name</label>
              <input
                type="text"
                class="form-control dt-full-name"
                id="basic-icon-default-fullname"
                placeholder="Jackpot 1"
                name="name"
              />
            </div>

              <div class="mb-1">
              <label class="form-label" for="basic-icon-default-icon">Icon</label>
               <input  class="form-label" type="file" name="image" placeholder="Choose image" id="basic-icon-default-icon">

               <img id="preview-image-before-upload" src="images/icons/file-icons/onedrive.png"
alt="preview image" style="max-height: 100px;">
              
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
              <label class="form-label" for="basic-icon-default-fullname">Per Bet Amount</label>
              <input
                type="number"
                class="form-control dt-full-name"
                id="basic-icon-default-perBetAmount"
                placeholder="20"
                name="perBetAmount"
              />
            </div>
            <div class="mb-1">
              <label class="form-label" for="basic-icon-default-fullname">Base Price</label>
              <input
                type="number"
                class="form-control dt-full-name"
                id="basic-icon-default-basePrice"
                placeholder="2000"
                name="basePrice"
              />
            </div>
            <hr>
            <div class="mb-1">
              <label class="form-label" for="basic-icon-default-fullname">Commission (%)</label>
             
             <table width="100%" >
                <tr><th>Mega Jackpot</th><th>Jackpot Prize</th><th>Company</th><th>Agent</th></tr>
                <tr><td><input
                type="number"
                class="form-control dt-full-name"
                id="basic-icon-default-megaPercentage"
                placeholder="10"
                name="megaPercentage"
              /></td><td><input
                type="number"
                class="form-control dt-full-name"
                id="basic-icon-default-poolPercentage"
                placeholder="20"
                name="poolPercentage"
              /></td><td> <input
                type="number"
                class="form-control dt-full-name"
                id="basic-icon-default-comPercentage"
                placeholder="60"
                name="comPercentage"
              /></td><td><input
                type="number"
                class="form-control dt-full-name"
                id="basic-icon-default-agentPercentage"
                placeholder="10"
                name="agentPercentage"
              /></td></tr>
             </table>
            </div>


          
        
            <hr>
             <div class="mb-1">

               <label class="form-label" for="basic-icon-default-fullname">Group Percentage (%)</label>
             
             <table width="100%" >
                <tr><th>Group 1</th><th>Group 2</th><th>Group 3</th></tr>
                <tr><td><input
                type="number"
                class="form-control dt-full-name"
                id="basic-icon-default-group1Percentage"
                placeholder="50"
                name="group1Percentage"
              /></td><td> <input
                type="number"
                class="form-control dt-full-name"
                id="basic-icon-default-group2Percentage"
                placeholder="30"
                name="group2Percentage"
              /></td><td> <input
                type="number"
                class="form-control dt-full-name"
                id="basic-icon-default-group3Percentage"
                placeholder="20"
                name="group3Percentage"
              /></td></tr>


              </table>
              
            </div>
           
           


             <div class="mb-1">
              <label class="form-label" for="basic-icon-default-isJackpotPool">Is Jackpot Pool</label>
              <select
                id="basic-icon-default-isJackpotPool"
                class="form-control select2"
                name="isJackpotPool"
               >               
               <option value="0">No</option>
               <option value="1">Yes</option>
             </select>
            </div> 
            
           

          
           
            <button type="submit" id="btn-save" class="btn btn-primary me-1 data-submit">Save</button>
            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
    <!-- Modal to add new pools Ends-->
     <!-- Modal to edit pools starts-->
    <div class="modal modal-slide-in edit-pools-modal fade" id="modals-slide-in-edit">
      <div class="modal-dialog">
        <form class="edit-new-pools modal-content pt-0" method="POST"  id="postForm_edit" name="postForm_edit" enctype="multipart/form-data">
          <input type="hidden" id="edit_id" name="edit_id" value="" />
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
          <div class="modal-header mb-1">
            <h5 class="modal-title" id="exampleModalLabel_edit">Edit Jackpot</h5>
          </div>
          <div class="modal-body flex-grow-1">
            
            
           <div class="mb-1">
              <label class="form-label" for="basic-icon-default-fullname">Name</label>
              <input
                type="text"
                class="form-control dt-full-name"
                id="basic-icon-default-name_edit"
                placeholder="Jackpot 1"
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
              <label class="form-label" for="basic-icon-default-fullname">Per Bet Amount</label>
              <input
                type="number"
                class="form-control dt-full-name"
                id="basic-icon-default-perBetAmount_edit"
                placeholder="20"
                name="perBetAmount"
              />
            </div>
            <div class="mb-1">
              <label class="form-label" for="basic-icon-default-fullname">Base Price</label>
              <input
                type="number"
                class="form-control dt-full-name"
                id="basic-icon-default-basePrice_edit"
                placeholder="2000"
                name="basePrice"
              />
            </div>
            <hr>
            <div class="mb-1">
              <label class="form-label" for="basic-icon-default-fullname">Commission (%)</label>
             
             <table width="100%" >
                <tr><th>Mega Jackpot</th><th>Jackpot Prize</th><th>Company</th><th>Agent</th></tr>
                <tr><td><input
                type="number"
                class="form-control dt-full-name"
                id="basic-icon-default-megaPercentage_edit"
                placeholder="10"
                name="megaPercentage"
              /></td><td><input
                type="number"
                class="form-control dt-full-name"
                id="basic-icon-default-poolPercentage_edit"
                placeholder="20"
                name="poolPercentage"
              /></td><td> <input
                type="number"
                class="form-control dt-full-name"
                id="basic-icon-default-comPercentage_edit"
                placeholder="60"
                name="comPercentage"
              /></td><td><input
                type="number"
                class="form-control dt-full-name"
                id="basic-icon-default-agentPercentage_edit"
                placeholder="10"
                name="agentPercentage"
              /></td></tr>
             </table>
            </div>


          
        
            <hr>
             <div class="mb-1">

               <label class="form-label" for="basic-icon-default-fullname">Group Percentage (%)</label>
             
             <table width="100%" >
                <tr><th>Group 1</th><th>Group 2</th><th>Group 3</th></tr>
                <tr><td><input
                type="number"
                class="form-control dt-full-name"
                id="basic-icon-default-group1Percentage_edit"
                placeholder="50"
                name="group1Percentage"
              /></td><td> <input
                type="number"
                class="form-control dt-full-name"
                id="basic-icon-default-group2Percentage_edit"
                placeholder="30"
                name="group2Percentage"
              /></td><td> <input
                type="number"
                class="form-control dt-full-name"
                id="basic-icon-default-group3Percentage_edit"
                placeholder="20"
                name="group3Percentage"
              /></td></tr>


              </table>
              
            </div>
           
           


             <div class="mb-1">
              <label class="form-label" for="basic-icon-default-isJackpotPool">Is Jackpot Pool</label>
              <select
                id="basic-icon-default-isJackpotPool_edit"
                class="form-control select2"
                name="isJackpotPool"
               >               
               <option value="0">No</option>
               <option value="1">Yes</option>
             </select>
            </div> 
                   
          
           
            <button type="submit" id="btn-save_edit" class="btn btn-primary me-1 data-submit">Update</button>
            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Modal to edit pools Ends-->
     <!-- Modal to delete pools start-->
    <div class="modal fade" id="myModal_delete" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-transparent">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body p-3 pt-0">
            <div class="text-center mb-2">
              <h1 class="mb-1">Delete Jackpot</h1>
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

      <!-- Modal to delete match pools start-->
    <div class="modal fade" id="myModal_match_delete" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-transparent">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body p-3 pt-0">
            <div class="text-center mb-2">
              <h1 class="mb-1">Delete Jackpot Match</h1>
              <p>Are you sure?</p>
            </div>

            <div class="alert alert-warning" role="alert">
              <h6 class="alert-heading">Warning!</h6>
              <div class="alert-body">
                Do you really want to delete this record? This process cannot be undone.
              </div>
            </div>

         
            
              <div class="col-sm-12 ps-sm-0">
                <input type="hidden" id="match_delete_id" value="" />
                <input type="hidden" id="match_delete_pool_id" value="" />
                <button type="submit" id="btn-save_match_delete" class="btn btn-warning data-delete">Delete</button>
                 <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
              </div>
             
           
          </div>
        </div>
      </div>
    </div>
    <!-- Modal to delete league Ends-->

    <!-- Modal to view league starts-->
    <div class="modal modal-slide-in edit-pools-modal fade" id="modals-slide-in-view">
      <div class="modal-dialog">
       
          <form class="edit-new-league modal-content pt-0"  id="postForm_view" name="postForm_view" >
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
          <div class="modal-header mb-1">
            <h5 class="modal-title" id="exampleModalLabel_view">Jackpot Details</h5>
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

     <!-- Modal to view league starts-->
    <div class="modal modal-slide-in edit-pools-modal fade" id="modals-slide-in-view-result">
      <div class="modal-dialog">
       
         <form class="edit-new-league modal-content pt-0"  id="postForm_view_result" name="postForm_view_result" > 
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
          <div class="modal-header mb-1">
            <h5 class="modal-title" id="exampleModalLabel_view_result">Jackpot / Jackpot Winner</h5>
          </div>
          <div class="modal-body flex-grow-1">
            <div  id="details_modal_body_content_result">
             
            </div>
           
            <button  class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
          </div>
          </form>
        
      </div>
    </div>
    <!-- Modal to add edit league Ends-->


     <!-- Modal to match pool starts-->
    <div class="modal modal-slide-in match-pool-modal fade" id="modals-slide-in-match">
      <div class="modal-dialog">
        <form class="team-new-pools modal-content pt-0" method="POST"  id="postForm_team" name="postForm_team" enctype="multipart/form-data">
          @csrf

          <input type="hidden" id="pool_id" name="pool_id" value="" />
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
          <div class="modal-header mb-1">
            <h5 class="modal-title" id="exampleModalLabel_edit"><span id="league_match_name_div"></span> - Match List</h5>
                        
          </div>
         
          <div class="modal-body flex-grow-1">

             <div class="col-md-12 col-12 mb-1">

                <div class="mb-1">
              <label class="form-label" for="basic-icon-default-fullname_edit">Existing Matches</label>
             <div id="all_match_content"></div>
             </div>
             <hr>
               <div class="mb-1">
              <label class="form-label" for="basic-icon-default-fullname_edit">Select League</label>
                <select
                    id="basic-icon-default-pool_league"
                    class="form-control select2"
                    name="league"
                   >
                   <option value="">Select League</option>
                   
                 </select>
            </div>
          

             <div class="mb-1">
              <label class="form-label" for="basic-icon-default-pool_match">Add Matches</label>
                <div  id="basic-icon-default-pool_match"  ></div>
            </div>
             <div class="mb-1">
              <button class="btn btn-success" id="league_team_add"  type="submit">Add</button>
               <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>

            
          </div>

            
          
           
          </div>
        </form>
      </div>
    </div>
    <!-- Modal to add match pool Ends-->

    

  </div>
  <!-- list and filter end -->
</section>
<!-- poolss list ends -->
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

  <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>


@endsection

@section('page-script')
  {{-- Page js files --}}
   <script> 

var custom_get_all_permissions_access_Array = <?php echo json_encode($custom_get_all_permissions_access); ?>; 

</script>

 <script src="{{ asset(mix('js/scripts/forms/pickers/form-pickers.js')) }}"></script>
 <script src="{{ asset(mix('js/scripts/extensions/ext-component-sweet-alerts.js')) }}"></script>

  <script src="{{ asset(mix('js/scripts/pages/app-pools-list.js')) }}"></script>
  }
@endsection

