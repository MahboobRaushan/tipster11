@extends('layouts/contentLayoutMaster')

@section('title', 'Pools List')

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
            <th>Name</th>
            <th>Start Time</th>           
            <th>End Time</th>
            <th>Per Bet Amount</th>
            <th>Base Price</th>
            <th>Percentage</th>
            <th>Is Jackpot Pool</th>
            <th>Actions</th>
          </tr>
        </thead>
      </table>
    </div>
    <!-- Modal to add new pools starts-->
    <div class="modal modal-slide-in new-pools-modal fade" id="modals-slide-in">
      <div class="modal-dialog">
        <form class="add-new-pools modal-content pt-0"  id="postForm" name="postForm" >
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
          <div class="modal-header mb-1">
            <h5 class="modal-title" id="exampleModalLabel">Add New Pool</h5>
          </div>
          <div class="modal-body flex-grow-1">
            <div class="mb-1">
              <label class="form-label" for="basic-icon-default-fullname">Name</label>
              <input
                type="text"
                class="form-control dt-full-name"
                id="basic-icon-default-fullname"
                placeholder="World Cup"
                name="name"
              />
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
            <div class="mb-1">
              <label class="form-label" for="basic-icon-default-fullname">Mega Jackpot Percentage</label>
              <input
                type="number"
                class="form-control dt-full-name"
                id="basic-icon-default-mega_percentage"
                placeholder="10"
                name="mega_percentage"
              />
            </div>
            <div class="mb-1">
              <label class="form-label" for="basic-icon-default-fullname">Pool Prize Percentage</label>
              <input
                type="number"
                class="form-control dt-full-name"
                id="basic-icon-default-pool_prize_percentage"
                placeholder="20"
                name="pool_prize_percentage"
              />
            </div>
            <div class="mb-1">
              <label class="form-label" for="basic-icon-default-fullname">Company Percentage</label>
              <input
                type="number"
                class="form-control dt-full-name"
                id="basic-icon-default-com_percentage"
                placeholder="60"
                name="com_percentage"
              />
            </div>
            <div class="mb-1">
              <label class="form-label" for="basic-icon-default-fullname">Agent Percentage</label>
              <input
                type="number"
                class="form-control dt-full-name"
                id="basic-icon-default-agent_percentage"
                placeholder="10"
                name="agent_percentage"
              />
            </div>
             <div class="mb-1">
              <label class="form-label" for="basic-icon-default-isJackpotPool">Is Jackpot Pool</label>
              <select
                id="basic-icon-default-isJackpotPool"
                class="form-control select2"
                name="isJackpotPool"
               >
               <option value="Yes">Yes</option>
               <option value="No">No</option>
             </select>
            </div> 
            
           

          
           
            <button type="button" id="btn-save" class="btn btn-primary me-1 data-submit">Save</button>
            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
    <!-- Modal to add new pools Ends-->
    

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




@endsection

@section('page-script')
  {{-- Page js files --}}
   
 <script src="{{ asset(mix('js/scripts/forms/pickers/form-pickers.js')) }}"></script>

  <script src="{{ asset(mix('js/scripts/pages/app-pools-list.js')) }}"></script>
  }
@endsection

