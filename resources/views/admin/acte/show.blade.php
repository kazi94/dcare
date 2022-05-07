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
    Liste des actes
@endsection


@section('content')

<div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Liste des Actes</h3>
      </div>

      <div class="title_right">
        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
          <button class="btn btn-primary" data-toggle="modal" data-target="#acte">Ajouter</button>
          
        </div>
      </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_content">
            <div class="table-responsive">
              <table class="table table-striped jambo_table bulk_action" id="patients">
                <thead>
                  <tr class="headings">
                    <th class="column-title"># </th>
                    <th class="column-title">Actes </th>
                    <th class="column-title">Prix </th>
                    <th class="column-title no-link last"><span class="nobr">Action</span>
                    </th>
                  </tr>
                </thead>

                <tbody>
                  <tr class="even pointer">
                    <td class=" ">121000040</td>
                    <td class=" ">Acte 1 </td>
                    <td class=" ">1000.00 DA</td>
                    <td class=" last">
                      <a href="{{ route('patient.edit' ,'1') }}"><i class="fa fa-edit fa-2x"></i></a>
                      <a href=""><i class="fa fa-trash fa-2x"></i></a>
                    </td>
                    </td>
                  </tr>
                  <tr class="odd pointer">
                    <td class=" ">121000039</td>
                    <td class=" ">Acte2</td>
                    <td class=" ">5000.00 DA
                    </td>
                    <td class=" last">
                      <a href="{{ route('patient.edit' ,'1') }}"><i class="fa fa-edit fa-2x"></i></a>
                      <a href=""><i class="fa fa-trash fa-2x"></i></a>
                    </td>
                  </tr>                         
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>

<!-- Acte --> 
<div id="acte" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm" >

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Nouveau Acte</h4>
      </div>
      <form action="">
        <div class="modal-body">
          <div class="row">
            <div class="col-xs-12 col-md-12">
              <div class="input-group">
                <label for="Acte">Acte</label>
                <input type="text" name="" id="" class="form-control" required="required">
              </div>
              <div class="input-group">
                <label for="Prix">Prix</label>
                <input type="text" name="" id="" class="form-control" placeholder="1000.00 DA" required="required">
              </div>              
            </div>

          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
          <button type="button" class="btn btn-success" >Valider</button>
        </div>
      </form>
    </div>

  </div>
</div>
<!-- END Acte -->

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
        $('#patients').DataTable();
        
      } );
    </script>
@endsection

