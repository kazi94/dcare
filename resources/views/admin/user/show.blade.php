@extends('layouts.model')

@section('content')

<div class="content-wrapper">

	
	<section class="content">
		@if (count($errors) > 0)
			@foreach ($errors->all() as $error)
				<p class="alert alert-danger">{{ $error }}</p>
			@endforeach
		@endif
		@if (session()->has('message'))
			<p class="alert alert-success message" style="">{{ session('message') }}</p>
		@endif

		<div class="row">

			<div class="col-sm-12 ">
				<div class="box box-info">
					

			      		<div class="box-header with-border">

			       			 <h2 class="box-title">Utilisateurs</h2>

			        		<a class='col-lg-offset-8 btn btn-success' href="{{ route('user.create') }}">Ajouter nouveau</a>

						</div>

						<div class="box-body table-responsive">

			
		                    <table class="table table-responsive table-bordered table-stripped text-center" id="t_user">

		                        <thead>
		                            <tr class="thead-dark">
{{--                         	            <th>
                        	            	<input type="checkbox"  class="" id="select_all" value=""/>
                        	            </th>   --}}      
		                                <th>Num°:</th>
		                                <th>Utilisateur</th>
		                                <th>Email</th>
		                                <th>Service</th>
		                                <th>Grade</th>
		                                <th>Spécialité</th>
		                                <th>Profile</th>
		                                <th>Modifier</th>
		                                <th>Supprimer</th>
		                            </tr>
		                        </thead>

		                        <tbody>

		                         	@foreach ($users as $user)
			                                {{-- @foreach ($produit->interactions as $interaction_id) --}}

		                            <tr>
            							{{-- <td align="center"><input type="checkbox" name="checked_id[]" class="checkbox" value={{ $user->id }}/></td>    --}}
		                            	<td>{{ $loop->index +1 }}</td>

		                                <td>{{ $user->name}} {{$user->prenom}}</td>

		                                <td>{{ $user->email}}</td>
		                                
		                                <td>{{ $user->service}}</td>

		                                <td>{{ $user->grade}}</td>

		                                <td>{{ $user->specialite}}</td>

		                                <td>{{ $user->role['nom_profile'] }}</td>

										<td>
											<a href="{{  route('user.edit',$user->id) }}"><span class="glyphicon glyphicon-edit"></span></a>
										</td>

										<td>
											<form style="display: none;" method="POST" action="{{ route('user.destroy',$user->id) }}" id="delete-form-{{ $user->id }}">
												{{ csrf_field() }}
												{{ method_field('DELETE') }}
											</form>

											<a href="" onclick="
												if (confirm('voulez vous supprimer cette ligne ?')) {
												event.preventDefault();
												document.getElementById('delete-form-{{ $user->id }}').submit();										}
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
@section('script')
    <script>
        $(function () {
            $('#t_user').DataTable({
            	"order" : [[ 1 , "asc"]],
    buttons: [
        'colvis',
        'excel',
        'print'
    ]
			  });
		    
		    $('#select_all').on('click',function(){
		        if(this.checked){
		            $('.checkbox').each(function(){
		                this.checked = true;
		            });
		        }else{
		             $('.checkbox').each(function(){
		                this.checked = false;
		            });
		        }
		    });
		    
		    $('.checkbox').on('click',function(){
		        if($('.checkbox:checked').length == $('.checkbox').length){
		            $('#select_all').prop('checked',true);
		        }else{
		            $('#select_all').prop('checked',false);
		        }
		    });
        });
	</script>
@endsection
