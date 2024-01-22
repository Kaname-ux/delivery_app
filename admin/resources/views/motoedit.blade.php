@extends('layouts.master')

@section("title")
moto | Modifier
@endsection

@section("content")
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h2>Modifier moto</h2>
					
			   </div>
			   <div class="card-body">
			   	<div class="row">
			   			<div class="col-sm-6">

			   		<form action="/moto-update/{{$moto->id}}"  method="POST">
			   			{{csrf_field()}}
			   			{{method_field('PUT')}}
						<div class="form-group">
                            <input value="{{$moto->imm}}" name="imm" class="form-control" type="text" placeholder="Immatriculation">
						</div>

						<div class="form-group">
							<label>Date d'achat</label>
                            <input type="date" required value="{{$moto->buy_date}}" name="buy_date" class="form-control" type="text" placeholder="Date d'achat">
						</div>

						<div class="form-group">
                            <input required value="{{$moto->ass_exp}}" name="ass_exp" class="form-control" type="date" placeholder="Validité assurance">
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
                    

                            
@endsection