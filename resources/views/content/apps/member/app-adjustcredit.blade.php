@extends('layouts/contentLayoutMaster')

@section('title', 'Adjust Credit Log')

@section('vendor-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css')) }}">

 <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/spinner/jquery.bootstrap-touchspin.css'))}}">

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

   


<!-- detailss list start -->
<section class="app-details-list">
   <input type="hidden" id="site_base_url" value=" <?php echo config('app.url'); ?>/" />
  <!-- list and filter start -->
  <div class="card">
    
    <div class="card-body">
       <div class="my-auto">
          <h6 class="mb-0">Player P023343</h6>
          <small>July 22, 2021</small>
        </div>
         <div class="my-auto mt-2">
          <h6 class="mb-0">Given Credit 250</h6>          
        </div>
         <div class="my-auto">
          <h6 class="mb-0">Use Credit 150</h6>          
        </div>
         <div class="my-auto mb-2">
          <h6 class="mb-0">Remaining Credit 100</h6>          
        </div>
        <div class="row">
            <div class="col-12">
               <div class="input-group">
                <input type="number" class="touchspin" value="45" />
              </div>
                <button type="button"  class="btn btn-primary me-1 block">Adjust</button>
                

              </div>
            </div>

    </div> 

     <div class="card">

      

     
      <div class="card-body">
        <div class="card-text">
          <div class="row">
            
            <div class="col-lg-12">
              <div class="card-header">
                <h4 class="card-title">Adjustment Log  ( Desposit Withdrawal ) Details</h4>
              </div>
              <div id="table_data" class="table-responsive">
              @include('/content/apps/member/app-details-adjustcredit-list-data')
              </div>
              
            </div>
            
          </div>
        </div>
      </div>
     </div> 
    

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

  



@endsection

@section('page-script')
  {{-- Page js files --}}
   
<script src="{{ asset(mix('js/scripts/forms/form-number-input.js'))}}"></script>
<script>
   $(document).ready( function () {
    
     var site_base_url = $('#site_base_url').val();
  $(document).on('click', '.pagination a', function(event){

  event.preventDefault(); 

  var page = $(this).attr('href').split('page=')[1];
  fetch_data(page);
 });

function fetch_data(page)
 {
  var user_id = $('#user_id').val();
  //alert(user_id);
  $.ajax({
   url:site_base_url+"member/details_adjustcreditlog_list_data?page="+page,
   success:function(data)
   {    
    //alert(data);
    $('#table_data').html(data);
    
   }
  });
 }
});
</script>
@endsection

