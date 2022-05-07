  @extends('layouts.app')
@section('content')
<div class="app-main__inner" id="patients">
  <div class="row">
    <div class="col-sm-11 col-md-10">
       <h3>MES PATIENTS
  </h3> 
    </div>

    <div class="col-sm-2 pl-md-5">
      <button class="btn btn-primary  " v-on:click="newModal()">Ajouter</button>
    </div>
  </div>
  
  
  <div class="row">
    
    <div class="col-sm-12">
      <div class="card card-body">
        <patients></patients>

      </div>
    </div>
    
  </div>

    <!-- --------------------------MODALS-------------------------- -->
  <div class="modal fade patient_add_modal"  tabindex="-1" id="patient_add_modal"  role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Nouveau Patient</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <patient-component 
        v-bind:pathologies="{{ $pathologies->toJson() }}"
        v-bind:antecedents="{{ $antecedents->toJson() }}"
        csrf="{{ csrf_token() }}"
        
        >
        </patient-component>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js_scripts')
    <script src="{{ mix('js/liste-patients.js') }}" type="text/javascript"></script>

@endsection
