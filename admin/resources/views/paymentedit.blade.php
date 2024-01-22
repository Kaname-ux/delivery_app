@extends('layouts.master')

@section("title")
Payment | Modifier
@endsection

@section("content")
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h2>Modifier Payment</h2>
					
			   </div>
			   <div class="card-body">
			   	<div class="row">
			   			<div class="col-sm-6">

			   		<form action="/payment-update/{{$payment->id}}"  method="POST">
			   			{{csrf_field()}}
			   			{{method_field('PUT')}}
						

						<div class="form-group">
                            <input required value="{{$payment->montant}}" name="montant" class="form-control" type="text" placeholder="Montant">
						</div>

						<div class="form-group">
                            <input required value={{Str::before($command->delivery_date, ' 00:00:00')}} name="deliv_date" class="form-control" type="date" placeholder="Date de livraison">
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
                            	value="">selectionner La methode</option>
                            	@foreach($payment_methods as $payment_method)
                            	<option
                            	{{($payment_method == $payment->payment_method) ? 'selected' : ''}}

                            	 value="{{$payment_method}}">{{$payment_method}}</option>
                        
                            	@endforeach
                            </select>
						</div>


						

						<button type="submit" class="btn btn-success">Modifier</button>
						<a href="/payment" class="btn btn-danger">Annuler</a>
						
						
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