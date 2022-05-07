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
		
		<div class="col-md-6 col-sm-offset-2">

			<!-- Horizontal Form -->
			<div class="box box-info">

				<div class="box-header with-border">

					<h3 class="box-title">Ajouter utilisateur</h3>

				</div>
				<!-- /.box-header -->

				<!-- form start -->

					<div class="box-body">
						<form class="form-group" role="form" method="POST" action="{{ route('user.store') }}">

							{{  csrf_field() }}
							<div class="col-sm-6">
								<div class="form-group">

									<label for="matricule" class="label-control"> Matricule* 

										<input type="text"  class="form-control" name="matricule" id="matricule"  placeholder="matricule" required>

									</label>

								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group">
									
									<label for="nom" class="label-control"> Nom* 

										<input type="text"  class="form-control" name="name" id="nom"  placeholder="nom" required />

									</label>

								</div>					
							</div>

							<div class="col-sm-6">
								<div class="form-group">
								
									<label for="prénom" class="label-control"> Prénom* 

										<input type="text"  class="form-control" name="prenom" id="prénom"  placeholder="prénom" required />

									</label>

								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group">
								
									<label for="date_naissance" class="label-control"> Date de naissance 

										<input type="date"  class="form-control" name="date_naissance" id="date_naissance"  placeholder="date_naissance" style="width: 214px;">

									</label>

								</div>															
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									
									<label for="email" class="label-control"> Email* 

										<input type="email"  class="form-control" name="email" id="email"  placeholder="Ex : '@'email.com" required />

									</label>

								</div>									
							</div>

							<div class="col-sm-6">
								<div class="form-group">
									
									<label for="password" class="label-control"> Mots de passe* 

										<input type="password"  class="form-control" name="password" id="password"  placeholder="Mots de passe" required />

									</label>

								</div>								
							</div>


								<div class="form-group">
									
									<input type="hidden" name="service" id="service">
									<input type="hidden" name="hopital" id="hopital">
									<label for="grade" class="label-control"> Grade </label>

										<select name="grade" id="grade" class="form-control"></select>

								</div>						

								<div class="form-group">
									
									<label for="specialite" class="label-control"> Spécialite </label>

										<select name="specialite" id="specialite" class="form-control"></select>

								</div>	

								<div class="form-group">
									
									<label for="role" class="label-control"> Role </label>

										<select name="role_id" id="role" class="form-control">
											
											@foreach($roles as $role)
													<option value="{{ $role->id }}">{{ $role->nom_profile }} </option>
											@endforeach
										</select>

								</div>



								<div class="form-group">

									<div class="checkbox">
										
										<label><input type="checkbox" name="admin" class="flat-red"> Administrateur</label>

									</div>
										
								</div>

							<button type="submit" class="btn btn-info pull-right">Ajouter</button>

						</form>

					</div>
					<!-- /.box-body -->

			</div>

		</div>
		
	</div>
	
</div>


@endsection

@section ('script')
	<script>
		
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

		       		//get json records from general.json and display in there respective div for admin
					$.getJSON("/js/json/general_settings.json",function(obj)
					{					 	
					 	$("#service").val(obj.service);	
					 	$("#hopital").val(obj.hopital);	
					});
				});				
	</script>
@endsection