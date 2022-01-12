@extends('layouts/contentLayoutMaster')

@section('title', 'Profile Photo')

@section('vendor-style')
  {{-- Page Css files --}}




@endsection

@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
@endsection

@section('content')

<?php 
 //print_r($custom_get_all_permissions_access);
 // die();
  ?>

   


<!-- users list start -->
<section class="app-user-list">
  <div class="row">
    <div class="col-lg-12 col-sm-12">
      <div class="card">
        <div class="card-body d-flex align-items-center justify-content-between">
         
          <form action="{{ route('user.photoupdate') }}"  method="POST"  id="postForm_edit" name="postForm_edit" enctype="multipart/form-data">
            @csrf
         <div>
         
         

         

             <div class="mb-1">
               <h3 class="fw-bolder mb-75">Profile Photo</h3>
               
              <label class="form-label" for="basic-icon-default-icon">Image</label>
               <input  class="form-label" type="file" name="image" placeholder="Choose image" id="basic-icon-default-icon_edit">

               <?php $current_user_id = Auth::user()->id; $users = DB::table('users')->where('id',$current_user_id)->first();  ?>
              
              
               <img id="preview-image-before-upload_edit" src="{{ $users->profile_photo_path ? url('').'/'.$users->profile_photo_path : asset('images/portrait/small/avatar-s-11.jpg') }}"
alt="preview image" style="max-height: 100px;">

            </div>
            
          
            
          
           
            <button type="submit" id="btn-save_edit" class="btn btn-primary me-1 data-submit">Save</button>
          
          </div>
        </form>
          
        </div>
      </div>
    </div>
  
    
    
  </div>

</section>
<!-- users list ends -->
@endsection

@section('vendor-script')
  {{-- Vendor js files --}}
   
 



@endsection

@section('page-script')
  {{-- Page js files --}}
   
<script> 
var current_user_id = "<?php echo $current_user_id ;?>";

</script>



  }
@endsection

