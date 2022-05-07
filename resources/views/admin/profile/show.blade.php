@extends('layouts.model')

@section('content')

<div class="content-wrapper">

	<section class="content">
		
		@if (session()->has('message'))

			<p class="alert alert-success">{{ session('message') }}</p>
			
		@endif

		<div class="row">

			<div class="col-sm-12 ">
				<div class="box box-widget">
		      		<div class="box-header with-border">

		       			 <h2 class="box-title">Profiles</h2>

		        		<a class='col-lg-offset-5 btn btn-success' href="{{ route('profile.create') }}">Ajouter nouveau</a>

					</div>

					<div class="box-body">

						<table id="example_list_account" class="table table-responsive text-center dataTable" role="grid" aria-describedby="example3_info">
							<thead>

								<tr role="row" class="thead-dark">

									<th>Num°:</th>

									<th>Profile</th>

									<th>Modifier</th>

									<th>Supprimer</th>

								</tr>

							</thead>

							<tbody>

								@foreach  ( $profiles as $profile) 

									<tr>

										<td> {{ $loop->index + 1 }}  </td>

										<td> {{ $profile->nom_profile }}    </td>


										<td><a href="{{  route('profile.edit',$profile->id) }}"><span class="glyphicon glyphicon-edit"></span></a></td>

										<td>
											<form style="display: none;" method="POST" action="{{ route('profile.destroy',$profile->id) }}" id="delete-form-{{ $profile->id }}">
												{{ csrf_field() }} 
												{{ method_field('DELETE') }}
											</form>

											<a href="" onclick="
												if (confirm('voulez vous supprimer cette ligne ?')) {
												event.preventDefault();
												document.getElementById('delete-form-{{ $profile->id }}').submit();										}
											"><span class="glyphicon glyphicon-trash"></span></a>
										</td>


									</tr>

								@endforeach
							</tbody>

						</table>

					</div>
				</div>

			</div>

		</div>

	</section>
</div>

@endsection