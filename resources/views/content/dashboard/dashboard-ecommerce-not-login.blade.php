@extends('layouts/fullLayoutMaster')

@section('title', 'Home')

@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('css/base/pages/authentication.css')) }}">
@endsection

@section('content')
  <div class="auth-wrapper auth-basic px-2">
    <div class="auth-inner my-2">
      <!-- Login basic -->
      <div class="card mb-0">
        <div class="card-body">
          <a href="{{url('/login')}}" class="brand-logo">
            <img src="images/logo/logo.png" style="width:200px;" />
           
          </a>

          <a href="{{url('/login')}}" class="brand-logo">
            <h4 class="card-title mb-1">Welcome to Tipster 17</h4>
          </a>
          <a href="{{url('/login')}}" class="brand-logo">
            <p class="card-text mb-2">Please stay with us and start the adventure</p>
          </a>

       

        

        

          <div class="divider my-2">
            <div class="divider-text">or</div>
          </div>

          <div class="auth-footer-btn d-flex justify-content-center">
            <a href="#" class="btn btn-facebook">
              <i data-feather="facebook"></i>
            </a>
            <a href="#" class="btn btn-twitter white">
              <i data-feather="twitter"></i>
            </a>
            <a href="#" class="btn btn-google">
              <i data-feather="mail"></i>
            </a>
            <a href="#" class="btn btn-github">
              <i data-feather="github"></i>
            </a>
          </div>
        </div>
      </div>
      <!-- /Login basic -->
    </div>
  </div>
@endsection
