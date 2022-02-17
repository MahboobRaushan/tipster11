
@extends('layouts/contentLayoutMaster')

@section('title', 'Agent Details Edit')
@section('vendor-style')
  <!-- vendor css files -->
  
  <link rel="stylesheet" href="{{asset('css/jquery.dataTables.min.css')}}">

  <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">


  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/wizard/bs-stepper.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/spinner/jquery.bootstrap-touchspin.css'))}}">


@endsection
@section('page-style')
<link rel="stylesheet" href="{{ asset('css/base/pages/ui-feather.css') }}">

<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-wizard.css')) }}">


@endsection

@section('content')
<div class="card">     
  <div class="card-body">   
    <div class="card-header">
      <h4 class="card-title">Agent Edit</h4>
    </div>
  </div>
</div>

<section class="modern-vertical-wizard">
  <div class="bs-stepper vertical wizard-modern modern-vertical-wizard-example">
    <div class="bs-stepper-header">
      <div
        class="step"
        data-target="#account-details-vertical-modern"
        role="tab"
        id="account-details-vertical-modern-trigger"
      >
        <button type="button" class="step-trigger">
          <span class="bs-stepper-box">
            <i data-feather="user" class="font-medium-3"></i>
          </span>
          <span class="bs-stepper-label">
            <span class="bs-stepper-title">Basic Details</span>
            <span class="bs-stepper-subtitle">Setup Basic Details</span>
          </span>
        </button>
      </div>
      <div
        class="step"
        data-target="#personal-info-vertical-modern"
        role="tab"
        id="personal-info-vertical-modern-trigger"
      >
        <button type="button" class="step-trigger">
          <span class="bs-stepper-box">
            <i data-feather="dollar-sign" class="font-medium-3"></i>
          </span>
          <span class="bs-stepper-label">
            <span class="bs-stepper-title">Credit Balance</span>
            <span class="bs-stepper-subtitle">Add Credit Balance</span>
          </span>
        </button>
      </div>
    
      
    </div>
    <div class="bs-stepper-content">
      <div
        id="account-details-vertical-modern"
        class="content"
        role="tabpanel"
        aria-labelledby="account-details-vertical-modern-trigger"
      >
        <div class="content-header">
          <h5 class="mb-0">Basic Details</h5>
          <small class="text-muted">Enter Agent's Basic Details.</small>
        </div>
        
        <input type="hidden" id="site_base_url" value=" <?php echo config('app.url'); ?>/" />
         <form action="#" id="basic_detailsForm">
          @csrf
         <div class="row">
          <div class="mb-1 col-md-4">
            <label class="form-label" for="vertical-modern-name"><i data-feather="user" class=""></i> Individual Agent ID : {{ $data->unique_id }}</label>

            
           
          </div>
           

          <div class="mb-1 col-md-4">
            <label class="form-label" for="vertical-modern-email"><i data-feather="calendar" class=""></i> Last Login : {{ $data->updated_at }}</label>
           
          </div>
           <div class="mb-1 col-md-4">
            <label class="form-label" for="vertical-modern-email"><i data-feather="calendar" class=""></i> Registration Date : {{ $data->created_at }}</label>
           
          </div>
        </div>
        <div class="row">
          <div class="mb-1 col-md-6">


            <input type="hidden" name="id" value="{{ $data->id }}" />
            <label class="form-label" for="vertical-modern-name">Name</label>
            <div class="input-group mb-1">
            
              <span class="input-group-text" id="basic-addon1"><i data-feather="user" class=""></i></span>
              <input
                name="name"
                id="name"
                type="text"
                value="{{ $data->name }}"
                class="form-control"
                placeholder="Name"
                aria-label="Name"
                aria-describedby="basic-addon1"
              />
            </div>
          </div>
           

          <div class="mb-1 col-md-6">
            <label class="form-label" for="vertical-modern-email">Email</label>
            <div class="input-group mb-1">
            
              <span class="input-group-text" id="basic-addon2"><i data-feather="at-sign" class=""></i></span>
              <input
                name="email"
                type="email"
                value="{{ $data->email }}"
                id="vertical-modern-email"
                class="form-control"
                placeholder="Email"
                aria-label="Email"
                aria-describedby="basic-addon2"
                readonly
              />
            </div>
          </div>
        </div>
       
        <div class="row">
         
          <div class="mb-1 col-md-6">
            <label class="form-label" for="status">Status</label>
           
             <select
                name="status"               
                id="status"
                class="select2 form-select"               
                aria-describedby="basic-addon6"
              >
              <option value="1" <?php echo $data->status==1?'selected':'' ;?>>Active</option>
              <option value="0" <?php echo $data->status==0?'selected':'' ;?>>Inactive</option>
              <option value="2" <?php echo $data->status==2?'selected':'' ;?>>Suspended</option>
            </select>
            
          </div>
        
         <div class="mb-1 col-md-6">
           <button type="submit" id="basic_details_submit" class="btn btn-primary"> Submit</button>            
          </div>
        </div>
      </form>
        <div class="d-flex justify-content-between">
          <button class="btn btn-outline-secondary btn-prev" disabled>
            <i data-feather="arrow-left" class="align-middle me-sm-25 me-0"></i>
            <span class="align-middle d-sm-inline-block d-none">Previous</span>
          </button>
          <button class="btn btn-primary btn-next">
            <span class="align-middle d-sm-inline-block d-none">Next</span>
            <i data-feather="arrow-right" class="align-middle ms-sm-25 ms-0"></i>
          </button>
        </div>
      </div>
      <div
        id="personal-info-vertical-modern"
        class="content"
        role="tabpanel"
        aria-labelledby="personal-info-vertical-modern-trigger"
      >
        <div class="content-header">
          <h5 class="mb-0">Credit Balance</h5>
          <small>Give credits to Agent.</small>
        </div>
        <div class="row">
          <div class="mb-1 col-md-3">
            <input type="hidden" id="initial_credits" value="<?php echo $data->credits ;?>" />
            <label class="form-label" for="vertical-modern-first-name"><span>Credits $</span><span id="original_credits"><?php echo $data->credits ;?></span></label>
            <div class="input-group">
              <input
              name="credits"
              id="credits"
                type="text"
                class="touchspin-min-max"
                value="0"
                data-bts-button-down-class="btn btn-warning"
                data-bts-button-up-class="btn btn-success"
              />
            </div>
          </div>
          <div class="mb-1 col-md-2 mt-2">
              <span>$</span><span id="credit_result"><?php echo $data->credits ;?></span>
          </div>

           <div class="mb-1 col-md-5">
            <label class="form-label" for="vertical-modern-first-name">Remarks</label>
            
              <textarea
              name="remarks_form"
              id="remarks_form"
              placeholder="Remarks" 
              class="form-control"
              ></textarea>
            
          </div>

          <div class="mb-1 col-md-2 mt-2">
              <button class="btn btn-info confirmitem"  data-bs-toggle="modal" data-bs-target="#myModal_directcredits">Confirm</button>
          </div>
         
        </div>
        
        <div class="d-flex justify-content-between">
          <button class="btn btn-primary btn-prev">
            <i data-feather="arrow-left" class="align-middle me-sm-25 me-0"></i>
            <span class="align-middle d-sm-inline-block d-none">Previous</span>
          </button>
         
          <button class="btn btn-outline-secondary btn-next" disabled>
            <i data-feather="arrow-next" class="align-middle me-sm-25 me-0"></i>
            <span class="align-middle d-sm-inline-block d-none">Next</span>
          </button>

        </div>

        

      </div>
      
       
    </div>

  </div>

</section>

<section >
 <div class="row" >
  <div class="col-12">
   

      <div class="card">

      

     
      <div class="card-body">
        <div class="card-text">
          <div class="row">
            
            <div class="col-lg-12">
              <div class="card-header">
                <h4 class="card-title">Bank Details</h4>
              </div>
              <div class="card-body">
                 <form action="#" id="bank_detailsForm">
              @csrf
               <input type="hidden" name="id" value="{{ $data->id }}" />
                 <table class="table table-striped" width="100%">
                      <tbody>
                      <tr><td>Account Name</td><td><input
                name="bank_account_name"
                id="bank_account_name"
                type="text"
                value="{{ $data->bank_account_name }}"
                class="form-control"
                placeholder="Account Name"
               
               
              /></td></tr>
                      <tr><td>Country</td><td><input
                name="bank_country"
                id="bank_country"
                type="text"
                value="{{ $data->bank_country }}"
                class="form-control"
                placeholder="Country"
                
               
              /></td></tr>
                      <tr><td>Bank Name</td><td><input
                name="bank_name"
                id="bank_name"
                type="text"
                value="{{ $data->bank_name }}"
                class="form-control"
                placeholder="Bank Name"
               
               
              /></td></tr>
                      <tr><td>Account Number</td><td><input
                name="bank_account_number"
                id="bank_account_number"
                type="text"
                value="{{ $data->bank_account_number }}"
                class="form-control"
                placeholder="Account Number"
               
               
              /></td></tr>
                      <tr><td>Account Type</td><td><input
                name="bank_account_type"
                id="bank_account_type"
                type="text"
                value="{{ $data->bank_account_type }}"
                class="form-control"
                placeholder="Account Type"
               
               
              /></td></tr>
                      <tr><td><button type="submit" id="bank_details_submit" class="btn btn-primary"> Submit</button> </td><td></td></tr>
                    </tbody>
                    </table>
                  </form>
                
              </div>
            </div>
          </div>
        </div>
        </div>
    </div>
   </div>
  </div>
</section>

<!-- Bordered table start -->
<div class="row" >
  <div class="col-12">
   

      <div class="card">

      

     
      <div class="card-body">
        <div class="card-text">
          <div class="row">
            
            <div class="col-lg-12">
              <div class="card-header">
                <h4 class="card-title">Desposit Withdrawal Details</h4>
              </div>
              <div id="table_data" class="table-responsive">
              @include('/content/apps/agent/app-details-edit-list-data')
              </div>
              
            </div>
            
          </div>
        </div>
      </div>
     </div>

      <div class="card">
     
      <div class="card-body">
        <div class="card-text">
          <div class="row">
            <div class="col-lg-12">
              <div class="card-header">
                <h4 class="card-title">Statements</h4>
              </div>
              <div class="table-responsive">
              <table class="datatables-basic table table-stripped" id="mystatementTable">
                <thead>
                  <tr>
                    <th>Date</th>
                    <th>In</th>
                    <th>Out</th>
                    <th>Balance</th>
                   
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>2022-01-26 10:09:05</td>
                    <td>100</td>
                    <td></td>
                    <td>100</td>
                  </tr>
                  <tr>
                    <td>2022-01-27 10:09:05</td>
                    <td>50</td>
                    <td></td>
                    <td>150</td>
                  </tr>
                  <tr>
                    <td>2022-01-27 12:09:05</td>
                    <td></td>
                    <td>80</td>
                    <td>70</td>
                  </tr>
                  <tr>
                    <td>2022-01-28 10:09:05</td>
                    <td>20</td>
                    <td></td>
                    <td>90</td>
                  </tr>
                  <tr>
                    <td>2022-01-28 12:09:05</td>
                    <td>10</td>
                    <td></td>
                    <td>100</td>
                  </tr>
                  <tr>
                    <td>2022-01-29 04:09:05</td>
                    <td>30</td>
                    <td></td>
                    <td>130</td>
                  </tr>
                  <tr>
                    <td>2022-01-29 05:09:05</td>
                    <td></td>
                    <td>40</td>
                    <td>90</td>
                  </tr>
                  <tr>
                    <td>2022-01-29 06:09:05</td>
                    <td></td>
                    <td>15</td>
                    <td>75</td>
                  </tr>
                  <tr>
                    <td>2022-01-29 07:09:05</td>
                    <td></td>
                    <td>50</td>
                    <td>25</td>
                  </tr>
                  <tr>
                    <td>2022-01-30 10:09:05</td>
                    <td>25</td>
                    <td></td>
                    <td>50</td>
                  </tr>
                  <tr>
                    <td>2022-01-30 11:09:05</td>
                    <td>10</td>
                    <td></td>
                    <td>40</td>
                  </tr>
                  <tr>
                    <td>2022-01-31 10:09:05</td>
                    <td>100</td>
                    <td></td>
                    <td>140</td>
                  </tr>
                  
                </tbody>
              </table>
            </div>


            </div>
            
            
          </div>
        </div>
      </div>
     </div>


  </div>
</div>
<!-- Bordered table end -->
<!-- Modal to delete game start-->
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
              <h1 class="mb-1">Direct Credit</h1>
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
                <input type="hidden" name="user_id" id="user_id" value="{{ $data->id }}" />
                <input type="hidden" name="amount" id="amount" value="" />
                <input type="hidden" name="remarks" id="remarks" value="" />
                <input type="hidden" name="type" id="type" value="" />

                <button type="submit" id="btn_save_confirm" class="btn btn-warning data-delete">Submit</button>
                 <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
              </div>
            </form>
             
           
          </div>
        </div>
      </div>
    </div>
    <!-- Modal to delete game Ends--> 
@endsection

 

@section('vendor-script')
  {{-- Vendor js files --}}
   <script src="{{ asset(mix('vendors/js/forms/wizard/bs-stepper.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/spinner/jquery.bootstrap-touchspin.js'))}}"></script>


@endsection

@section('page-script')
  {{-- Page js files --}}
  


<script src="{{asset('js/scripts/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
<script src="{{ asset(mix('js/scripts/forms/form-wizard.js')) }}"></script>
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
   url:site_base_url+"agent/details_edit_list_data?page="+page+'&user_id='+user_id,
   success:function(data)
   {    
    //alert(data);
    $('#table_data').html(data);
    
   }
  });
 }

    $('#mystatementTable').DataTable();



          //credits
          //credit_result
         
          $('.bootstrap-touchspin-down').on('click', function () {
            
            var credits = $('#credits').val();
            credits = parseInt(credits);

            
            var initial_credits = $('#initial_credits').val();
            initial_credits = parseInt(initial_credits);

            credits = credits+initial_credits;
            $('#credit_result').html(credits);
        });
          $('.bootstrap-touchspin-up').on('click', function () {
            var credits = $('#credits').val();
            credits = parseInt(credits);

             var initial_credits = $('#initial_credits').val();
            initial_credits = parseInt(initial_credits);

            credits = credits+initial_credits;
            $('#credit_result').html(credits);
        });
          $('#credits').on('keyup', function () {
            var credits = $('#credits').val();
            credits = parseInt(credits);

             var initial_credits = $('#initial_credits').val();
            initial_credits = parseInt(initial_credits);

            credits = credits+initial_credits;
            $('#credit_result').html(credits);
        });




$(document).on('click', '.confirmitem', function(event){
    event.preventDefault(); 
    var id = $(this).data("id"); 

    

    var credits = $('#credits').val();
      credits = parseInt(credits);

      var credit_result = $('#credit_result').html();
      credit_result = parseInt(credit_result);
      var outputhtml ='';
      if(credit_result < 0)
      {
        outputhtml = outputhtml+'<strong>Final credits should be positive</strong>';
        document.getElementById('btn_save_confirm').style.display = 'none';

      }
      else 
      {
        if(credits == 0)
        {
          document.getElementById('btn_save_confirm').style.display = 'none';
        }
        else 
        {
          document.getElementById('btn_save_confirm').style.display = 'inline-block';
        }
        
      }


      if(credits > 0)
      {
        $('#type').val('Deposit');

        
         

      }
      if(credits < 0)
      {
        $('#type').val('Withdraw');
        
      }
     
     credits = Math.abs(credits);
      $('#amount').val(credits);

       var remarks_form =$('#remarks_form').val();
       $('#remarks').val(remarks_form);

      $('#confirm_message_div').html(outputhtml);

   });


$(document).on('click', '#btn_save_confirm', function(event){
  event.preventDefault();
   $.ajax({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
             
              url:  site_base_url+'agent/direct_credit',
              method: "POST",
               data:$('#confirm_Form').serialize(),
               dataType:'JSON',
               
              success: function (data) {
                 
               
                 //alert(JSON.stringify(data));
                 //console.log( data);                 

                  if(data.status=='ok')

                    {                     

                      toastr_message_show('success',data.message);
                    }

                    else 

                    {                    

                      toastr_message_show('error',Object.values(data.message));

                    }


                    $('#myModal_directcredits').modal('hide'); 

                    fetch_data(1);

                   // setTimeout(function(){
                    //   window.location.reload(1);
                   // }, 5000);  

                   var credit_result = $('#credit_result').html() ; 
                   $('#original_credits').html(credit_result) ;
                    $('#initial_credits').val(credit_result) ;
                   
                    $('#remarks_form').val('');

                   $('#credits').val(0) ;

                      
               
                  
              },
              error: function (data) {
                // alert(JSON.stringify(data));
                  //$('#btn-save_edit').html('Save Changes');
                 
                  
              }
          });
   
});


$(document).on('click', '#basic_details_submit', function(event){

  event.preventDefault();
  var name = $('#name').val();
  var status = $('#status').val();

 
     
      if((name!='') && (status!=''))
      {
          $.ajax({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
             
              url:  site_base_url+'agent/basic_detailsupdate',
              method: "POST",
               data:$('#basic_detailsForm').serialize(),
               dataType:'JSON',
               
              success: function (data) {
                 
               
                 // alert(JSON.stringify(data));
                 //console.log( data);                 

                  if(data.status=='ok')

                    {                     

                      toastr_message_show('success',data.message);
                    }

                    else 

                    {                    

                      toastr_message_show('error',Object.values(data.message));

                    }
                            
               
                  
              },
              error: function (data) {
                // alert(JSON.stringify(data));
                  //$('#btn-save_edit').html('Save Changes');
                 
                  
              }
          });

        


      }
      else 
      {
        toastr_message_show('error','Name, Status ');
      }

    });  


$(document).on('click', '#bank_details_submit', function(event){

  event.preventDefault();


 
          $.ajax({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
             
              url:  site_base_url+'agent/bank_detailsupdate',
              method: "POST",
               data:$('#bank_detailsForm').serialize(),
               dataType:'JSON',
               
              success: function (data) {
                 
               
                 // alert(JSON.stringify(data));
                 //console.log( data);                 

                  if(data.status=='ok')

                    {                     

                      toastr_message_show('success',data.message);
                    }

                    else 

                    {                    

                      toastr_message_show('error',Object.values(data.message));

                    }
                            
               
                  
              },
              error: function (data) {
                 //alert(JSON.stringify(data));
                  //$('#btn-save_edit').html('Save Changes');
                 
                  
              }
          });

        


     
    });          

  } );
</script> 

@endsection
