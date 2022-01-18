@extends('layouts/contentLayoutMaster')

@section('title', 'Transaction List')

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

   


<!-- transactions list start -->
<section class="app-transaction-list">
  
  <!-- list and filter start -->
  <div class="card">
    
    <div class="card-datatable table-responsive pt-0">
      <table class="transaction-list-table table">
        <thead class="table-light">
          <tr>
            <th></th>
            <th>Username</th>
            <th>Reg Date</th>
            <th>Commission (This Week)</th>           
            <th>Credit Balance</th>
            <th>Member No</th>
            <th>Email</th>
            <th>Status</th>
          
            <th>Actions</th>
          </tr>
        </thead>
      </table>
    </div>
    <!-- Modal to add new transaction starts-->
    <div class="modal modal-slide-in new-transaction-modal fade" id="modals-slide-in">
      <div class="modal-dialog">
        <form class="add-new-transaction modal-content pt-0"  id="postForm" name="postForm" >
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
          <div class="modal-header mb-1">
            <h5 class="modal-title" id="exampleModalLabel">Add New Transaction</h5>
          </div>
          <div class="modal-body flex-grow-1">
            <div class="mb-1">
              <label class="form-label" for="basic-icon-default-fullname">Username</label>
              <input
                type="text"
                class="form-control dt-full-name"
                id="basic-icon-default-username"
                placeholder="A001"
                name="username"
              />
            </div>

            <div class="mb-1">
             
                  <label class="form-label" for="basic-icon-default-fullname">Reg Date</label>
                    <input
                      type="text"
                     
                      class="form-control flatpickr-basic"
                       placeholder="YYYY-MM-DD"
                      id="basic-icon-default-regDate"
                     
                      name="regDate"
                    />
                
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
              <label class="form-label" for="basic-icon-default-fullname">Commission (This Week)</label>
              <input
                type="number"
                class="form-control dt-full-name"
                id="basic-icon-default-commission"
                placeholder="2000"
                name="commission"
              />
            </div>
            <div class="mb-1">
              <label class="form-label" for="basic-icon-default-fullname">Credit Balance</label>
              <input
                type="number"
                class="form-control dt-full-name"
                id="basic-icon-default-creditBalance"
                placeholder="100"
                name="creditBalance"
              />
            </div>
            <div class="mb-1">
              <label class="form-label" for="basic-icon-default-fullname">Member No</label>
              <input
                type="text"
                class="form-control dt-full-name"
                id="basic-icon-default-memberNo"
                placeholder="M012"
                name="memberNo"
              />
            </div>
            <div class="mb-1">
              <label class="form-label" for="basic-icon-default-fullname">Email</label>
              <input
                type="email"
                class="form-control dt-full-name"
                id="basic-icon-default-email"
                placeholder="abc@dfg.com"
                name="email"
              />
            </div>
           
             <div class="mb-1">
              <label class="form-label" for="basic-icon-default-isJackpotPool">Status</label>
              <select
                id="basic-icon-default-status"
                class="form-control select2"
                name="status"
               >
               <option value="Active">Active</option>
               <option value="Inactive">Inactive</option>
             </select>
            </div> 
            
           

          
           
            <button type="button" id="btn-save" class="btn btn-primary me-1 data-submit">Save</button>
            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
    <!-- Modal to add new transaction Ends-->
    

  </div>
  <!-- list and filter end -->
</section>
<!-- transactions list ends -->
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

  <script src="{{ asset(mix('js/scripts/pages/app-transaction-list.js')) }}"></script>
  }
@endsection

