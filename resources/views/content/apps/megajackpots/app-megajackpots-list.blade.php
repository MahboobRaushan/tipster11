@extends('layouts/contentLayoutMaster')

@section('title', 'Mega Jackpots List')

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
            <td><strong>Big Jackpot</strong></td>  
          </tr>
          <tr>
            <td>Start Time</td>           
            <td><strong>2022-01-15 3.00 p.m.</strong></td>  
          </tr>
          <tr>
            <td>End Time</td>           
            <td><strong>2022-01-19 2.59 p.m.</strong></td>  
          </tr>
          <tr>
            <td>Base Price</td>           
            <td><strong>$2000</strong></td>  
          </tr>
          <tr>
            <td>Accumulate Price</td>           
            <td><strong>$8800</strong></td>  
          </tr>
          <tr>
            <td>Total Price</td>           
            <td><strong>$10000</strong></td>  
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
            <th>Base Price</th>
            <th>Accumulate Price</th>
            <th>Total Price</th>
            
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
            <th>Base Price</th>
            <th>Accumulate Price</th>
            <th>Total Price</th>
            <th>Winner</th>
            
          </tr>
        </thead>
      </table>
    </div>
    

  </div>
  <!-- list and filter end -->
</section>
<!-- megajackpotss list ends -->
@endsection

@section('vendor-script')
  {{-- Vendor js files --}}
  <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>


  
 



@endsection

@section('page-script')
  {{-- Page js files --}}
   
<script> 

var custom_get_all_permissions_access_Array = <?php echo json_encode($custom_get_all_permissions_access); ?>; 
</script>


  <script src="{{ asset(mix('js/scripts/pages/app-megajackpots-list.js')) }}"></script>
  }
@endsection

