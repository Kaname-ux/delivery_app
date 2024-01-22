@extends('layouts.master')

@section("title")
Utilisateur | Modifier
@endsection

@section("content")
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h2>Modifier role d'utilisateurs</h2>
					
			   </div>
			   <div class="card-body">
			   	<div class="col-md-6">
			   		<form action="/role-register-update/{{$user->id}}" method="POST">
			   			{{csrf_field()}}
			   			{{method_field('PUT')}}
						<div class="form-group">
                            <input value="{{$user->name}}" name="username" class="form-control" type="text" placeholder="Nom">
						</div>

						<div class="form-group">
                            <select class="form-control" name="usertype">
                            	<option value="admin">Admin</option>
                            	<option value="gerant">Gerant</option>
                            	<option value="logistique">Logisticien</option>
                            	<option value="payeur">Agent de paiement</option>
                            </select>
						</div>

						<button type="submit" class="btn btn-success">Valider</button>
						<a href="/role-register" class="btn btn-danger">Annuler</a>
						
						
					</form>
			   	</div>
			   	
			   </div>
					
				
				
			</div>
		</div>
	</div>
</div>
@endsection

@section("script")
@endsection