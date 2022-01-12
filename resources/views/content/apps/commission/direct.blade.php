@extends('layouts/contentLayoutMaster')

@section('title', 'Direct')

@section('vendor-style')
  <link rel="stylesheet" href="{{asset('vendors/css/forms/select/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')}}">
  <link rel="stylesheet" href="{{asset('vendors/css/tables/datatable/responsive.bootstrap5.min.css')}}">
  <link rel="stylesheet" href="{{asset('vendors/css/tables/datatable/buttons.bootstrap5.min.css')}}">
  <link rel="stylesheet" href="{{asset('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css')}}">

@endsection

@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{asset('css/base/plugins/forms/form-validation.css')}}">
@endsection

@section('content')

<?php 
 //print_r($custom_get_all_permissions_access);
 // die();
  ?>

   


<!-- users list start -->
<section class="app-user-list">
  <div class="row">
    <div class="col-lg-12 col-sm-12">
      <div class="card">
        <div class="card-body d-flex align-items-center justify-content-between">
          <div>
            <h3 class="fw-bolder mb-75">Direct</h3>
            <span>commission</span>
          </div>
          
        </div>
      </div>
    </div>
    
  
   
  </div>
  <!-- list and filter start -->
  
  <!-- list and filter end -->
</section>
<!-- users list ends -->
@endsection

@section('vendor-script')
  <script src="{{asset('vendors/js/forms/select/select2.full.min.js')}}"></script>
  <script src="{{asset('vendors/js/tables/datatable/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')}}"></script>
  <script src="{{asset('vendors/js/tables/datatable/dataTables.responsive.min.js')}}"></script>
  <script src="{{asset('vendors/js/tables/datatable/responsive.bootstrap5.js')}}"></script>
  <script src="{{asset('vendors/js/tables/datatable/datatables.buttons.min.js')}}"></script>
  <script src="{{asset('vendors/js/tables/datatable/jszip.min.js')}}"></script>
  <script src="{{asset('vendors/js/tables/datatable/pdfmake.min.js')}}"></script>
  <script src="{{asset('vendors/js/tables/datatable/vfs_fonts.js')}}"></script>
  <script src="{{asset('vendors/js/tables/datatable/buttons.html5.min.js')}}"></script>
  <script src="{{asset('vendors/js/tables/datatable/buttons.print.min.js')}}"></script>
  <script src="{{asset('vendors/js/tables/datatable/dataTables.rowGroup.min.js')}}"></script>
  <script src="{{asset('vendors/js/forms/validation/jquery.validate.min.js')}}"></script>
  <script src="{{asset('vendors/js/forms/cleave/cleave.min.js')}}"></script>
  <script src="{{asset('vendors/js/forms/cleave/addons/cleave-phone.us.js')}}"></script>


@endsection

@section('page-script')
  {{-- Page js files --}}
   

  }
@endsection

