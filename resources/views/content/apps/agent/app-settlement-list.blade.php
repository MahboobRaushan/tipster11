@extends('layouts/contentLayoutMaster')

@section('title', 'Settlement List')

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

   


<!-- detailss list start -->
<section class="app-details-list">
  
  <!-- list and filter start -->
  <div class="card">
    
    <div class="card-datatable table-responsive pt-0">
      <table class="details-list-table table">
        <thead class="table-light">
          <tr>
            <th></th>
            <th>Individual Agent Id</th>
            <th>Settlement Amount</th>  
            <th>Settlement Date</th>
            <th>Settlement Status</th>        
          
            <th>Actions</th>
          </tr>
        </thead>
      </table>
    </div>
    <!-- Modal to add new details starts-->
    <div class="modal modal-slide-in new-details-modal fade" id="modals-slide-in">
      <div class="modal-dialog">
        <form class="add-new-details modal-content pt-0"  id="postForm" name="postForm" >
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
          <div class="modal-header mb-1">
            <h5 class="modal-title" id="exampleModalLabel">Add New Details</h5>
          </div>
          <div class="modal-body flex-grow-1">
            <div class="mb-1">
              <label class="form-label" for="basic-icon-default-fullname">Individual Agent Id</label>
              <input
                type="text"
                class="form-control dt-full-name"
                id="basic-icon-default-individualAgentId"
                placeholder="A001"
                name="individualAgentId"
              />
            </div>

          
            <div class="mb-1">
              <label class="form-label" for="basic-icon-default-fullname">Settlement Amount</label>
              <input
                type="number"
                class="form-control dt-full-name"
                id="basic-icon-default-settlementAmount"
                placeholder="2000"
                name="settlementAmount"
              />
            </div>
             <div class="mb-1">
              <label class="form-label" for="basic-icon-default-fullname">Settlement Date</label>
              <input
                      type="text"
                     
                      class="form-control flatpickr-basic"
                       placeholder="YYYY-MM-DD"
                      id="basic-icon-default-settlementDate"
                     
                      name="settlementDate"
                    />
            </div>
             <div class="mb-1">
              <label class="form-label" for="basic-icon-default-fullname">Settlement Status</label>
               <select
                id="basic-icon-default-settlementStatus"
                class="form-control select2"
                name="settlementStatus"
               >
               <option value="paid">Paid</option>
               <option value="due">Due</option>
             </select>
            </div>
           
          
           
            <button type="button" id="btn-save" class="btn btn-primary me-1 data-submit">Save</button>
            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
    <!-- Modal to add new details Ends-->
    

  </div>
  <!-- list and filter end -->
</section>
<!-- detailss list ends -->
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

  <script src="{{ asset(mix('js/scripts/pages/app-agentstatement-list.js')) }}"></script>
  }
@endsection

