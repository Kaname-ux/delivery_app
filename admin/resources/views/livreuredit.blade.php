@extends('layouts.master')

@section("title")
livreur | Modifier
@endsection

@section("content")
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h2>Modifier livreur</h2>
					
			   </div>
			   <div class="card-body">
			   	<div class="row">
			   			<div class="col-sm-6">

			   		<form action="/livreur-update/{{$livreur->id}}"  method="POST">
			   			{{csrf_field()}}
			   			{{method_field('PUT')}}
						<div class="form-group">
                            <input value="{{$livreur->nom}}" name="nom" class="form-control" type="text" placeholder="Nom">
						</div>

						<div class="form-group">
                            <input required value="{{$livreur->phone}}" name="phone" class="form-control" type="text" placeholder="Contactt">
						</div>

						<div class="form-group">
                            <input required value="{{$livreur->adresse}}" name="adresse" class="form-control" type="text" placeholder="Adresse">
						</div>


						<div class="form-group">
                            <input required value="{{$livreur->pieces}}" name="pieces" class="form-control" type="text" placeholder="Numero de pieces">
						</div>


						<div class="form-group">
                            <input  name="fuel" class="form-control" type="text" placeholder="Numero de carte carburant">
						</div>


						<div class="form-group">
                            <select required  name="working_day" class="form-control" type="text" placeholder="Numero de pièces">
                            	<option>Selectioner jour de travail</option>
                            	<option @if($livreur->working_day == 'Paire') selected @endif value="Paire">Paire</option>
                            	<option  @if($livreur->working_day == 'Impaire') selected @endif value="Impaire">Impaire</option>

                            </select>
						</div>

						<button type="submit" class="btn btn-success">Modifier</button>
						<a href="/livreur" class="btn btn-danger">Annuler</a>
						
						
					</form>
			   	</div>

			   	<div  class="col-sm-6">
			   		<div id="current_fee">
			   			
			   		</div>

			   		<div id="current_adresse">
			   			
			   		</div>
			   		
			   	</div>
			   	</div>
			   

			   	
			   	
			   </div>
					
				
				
			</div>
		</div>
	</div>
</div>

                         
@endsection

@section("script")
                    

                            
@endsection