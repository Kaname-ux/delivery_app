@extends('layouts.master')

@section("title")
Commande | Modifier
@endsection

@section("content")
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h2>Modifier Commande</h2>
					
			   </div>
			   <div class="card-body">
			   	<div class="row">
			   			<div class="col-sm-6">

			   		<form action="/command-update/{{$command->id}}"  method="POST">
			   			{{csrf_field()}}
			   			{{method_field('PUT')}}
						<div class="form-group">
                            <input value="{{$command->description}}" name="descript" class="form-control" type="text" placeholder="Description">
						</div>

						<div class="form-group">
                            <input required value="{{$command->montant}}" name="montant" class="form-control" type="text" placeholder="Montant">
						</div>

						<div class="form-group">
                            <input required value={{Str::before($command->delivery_date, ' 00:00:00')}} name="deliv_date" class="form-control" type="date" placeholder="Date de livraison">
						</div>

						

						<div class="form-group">
                            <select required id="fee"  class="form-control" name="fee">
                            	<option  value="">selectionner adresse</option>
                            	@foreach($fees as $fee)
                            	<option 
                            	@if($command->fee)
                            	@if( $fee->id == $command->fee->id)
                                  

                                 selected
                                 
                                 @endif
                                 @endif
                            	value="{{$fee->id}}">{{$fee->destination}} : {{$fee->price}}</option>
                        
                            	@endforeach
                            </select>


                            
						</div>

						<div class="form-group">
                            <input  value="{{Str::after($command->adresse, ':')}}" id="lieu" name="adresse" class="form-control" type="text" placeholder="Lieu de livraison" >
						</div>

						<div class="form-group">
                            <input value="{{$command->phone}}" required value="" name="phone" class="form-control" type="text" placeholder="Contact">
						</div>

						<div class="form-group">
                            <input value="{{$command->observation}}" name="observation" class="form-control" type="text" placeholder="Note">
						</div>

					



						<div class="form-group">
                            <select class="form-control" name="livreur">
                            	<option value="">selectionner un livreur</option>
                            	@foreach($livreurs as $livreur)
                            	<option 
                            	{{($livreur->id == $command->livreur_id) ? 'selected' : ''}} value="{{$livreur->id}}">{{$livreur->nom}}</option>
                        
                            	@endforeach
                            </select>
						</div>
                       
						<div class="form-group">
                            <select class="form-control" name="client">
                            <option 
                            	value="">selectionner Le client</option>
                            	@foreach($clients as $client)
                            	<option
                            	{{($client->id == $command->client_id) ? 'selected' : ''}}

                            	 value="{{$client->id}}">{{$client->nom}}</option>
                        
                            	@endforeach
                            </select>
						</div>


						<div class="form-group">
                            <select class="form-control" name="etat">
                            <option 
                            	value="">selectionner Le client</option>
                            	@foreach($etats as $etat)
                            	<option
                            	{{($etat == $command->etat) ? 'selected' : ''}}

                            	 value="{{$etat}}">{{$etat}}</option>
                        
                            	@endforeach
                            </select>
						</div>

						<button type="submit" class="btn btn-success">Modifier</button>
						<a href="/dashboard" class="btn btn-danger">Annuler</a>
						
						
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
                     <script >
                            $(document).ready(function(){
                          $("#fee, #lieu").on("change", function(){
                          	
                          	var current_adresse = $( "#fee option:selected" ).text();
                          	


                           $('#adresse').val(current_adresse + ': ' +  lieu);

                           $('#current_adresse').html('<h6>Cout de livraison</h6>  ' +current_adresse);
                                });
                             });
                            </script>

                            
@endsection