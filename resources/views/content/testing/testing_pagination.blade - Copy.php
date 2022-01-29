
@extends('layouts/contentLayoutMaster')

@section('title', 'Bootstrap Tables')

@section('content')


<!-- Bordered table start -->
<div class="row" id="table-bordered">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">Demo Ajax Pagination Table</h4>
      </div>
      <div class="card-body">
        <p class="card-text">
          This is rendering the ajax data, not the enire data , for performance testing , when data row 3000-4000
        </p>
      </div>
      <div  id="table_data">
       @include('testing_pagination_data')
      
      </div>
    </div>
  </div>
</div>
<!-- Bordered table end -->


@endsection

<script>
$(document).ready(function(){

 $(document).on('click', '.pagination a', function(event){
  event.preventDefault(); 
  var page = $(this).attr('href').split('page=')[1];
  fetch_data(page);
 });

 function fetch_data(page)
 {
  $.ajax({
   url:"/testingpagination_fetch_data?page="+page,
   success:function(data)
   {
    $('#table_data').html(data);
   }
  });
 }
 
});
</script>