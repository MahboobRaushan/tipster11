@extends('layouts/contentLayoutMaster')

@section('title', 'Statement List')

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

     <div class="card-text m-2">
          <div class="row">
            <div class="col-lg-12">
             <div class="row">
                <div class="col-md-4 ">
                  <label class="form-label" for="fp-range">Date Range</label>
                  <input
                    type="text"
                    id="fp-range"
                    class="form-control flatpickr-range"
                    placeholder="YYYY-MM-DD to YYYY-MM-DD"
                  />
                </div>
                 <div class="col-md-4 ">
                  <label class="form-label" for="fp-range">Agent ID</label>
                  <select class="select2 form-select" id="agent_id">
                    <option value="">Select Agent ID</option>
                     <option>A645631</option>
                     <option>A57545</option>
                     <option>A99754</option>
                     <option>A007457</option>
                    </select>
                </div>
                <div class="col-md-4 mt-2">
                  <button id="search_data_result" class="dt-button add-new btn btn-info" >Search</button>
                  
                </div>

                

              </div>
            </div>
           
          </div>
        </div>
    
    <div class="card-datatable table-responsive pt-0">
      <table class="details-list-table table">
        <thead class="table-light">
          <tr>
            <th></th>
            <th>Individual Agent Id</th>
            <th>Date</th> 
            <th>Bet Amount</th>  
            <th>Percentage</th>
            <th>Commission</th>        
          
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
              <label class="form-label" for="basic-icon-default-fullname">Today Bet Amount</label>
              <input
                type="number"
                class="form-control dt-full-name"
                id="basic-icon-default-todaybetAmount"
                placeholder="2000"
                name="todaybetAmount"
              />
            </div>
             <div class="mb-1">
              <label class="form-label" for="basic-icon-default-fullname">Percentage</label>
              <input
                type="number"
                class="form-control dt-full-name"
                id="basic-icon-default-percentage"
                placeholder="5"
                name="percentage"
              />
            </div>
             <div class="mb-1">
              <label class="form-label" for="basic-icon-default-fullname">Commission</label>
              <input
                type="number"
                class="form-control dt-full-name"
                id="basic-icon-default-commission"
                placeholder="10"
                name="commission"
              />
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
  
@endsection

