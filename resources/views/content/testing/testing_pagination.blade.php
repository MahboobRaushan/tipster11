
@extends('layouts/contentLayoutMaster')

@section('title', 'Bootstrap Tables')

@section('page-style')
<link rel="stylesheet" href="{{asset('css/base/pages/ui-feather.css')}}">
@endsection

@section('content')


<!-- Bordered table start -->
<div class="row" id="table-bordered">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">Demo Ajax Pagination Table</h4>
      </div>
      <div class="card-body">
        <p class="card-text">
          This is rendering the ajax data, not the enire data , for performance testing , when data row 3000-4000
        </p>
      </div>
      <div id="table_data">
      @include('/content/testing/testing_pagination_data')
      </div>
    </div>
  </div>
</div>
<!-- Bordered table end -->


@endsection


@section('vendor-script')
  {{-- Vendor js files --}}


@endsection

@section('page-script')
  {{-- Page js files --}}
   

<script src="{{ asset('js/scripts/pages/testing_pagination.js') }}"></script>
<script src="{{asset('js/scripts/ui/ui-feather.js')}}"></script>
@endsection
