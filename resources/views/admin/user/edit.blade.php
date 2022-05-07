@extends('layouts.model1')

@section('content')

<div class="content-wrapper">
	<section class="content">
		@if (count($errors) > 0)

		  @foreach ($errors->all() as $error)

		    <p class="alert alert-danger">{{ $error }}</p>

		  @endforeach

		@endif

		@if (session()->has('message'))

			<p class="alert alert-success">{{ session('message') }}</p>

		@endif
		<div class="row">
			
			<div class="col-md-6 col-sm-offset-2">

				<!-- Horizontal Form -->
				<div class="box box-info">

					<div class="box-header with-border">

						<h3 class="box-title">Modifier utilisteur</h3>

					</div>
					<!-- /.box-header -->

					<!-- form start -->

						<div class="box-body">
							<form class="form-group" role="form" method="POST" action="{{ route('user.update',$user->id) }}">
								{{  csrf_field() }}
								{{ method_field('PATCH') }}			
								<input type="hidden" name="hopital" id="hopital">	
								<input type="hidden" name="service" id="service">	
								<div class="form-group">
	
									<label for="matricule" class="label-control"> Matricule* 

										<input type="text"  class="form-control" name="matricule" id="matricule"  placeholder="matricule" value="{{ $user->matricule }}" required />

									</label>

								</div>



								<div class="form-group">
									
									<label for="nom" class="label-control"> Nom* 

										<input type="text"  class="form-control" name="name" id="nom"  placeholder="nom" value="{{ $user->name }}" required />

									</label>

								</div>					

								<div class="form-group">
								
									<label for="prénom" class="label-control"> Prénom* 

										<input type="text"  class="form-control" name="prenom" id="prénom"  placeholder="prénom" value="{{ $user->prenom }}" required />

									</label>

								</div>						
								<div class="form-group">
								
									<label for="date_naissance" class="label-control"> Date de naissance 

										<input type="date"  class="form-control" name="date_naissance" id="date_naissance"  placeholder="date_naissance" value="{{$user->date_naissance}}">

									</label>

								</div>	
								<div class="form-group">
									
									<label for="email" class="label-control"> Email* 

										<input type="email"  class="form-control" name="email" id="email"  placeholder="email" value="{{ $user->email }}" autocomplete="off" required />

									</label>

								</div>						

								<div class="form-group">
									
									<label for="grade" class="label-control"> Grade </label>

										<select name="grade" id="grade" class="form-control">
											@php
												$string = file_get_contents(public_path()."/js/json/general.json");//recuperer analyse auto
										        $json_a = json_decode($string, true);
										        foreach ($json_a as $value) {
										        	if ($value['grade'])
										        		echo "<option ". (($user->grade == ucfirst($value['grade'])) ? "selected" : "") ." >".$value['grade']."</option>";
										        }									
											@endphp														
										</select>

								</div>						

								<div class="form-group">
									
									<label for="specialite" class="label-control"> Spécialite </label>

										<select name="specialite" id="specialite" class="form-control">
											<option></option>
											@php
												$string = file_get_contents(public_path()."/js/json/general.json");//recuperer analyse auto
										        $json_a = json_decode($string, true);
										        foreach ($json_a as $value) {
										        	if ($value['specialite'])
										        		echo "<option ". (($user->specialite == $value['specialite']) ? "selected" : "") ." >".$value['specialite']."</option>";
										        }									
											@endphp												
										</select>

								</div>	

								<div class="form-group">
									
									<label for="role" class="label-control"> Profil </label>

										<select name="role_id" id="role" class="form-control">
											
											@foreach($roles as $role)

													<option value="{{ $role->id }}" @if ($role->id == $user->role_id) selected @endif>{{ $role->nom_profile }} </option>
											@endforeach
										</select>

								</div>					

{{-- 								<div class="form-group form-inline">
									
									<label for="password" class="label-control form-horizontal"> Mots de passe* 

										<input type="password"  class="form-control" name="password" id="password" value=""  placeholder="Mots de passe" required />
										<span style="cursor: pointer; color :red" onclick="($('#password').is(':text')) ? $('#password').prop('type', 'password') : $('#password').prop('type', 'text')">Montrer/Cacher</span>
									</label>

								</div> --}}

								<div class="form-group">

									<div class="checkbox col-md-6">
										
										<label><input type="checkbox" name="admin" class="flat-red"@if ($user->is_admin === "on") checked @endif> Administrateur</label>

									</div>
										
								</div>


								<button type="submit" class="btn btn-info pull-right">Modifier</button>
							</form>

						</div>
						<!-- /.box-body -->

				</div>

			</div>
			
		</div>
		
	</section>

	
</div>


@endsection

@section ('script')
{{-- 	<script>
		
		        $(function() {

		        	 //get json records from general.json and display bilan and unités in there respective select for admin
		        	 $.getJSON("/js/json/general.json",function(obj){

		        			$.each(obj,function(key,value){
		        					// console.log(value.unite.length)
	        					if (value.grade!= "" ) {
					        		$("#grade").append("<option value="+value.grade+">"+value.grade+"</option>");
	        					}
	        					if (value.specialite !="") {
					        		$("#specialite").append("<option value="+value.specialite+">"+value.specialite+"</option>");	        					
	        					}

		        		});
		       		 });
				});
	</script> --}}
@endsection