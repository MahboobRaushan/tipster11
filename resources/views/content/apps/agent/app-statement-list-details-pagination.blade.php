<div class="card-datatable table-responsive pt-0">
      <table class="datatables-basic table">
        <thead class="table-light">
          <tr>
            
            <th>Individual Agent Id</th>
            <th>Member ID</th> 
            <th>Member Name</th> 
            <th>Date</th> 
            <th>Bet Amount</th>  
            <th>Percentage</th>
            <th>Commission</th>        
          
           
          </tr>
        </thead>
        <tbody>
          <?php if(!empty($data )){
            foreach($data  as $statement)
            {
              ?>
              <tr>
                <td><?php echo $statement['individualAgentId']?> </td>
                <td><?php echo $statement['member_id']?> </td>
                <td><?php echo $statement['member_name']?> </td>
              <td><?php echo $statement['date']?></td>
               <td><?php echo $statement['todaybetAmount']?></td>
                <td><?php echo $statement['percentage']?></td>
                 <td><?php echo $statement['commission']?></td>
                 

              </tr>
              <?php 
            }
          }
          ?>
        </tbody>
      </table>
    
    </div>
    <div id="pagination">
      {{ $data->links() }}
        </div>