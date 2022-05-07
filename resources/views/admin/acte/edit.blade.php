@extends('layouts.app')

@section('css_scripts')
    <!-- bootstrap-daterangepicker -->
    <link href="{{ asset('gentelella/vendors/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">
    <!-- bootstrap-datetimepicker -->
    <link href="{{ asset('gentelella/vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css') }}" rel="stylesheet">
    <!-- Ion.RangeSlider -->
    <link href="{{ asset('gentelella/vendors/normalize-css/normalize.css') }}" rel="stylesheet">
    <link href="{{ asset('gentelella/vendors/ion.rangeSlider/css/ion.rangeSlider.css') }}" rel="stylesheet">
    <link href="{{ asset('gentelella/vendors/ion.rangeSlider/css/ion.rangeSlider.skinFlat.css') }}" rel="stylesheet">
    <!-- Bootstrap Colorpicker -->
    <link href="{{ asset('gentelella/vendors/mjolnic-bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}" rel="stylesheet">

    <link href="{{ asset('gentelella/vendors/cropper/dist/cropper.min.css') }}" rel="stylesheet">
@endsection

@section('title')
    Dossier du patient : Kazi Aouel Sid Ahmed
@endsection


@section('content')

  <div>
    <div class="page-title">
  		<div class="row">
  			<div class="col-xs-6 col-md-3 col-lg-3 col-md-push-2">
  				<a class="btn btn-app" data-toggle="modal" data-target="#schema_modal">
            <i class="fa fa-plus" ></i> Schéma dentaire
          </a>
  			</div>
  			<div class="col-xs-6 col-md-3 col-lg-3 col-md-push-1">
  				<a class="btn btn-app" data-toggle="modal" data-target="#prescription_modal">
            <i class="fa fa-plus"></i> Prescription
          </a>
  			</div>				
  			<div class="col-xs-6 col-md-3 col-lg-3">
  				<a class="btn btn-app">
            <i class="fa fa-plus"></i> Traitement
          </a>
  			</div>
  			<div class="col-xs-6 col-md-3 col-lg-3 col-md-pull-1">
  				<a class="btn btn-app">
            <i class="fa fa-plus"></i> Radio
          </a>
  			</div>								
      </div>
              
      <div class="clearfix"></div>

      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>Dossier Patient</h2>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
                <div class="profile_img">
                  <div id="crop-avatar">
                    <!-- Current avatar -->
                    <img class="img-responsive avatar-view" src="{{ asset('img/img.jpg') }}" alt="Avatar" title="Change the avatar">
                  </div>
                </div>
                <h3>Samuel Doe,H/F</h3>

                <ul class="list-unstyled user_data">
                  <li>
                  	<i class="fa fa-user user-profile-icon"></i> Age
                  </li>                      	
                  <li>
                  	<i class="fa fa-map-marker user-profile-icon"></i> Adresse Physique
                  </li>

                  <li>
                    <i class="fa fa-briefcase user-profile-icon"></i> Profession
                  </li>
                </ul>

                <a class="btn btn-success"><i class="fa fa-edit m-right-xs"></i>Modifier Profile</a>
                <br>

              </div>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <div class="" role="tabpanel" data-example-id="togglable-tabs">
                  <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Récentes actvités</a>
                    </li>
                    <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Plans de traitement</a>
                    </li>
                    <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Prescriptions</a>
                    </li>
                    <li role="presentation" class=""><a href="#tab_content4" role="tab" id="profile-tab3" data-toggle="tab" aria-expanded="false">Traitements</a>
                    </li>
                    <li role="presentation" class=""><a href="#tab_content5" role="tab" id="profile-tab4" data-toggle="tab" aria-expanded="false">Radiologies</a>
                    </li>                          
                  </ul>

                  <div id="myTabContent" class="tab-content">
                    <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" 
                    aria-labelledby="home-tab">
                    <div class="x_content">
                      <ul class="list-unstyled timeline">
                        <li>
                          <div class="block">
                            <div class="tags">
                              <a href="" class="tag">
                                <span>Entertainment</span>
                              </a>
                            </div>
                            <div class="block_content">
                              <!-- <h2 class="title">
                                              <a>Who Needs Sundance When You’ve Got&nbsp;Crowdfunding?</a>
                                          </h2> -->
                              <div class="byline">
                                <span>13 heures avant</span> by <a>Jhon Doe</a>
                              </div>
                              <p class="excerpt">Film festivals used to be do-or-die moments for movie makers. They were where you met the producers that could fund your project, and if the buyers liked your flick, they’d pay to Fast-forward and… <a>Read&nbsp;More</a>
                              </p>
                            </div>
                          </div>
                        </li>
                        <li>
                          <div class="block">
                            <div class="tags">
                              <a href="" class="tag">
                                <span>Rendez-vous</span>
                              </a>
                            </div>
                            <div class="block_content">
                              <!-- <h2 class="title">
                                              <a>Who Needs Sundance When You’ve Got&nbsp;Crowdfunding?</a>
                                          </h2> -->
                              <div class="byline">
                                <span>13 heures avant</span> by <a>Jhon Doe</a>
                              </div>
                              <p class="excerpt">Film festivals used to be do-or-die moments for movie makers. They were where you met the producers that could fund your project, and if the buyers liked your flick, they’d pay to Fast-forward and… <a>Read&nbsp;More</a>
                              </p>
                            </div>
                          </div>
                        </li>
                        <li>
                          <div class="block">
                            <div class="tags">
                              <a href="" class="tag">
                                <span>Prescription</span>
                              </a>
                            </div>
                            <div class="block_content">
                              <!-- <h2 class="title">
                                              <a>Who Needs Sundance When You’ve Got&nbsp;Crowdfunding?</a>
                                          </h2> -->
                              <div class="byline">
                                <span>13 heures avant</span> by <a>Jhon Doe</a>
                              </div>
                              <p class="excerpt">Film festivals used to be do-or-die moments for movie makers. They were where you met the producers that could fund your project, and if the buyers liked your flick, they’d pay to Fast-forward and… <a>Read&nbsp;More</a>
                              </p>
                            </div>
                          </div>
                        </li>
                      </ul>
                    </div>
                    </div>

                    <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">

                      <!-- start plan de traitements -->
                      <table class="table table-striped" id="plans">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Schéma Dentaire</th>
                            <th>Payé</th>
                            <th>Reste</th>
                            <th>Progression</th>
                            <th>Devis</th>
                            <th>Facture</th>
                            <th>Versements</th>
                            <th>Détails</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr style="text-align: center;cursor: pointer;" data-toggle="collapse"  href="#1">
                            <td>1</td>
                            <td>Schéma Dentaire 01/01/2001</td>
                            <td> 500 DA</td>
                            <td> 2500 DA</td>
                            <td class="vertical-align-mid">
                              <div class="progress">
                                <div class="progress-bar progress-bar-success" data-transitiongoal="35" aria-valuenow="35" style="width: 35%;"></div>
                              </div>
                            </td>
                            <td><a href=""><i class="fa fa-print"></i></a></td>
                            <td><a href=""><i class="fa fa-print"></i></a></td>
                            <td><i class="fa fa-align-justify"></i></td>
                            <td><a href=""><i class="fa fa-search"></i></a></td>
                          </tr>
                          <tr>
                            <td style="display: none;"></td>
                             <td style="display: none;"></td>
                             <td style="display: none;"></td>
                             <td style="display: none;"></td> 
                             <td style="display: none;"></td> 
                             <td style="display: none;"></td> 
                             <td style="display: none;"></td> 
                             <td style="display: none;"></td> 
                             <td style="display: none;"></td> 
                            
                            <td colspan="5" style="padding: 0 !important;">
                            <div id="1" class="accordian-body collapse">
                              <table class="table">
                                <tr>
                                  <td>1</td>
                                  <td>Acte X</td>
                                  <td>Date Réalisation D'Acte</td>
                                  <td>En cours</td>
                                </tr>
                                <tr class="bg-green">
                                  <td>1</td>
                                  <td>Acte X</td>
                                  <td>Date Réalisation D'Acte</td>
                                  <td>Fait</td>
                                </tr>                      
                                <tr class="bg-green">
                                  <td>1</td>
                                  <td>Acte X</td>
                                  <td>Date Réalisation D'Acte</td>
                                  <td>Fait</td>
                                </tr>                      
                              </table>
                            </div>
                            </td>

                          </tr>                                
                        </tbody>
                      </table>
                      <!-- end plan de traitements -->

                    </div>

                    {{-- TAB PRESCRIPTION --}}
                    <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
                      <table class="table table-striped " id="prescriptions">
                        <thead>
                          <tr style="text-align: center;">
                            <th>#</th>
                            <th>Date de Prescription</th>
                            <th>Imprimer</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr style="text-align: center;cursor: pointer;" data-toggle="collapse"  href="#2">
                            <td>1</td>
                            <td>01/01/2001</td>
                            <td><a href=""><i class="fa fa-print"></i></a></td>
                          </tr>
                          <tr>
                             <td style="display: none;"></td> 
                             <td style="display: none;"></td> 
                            
                            <td colspan="2" style="padding: 0 !important;">
                            <div id="2" class="accordian-body collapse">
                              <table class="table">
                                <thead>
                                  <tr>
                                    <th>#</th>
                                    <th>Médicament</th>
                                  </tr>
                                </thead>
                                <tr>
                                  <td>1</td>
                                  <td>Médicament X</td>
                                </tr>
               
                              </table>
                            </div>
                            </td>

                          </tr>                                
                        </tbody>
                      </table>
                    </div>
                    {{-- END TAB PRESCRIPTION --}}

                    {{-- TAB TRAITEMENTS --}}
                    <div role="tabpanel" class="tab-pane fade" id="tab_content4" aria-labelledby="profile-tab">
                      <table class="data table table-striped no-margin" id="prescription">
                        <thead>
                          <tr style="text-align: center;">
                            <th>#</th>
                            <th>Date de Prescription</th>
                            <th>Imprimer</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr style="text-align: center;cursor: pointer;" data-toggle="collapse"  href="#2">
                            <td>1</td>
                            <td>01/01/2001</td>
                            <td><a href=""><i class="fa fa-print"></i></a></td>
                          </tr>
                          <tr>
                             <td style="display: none;"></td> 
                             <td style="display: none;"></td> 
                            
                            <td colspan="2" style="padding: 0 !important;">
                            <div id="2" class="accordian-body collapse">
                              <table class="table">
                                <thead>
                                  <tr>
                                    <th>#</th>
                                    <th>Médicament</th>
                                  </tr>
                                </thead>
                                <tr>
                                  <td>1</td>
                                  <td>Médicament X</td>
                                </tr>
               
                              </table>
                            </div>
                            </td>

                          </tr>                                
                        </tbody>
                      </table>
                    </div>
                    {{-- END TAB TRAITEMENTS --}}

                    {{-- TAB RADIOLOGIES--}}
                    <div role="tabpanel" class="tab-pane fade" id="tab_content5" aria-labelledby="profile-tab">
                      <table class="data table table-striped no-margin" id="prescription">
                        <thead>
                          <tr style="text-align: center;">
                            <th>#</th>
                            <th>Date de Prescription</th>
                            <th>Imprimer</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr style="text-align: center;cursor: pointer;" data-toggle="collapse"  href="#2">
                            <td>1</td>
                            <td>01/01/2001</td>
                            <td><a href=""><i class="fa fa-print"></i></a></td>
                          </tr>
                          <tr>
                             <td style="display: none;"></td> 
                             <td style="display: none;"></td> 
                            
                            <td colspan="2" style="padding: 0 !important;">
                            <div id="2" class="accordian-body collapse">
                              <table class="table">
                                <thead>
                                  <tr>
                                    <th>#</th>
                                    <th>Médicament</th>
                                  </tr>
                                </thead>
                                <tr>
                                  <td>1</td>
                                  <td>Médicament X</td>
                                </tr>
               
                              </table>
                            </div>
                            </td>

                          </tr>                                
                        </tbody>
                      </table>
                    </div>
                    {{-- END TAB RADIOLOGIES--}}                          

                  </div>

                </div>
              </div>
            </div>
          </div>

          <div class="table-responsive">
            <h2>Payments</h2>
            <table class="table table-striped" id="payments">
              <thead>
                <tr style="background-color: blue; color:white">
                  <th>Pay NO</th>
                  <th>Patient</th>
                  <th>Dentiste</th>
                  <th>Date</th>
                  <th>Charger</th>
                </tr>
              </thead>

              <tbody>
                <tr>
                  <td>138</td>
                  <td>Jhno Doe</td>
                  <td>Dr.Jhon Doe</td>
                  <td>01 Janv 2001</td>
                  <td>500 DA</td>
                </tr>
                <tr>
                  <td>138</td>
                  <td>Jhno Doe</td>
                  <td>Dr.Jhon Doe</td>
                  <td>01 Janv 2001</td>
                  <td>500 DA</td>
                </tr>                        
                <tr>
                  <td>138</td>
                  <td>Jhno Doe</td>
                  <td>Dr.Jhon Doe</td>
                  <td>01 Janv 2001</td>
                  <td>500 DA</td>
                </tr>                        
                <tr>
                  <td>138</td>
                  <td>Jhno Doe</td>
                  <td>Dr.Jhon Doe</td>
                  <td>01 Janv 2001</td>
                  <td>500 DA</td>
                </tr>                        
                <tr>
                  <td>138</td>
                  <td>Jhno Doe</td>
                  <td>Dr.Jhon Doe</td>
                  <td>01 Janv 2001</td>
                  <td>500 DA</td>
                </tr>                        
                <tr>
                  <td>138</td>
                  <td>Jhno Doe</td>
                  <td>Dr.Jhon Doe</td>
                  <td>01 Janv 2001</td>
                  <td>500 DA</td>
                </tr>                        
                <tr>
                  <td>138</td>
                  <td>Jhno Doe</td>
                  <td>Dr.Jhon Doe</td>
                  <td>01 Janv 2001</td>
                  <td>500 DA</td>
                </tr>                        
              </tbody>
            </table>
          </div>
        </div>

       
      </div>


    </div>
  </div>

  {{-- ---------------------------------Modals -------------------------------- --}}

  <!-- Schéma Dentaire -->
  <div id="schema_modal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg" {{-- style="width:1200px" --}}>

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Schéma dentaire</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-9">
            <img src="{{ asset('img/schema.jpg') }}" alt="Schéma dentaire" width="500px" height="500px">
          </div>
          <div class="col-md-3">
            <h3>Plan de traitement</h3>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Actes</th>
                  <th>Prix</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <select name="" id="" class="form-control">
                      <option value="">Acte 1</option>
                    </select>
                  </td>
                  <td>500 DA</td>
                  <td><input type="checkbox" ></td>
                </tr>
                <tr>
                  <td>
                    <select name="" id="" class="form-control">
                      <option value="">Acte 1</option>
                    </select>
                  </td>
                  <td>500 DA</td>
                  <td><input type="checkbox" ></td>
                </tr>
                <tr>
                  <td>
                    <select name="" id="" class="form-control">
                      <option value="">Acte 1</option>
                    </select>
                  </td>
                  <td>500 DA</td>
                  <td><input type="checkbox" ></td>
                </tr>
                <tr>
                  <td>
                    <select name="" id="" class="form-control">
                      <option value="">Acte 1</option>
                    </select>
                  </td>
                  <td>500 DA</td>
                  <td><input type="checkbox" ></td>
                </tr>
                <tr>
                  <td>
                    <select name="" id="" class="form-control">
                      <option value="">Acte 1</option>
                    </select>
                  </td>
                  <td>500 DA</td>
                  <td><input type="checkbox" ></td>
                </tr>                                                               
              </tbody>
              <tfoot>
                <tr>
                  <td>TOTAL</td>
                  <td>3000 DA</td>
                </tr>
              </tfoot>
            </table>
          </div>
          
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
        <button type="button" class="btn btn-primary"><i class="fa fa-print"></i> Devis</button>
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#facture"><i class="fa fa-dollar"></i> Encaiser</button>
      </div>
    </div>

  </div>
  </div>       
  <!-- END Schéma Dentaire -->
   
  <!-- Facture -->
  <div id="facture_modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md" >

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Facture/Devis</h4>
        </div>
        <div class="modal-body">
          <div class="row">

          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
          <button type="button" class="btn btn-success" data-toggle="modal" data-target="#facture">Imprimer</button>
        </div>
      </div>

    </div>
  </div>
  <!-- END Facture --> 

  <!-- Prescription --> 
  <div id="prescription_modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md" >

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Nouvelle Prescription</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-xs-12 col-md-6">
              <div class="input-group">
                <label for="Médicament">Médicament</label>
                <input type="text" name="" id="" class="form-control">
              </div>

              <button class="btn btn-primary">Ajouter</button>
            </div>
            <div class="col-xs-12 col-md-6">
              <table class="table">
                <thead>
                  <tr>
                    <th>Liste des Médicaments</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Médicament 1</td>
                    <td><i class="fa fa-close"></i></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
          <button type="button" class="btn btn-success" >Valider</button>
        </div>
      </div>

    </div>
  </div>
  <!-- END Prescription -->

  {{-- ---------------------------------END Modals -------------------------------- --}}

@endsection

@section('js_scripts')
    <!-- bootstrap-wysiwyg -->
    <script src="{{ asset('gentelella/vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js') }}"></script>
    <script src="{{ asset('gentelella/vendors/jquery.hotkeys/jquery.hotkeys.js') }}"></script>
    <script src="{{ asset('gentelella/vendors/google-code-prettify/src/prettify.js') }}"></script>
    <!-- jQuery Tags Input -->
    <script src="{{ asset('gentelella/vendors/jquery.tagsinput/src/jquery.tagsinput.js') }}"></script>
    <!-- Switchery -->
    <script src="{{ asset('gentelella/vendors/switchery/dist/switchery.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('gentelella/vendors/select2/dist/js/select2.full.min.js') }}"></script>
    <!-- Parsley -->
    <script src="{{ asset('gentelella/vendors/parsleyjs/dist/parsley.min.js') }}"></script>
    <!-- Autosize -->
    <script src="{{ asset('gentelella/vendors/autosize/dist/autosize.min.js') }}"></script>
    <!-- jQuery autocomplete -->
    <script src="{{ asset('gentelella/vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js') }}"></script>
    <!-- starrr -->
    <script src="{{ asset('gentelella/vendors/starrr/dist/starrr.js') }}"></script>

    <script>
      $(document).ready( function () {
        $('#payments').DataTable();
        $('#plans').DataTable();
        $('#prescriptions').DataTable();
        $('#traitements').DataTable();
        
      } );
    </script>
@endsection

