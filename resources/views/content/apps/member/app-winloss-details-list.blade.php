@extends('layouts/contentLayoutMaster')

@section('title', 'Winloss Details List')

@section('vendor-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">



@endsection

@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
  <link rel="stylesheet" href="{{asset('css/base/pages/ui-feather.css')}}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">

@endsection

@section('content')

<?php 
 //print_r($custom_get_all_permissions_access);
 // die();
  ?>

   


<!-- detailss list start -->
<section class="app-details-list">
  
  <!-- list and filter start -->
  <div class="card">

    <div class="card-text m-2">
          <div class="row">
            <div class="col-lg-6">
              <div class="row">
                <div class="col-md-6 ">
                   <label class="form-label" >Player Id : P156023 (Player AAA)</label>
                </div>
                 <div class="col-md-6 ">
                   <label class="form-label" >Agent Id : A678023 (Agent WWW)</label>
                </div>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="row">
                <div class="col-md-6 ">
                  <label class="form-label" for="fp-range">Date Range</label>
                  <input
                    type="text"
                    id="fp-range"
                    class="form-control flatpickr-range"
                    placeholder="YYYY-MM-DD to YYYY-MM-DD"
                  />
                </div>
                
                <div class="col-md-6 mt-2">
                  <button id="search_data_result" class="dt-button add-new btn btn-info" >Search</button>
                  
                </div>

                

              </div>
            </div>
           
          </div>
        </div>
    
    <div class="card-datatable table-responsive pt-0">
      <table class="details-list-table table">
        <thead class="table-light">
          <tr>
            <th></th>
            <th>Day</th>
            <th>Total Bet</th>            
            <th>Win Loss</th>
            <th>Actions</th>
          </tr>
        </thead>
      </table>
    </div>
    
    

  </div>
  <!-- list and filter end -->
</section>
<!-- detailss list ends -->
<!-- Modal to delete game start-->
    <div class="modal fade" id="myModal_playerDetails" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-transparent">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body p-3 pt-0">
          <form action="#" id="confirm_Form">
        <h3><i data-feather="calendar" class="me-50"></i> 2022-02-14</h3>
        <hr>
           
            <div class="accordion" id="accordionExample">
              <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                  <div
                    class="accordion-button"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#accordionOne"
                    aria-expanded="true"
                    aria-controls="accordionOne"
                  >

                  <table width="100%">
                    <tr>
                     <td width="33%">
                        <h6 class="text-success">Pool 1</h6>
                      </td>
                      <td width="33%">
                        <h6 class="text-info">Pool Status: Finished</h6>
                       </td>
                      <td width="33%">
                        <h6 class="text-primary">Win Loss: 20</h6>
                       </td>
                    </tr>
                    </table>
                    
                  </div>
                </h2>
                <div
                  id="accordionOne"
                  class="accordion-collapse collapse show"
                  aria-labelledby="headingOne"
                  data-bs-parent="#accordionExample"
                >
                  <div class="accordion-body">
                   

                     <div class="row match-height">
                      <div class="col-md-12 col-lg-12">
                        <div class="card">
                          
                          <div class="card-body">
                            <div class="row">
                              <div class="col-md-6 col-lg-6">
                                <h4 class="card-title">Bet 1</h4>
                              </div>
                              <div class="col-md-6 col-lg-6" >
                                  <span style="float:right;">00</span>
                                  <span class="blink_me text-success" style="float:right;    font-size: 20px;    font-weight: bold;    margin-top: -4px;        padding-left: 5px;    padding-right: 5px;">:</span>
                                  <span style="float:right;"> 07</span>
                                  <span style="float:right;"><i data-feather="clock" class="me-50"></i></span>
                              </div>
                            </div>

                            
                            
                            
                            <table class="table table-responsive table-striped table-border">
                              <thead><tr><th>No</th><th>Matches</th><th>Selection</th><th>Result</th><th>Score</th></tr></thead>
                              <tbody>
                                <tr><td>1</td><td>Bangalore vs CSK</td><td><span class="text-success">Bangalore</span></td><td>Away</td><td>0:1</td></tr>
                                <tr><td>2</td><td>KKR vs Mumbai</td><td><span class="text-info">Draw</span></td><td>Draw</td><td>2:2</td></tr>
                                 <tr><td>3</td><td>CSK vs Mumbai</td><td><span class="text-info">CSK</span></td><td>Home</td><td>4:2</td></tr>
                              </tbody>
                            </table>
                           
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12 col-lg-12">
                        <div class="card">
                          
                          <div class="card-body">
                             <div class="row">
                              <div class="col-md-6 col-lg-6">
                                <h4 class="card-title">Bet 2</h4>
                              </div>
                              <div class="col-md-6 col-lg-6" >
                                  <span style="float:right;">00</span>
                                  <span class="blink_me text-success" style="float:right;    font-size: 20px;    font-weight: bold;    margin-top: -4px;        padding-left: 5px;    padding-right: 5px;">:</span>
                                  <span style="float:right;"> 12</span>
                                  <span style="float:right;"><i data-feather="clock" class="me-50"></i></span>
                              </div>
                            </div>
                           
                             <table class="table table-responsive table-striped table-border">
                              <thead><tr><th>No</th><th>Matches</th><th>Selection</th><th>Result</th><th>Score</th></tr></thead>
                              <tbody>
                                <tr><td>1</td><td>Bangalore vs CSK</td><td><span class="text-success">Bangalore</span></td><td>Away</td><td>0:1</td></tr>
                                <tr><td>2</td><td>KKR vs Mumbai</td><td><span class="text-info">Draw</span></td><td>Draw</td><td>2:2</td></tr>
                                 
                              </tbody>
                            </table>
                           
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12 col-lg-12">
                        <div class="card">
                          
                          <div class="card-body">
                             <div class="row">
                              <div class="col-md-6 col-lg-6">
                                <h4 class="card-title">Bet 3</h4>
                              </div>
                              <div class="col-md-6 col-lg-6" >
                                  <span style="float:right;">34</span>
                                  <span class="blink_me text-success" style="float:right;    font-size: 20px;    font-weight: bold;    margin-top: -4px;        padding-left: 5px;    padding-right: 5px;">:</span>
                                  <span style="float:right;"> 17</span>
                                  <span style="float:right;"><i data-feather="clock" class="me-50"></i></span>
                              </div>
                            </div>
                        

                             <table class="table table-responsive table-striped table-border">
                              <thead><tr><th>No</th><th>Matches</th><th>Selection</th><th>Result</th><th>Score</th></tr></thead>
                              <tbody>
                                <tr><td>1</td><td>KKR vs Mumbai</td><td><span class="text-info">Draw</span></td><td>Draw</td><td>2:2</td></tr>
                                 <tr><td>2</td><td>CSK vs Mumbai</td><td><span class="text-info">CSK</span></td><td>Home</td><td>4:2</td></tr>
                              </tbody>
                            </table>
                           
                          </div>
                        </div>
                      </div>
                        <div class="col-md-12 col-lg-12">
                        <div class="card">
                          
                          <div class="card-body">
                             <div class="row">
                              <div class="col-md-6 col-lg-6">
                                <h4 class="card-title">Bet 4</h4>
                              </div>
                              <div class="col-md-6 col-lg-6" >
                                  <span style="float:right;">09</span>
                                  <span class="blink_me text-success" style="float:right;    font-size: 20px;    font-weight: bold;    margin-top: -4px;        padding-left: 5px;    padding-right: 5px;">:</span>
                                  <span style="float:right;"> 20</span>
                                  <span style="float:right;"><i data-feather="clock" class="me-50"></i></span>
                              </div>
                            </div>
                            
                             <table class="table table-responsive table-striped table-border">
                              <thead><tr><th>No</th><th>Matches</th><th>Selection</th><th>Result</th><th>Score</th></tr></thead>
                              <tbody>
                                 <tr><td>1</td><td>KKR vs Mumbai</td><td><span class="text-info">Draw</span></td><td>Draw</td><td>2:2</td></tr>
                                 
                              </tbody>
                            </table>
                           
                          </div>
                        </div>
                      </div>
                     
                    
                    </div>



                  </div>
                </div>
              </div>
              <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                  <div
                    class="accordion-button collapsed"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#accordionTwo"
                    aria-expanded="false"
                    aria-controls="accordionTwo"
                  >
                     <table width="100%">
                    <tr>
                     <td width="33%">
                        <h6 class="text-success">Pool 2</h6>
                      </td>
                      <td width="33%">
                        <h6 class="text-info">Pool Status: Active</h6>
                       </td>
                      <td width="33%">
                        <h6 class="text-primary">Win Loss: 0</h6>
                       </td>
                    </tr>
                    </table>
                  </div>
                </h2>
                <div
                  id="accordionTwo"
                  class="accordion-collapse collapse"
                  aria-labelledby="headingTwo"
                  data-bs-parent="#accordionExample"
                >
                  <div class="accordion-body">
                      <div class="row match-height">
                      <div class="col-md-12 col-lg-12">
                        <div class="card">
                          
                          <div class="card-body">
                             <div class="row">
                              <div class="col-md-6 col-lg-6">
                                <h4 class="card-title">Bet 1</h4>
                              </div>
                              <div class="col-md-6 col-lg-6" >
                                  <span style="float:right;">00</span>
                                  <span class="blink_me text-success" style="float:right;    font-size: 20px;    font-weight: bold;    margin-top: -4px;        padding-left: 5px;    padding-right: 5px;">:</span>
                                  <span style="float:right;"> 07</span>
                                  <span style="float:right;"><i data-feather="clock" class="me-50"></i></span>
                              </div>
                            </div>
                            
                            <table class="table table-responsive table-striped table-border">
                              <thead><tr><th>No</th><th>Matches</th><th>Selection</th><th>Result</th><th>Score</th></tr></thead>
                              <tbody>
                                <tr><td>1</td><td>Bangalore vs CSK</td><td><span class="text-success">Bangalore</span></td><td>Away</td><td>0:1</td></tr>
                                <tr><td>2</td><td>KKR vs Mumbai</td><td><span class="text-info">Draw</span></td><td>Draw</td><td>2:2</td></tr>
                               
                              </tbody>
                            </table>
                           
                          </div>
                        </div>
                      </div>
                      
                     
                    
                    </div>
                  </div>
                </div>
              </div>
              <div class="accordion-item">
                <h2 class="accordion-header" id="headingThree">
                  <div
                    class="accordion-button collapsed"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#accordionThree"
                    aria-expanded="false"
                    aria-controls="accordionThree"
                  >
                     <table width="100%">
                    <tr>
                     <td width="33%">
                        <h6 class="text-success">Pool 3</h6>
                      </td>
                      <td width="33%">
                        <h6 class="text-info">Pool Status: Calculating</h6>
                       </td>
                      <td width="33%">
                        <h6 class="text-primary">Win Loss: 0</h6>
                       </td>
                    </tr>
                    </table>
                  </div>
                </h2>
                <div
                  id="accordionThree"
                  class="accordion-collapse collapse"
                  aria-labelledby="headingThree"
                  data-bs-parent="#accordionExample"
                >
                  <div class="accordion-body">
                     <div class="row match-height">
                      <div class="col-md-12 col-lg-12">
                        <div class="card">
                          
                          <div class="card-body">
                             <div class="row">
                              <div class="col-md-6 col-lg-6">
                                <h4 class="card-title">Bet 1</h4>
                              </div>
                              <div class="col-md-6 col-lg-6" >
                                  <span style="float:right;">00</span>
                                  <span class="blink_me text-success" style="float:right;    font-size: 20px;    font-weight: bold;    margin-top: -4px;        padding-left: 5px;    padding-right: 5px;">:</span>
                                  <span style="float:right;"> 08</span>
                                  <span style="float:right;"><i data-feather="clock" class="me-50"></i></span>
                              </div>
                            </div>
                            
                            <table class="table table-responsive table-striped table-border">
                              <thead><tr><th>No</th><th>Matches</th><th>Selection</th><th>Result</th><th>Score</th></tr></thead>
                              <tbody>
                                <tr><td>1</td><td>Bangalore vs CSK</td><td><span class="text-success">Bangalore</span></td><td>Away</td><td>0:1</td></tr>
                                <tr><td>2</td><td>KKR vs Mumbai</td><td><span class="text-info">Draw</span></td><td>Draw</td><td>2:2</td></tr>
                                 <tr><td>3</td><td>CSK vs Mumbai</td><td><span class="text-info">CSK</span></td><td>Home</td><td>4:2</td></tr>
                              </tbody>
                            </table>
                           
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12 col-lg-12">
                        <div class="card">
                          
                          <div class="card-body">
                             <div class="row">
                              <div class="col-md-6 col-lg-6">
                                <h4 class="card-title">Bet 2</h4>
                              </div>
                              <div class="col-md-6 col-lg-6" >
                                  <span style="float:right;">00</span>
                                  <span class="blink_me text-success" style="float:right;    font-size: 20px;    font-weight: bold;    margin-top: -4px;        padding-left: 5px;    padding-right: 5px;">:</span>
                                  <span style="float:right;"> 11</span>
                                  <span style="float:right;"><i data-feather="clock" class="me-50"></i></span>
                              </div>
                            </div>
                           
                            <table class="table table-responsive table-striped table-border">
                              <thead><tr><th>No</th><th>Matches</th><th>Selection</th><th>Result</th><th>Score</th></tr></thead>
                              <tbody>
                              
                                 <tr><td>1</td><td>CSK vs Mumbai</td><td><span class="text-info">CSK</span></td><td>Home</td><td>4:2</td></tr>
                              </tbody>
                            </table>
                           
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12 col-lg-12">
                        <div class="card">
                          
                          <div class="card-body">
                             <div class="row">
                              <div class="col-md-6 col-lg-6">
                                <h4 class="card-title">Bet 3</h4>
                              </div>
                              <div class="col-md-6 col-lg-6" >
                                  <span style="float:right;">00</span>
                                  <span class="blink_me text-success" style="float:right;    font-size: 20px;    font-weight: bold;    margin-top: -4px;        padding-left: 5px;    padding-right: 5px;">:</span>
                                  <span style="float:right;"> 13</span>
                                  <span style="float:right;"><i data-feather="clock" class="me-50"></i></span>
                              </div>
                            </div>
                        

                             <table class="table table-responsive table-striped table-border">
                              <thead><tr><th>No</th><th>Matches</th><th>Selection</th><th>Result</th><th>Score</th></tr></thead>
                              <tbody>
                                <tr><td>1</td><td>Bangalore vs CSK</td><td><span class="text-success">Bangalore</span></td><td>Away</td><td>0:1</td></tr>
                                <tr><td>2</td><td>KKR vs Mumbai</td><td><span class="text-info">Draw</span></td><td>Draw</td><td>2:2</td></tr>
                                
                              </tbody>
                            </table>
                           
                          </div>
                        </div>
                      </div>
                        <div class="col-md-12 col-lg-12">
                        <div class="card">
                          
                          <div class="card-body">
                             <div class="row">
                              <div class="col-md-6 col-lg-6">
                                <h4 class="card-title">Bet 2</h4>
                              </div>
                              <div class="col-md-6 col-lg-6" >
                                  <span style="float:right;">00</span>
                                  <span class="blink_me text-success" style="float:right;    font-size: 20px;    font-weight: bold;    margin-top: -4px;        padding-left: 5px;    padding-right: 5px;">:</span>
                                  <span style="float:right;"> 16</span>
                                  <span style="float:right;"><i data-feather="clock" class="me-50"></i></span>
                              </div>
                            </div>
                            
                            
                            <table class="table table-responsive table-striped table-border">
                              <thead><tr><th>No</th><th>Matches</th><th>Selection</th><th>Result</th><th>Score</th></tr></thead>
                              <tbody>
                                <tr><td>1</td><td>Bangalore vs CSK</td><td><span class="text-success">Bangalore</span></td><td>Away</td><td>0:1</td></tr>
                               
                                 <tr><td>2</td><td>CSK vs Mumbai</td><td><span class="text-info">CSK</span></td><td>Home</td><td>4:2</td></tr>
                              </tbody>
                            </table>
                           
                          </div>
                        </div>
                      </div>
                     
                    
                    </div>
                  </div>
                </div>
              </div>
              <div class="accordion-item">
                <h2 class="accordion-header" id="headingFour">
                  <div
                    class="accordion-button collapsed"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#accordionFour"
                    aria-expanded="false"
                    aria-controls="accordionFour"
                  >
                     <table width="100%">
                    <tr>
                     <td width="33%">
                        <h6 class="text-success">Pool 4</h6>
                      </td>
                      <td width="33%">
                        <h6 class="text-info">Pool Status: Finished</h6>
                       </td>
                      <td width="33%">
                        <h6 class="text-primary">Win Loss: 120</h6>
                       </td>
                    </tr>
                    </table>
                  </div>
                </h2>
                <div
                  id="accordionFour"
                  class="accordion-collapse collapse"
                  aria-labelledby="headingFour"
                  data-bs-parent="#accordionExample"
                >
                  <div class="accordion-body">
                     <div class="row match-height">
                      <div class="col-md-12 col-lg-12">
                        <div class="card">
                          
                          <div class="card-body">
                             <div class="row">
                              <div class="col-md-6 col-lg-6">
                                <h4 class="card-title">Bet 1</h4>
                              </div>
                              <div class="col-md-6 col-lg-6" >
                                  <span style="float:right;">00</span>
                                  <span class="blink_me text-success" style="float:right;    font-size: 20px;    font-weight: bold;    margin-top: -4px;        padding-left: 5px;    padding-right: 5px;">:</span>
                                  <span style="float:right;"> 07</span>
                                  <span style="float:right;"><i data-feather="clock" class="me-50"></i></span>
                              </div>
                            </div>
                            
                            <table class="table table-responsive table-striped table-border">
                              <thead><tr><th>No</th><th>Matches</th><th>Selection</th><th>Result</th><th>Score</th></tr></thead>
                              <tbody>
                                <tr><td>1</td><td>Bangalore vs CSK</td><td><span class="text-success">Bangalore</span></td><td>Away</td><td>0:1</td></tr>
                                <tr><td>2</td><td>KKR vs Mumbai</td><td><span class="text-info">Draw</span></td><td>Draw</td><td>2:2</td></tr>
                                 <tr><td>3</td><td>CSK vs Mumbai</td><td><span class="text-info">CSK</span></td><td>Home</td><td>4:2</td></tr>
                              </tbody>
                            </table>
                           
                          </div>
                        </div>
                      </div>
                    
                      <div class="col-md-12 col-lg-12">
                        <div class="card">
                          
                          <div class="card-body">
                             <div class="row">
                              <div class="col-md-6 col-lg-6">
                                <h4 class="card-title">Bet 2</h4>
                              </div>
                              <div class="col-md-6 col-lg-6" >
                                  <span style="float:right;">00</span>
                                  <span class="blink_me text-success" style="float:right;    font-size: 20px;    font-weight: bold;    margin-top: -4px;        padding-left: 5px;    padding-right: 5px;">:</span>
                                  <span style="float:right;"> 08</span>
                                  <span style="float:right;"><i data-feather="clock" class="me-50"></i></span>
                              </div>
                            </div>
                        

                             <table class="table table-responsive table-striped table-border">
                              <thead><tr><th>No</th><th>Matches</th><th>Selection</th><th>Result</th><th>Score</th></tr></thead>
                              <tbody>
                                <tr><td>1</td><td>Bangalore vs CSK</td><td><span class="text-success">Bangalore</span></td><td>Away</td><td>0:1</td></tr>
                                <tr><td>2</td><td>KKR vs Mumbai</td><td><span class="text-info">Draw</span></td><td>Draw</td><td>2:2</td></tr>
                                
                              </tbody>
                            </table>
                           
                          </div>
                        </div>
                      </div>
                       
                     
                    
                    </div>
                  </div>
                </div>
              </div>
            </div>

           
             
            
              <div class="col-sm-12 ps-sm-0"> 
               
                 <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
              </div>
            </form>
             
           
          </div>
        </div>
      </div>
    </div>
    <!-- Modal to delete game Ends--> 


@endsection

@section('vendor-script')
  {{-- Vendor js files --}}
  <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/jszip.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/pdfmake.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/vfs_fonts.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.html5.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.print.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.rowGroup.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/forms/cleave/cleave.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/forms/cleave/addons/cleave-phone.us.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>

  



@endsection

@section('page-script')
  {{-- Page js files --}}
   


  <script src="{{ asset(mix('js/scripts/pages/app-memberwinlossdetails-list.js')) }}"></script>
  <script src="{{asset('js/scripts/ui/ui-feather.js')}}"></script>
<script src="{{ asset(mix('js/scripts/forms/pickers/form-pickers.js')) }}"></script>

@endsection

