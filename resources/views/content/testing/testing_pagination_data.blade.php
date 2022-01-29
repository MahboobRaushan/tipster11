<div class="table-responsive" >
        
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Sl No</th>
              <th>ID</th>
              <th>Name</th>
              <th>Email</th>
             
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
                <div class="dropdown">
                  <button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0" data-bs-toggle="dropdown">
                    <i data-feather="more-vertical"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="#">
                      <i data-feather="edit-2" class="me-50"></i>
                      <span>Edit</span>
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


       