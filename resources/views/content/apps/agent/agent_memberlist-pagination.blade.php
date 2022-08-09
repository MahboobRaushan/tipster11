<div class="card-datatable table-responsive pt-0">
  <table class="datatables-basic table">
        <thead class="table-light">
          <tr>
            
            <th>Id</th>
            <th>Name</th> 
            <th>Registration Date</th>  
            <th>Email</th>
            <th>Player ID</th>        
          
           
          </tr>
        </thead>
        <tbody>
          <?php if(!empty($data )){
            foreach($data  as $statement)
            {
              ?>
              <tr>
                <td><?php echo $statement['id']?> </td>
              <td><?php echo $statement['name']?></td>
               <td><?php echo $statement['created_at']?></td>
                <td><?php echo $statement['email']?></td>
                 <td><?php echo $statement['unique_id']?></td>
                 
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