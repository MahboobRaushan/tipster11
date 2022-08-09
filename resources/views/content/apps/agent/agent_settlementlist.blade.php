@extends('layouts/contentLayoutMaster')

@section('title', 'Agent Settlement History')

@section('vendor-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css')) }}">

  <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">

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
  <div class="card">
<input type="hidden" id="loadingimgsrc" value="{{ asset('images/logo/ajax-loader.gif') }}" />

    <div class="card-text m-2">
      <div class="row">
        <div class="col-lg-12">
          <h6>Apply Settlement</h6>
          @if (Session::has('success'))
            <div class="alert alert-success">
                <ul>
                    <li>{{ Session::get('success') }}</li>
                </ul>
            </div>
        @endif

        @if($pending_status)
        Already pending for approval
        @else
           <div class="row">
            <div class="col-md-3 ">
                <label class="form-label" for="from_date">From Date</label>
                <input type="text" disabled class="form-control" name="from_date" id="from_date" value="{{$to_date_set}}"  />
                
              </div>
              <div class="col-md-3 ">
                <label class="form-label " for="to_date">To Date</label>
                <input
                  type="text"
                  name="daterange"
                  id="to_date"                   
                  class="form-control flatpickr-basic"
                  placeholder="YYYY-MM-DD"
                />
              </div>
              <div class="col-md-3 mt-2">
                  <a href="{{Route('settlementlist_get')}}"  class="dt-button add-new btn btn-info next_settlement_button" >Next</a>
                  
                </div>
               
            </div>
        @endif

            <div id="settlement_apply_div" style="display: none;">
             
                <form action="{{Route('settlement_save')}}" method="POST">
                  @csrf
                 <input type="hidden" id="from_date_apply" name="from_date" value="" />
                  <input type="hidden" id="to_date_apply" name="to_date" value="" />
                   <input type="hidden" id="total_commission" name="total_commission" value="" />
                   <div class="row">
                  <div class="col-md-3 ">
                    <label class="form-label " for="total_commission">Amount</label>
                    <input
                      type="text"
                       id="total_commission_disabled"                   
                      class="form-control"
                      disabled
                    />
                  </div>
                  <div class="col-md-3 ">
                    <label class="form-label " for="agent_comments">Any Comments</label>
                    <textarea
                       id="agent_comments"                   
                      class="form-control"
                      name="agent_comments"
                    ></textarea>
                  </div>

                  
                  <div class="col-md-3 mt-2">
                      <button type="submit"  class="dt-button add-new btn btn-info" style="display:none;" id="commission_submit_button" >Submit</button>
                      
                    </div>
                 
                   
                </div>
                 </form>
            </div>
        </div>
      </div>
    </div>
    </div> 
  <hr>
  <!-- list and filter start -->
  <div class="card">

     <div class="card-text m-2">
          <div class="row">
            <div class="col-lg-12">
              <form id="searchform" name="searchform" >
             <div class="row">
                <div class="col-md-3 ">
                  <label class="form-label" for="fp-range">Date Range</label>
                  <input
                    type="text"
                    name="daterange"
                    id="fp-range"                   
                    class="form-control flatpickr-range"
                    placeholder="YYYY-MM-DD to YYYY-MM-DD"
                  />
                </div>
                                
                
                <div class="col-md-3 mt-2">
                  <a id="search_btn" href='{{Route("settlementlist")}}' class="dt-button add-new btn btn-info" >Search</a>
                  
                </div>

                

              </div>
            </form>
            </div>
           
          </div>
        </div>
    
    <div >
     

        <div id="pagination_data">
          @include("content/apps/agent/agent_settlementlist-pagination",['pageConfigs'=>$pageConfigs         
          ,'data'=>$data ,'to_date_set'=>$to_date_set,'pending_status'=>$pending_status      
          
          ])
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
