
@extends('layouts/contentLayoutMaster')

@section('title', 'Player Details List')
@section('vendor-style')
  <!-- vendor css files -->
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection
@section('page-style')
<link rel="stylesheet" href="{{asset('css/base/pages/ui-feather.css')}}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
@endsection

@section('content')


<!-- Bordered table start -->
<div class="row" id="table-bordered">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">Player Details List</h4>
      </div>
      <div class="card-body">
        <div class="card-text">
          <div class="row">
            <div class="col-lg-9">
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
                  <label class="form-label" for="fp-range">Agent</label>
                  <select class="select2 form-select" id="agent_id">
                      <option value="AK">Agent 1</option>
                      <option value="HI">Agent 2</option>
                      <option value="CA">Agent 3</option>
                      <option value="NV">Agent 4</option>
                      <option value="OR">Agent 5</option>
                    </select>
                </div>
                <div class="col-md-4 mt-2">
                  <button class="dt-button add-new btn btn-info" >Search</button>
                  
                </div>

                

              </div>
            </div>
            <div class="col-lg-3 mt-2">
              <a href="details/add" class="dt-button add-new btn btn-primary" style="float:right;">Add Player</a>
            </div>
          </div>
        </div>
      </div>
      <div id="table_data">
      @include('/content/apps/member/app-details-list-data')
      </div>
    </div>
  </div>
</div>
<!-- Bordered table end -->


@endsection


@section('vendor-script')
  {{-- Vendor js files --}}
<script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>

@endsection

@section('page-script')
  {{-- Page js files --}}
   

<script src="{{ asset('js/scripts/pages/app_memberdetails_list.js') }}"></script>
<script src="{{asset('js/scripts/ui/ui-feather.js')}}"></script>
<script src="{{ asset(mix('js/scripts/forms/pickers/form-pickers.js')) }}"></script>
<script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
@endsection
