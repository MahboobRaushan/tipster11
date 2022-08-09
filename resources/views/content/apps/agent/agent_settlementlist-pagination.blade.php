<div class="card-datatable table-responsive pt-0">
  <table class="datatables-basic table">
        <thead class="table-light">
          <tr>
            
            <th>from date</th>
            <th>to date</th> 
            <th>total commission</th> 
            <th>settlement amount</th> 
            <th>company status</th>  
            <th>agent apply date</th>
            <th>company action date</th> 
            <th>View </th>  
            <th>Delete </th>        
          
           
          </tr>
        </thead>
        <tbody>
          <?php if(!empty($data )){
            foreach($data  as $statement)
            {
              ?>
              <tr>
                 <td><?php echo $statement['from_date']?> </td>
                <td><?php echo $statement['to_date']?> </td>
                <td><?php echo $statement['total_commission']?> </td>
              <td><?php echo $statement['settlement_amount']?></td>
               <td><?php echo $statement['company_status']?></td>
                <td><?php echo $statement['agent_apply_date']?></td>
                 <td><?php echo $statement['company_action_date']?></td>
                 <td>  <span   class="btn btn-info view_modal" style="cursor: pointer;" data-id="<?php echo $statement['id']?>" >View</span></td>
                 <td><?php if(($statement['company_status']=='Pending') || ($statement['company_status']=='Rejected') ){?> <span    class="btn btn-danger myModal_delete" style="cursor: pointer;" data-id="<?php echo $statement['id']?>" >Delete</span> <?php } ?></td>
                 
              </tr>
              <?php 
            }
          }
          ?>
        </tbody>
      </table>
      <div id="pagination">
      {{ $data->links() }}
        </div>
</div>


  <!-- Modal to add new match starts-->
    <div class="modal modal-slide-in new-match-modal fade" id="modals-slide-in-view">
      <div class="modal-dialog">
        <form class="add-new-match modal-content pt-0"   enctype="multipart/form-data" >
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
          <div class="modal-header mb-1">
            <h5 class="modal-title" id="exampleModalLabel">Settlement Details</h5>
          </div>
          <div class="modal-body flex-grow-1" >
            <div class="mb-1" id="details_modal_body_content">
             
            </div>
           
           
            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
    <!-- Modal to add new match Ends-->

     <!-- Modal to delete match start-->
    <div class="modal fade" id="myModal_delete" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-transparent">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body p-3 pt-0">
            <div class="text-center mb-2">
              <h1 class="mb-1">Delete Settlement</h1>
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
                <button type="submit" id="btn-save_delete" class="btn btn-warning data-delete">Delete</button>
                 <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
              </div>
             
           
          </div>
        </div>
      </div>
    </div>
    <!-- Modal to delete match Ends-->
    <input type="hidden" id="baseurl" value="{{url('/')}}">