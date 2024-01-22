@extends('layouts.master')

@section("title")
Payment | Ajouter
@endsection

@section("content")
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h2>Ajouter Payment</h2>
					
			   </div>
			   <div class="card-body">
			   	<div class="row">
			   			<div class="col-sm-6">

			   		<form action="/payment-register"  method="POST">
			   			{{csrf_field()}}
			   			{{method_field('PUT')}}
						

						<div class="form-group">
                            <input required value="" name="montant" class="form-control" type="text" placeholder="Montant">
						</div>

						<div class="form-group">
                            <input required value="" name="payment_date" placeholder="Date de payment" class="form-control" type="Date">
						</div>

						

					
                       
						<div class="form-group">
                            <select required class="form-control" name="client">
                            <option 
                            	value="">selectionner Le client</option>
                            	@foreach($clients as $client)
                            	<option
                            	

                            	 value="{{$client->id}}">{{$client->nom}}</option>
                        
                            	@endforeach
                            </select>
						</div>


						<div class="form-group">
                            <select class="form-control" name="payment_method">
                            <option 
                            	value="">selectionner La methode</option>
                            	@foreach($payment_methods as $payment_method)
                            	<option
                            	

                            	 value="{{$payment_method}}">{{$payment_method}}</option>
                        
                            	@endforeach
                            </select>
						</div>


						<div class="form-group">
                            <input value="" name="payed_by" class="form-control" type="text" placeholder="Payé par">
						</div>

						<button type="submit" class="btn btn-success">Valider</button>
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