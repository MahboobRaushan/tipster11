<div class="table-responsive" >

       
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Sl No</th>
              <th>Individual Agent ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Registration Date</th>              
              <th>Credit Balance</th>              
              <th>Status</th>
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
                {{ $row->unique_id }}
              </td>
               <td>
                {{ $row->name }}
              </td>
              <td>
                {{ $row->email }}
              </td>
               <td>
                {{ $row->created_at }}
              </td>
             
              <td> {{ $row->credits }}</td>
              
              <td> 
                <?php if($row->status ==1){?>
              <span class="badge rounded-pill badge-light-success" text-capitalized="">Active</span>
              <?php } ?>
              <?php if($row->status ==0){?>
              <span class="badge rounded-pill badge-light-warning" text-capitalized="">Inactive</span>
              <?php } ?>
              <?php if($row->status ==2){?>
              <span class="badge rounded-pill badge-light-danger" text-capitalized="">Suspended</span>
              <?php } ?>
            </td> 
              <td>
                <div class="dropdown">
                  <button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0" data-bs-toggle="dropdown">
                    <i data-feather="more-vertical"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="details/edit/{{ $row->id }}">
                      <i data-feather="edit-2" class="me-50"></i>
                      <span>Edit Agent</span>
                    </a>
                    
                    <a class="dropdown-item reset_password" data-id="{{ $row->id }}" data-bs-toggle="modal" data-bs-target="#inlineForm">
                      <i data-feather="key" class="me-50"></i>
                      <span>Reset Password and ID</span>
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
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title" id="myModalLabel33">Reset Password Form</h4>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    
                    
                    <form action="#" id="postForm">
                      @csrf
                      <div class="modal-body">
                        <div id="password_message"></div>

                         <label>Password: </label>
                        <div class="mb-1">
                          <input type="hidden"  name="user_id" id="user_id" value=""/>
                          <input name="password" id="password" type="password" placeholder="Password" class="form-control" />
                        </div>

                        <label>Confirm Password: </label>
                        <div class="mb-1">
                          <input type="password" id="confirm_password" placeholder="Confirm Password" class="form-control" />
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="submit" id="password_submit" class="btn btn-primary" >Save</button>
                      </div>
                    </form>
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
              <h1 class="mb-1">Delete Agent</h1>
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
