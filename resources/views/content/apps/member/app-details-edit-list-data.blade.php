<div class="table-responsive" >
        
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Sl No</th>
              <th>Date</th>
              <th>Desposit</th>
              <th>Withdrawal</th>
              <th>By</th>
              <th>Balance Amount</th>

              
            </tr>
          </thead>
          <tbody>
            @php $i = ($data_credits->currentpage()-1)* $data_credits->perpage() ;
            $start_no = $i;
            $start_no++;
            @endphp
             @foreach($data_credits as $row)
            <tr>
              <td>
                {{ ++$i }}
              </td>
              <td>
                {{ $row->created_at }}
              </td>

              <td>
                {{ $row->type=='Deposit'?$row->amount:'' }}
              </td>
               <td>
                {{ $row->type=='Withdraw'?$row->amount:'' }}
              </td>

              <td>
                {{ $row->reference_by }}
              </td>
               <td>
                {{ $row->current_balance }}
              </td>
                             
             
            </tr>
             @endforeach
             @php $end_no = $i; @endphp
          </tbody>
        </table>
       
      </div>
       

       
        <div class="d-flex justify-content-between mx-0 row dataTables_wrapper "><div class="col-sm-12 col-md-6"><div class="dataTables_info" id="DataTables_Table_1_info" >Showing {{$start_no}} to {{$end_no}} of {{$data_credits->total()}} entries</div></div><div class="col-sm-12 col-md-6"><div class="dataTables_paginate paging_simple_numbers" ><div class="pagination" >
          {!! $data_credits->links() !!}
        </div></div></div></div>

     

