@extends('layouts.app')

@section('css_scripts')
    <!-- bootstrap-daterangepicker -->
    <link href="{{ asset('vendors/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">
    <!-- bootstrap-datetimepicker -->
    <link href="{{ asset('vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css') }}" rel="stylesheet">
    <!-- Ion.RangeSlider -->
    <link href="{{ asset('vendors/normalize-css/normalize.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/ion.rangeSlider/css/ion.rangeSlider.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/ion.rangeSlider/css/ion.rangeSlider.skinFlat.css') }}" rel="stylesheet">
    <!-- Bootstrap Colorpicker -->
    <link href="{{ asset('vendors/mjolnic-bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}" rel="stylesheet">

    <link href="{{ asset('vendors/cropper/dist/cropper.min.css') }}" rel="stylesheet">
@endsection

@section('title')
    Ajouter un nouveau patient
@endsection


@section('content')

    <div class="">
        <div class="page-title">
          <div class="title_left">
            <h3>Nouveau Patient</h3>
          </div>
        </div>

        <div class="clearfix"></div>
        
        <div class="row">
            <form id="demo-form2" method="POST" action="{{ route('patient.store') }}" data-parsley-validate class="form-horizontal form-label-left">
                @csrf
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="x_panel">
                      <div class="x_title">
                        <h2>Informations Personnelles </h2>
                        <div class="clearfix"></div>
                      </div>
                      <div class="x_content">
                        <br />

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Nom <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="first-name" name="name" class="form-control col-md-7 col-xs-12">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Prénom <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="last-name" name="nickname" class="form-control col-md-7 col-xs-12">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Sexe</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                 M:
                                <input type="radio" class="flat" name="gender" id="genderM" value="M" checked="" required /> F:
                                <input type="radio" class="flat" name="gender" id="genderF" value="F" />
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Date de naissance
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input id="birthday" class="date-picker form-control col-md-7 col-xs-12"  type="date" name="birthday">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="job">Profession
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="job" name="job" class="form-control col-md-7 col-xs-12">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">Adresse physique 
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="address" name="address" class="form-control col-md-7 col-xs-12">
                            </div>
                          </div>                                            
                      </div>
                    </div>
                </div>

                <div class="col-md-6 col-xs-12">
                    <div class="x_panel">
                      <div class="x_title">
                        <h2>Informations médicales</h2>
                        <div class="clearfix"></div>
                      </div>
                      <div class="x_content">
                        <br />
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Fumeur</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                Oui:
                                <input type="radio" class="flat" name="smoker" id="smokerY" value="yes" checked=""  /> 
                                Non:
                                <input type="radio" class="flat" name="smoker" id="smokerN" value="no" />
                            </div>
                          </div>    
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ref_doctor">Chirugien référent 
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="first-name" name="ref_doctor" class="form-control col-md-7 col-xs-12">
                            </div>
                          </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Pathologies</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <select class="select2_single form-control" tabindex="-1">
                                <option></option>
                                <option value="AK">Alaska</option>
                                <option value="HI">Hawaii</option>
                                <option value="CA">California</option>
                                <option value="NV">Nevada</option>
                                <option value="OR">Oregon</option>
                                <option value="WA">Washington</option>
                                <option value="AZ">Arizona</option>
                                <option value="CO">Colorado</option>
                                <option value="ID">Idaho</option>
                                <option value="MT">Montana</option>
                                <option value="NE">Nebraska</option>
                                <option value="NM">New Mexico</option>
                                <option value="ND">North Dakota</option>
                                <option value="UT">Utah</option>
                                <option value="WY">Wyoming</option>
                                <option value="AR">Arkansas</option>
                                <option value="IL">Illinois</option>
                                <option value="IA">Iowa</option>
                                <option value="KS">Kansas</option>
                                <option value="KY">Kentucky</option>
                                <option value="LA">Louisiana</option>
                                <option value="MN">Minnesota</option>
                                <option value="MS">Mississippi</option>
                                <option value="MO">Missouri</option>
                                <option value="OK">Oklahoma</option>
                                <option value="SD">South Dakota</option>
                                <option value="TX">Texas</option>
                              </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Antécédent Stomatologiques</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <select class="select2_single form-control" tabindex="-1">
                                <option></option>
                                <option value="AK">Alaska</option>
                                <option value="HI">Hawaii</option>
                                <option value="CA">California</option>
                                <option value="NV">Nevada</option>
                                <option value="OR">Oregon</option>
                                <option value="WA">Washington</option>
                                <option value="AZ">Arizona</option>
                                <option value="CO">Colorado</option>
                                <option value="ID">Idaho</option>
                                <option value="MT">Montana</option>
                                <option value="NE">Nebraska</option>
                                <option value="NM">New Mexico</option>
                                <option value="ND">North Dakota</option>
                                <option value="UT">Utah</option>
                                <option value="WY">Wyoming</option>
                                <option value="AR">Arkansas</option>
                                <option value="IL">Illinois</option>
                                <option value="IA">Iowa</option>
                                <option value="KS">Kansas</option>
                                <option value="KY">Kentucky</option>
                                <option value="LA">Louisiana</option>
                                <option value="MN">Minnesota</option>
                                <option value="MS">Mississippi</option>
                                <option value="MO">Missouri</option>
                                <option value="OK">Oklahoma</option>
                                <option value="SD">South Dakota</option>
                                <option value="TX">Texas</option>
                              </select>
                            </div>
                        </div>
                         <div class="ln_solid"></div>
                          </div>
                          <div class="form-group">
                            <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                               <button class="btn btn-primary" type="reset">Annuler</button>
                              <button type="submit" class="btn btn-success">Ajouter</button>
                            </div>
                          </div>

                      </div>
                    </div>              
                </div>
            </form>
        </div>
    </div>

 
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
@endsection

