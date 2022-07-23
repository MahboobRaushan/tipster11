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

   

  <input type="hidden" id="site_base_url" value=" <?php echo config('app.url'); ?>/" />
<!-- megajackpotss list start -->
<section class="app-megajackpots-list">
  
  <!-- list and filter start -->
  <div class="card">
    <div class="card-body border-bottom">
      <h4 class="card-title">Current Mega Jackpot</h4>
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
                value="{{ $mega_jackpot_basePrize }}"
                data-bts-button-down-class="btn btn-warning"
                data-bts-button-up-class="btn btn-success"
              />
            </div>  <button class="btn btn-info confirmitem"  data-bs-toggle="modal" data-bs-target="#myModal_directcredits">Confirm</button></td>  
          </tr>
          <tr>
            <td>Accumulate Prize</td>           
            <td><strong><span>$</span><span id="accumulate_prize">{{ $mega_jackpot_accumulatedPrize }}</span></strong></td>  
          </tr>
          <tr>
            <td>Current Mega Jackpot Prize</td>           
            <td><strong><span>$</span><span id="total_prize">{{ ($mega_jackpot_basePrize+$mega_jackpot_accumulatedPrize) }}</span></strong></td>  
          </tr>
        </tbody>
      </table>
    </div>
    </div>
    <div class="card">
      <div class="card-body border-bottom">
      <h4 class="card-title">Current Mega Jackpot Rounds</h4>

      <h6><?php if(!empty($mega_jackpot_round)){echo $mega_jackpot_round->round_title;}?></h6>
      <?php if(!empty($mega_jackpot_round)){?>
    
      <div class="card table-responsive pt-0">
        <table class="table">
          <thead class="table-light">
            <tr>
               <th>Pool 1</th>  
               <th>Pool 2</th>
               <th>Pool 3</th>          
              
            </tr>
          </thead>
          <tbody>
              <tr>
                <td><?php if($mega_jackpot_round->pool_1_id==0){?><span class="badge rounded-pill badge-light-danger blink">Please add Pool</span>
                <form action="#" >
               @csrf
                <div>
                  <div class="mb-1 mt-1">
                    <select class="form-control" name="poolidselect_1" id="poolidselect_1">
                      <?php 
                      if(!empty($pooldetails))
                      {
                        foreach($pooldetails as $pd)
                        {
                          ?>
                          <option value="<?php echo $pd->id;?>"><?php echo $pd->name;?></option>
                          <?php 
                        }
                      }
                      ?>
                      </select>
                  </div>
                  <div class="mb-1">  
                     <input type="hidden" id="mega_jackpot_round_id_1" name="mega_jackpot_round_id_1" value="{{ $mega_jackpot_round->id }}" />
                    <input type="button" id="basic_details_submit_1" name="Add" value="Add" class="btn btn-primary waves-effect waves-float waves-light" />
                  </div>
                </div>
              </form>
               <?php }?>
               <?php if($mega_jackpot_round->pool_1_status=='Active'){?><span class="badge rounded-pill badge-light-info">Active</span><?php }?><?php if($mega_jackpot_round->pool_1_status=='Finished'){?><span class="badge rounded-pill badge-light-success">Finished</span><?php }?>

               <?php if($mega_jackpot_round->pool_1_status=='Finished' ){?><span class="badge rounded-pill badge-light-success">Finished</span><?php }?>
               <?php if($mega_jackpot_round->pool_1_status=='Active' ||  $mega_jackpot_round->pool_1_status=='Finished'){?>
              
                <div class="text-success">{{ $pool_1_details->name }}</div>

               <form action="#" >
               @csrf
                <div>
                  <div class="mb-1 mt-1">
                    <input type="hidden" id="mega_jackpot_round_id_1_remove" name="mega_jackpot_round_id_1_remove" value="{{ $mega_jackpot_round->id }}" />

                    <input type="hidden" id="poolidremove_1" name="poolidremove_1" value="{{ $pool_1_details->id }}" />

                    

                     <input type="button" id="basic_details_remove_1" name="Remove" value="Remove" class="btn btn-danger waves-effect waves-float waves-light"  />
                     </div>
                </div>
              </form>

                <?php }?>
               
             </td>
               <td><?php if($mega_jackpot_round->pool_2_id==0){?><span class="badge rounded-pill badge-light-danger blink">Please add Pool</span>
                <form action="#" >
               @csrf
                <div>
                  <div class="mb-1 mt-1">
                    <select class="form-control" name="poolidselect_2" id="poolidselect_2">
                      <?php 
                      if(!empty($pooldetails))
                      {
                        foreach($pooldetails as $pd)
                        {
                          ?>
                          <option value="<?php echo $pd->id;?>"><?php echo $pd->name;?></option>
                          <?php 
                        }
                      }
                      ?>
                      </select>
                  </div>
                  <div class="mb-1">  
                     <input type="hidden" id="mega_jackpot_round_id_2" name="mega_jackpot_round_id_2" value="{{ $mega_jackpot_round->id }}" />
                    <input type="button" id="basic_details_submit_2" name="Add" value="Add" class="btn btn-primary waves-effect waves-float waves-light" />
                  </div>
                </div>
              </form>
               <?php }?>
               <?php if($mega_jackpot_round->pool_2_status=='Active'){?><span class="badge rounded-pill badge-light-info">Active</span><?php }?><?php if($mega_jackpot_round->pool_2_status=='Finished'){?><span class="badge rounded-pill badge-light-success">Finished</span><?php }?>

               <?php if($mega_jackpot_round->pool_2_status=='Finished' ){?><span class="badge rounded-pill badge-light-success">Finished</span><?php }?>
               <?php if($mega_jackpot_round->pool_2_status=='Active' ||  $mega_jackpot_round->pool_2_status=='Finished'){?>
              
                <div class="text-success">{{ $pool_2_details->name }}</div>

               <form action="#" >
               @csrf
                <div>
                  <div class="mb-1 mt-1">
                    <input type="hidden" id="mega_jackpot_round_id_2_remove" name="mega_jackpot_round_id_2_remove" value="{{ $mega_jackpot_round->id }}" />

                    <input type="hidden" id="poolidremove_2" name="poolidremove_2" value="{{ $pool_2_details->id }}" />

                    

                     <input type="button" id="basic_details_remove_2" name="Remove" value="Remove" class="btn btn-danger waves-effect waves-float waves-light"  />
                     </div>
                </div>
              </form>

                <?php }?>
               
             </td>  
                 <td><?php if($mega_jackpot_round->pool_3_id==0){?><span class="badge rounded-pill badge-light-danger blink">Please add Pool</span>
                <form action="#" >
               @csrf
                <div>
                  <div class="mb-1 mt-1">
                    <select class="form-control" name="poolidselect_3" id="poolidselect_3">
                      <?php 
                      if(!empty($pooldetails))
                      {
                        foreach($pooldetails as $pd)
                        {
                          ?>
                          <option value="<?php echo $pd->id;?>"><?php echo $pd->name;?></option>
                          <?php 
                        }
                      }
                      ?>
                      </select>
                  </div>
                  <div class="mb-1">  
                     <input type="hidden" id="mega_jackpot_round_id_3" name="mega_jackpot_round_id_3" value="{{ $mega_jackpot_round->id }}" />
                    <input type="button" id="basic_details_submit_3" name="Add" value="Add" class="btn btn-primary waves-effect waves-float waves-light" />
                  </div>
                </div>
              </form>
               <?php }?>
               <?php if($mega_jackpot_round->pool_3_status=='Active'){?><span class="badge rounded-pill badge-light-info">Active</span><?php }?><?php if($mega_jackpot_round->pool_3_status=='Finished'){?><span class="badge rounded-pill badge-light-success">Finished</span><?php }?>

               <?php if($mega_jackpot_round->pool_3_status=='Finished' ){?><span class="badge rounded-pill badge-light-success">Finished</span><?php }?>
               <?php if($mega_jackpot_round->pool_3_status=='Active' ||  $mega_jackpot_round->pool_3_status=='Finished'){?>
              
                <div class="text-success">{{ $pool_3_details->name }}</div>

               <form action="#" >
               @csrf
                <div>
                  <div class="mb-1 mt-1">
                    <input type="hidden" id="mega_jackpot_round_id_3_remove" name="mega_jackpot_round_id_3_remove" value="{{ $mega_jackpot_round->id }}" />

                    <input type="hidden" id="poolidremove_3" name="poolidremove_3" value="{{ $pool_3_details->id }}" />

                    

                     <input type="button" id="basic_details_remove_3" name="Remove" value="Remove" class="btn btn-danger waves-effect waves-float waves-light"  />
                     </div>
                </div>
              </form>

                <?php }?>
               
             </td>    
              
            </tr>
          </tbody>
        </table>
      </div>
      <?php 
    }
    else 
    {
      ?>
      <span class="blink text-danger">There is no rounds assigned</span>
      <?php 
    }
    ?>
     </div>
    
   </div>
    <div class="card">
      <div class="card-body border-bottom">
     <h4 class="card-title">Pools Involved</h4>
    
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
              <th>Which Mega Jackpot (Round)</th>
             
              <th>Status</th>
              <th>Actions</th>
              
            </tr>
          </thead>
        </table>
      </div>

         <div class="d-flex justify-content-between mx-0 row dataTables_wrapper "><div class="col-sm-12 col-md-4"><div class="dataTables_info" id="DataTables_Table_1_info" >Showing <span id="pagination_start_no"></span> to <span id="pagination_end_no"></span> of <span id="pagination_total_entries"></span> entries</div></div><div class="col-sm-12 col-md-8"><div class="dataTables_paginate paging_simple_numbers" id="dataTables_paginate_id" ><div class="pagination" >
          
        </div></div></div></div>
    </div>
    

  </div>
  <!-- list and filter end -->

  <!-- list and filter start -->
  <div class="card">
    <div class="card-body border-bottom">
      <h4 class="card-title">Mega Jackpot History</h4>
      
    
    </div>
    <div class="card-datatable table-responsive pt-0">
      <table class="megajackpots_involved-list-table_2 table">
        <thead class="table-light">
          <tr>
             <th>Name</th>
            <th>Start Time</th>           
            <th>End Time</th>
            <th>Base Prize</th>
            <th>Accumulate Prize</th>
            <th>Total Prize</th>
            <th>Winner</th>
            
          </tr>
        </thead>
        <tbody>
          @if(!empty($mega_jackpot_history))
            @foreach($mega_jackpot_history as $mj)
              <tr>
                <td>{{$mj->name}}</td>
                <td>{{$mj->startTime}}</td>          
                <td>{{$mj->endTime}}</td> 
                <td>{{(int)$mj->basePrize}}</td> 
                <td>{{(int)$mj->accumulatedPrize}}</td> 
                <td>{{(int)($mj->basePrize+$mj->accumulatedPrize)}}</td>
                 <td>{{$mj->winner_user_ids}}</td>
                
              </tr>
            @endforeach
          @endif
        </tbody>
       
      
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
              <h1 class="mb-1">Base Prize Update</h1>
               <div id="confirm_message_div" class="text-danger"></div>
              <p>Are you sure?</p>
            </div>
             <input type="hidden" name="amount" id="amount" value="" />
              <input type="hidden" name="mega_jackpot_id" id="mega_jackpot_id" value="{{ $mega_jackpot_id }}" />

             

            <div class="alert alert-warning" role="alert">
              <h6 class="alert-heading">Warning!</h6>
              <div class="alert-body">
                Do you really want to this ? This process cannot be undone.
              </div>
            </div>

           
             
            
              <div class="col-sm-12 ps-sm-0">
               
                <button type="submit" id="btn_save_confirm" class="btn btn-warning confirmitem">Submit</button>
                 <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
              </div>
            </form>
             
           
          </div>
        </div>
      </div>
    </div>


 <!-- Modal to view league starts-->
    <div class="modal modal-slide-in edit-pools-modal fade" id="modals-slide-in-view">
      <div class="modal-dialog">
       
          <form class="edit-new-league modal-content pt-0"  id="postForm_view" name="postForm_view" >
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
          <div class="modal-header mb-1">
            <h5 class="modal-title" id="exampleModalLabel_view">Jackpot Details</h5>
          </div>
          <div class="modal-body flex-grow-1">
            <div  id="details_modal_body_content">
             
            </div>
           
            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
    <!-- Modal to add edit league Ends-->
    
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

$(document).on('click', '.confirmitem', function(event){
    event.preventDefault(); 

    
    var base_prize = $('#base_prize').val();
      base_prize = parseInt(base_prize);

      base_prize = Math.abs(base_prize);
      $('#amount').val(base_prize);
   
});

$(document).on('click', '#btn_save_confirm', function(event){
  event.preventDefault();

  var site_base_url = $('#site_base_url').val();

   
  
    $.ajax({
              beforeSend: function(){
                $('.ajax-loader').css("visibility", "visible");
              },
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
             
              url:  site_base_url+'megajackpots/baseprize',
              method: "POST",
               data:$('#confirm_Form').serialize(),
               dataType:'JSON',
               
              success: function (data) {                
               
                 //  alert(JSON.stringify(data));           

                  if(data.status=='ok')

                    {                     

                      toastr_message_show('success',data.message);
                    }

                    else 

                    {                    

                      toastr_message_show('error',Object.values(data.message));

                    }


                    $('#myModal_directcredits').modal('hide'); 

                    

                      
               
                  
              },
              error: function (data) {
                 alert(JSON.stringify(data));
               //  document.write(JSON.stringify(data));
                  
                 
                  
              } ,
              complete: function(){
                $('.ajax-loader').css("visibility", "hidden");
              } 
          });
          
   
});

$(document).on('click', '#basic_details_submit_1', function(event){

  event.preventDefault();
  var pool_id = $('#poolidselect_1').val();
  var mega_jackpot_round_id = $('#mega_jackpot_round_id_1').val();
  

  var mega_jackpot_id = $('#mega_jackpot_id').val();

  var type = 'Add';

  var pool_no = 1;



   var site_base_url = $('#site_base_url').val();
   addremovepool(pool_id,mega_jackpot_id,type,pool_no,mega_jackpot_round_id);
     
     

    }); 

$(document).on('click', '#basic_details_submit_2', function(event){

  event.preventDefault();
  var pool_id = $('#poolidselect_2').val();
  var mega_jackpot_round_id = $('#mega_jackpot_round_id_2').val();
  

  var mega_jackpot_id = $('#mega_jackpot_id').val();

  var type = 'Add';

  var pool_no = 2;



   var site_base_url = $('#site_base_url').val();
   addremovepool(pool_id,mega_jackpot_id,type,pool_no,mega_jackpot_round_id);
     
     

    }); 


$(document).on('click', '#basic_details_submit_3', function(event){

  event.preventDefault();
  var pool_id = $('#poolidselect_3').val();
  var mega_jackpot_round_id = $('#mega_jackpot_round_id_3').val();
  

  var mega_jackpot_id = $('#mega_jackpot_id').val();

  var type = 'Add';

  var pool_no = 3;



   var site_base_url = $('#site_base_url').val();
   addremovepool(pool_id,mega_jackpot_id,type,pool_no,mega_jackpot_round_id);
     
     

    });

$(document).on('click', '#basic_details_remove_1', function(event){


  var returnconfirm =confirm('Do you want to really delete this item?');
  if(returnconfirm)
  {

      event.preventDefault();
      var pool_id = $('#poolidremove_1').val();
      var mega_jackpot_round_id = $('#mega_jackpot_round_id_1_remove').val();
      

      var mega_jackpot_id = $('#mega_jackpot_id').val();

      var type = 'Remove';

      var pool_no = 1;



       var site_base_url = $('#site_base_url').val();

       addremovepool(pool_id,mega_jackpot_id,type,pool_no,mega_jackpot_round_id);
         
         
        }

    });
$(document).on('click', '#basic_details_remove_2', function(event){


  var returnconfirm =confirm('Do you want to really delete this item?');
  if(returnconfirm)
  {

      event.preventDefault();
      var pool_id = $('#poolidremove_2').val();
      var mega_jackpot_round_id = $('#mega_jackpot_round_id_2_remove').val();
      

      var mega_jackpot_id = $('#mega_jackpot_id').val();

      var type = 'Remove';

      var pool_no = 2;



       var site_base_url = $('#site_base_url').val();

       addremovepool(pool_id,mega_jackpot_id,type,pool_no,mega_jackpot_round_id);
         
         
        }

    });

$(document).on('click', '#basic_details_remove_3', function(event){


  var returnconfirm =confirm('Do you want to really delete this item?');
  if(returnconfirm)
  {

      event.preventDefault();
      var pool_id = $('#poolidremove_3').val();
      var mega_jackpot_round_id = $('#mega_jackpot_round_id_3_remove').val();
      

      var mega_jackpot_id = $('#mega_jackpot_id').val();

      var type = 'Remove';

      var pool_no = 3;



       var site_base_url = $('#site_base_url').val();

       addremovepool(pool_id,mega_jackpot_id,type,pool_no,mega_jackpot_round_id);
         
         
        }

    });

    function  addremovepool(pool_id,mega_jackpot_id,type,pool_no,mega_jackpot_round_id)
    {

       var site_base_url = $('#site_base_url').val();

       if((pool_id!='') && (mega_jackpot_id!='') && (type!='') && (pool_no!='')  && (mega_jackpot_round_id!='') )
          {
               $.ajax({
                  beforeSend: function(){
                    $('.ajax-loader').css("visibility", "visible");
                  },
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                 
                  url:  site_base_url+'megajackpots/poolround',
                  method: "POST",
                   data:{'pool_id':pool_id,'mega_jackpot_id':mega_jackpot_id,'type':type,'pool_no':pool_no,'mega_jackpot_round_id':mega_jackpot_round_id},
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

                        
                         document.location.reload();  

                   
                      
                  },
                  error: function (data) {
                     alert(JSON.stringify(data));
                      //$('#btn-save_edit').html('Save Changes');
                     
                      
                  } ,
                  complete: function(){
                   // $('.ajax-loader').css("visibility", "hidden");
                  }  
              });

            


          }
          else 
          {
            toastr_message_show('error','Something errors');
          }
    } 
</script>
@endsection

