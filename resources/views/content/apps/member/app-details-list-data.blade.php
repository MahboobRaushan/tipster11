<div class="table-responsive" >
        
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Sl No</th>
              <th>Individual Member ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Registration Date</th>
              <th>Agent</th>
              <th>This Week Bet Amount</th>
              <th>Credit Balance</th>
              <th>This Week WinLoss</th>

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
                {{ $row->id }}
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
              <td>
                {{ $row->agent_id }}
              </td>
              <td>10</td>
              <td>100</td>
              <td>20</td>
               
              <td>
                <div class="dropdown">
                  <button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0" data-bs-toggle="dropdown">
                    <i data-feather="more-vertical"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="details/edit/{{ $row->id }}">
                      <i data-feather="edit-2" class="me-50"></i>
                      <span>Edit Member</span>
                    </a>
                    
                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#inlineForm">
                      <i data-feather="key" class="me-50"></i>
                      <span>Reset Password and ID</span>
                    </a>
                    <a class="dropdown-item" href="#">
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
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title" id="myModalLabel33">Reset Password Form</h4>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="#">
                      <div class="modal-body">
                         <label>Password: </label>
                        <div class="mb-1">
                          <input type="password" placeholder="Password" class="form-control" />
                        </div>

                        <label>Confirm Password: </label>
                        <div class="mb-1">
                          <input type="password" placeholder="Confirm Password" class="form-control" />
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Save</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>      