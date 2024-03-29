
@extends('layouts/contentLayoutMaster')

@section('title', 'Add / View Agent')
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
<link rel="stylesheet" href="{{asset('css/base/pages/ui-feather.css')}}">

<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-wizard.css')) }}">


@endsection

@section('content')
<div class="card">     
  <div class="card-body">   
    <div class="card-header">
      <h4 class="card-title">Add / View Agent</h4>
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
            <label class="form-label" for="vertical-modern-name"><i data-feather="user" class=""></i> Individual Agent ID : XXXX</label>

            
           
          </div>
           

          <div class="mb-1 col-md-4">
            <label class="form-label" for="vertical-modern-email"><i data-feather="calendar" class=""></i> Last Login : XXXX</label>
           
          </div>
           <div class="mb-1 col-md-4">
            <label class="form-label" for="vertical-modern-email"><i data-feather="calendar" class=""></i> Registration Date : XXXX</label>
           
          </div>
        </div>
        <div class="row">
          <div class="mb-1 col-md-6">
            <label class="form-label" for="vertical-modern-name">Name</label>
            <div class="input-group mb-1">
            
              <span class="input-group-text" id="basic-addon1"><i data-feather="user" class=""></i></span>
              <input
               name="name"
                id="name"
                type="text"
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
                id="vertical-modern-email"
                class="form-control"
                placeholder="Email"
                aria-label="Email"
                aria-describedby="basic-addon2"
              />
            </div>
          </div>
        </div>

        <div class="row">
          <div class="mb-1 col-md-6">
            <label class="form-label" for="vertical-modern-name">Password</label>
            <div class="input-group mb-1">
            
              <span class="input-group-text" id="basic-addon5"><i data-feather="key" class=""></i></span>
              <input
               name="password"
                id="password"
                type="password"
                class="form-control"
                placeholder="Password"
                aria-label="Password"
                aria-describedby="basic-addon5"
              />
            </div>
          </div>
           
          <div class="mb-1 col-md-6">
            <label class="form-label" for="vertical-modern-name">Confirm Password</label>
            <div class="input-group mb-1">
            
              <span class="input-group-text" id="basic-addon6"><i data-feather="key" class=""></i></span>
              <input
               name="password_confirmation"
                id="password_confirmation"
                type="password"
                class="form-control"
                placeholder="Confirm Password"
                aria-label="Confirm Password"
                aria-describedby="basic-addon6"
              />
            </div>
          </div>
        </div>
        
        <div class="row">
        
          <div class="mb-1 col-md-6">
            <label class="form-label" for="vertical-modern-status">Status</label>
             <select
                name="status"               
                id="vertical-modern-status"
                class="select2 form-select"               
                aria-describedby="basic-addon6"
              >
              <option value="1">Active</option>
              <option value="0">Inactive</option>
              <option value="2" >Suspended</option>
            </select>
            
          </div>
           <div class="mb-1 col-md-6">
            <label class="form-label" for="vertical-modern-commission_percentage">Commission Percentage</label>
            <div class="input-group mb-1">
            
              <span class="input-group-text" id="basic-addon6"><i data-feather="dollar-sign" class=""></i></span>
              <input
               name="commission_percentage"
                id="commission_percentage"
                type="number"
                class="form-control"
                placeholder="Commission Percentage"
                aria-label="Password"
                aria-describedby="basic-addon6"
              />
            </div>
          </div>
       
         <div class="mb-1 mt-2 col-md-6">
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
          <div class="mb-1 col-md-6">
            <label class="form-label" for="vertical-modern-first-name">Credits $2000</label>
            <div class="input-group">
              <input
              name="credits"
              id="credits"
                type="text"
                class="touchspin-color"
                value="60"
                data-bts-button-down-class="btn btn-warning"
                data-bts-button-up-class="btn btn-success"
              />
            </div>
          </div>
          <div class="mb-1 col-md-3 mt-2">
              <span>$</span><span id="credit_result">2060</span>
          </div>



          <div class="mb-1 col-md-3 mt-2">
              <button class="btn btn-info" >Confirm</button>
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
                 <table class="table table-striped" width="100%">
                  <tbody>
                    <tr><td>Account Name</td><td>: XXXX</td></tr>
                    <tr><td>Country</td><td>: XXXX</td></tr>
                    <tr><td>Bank Name</td><td>: XXXX</td></tr>
                    <tr><td>Account Number</td><td>: XXXX</td></tr>
                    <tr><td>Account Type</td><td>: XXXX</td></tr>
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
              <div class="table-responsive">
              <table class="table table-striped" id="mydepositwithdrawlTable">
                <thead>
                  <tr>
                    <th>Date</th>
                    <th>Desposit</th>
                    <th>Withdrawal</th>
                    <th>Balance Amount</th>
                   
                  </tr>
                </thead>
                <tbody>
                   
                  
                </tbody>
              </table>
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
  
  <script>
  $(document).ready( function () {
    $('#mydepositwithdrawlTable').DataTable();
    $('#mystatementTable').DataTable();

     
          //credits
          //credit_result
         
          $('.bootstrap-touchspin-down').on('click', function () {
            
            var credits = $('#credits').val();
            credits = parseInt(credits);
            credits = credits+2000;
            $('#credit_result').html(credits);
        });
          $('.bootstrap-touchspin-up').on('click', function () {
            var credits = $('#credits').val();
            credits = parseInt(credits);
            credits = credits+2000;
            $('#credit_result').html(credits);
        });
          $('#credits').on('keyup', function () {
            var credits = $('#credits').val();
            credits = parseInt(credits);
            credits = credits+2000;
            $('#credit_result').html(credits);
        });

          var site_base_url = $('#site_base_url').val();


$(document).on('click', '#basic_details_submit', function(event){

  event.preventDefault();

  var name = $('#name').val();
  var status = $('#status').val();

  var email = $('#email').val();
  var password = $('#password').val();
  var password_confirmation = $('#password_confirmation').val();

 
     
      if((name!='') && (status!='') && (email!='')  && (password!='')  && (password==password_confirmation))
      {
           $.ajax({
              beforeSend: function(){
                $('.ajax-loader').css("visibility", "visible");
              },
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
             
              url:  site_base_url+'agent/newagentadd',
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

                  
                   $('#name').val('');
                   $('#status').val('');

                   $('#email').val('');
                   $('#password').val('');
                   $('#password_confirmation').val('');                           
               
                  
              },
              error: function (data) {
                 alert(JSON.stringify(data));
                  //$('#btn-save_edit').html('Save Changes');
                 
                  
              } ,
              complete: function(){
                $('.ajax-loader').css("visibility", "hidden");
              }    
          });

        


      }
      else 
      {
        toastr_message_show('error','Name,Email, Status and Password should be field up');
      }

    });  

  } );
</script> 


<script src="{{asset('js/scripts/jquery.dataTables.min.js')}}"></script>

<script src="{{asset('js/scripts/ui/ui-feather.js')}}"></script>

<script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>

<script src="{{ asset(mix('js/scripts/forms/form-wizard.js')) }}"></script>
<script src="{{ asset(mix('js/scripts/forms/form-number-input.js'))}}"></script>
@endsection
