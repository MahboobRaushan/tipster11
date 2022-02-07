<div class="table-responsive" >
        
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Sl No</th>
                <th>Date and Time</th>
              <th>Player ID</th>
              <th>Player Name</th>
              <th>Player Email</th>
              <th>Agent Name</th>
             
              <th>Current Balance</th>
              <th>Amount</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @php $i = ($data->currentpage()-1)* $data->perpage() ;
            $start_no = $i;
            $start_no++;
            @endphp
             @foreach($data as $row)
            <tr>
              <td>
                {{ ++$i }}
              </td>
              <td>
                {{ $row->withdraw_time }}
              </td>
              
               <td>
                {{ $row->player_id }}
              </td>
              
              <td>
                {{ $row->player_name }}
              </td>
              <td>
                {{ $row->player_email }}
              </td>
               
              <td>
                {{ $row->agent_name }}
              </td>
             
              <td> {{ $row->credits }}</td>
              <td> {{ $row->amount }}</td>


             
               
              <td>
                <div class="dropdown">
                  <button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0" data-bs-toggle="dropdown">
                    <i data-feather="more-vertical"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end">
                   
                  <?php 
                  if($row->credits >= $row->amount)  {?>
                    <a class="dropdown-item approval" data-id="{{ $row->id }}" data-bs-toggle="modal" data-bs-target="#inlineForm">
                      <i data-feather="check-square" class="me-50"></i>
                      <span>Approval</span>
                    </a>
                  <?php } ?>
                    <a class="dropdown-item deleteitem"  data-id="{{ $row->id }}" data-bs-toggle="modal" data-bs-target="#myModal_delete" >
                      <i data-feather="trash" class="me-50"></i>
                      <span>Delete</span>
                    </a>
                  </div>
                </div>
              </td>
            </tr>
             @endforeach
             @php $end_no = $i; @endphp
          </tbody>
        </table>
       
      </div>
       

       
        <div class="d-flex justify-content-between mx-0 row dataTables_wrapper "><div class="col-sm-12 col-md-6"><div class="dataTables_info" id="DataTables_Table_1_info" >Showing {{$start_no}} to {{$end_no}} of {{$data->total()}} entries</div></div><div class="col-sm-12 col-md-6"><div class="dataTables_paginate paging_simple_numbers" ><div class="pagination" >
          {!! $data->links() !!}
        </div></div></div></div>


 <div
                class="modal fade text-start"
                id="inlineForm"
                tabindex="-1"
                aria-labelledby="myModalLabel33"
                aria-hidden="true"
              >
                <div class="modal-dialog modal-dialog-centered modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title" id="myModalLabel33">Approval Panel</h4>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    
                    
                    <form action="#" id="postForm">
                      @csrf
                      <div class="modal-body">
                        
                         <label>Current Balance: </label>
                        <div class="mb-1">
                         
                          <div id="currentbalancediv"></div>
                        </div>


                         <label>Amount: </label>
                        <div class="mb-1">
                          <input type="hidden"  name="withdraw_id" id="withdraw_id" value=""/>
                          <input type="hidden"  name="user_id" id="user_id" value=""/>
                          <input name="amount" id="amount" type="text" placeholder="Amount" class="form-control" />
                        </div>
                         <label>Bank Account Name: </label>
                        <div class="mb-1">
                         
                          <input name="bank_account_name" id="bank_account_name" type="text" placeholder="Bank Account Name" class="form-control" />
                        </div>

                        <label>Bank Country: </label>
                        <div class="mb-1">
                         
                          <input name="bank_country" id="bank_country" type="text" placeholder="Bank Country" class="form-control" />
                        </div>

                         <label>Bank Name: </label>
                        <div class="mb-1">
                         
                          <input name="bank_name" id="bank_name" type="text" placeholder="Bank Name" class="form-control" />
                        </div>

                         <label>Bank Account Number: </label>
                        <div class="mb-1">
                         
                          <input name="bank_account_number" id="bank_account_number" type="text" placeholder="Bank Account Number" class="form-control" />
                        </div>

                        <label>Bank Account Type: </label>
                        <div class="mb-1">
                         
                          <input name="bank_account_type" id="bank_account_type" type="text" placeholder="Bank Account Type" class="form-control" />
                        </div>


                         <label>Status: </label>
                        <div class="mb-1">
                          <select class="form-control select2" id="status" name="status" >
                            <option value="Approved">Approved</option>
                            <option value="Reject">Reject</option>
                          </select>
                        </div>
                        <label>Message: </label>
                        <div class="mb-1">
                          <textarea id="status_change_message" name="status_change_message" placeholder="Comments" class="form-control" ></textarea>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="submit" id="approval_submit" class="btn btn-primary" >Submit</button>
                      </div>
                      <div id="approvaldetailsdiv"></div>
                    </form>
                  </div>
                </div>
              </div>  

     <div
        class="modal fade text-start"
        id="inlineFormdetails"
        tabindex="-1"
        aria-labelledby="myModalLabel17"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" id="myModalLabel17">Withdraw Request Details</h4>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            @csrf
            <input type="hidden" id="withdraw_id_text" value="" />
            <div class="modal-body" id="viewdetailsdiv">
             ...
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>


    <!-- Modal to delete game start-->
    <div class="modal fade" id="myModal_delete" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-transparent">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body p-3 pt-0">
            <div class="text-center mb-2">
              <h1 class="mb-1">Delete Withdraw</h1>
              <p>Are you sure?</p>
            </div>

            <div class="alert alert-warning" role="alert">
              <h6 class="alert-heading">Warning!</h6>
              <div class="alert-body">
                Do you really want to delete this record? This process cannot be undone.
              </div>
            </div>

         
            
              <div class="col-sm-12 ps-sm-0">
                <input type="hidden" id="delete_id" value="" />
                <button type="submit" id="btn_save_delete" class="btn btn-warning data-delete">Delete</button>
                 <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
              </div>
             
           
          </div>
        </div>
      </div>
    </div>
    <!-- Modal to delete game Ends-->  
                            