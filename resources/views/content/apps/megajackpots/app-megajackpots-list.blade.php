@extends('layouts/contentLayoutMaster')

@section('title', 'Mega Jackpots List')

@section('vendor-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css')) }}">

 <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/wizard/bs-stepper.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/spinner/jquery.bootstrap-touchspin.css'))}}">

@endsection

@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset('css/base/pages/ui-feather.css') }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
@endsection

@section('content')

<?php 
 //print_r($custom_get_all_permissions_access);
 // die();
  ?>

   


<!-- megajackpotss list start -->
<section class="app-megajackpots-list">
  
  <!-- list and filter start -->
  <div class="card">
    <div class="card-body border-bottom">
      <h4 class="card-title">Current Mega Jackpots</h4>
      <table class="table">
        <tbody>
          <tr>
            <td>Current Mega Jackpot</td>           
            <td><strong>1</strong></td>  
          </tr>
          <tr>
            <td>Start Time</td>           
            <td><strong>2022-01-15 3.00 p.m.</strong></td>  
          </tr>
          <tr>
            <td>End Time</td>           
            <td><strong>XXXX</strong></td>  
          </tr>
          <tr>
            <td>Base Prize</td>           
            <td><div class="input-group">
              <span>$</span><input
              name="base_prize"
              id="base_prize"
                type="text"
                class="touchspin-min-max"
                value="2000"
                data-bts-button-down-class="btn btn-warning"
                data-bts-button-up-class="btn btn-success"
              />
            </div>  <button class="btn btn-info confirmitem"  data-bs-toggle="modal" data-bs-target="#myModal_directcredits">Confirm</button></td>  
          </tr>
          <tr>
            <td>Accumulate Prize</td>           
            <td><strong><span>$</span><span id="accumulate_prize">8800</span></strong></td>  
          </tr>
          <tr>
            <td>Current Mega Jackpot Prize</td>           
            <td><strong><span>$</span><span id="total_prize">10000</span></strong></td>  
          </tr>
        </tbody>
      </table>
     <h4 class="card-title">Pools Involved</h4>
    </div>
    <div class="card-datatable table-responsive pt-0">
      <table class="megajackpots-list-table table">
        <thead class="table-light">
          <tr>
            <th></th>           
            <th>Name</th>
            <th>Start Time</th>           
            <th>End Time</th>
            <th>Final Prize (Pool Final Total Prize)</th>
            <th>Winner</th>
            <th>Contributed Amount to Mega Jackpot</th>
            <th>Which Mega Jackpot</th>
            <th>Status</th>
            <th>Actions</th>
            
          </tr>
        </thead>
      </table>
    </div>
    

  </div>
  <!-- list and filter end -->

  <!-- list and filter start -->
  <div class="card">
    <div class="card-body border-bottom">
      <h4 class="card-title">Mega Jackpot History</h4>
      
    
    </div>
    <div class="card-datatable table-responsive pt-0">
      <table class="megajackpots_involved-list-table table">
        <thead class="table-light">
          <tr>
            <th></th>           
            
            <th>Start Time</th>           
            <th>End Time</th>
            <th>Base Prize</th>
            <th>Accumulate Prize</th>
            <th>Total Prize</th>
            <th>Winner</th>
            
          </tr>
        </thead>
      </table>
    </div>
    

  </div>
  <!-- list and filter end -->
</section>
<!-- megajackpotss list ends -->

 <div class="modal fade" id="myModal_directcredits" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-transparent">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body p-3 pt-0">
          <form action="#" id="confirm_Form">
          @csrf 
            <div class="text-center mb-2">
              <h1 class="mb-1">Base Prize</h1>
               <div id="confirm_message_div" class="text-danger"></div>
              <p>Are you sure?</p>
            </div>

            <div class="alert alert-warning" role="alert">
              <h6 class="alert-heading">Warning!</h6>
              <div class="alert-body">
                Do you really want to this ? This process cannot be undone.
              </div>
            </div>

           
             
            
              <div class="col-sm-12 ps-sm-0">
               
                <button type="submit" id="btn_save_confirm" class="btn btn-warning data-delete">Submit</button>
                 <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
              </div>
            </form>
             
           
          </div>
        </div>
      </div>
    </div>

@endsection

@section('vendor-script')
  {{-- Vendor js files --}}
  <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>


  
    <script src="{{ asset(mix('vendors/js/forms/wizard/bs-stepper.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>

<script src="{{ asset(mix('vendors/js/forms/spinner/jquery.bootstrap-touchspin.js'))}}"></script>




@endsection

@section('page-script')
  {{-- Page js files --}}
   
<script> 

var custom_get_all_permissions_access_Array = <?php echo json_encode($custom_get_all_permissions_access); ?>; 

</script>


  <script src="{{ asset(mix('js/scripts/pages/app-megajackpots-list.js')) }}"></script>
<script src="{{ asset(mix('js/scripts/forms/form-number-input-zero-lacs.js'))}}"></script>
<script>

 $('.bootstrap-touchspin-down').on('click', function () {
            
            var base_prize = $('#base_prize').val();
            base_prize = parseInt(base_prize);

            
            var accumulate_prize = $('#accumulate_prize').html();
            accumulate_prize = parseInt(accumulate_prize);

            var total_prize = base_prize+accumulate_prize;
            $('#total_prize').html(total_prize);
        });
          $('.bootstrap-touchspin-up').on('click', function () {
            
             var base_prize = $('#base_prize').val();
            base_prize = parseInt(base_prize);

            
            var accumulate_prize = $('#accumulate_prize').html();
            accumulate_prize = parseInt(accumulate_prize);

            var total_prize = base_prize+accumulate_prize;
            $('#total_prize').html(total_prize);
        });
          $('#base_prize').on('keyup', function () {
            var base_prize = $('#base_prize').val();
            base_prize = parseInt(base_prize);

            
            var accumulate_prize = $('#accumulate_prize').html();
            accumulate_prize = parseInt(accumulate_prize);

            var total_prize = base_prize+accumulate_prize;
            $('#total_prize').html(total_prize);
        });

</script>
@endsection

