@extends('layouts/contentLayoutMaster')

@section('title', 'Company')

@section('vendor-style')
  <link rel="stylesheet" href="{{asset('vendors/css/forms/select/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')}}">
  <link rel="stylesheet" href="{{asset('vendors/css/tables/datatable/responsive.bootstrap5.min.css')}}">
  <link rel="stylesheet" href="{{asset('vendors/css/tables/datatable/buttons.bootstrap5.min.css')}}">
  <link rel="stylesheet" href="{{asset('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css')}}">

@endsection

@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{asset('css/base/plugins/forms/form-validation.css')}}">
@endsection

@section('content')

<?php 
//echo "<pre>";
 //print_r($companysettings->id);
 //echo "</pre>";
 // die();
  ?>



<!-- Basic Horizontal form layout section start -->
<section id="basic-horizontal-layouts">
  <div class="row">
    
    <div class="col-md-12 col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Company Settings</h4>
        </div>
        <div class="card-body">
           <form action="{{ route('companysave') }}"  method="POST"  id="postForm_edit" name="postForm_edit" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="col-6">
                <div class="mb-1 row">
                  <div class="col-sm-3">
                    <label class="col-form-label" for="contact-icon">Logo</label>
                  </div>
                  <div class="col-sm-9">
                    <div class="input-group input-group-merge">
                      <span class="input-group-text"><i data-feather="image"></i></span>
                      <input
                        type="file"
                        id="logo_file"
                        class="form-control"
                        name="logo"
                        
                       
                      />

                      


                    </div>
                     <?php  $companysettings = DB::table('companysettings')->get()->first(); ?>

                      

                      <img id="preview-image-before-upload_logo" src="{{ $companysettings->logo ? url('').'/'.$companysettings->logo : asset('images/portrait/small/avatar-s-11.jpg') }}"
alt="preview image" style="max-height: 100px;">
                        
                  </div>
                </div>
              </div>
               <div class="col-6">
                <div class="mb-1 row">
                  <div class="col-sm-3">
                    <label class="col-form-label" for="contact-icon">Favicon</label>
                  </div>
                  <div class="col-sm-9">
                    <div class="input-group input-group-merge">
                      <span class="input-group-text"><i data-feather="image"></i></span>
                      <input
                        type="file"
                        id="favicon_file"
                        class="form-control"
                        name="favicon"


                        
                       
                      />
                    </div>
                     <img id="preview-image-before-upload_favicon" src="{{ $companysettings->favicon ? url('').'/'.$companysettings->favicon : asset('images/portrait/small/avatar-s-11.jpg') }}"
alt="preview image" style="max-height: 100px;">
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="mb-1 row">
                  <div class="col-sm-3">
                    <label class="col-form-label" for="fname-icon">Name</label>
                  </div>
                  <div class="col-sm-9">
                    <div class="input-group input-group-merge">
                      <span class="input-group-text"><i data-feather="user"></i></span>
                      <input
                        type="text"
                        id="fname-icon"
                        class="form-control"
                        name="name"
                        placeholder="Name"
                        value="{{$companysettings->name}}"
                      />
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="mb-1 row">
                  <div class="col-sm-3">
                    <label class="col-form-label" for="email-icon">Email</label>
                  </div>
                  <div class="col-sm-9">
                    <div class="input-group input-group-merge">
                      <span class="input-group-text"><i data-feather="mail"></i></span>
                      <input
                        type="email"
                        id="email-icon"
                        class="form-control"
                        name="email"
                        placeholder="Email"
                        value="{{$companysettings->email}}"
                      />
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="mb-1 row">
                  <div class="col-sm-3">
                    <label class="col-form-label" for="contact-icon">Mobile</label>
                  </div>
                  <div class="col-sm-9">
                    <div class="input-group input-group-merge">
                      <span class="input-group-text"><i data-feather="smartphone"></i></span>
                      <input
                        type="text"
                        id="contact-icon"
                        class="form-control"
                        name="phone"
                        placeholder="Mobile"
                        value="{{$companysettings->phone}}"
                      />
                    </div>
                  </div>
                </div>
              </div>
               <div class="col-6">
                <div class="mb-1 row">
                  <div class="col-sm-3">
                    <label class="col-form-label" for="contact-icon">Website</label>
                  </div>
                  <div class="col-sm-9">
                    <div class="input-group input-group-merge">
                      <span class="input-group-text"><i data-feather="globe"></i></span>
                      <input
                        type="text"
                        id="contact-icon"
                        class="form-control"
                        name="website"
                        placeholder="Website"
                        value="{{$companysettings->website}}"
                      />
                    </div>
                  </div>
                </div>
              </div>
                <div class="col-12">
                <div class="mb-1 row">
                  <div class="col-sm-3">
                    <label class="col-form-label" for="contact-icon">Address</label>
                  </div>
                  <div class="col-sm-9">
                    <div class="input-group input-group-merge">
                      <span class="input-group-text"><i data-feather="home"></i></span>
                      <textarea
                        id="contact-icon"
                        class="form-control"
                        name="address"
                        placeholder="Address"
                        >{{$companysettings->address}}</textarea>
                    </div>
                  </div>
                </div>
              </div>
              
             
              <div class="col-sm-12">
                <button type="submit" class="btn btn-primary me-1">Submit</button>
                <button type="reset" class="btn btn-outline-secondary">Reset</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Basic Horizontal form layout section end -->


@endsection

@section('vendor-script')
  <script src="{{asset('vendors/js/forms/select/select2.full.min.js')}}"></script>
  <script src="{{asset('vendors/js/tables/datatable/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')}}"></script>
  <script src="{{asset('vendors/js/tables/datatable/dataTables.responsive.min.js')}}"></script>
  <script src="{{asset('vendors/js/tables/datatable/responsive.bootstrap5.js')}}"></script>
  <script src="{{asset('vendors/js/tables/datatable/datatables.buttons.min.js')}}"></script>
  <script src="{{asset('vendors/js/tables/datatable/jszip.min.js')}}"></script>
  <script src="{{asset('vendors/js/tables/datatable/pdfmake.min.js')}}"></script>
  <script src="{{asset('vendors/js/tables/datatable/vfs_fonts.js')}}"></script>
  <script src="{{asset('vendors/js/tables/datatable/buttons.html5.min.js')}}"></script>
  <script src="{{asset('vendors/js/tables/datatable/buttons.print.min.js')}}"></script>
  <script src="{{asset('vendors/js/tables/datatable/dataTables.rowGroup.min.js')}}"></script>
  <script src="{{asset('vendors/js/forms/validation/jquery.validate.min.js')}}"></script>
  <script src="{{asset('vendors/js/forms/cleave/cleave.min.js')}}"></script>
  <script src="{{asset('vendors/js/forms/cleave/addons/cleave-phone.us.js')}}"></script>


@endsection

@section('page-script')
  {{-- Page js files --}}
   <script>
      $('#logo_file').change(function(){
          let reader = new FileReader();
          reader.onload = (e) => { 
          $('#preview-image-before-upload_logo').attr('src', e.target.result); 
          }
          reader.readAsDataURL(this.files[0]); 
          });

      $('#favicon_file').change(function(){
          let reader = new FileReader();
          reader.onload = (e) => { 
          $('#preview-image-before-upload_favicon').attr('src', e.target.result); 
          }
          reader.readAsDataURL(this.files[0]); 
          });
        </script>

  }
@endsection

