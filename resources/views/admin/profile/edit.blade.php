@extends('layouts.model1')

@section('content')

<div class="content-wrapper">

@if (count($errors) > 0)
  @foreach ($errors->all() as $error)
    <p class="alert alert-danger">{{ $error }}</p>
  @endforeach
@endif

@if (session()->has('message'))
	<p class="alert alert-success">{{ session('message') }}</p>
@endif
	<div class="row">
		
		<div class="col-md-7 col-sm-offset-2">

			<!-- Horizontal Form -->
			<div class="box box-info">

				<div class="box-header with-border">

					<h3 class="box-title">Modifier Profile</h3>

				</div>
				<!-- /.box-header -->

				<!-- form start -->
					<div class="box-body">
						<form class="form-group" role="form" method="POST" action="{{ route('profile.update',$role->id) }}">

							{{  csrf_field() }}
							{{ method_field('PATCH') }}
								<div class="form-group col-md-6">

									<label for="nom_profile" class="label-control"> Nom profile* 

										<input type="text"  class="form-control" name="nom_profile" id="nom_profile"  placeholder="Profile" value="{{ $role->nom_profile }}">

									</label>

								</div>
								<div class="form-group col-md-6">

									<label for="nom_profile" class="label-control"> Peut faire l'analyse pharmaceutique 

										<input type="checkbox" class="flat-red" name="analyse_ph" @if ($role->analyse_ph === "on") checked @endif>

									</label>
								</div>
								<div class="form-group col-md-6">
									<label for="nom_profile" class="label-control"> Peut voir les rendez-vous rédigé par les autres utilisateurs 

										<input type="checkbox" class="flat-red" name="afficher_rdv" @if ($role->afficher_rdv === "on") checked @endif>

									</label>
								</div>								
								<div class="form-group clo-md-6">

										<label for="nom_profile" class="label-control"> Peut voir le résultat de l'analyse thérapeutique 

											<input type="checkbox" class="flat-red" name="analyse_th" @if ($role->analyse_th === "on") checked @endif>

										</label>

								</div>	
								<div class="form-group clo-md-6">

									<label for="nom_profile" class="label-control"> Peut voir le résultat de l'analyse de suivie 

										<input type="checkbox" class="flat-red" name="analyse_sv" @if ($role->analyse_sv === "on") checked @endif>

									</label>

								</div>			
								<div class="form-group clo-md-6">

										<label for="nom_profile" class="label-control"> Peut accéder l'éditeur de regle 

											<input type="checkbox" class="flat-red" name="editeur_regle" @if ($role->editeur_regle === "on") checked @endif>

										</label>

								</div>
								
								<div class="form-group clo-md-6">

								</div>
								<div class="form-group col-md-6">

									<label for="nom_profile" class="label-control"> Médecin prescripteur 

										<input type="checkbox" class="flat-red" name="medecin_presc" @if ($role->medecin_presc === "on") checked @endif>

									</label>

								</div>		


								<div class="form-group clo-md-6">

									<label for="nom_profile" class="label-control"> OK Chimio

										<input type="checkbox" class="flat-red" name="ok_chimio" @if ($role->ok_chimio === "on") checked @endif>

									</label>

								</div>



								<div class="form-group clo-md-6">

									<label for="nom_profile" class="label-control"> Verifie disponibilite médicament

										<input type="checkbox" class="flat-red" name="verif_medic" @if ($role->verif_medic === "on") checked @endif>

									</label>

								</div>




								<table class="table table-bordered">
											<thead class="thead-dark">
												<tr>
													<th></th>
													<th>Lister</th>
													<th>détails</th>
													<th>Ajouter</th>
													<th>Modifier</th>
													<th>Supprimer</th>
													<th>Imprimer</th>
													<th>Exporter</th>
													<th>Cloner</th>
													<th>Dessiner</th>
												</tr>
											</thead>
											<tbody style="text-align: center;">

												@php

													$tableau =array('Patient', 'Prescription' , 'Automédication','Analyse biologique','Traitement chronique','Phytothérapie','Questionnaire','Education thérapeutique','Consultation','Fiche de conciliation','Hospitalisation','act_medicale','dashboard','compte patient','compte externe', 'Prescription_chimio', 'Protocole_chimio');
                
													$tableau1 =array('patient', 'prescription' , 'auto','analyse_bio','traitement','question','phyto','et','consultation','fiche','ho','act','dashboard','cpt_pat','cpt_ext','Prescription_chimio', 'Protocole_chimio');

                
													$k=0;
												@endphp
												@for ( $i =0 ; $i < count($tableau) ; $i++)
													@php
														$y = 'ajouter_'.$tableau1[$i];
										                $z = 'modifier_'.$tableau1[$i];
										                $w = 'supprimer_'.$tableau1[$i];
										                $a = 'imprimer_'.$tableau1[$i];
										                $b = 'lister_details_'.$tableau1[$i];
										                $f = 'lister_'.$tableau1[$i];
										                $e = 'exporter_'.$tableau1[$i];
													@endphp
												<tr>
													<td>{{ $tableau[$i] }}</td>

													<td><label><input type="checkbox" class="flat-red" name=   "lister_{{$tableau[$i]}}" @if ($role->$f === "on") checked @endif ></label></td>
													<td><label><input type="checkbox" class="flat-red" name=  "détails_{{$tableau[$i]}}" @if ($role->$b === "on") checked @endif ></label></td>
													<td><label><input type="checkbox" class="flat-red" name=  "ajouter_{{$tableau[$i]}}" @if ($role->$y === "on") checked @endif ></label></td>
													<td><label><input type="checkbox" class="flat-red" name= "modifier_{{$tableau[$i]}}" @if ($role->$z === "on") checked @endif ></label></td>
													<td><label><input type="checkbox" class="flat-red" name="supprimer_{{$tableau[$i]}}" @if ($role->$w === "on") checked @endif ></label></td>
													<td><label><input type="checkbox" class="flat-red" name= "imprimer_{{$tableau[$i]}}" @if ($role->$a === "on") checked @endif ></label></td>
													<td><label><input type="checkbox" class="flat-red" name= "exporter_{{$tableau[$i]}}" @if ($role->$e === "on") checked @endif ></label></td>
													<td>@if ($tableau[$i] === "Prescription")<label><input type="checkbox" class="flat-red" name= "cloner_{{$tableau[$i]}}" @if ($role->cloner_prescription === "on") checked @endif ></label>@endif</td>
													<td>@if ($tableau[$i] === "Analyse biologique")<label><input type="checkbox" class="flat-red" name= "dessiner_graphe" @if ($role->dessiner_graphe === "on") checked @endif ></label>@endif</td>

												</tr>
												@endfor
											</tbody>
										</table>		

							<button type="submit" class="btn btn-warning pull-right">Modifier</button>

						</form>

					</div>
					<!-- /.box-body -->

			</div>

		</div>
		
	</div>
	
</div>


@endsection

@section ('script')

	<script src="{{ asset('js/profil.js')}}"></script>

@endsection