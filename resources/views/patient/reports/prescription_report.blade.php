@extends('layouts.model_report')


@section('content')
<div class="container">
    
    <table class="table table-condensed table-sm table-borderless">
                
        <tr><td class="float-right"><img src="{{ $prescription->user->cabinet->logo }}" alt="{{ $prescription->user->cabinet->nom }}"  style="width: 100px; height: 100px; top: -10px; right: 44px" / ></td></tr>
        <tr><td><u><b>Médecin :</b></u> Dr. {{ $prescription->user->name}} {{$prescription->user->prenom}} </td>  <td></td> </tr>
        <tr><td><u><b>Profession :</b></u>  {{ $prescription->user->profession}}</td>  <td><u><b>Date prescription :</b></u> {{ $prescription->date_prescription}} </td></td> </tr>
        <tr><td><u><b>Patient :</b></u>  {{ $prescription->patient->nom}} {{ $prescription->patient->prenom}}</td>   </tr>
        <tr><td><u><b>Date de naissance :</b></u>  {{ $prescription->patient->date_naissance}}</td>   </tr>
        <tr><td><u><b>Age :</b></u> {{ $prescription->patient->age }} ans  </td>   </tr>

    </table>

    <br/>

    <table class="table table-bordered">
        <thead>
            <tr class="alert alert-dark">
                <th>#</th>
                <th>Médicament</th>
            </tr>
        </thead>
        
        <tbody>
            @foreach( $prescription->lignes as $key => $ligne)
                <tr>
                    <td>{{ $key +1}}</td>
                    <td>{{ $ligne->medicament }}</td>                
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="col-sm-4 pull-right"><h3>Signature : ......................</h3></div>
</div>


@endsection