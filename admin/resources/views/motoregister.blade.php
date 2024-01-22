@extends('layouts.master')

@section("title")
Moto | Modifier
@endsection

@section("content")
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h2>Ajouter Moto</h2>
					
			   </div>
			   <div class="card-body">
			   	<div class="row">
			   			<div class="col-sm-6">
			   		<form action="/moto-register" method="POST">
			   			{{csrf_field()}}
			   			{{method_field('PUT')}}
						<div class="form-group">
                            <input value="" name="imm" class="form-control" type="text" placeholder="Immatriculation">
						</div>

						<div class="form-group">
                            <input required value="" name="buy_date" class="form-control" type="date" placeholder="Date d'achat">
						</div>

						<div class="form-group">
                            <input required value="" name="ass_exp" class="form-control" type="date" placeholder="Validité assurance">
						</div>



						

						

						<button type="submit" class="btn btn-success">Valider</button>
						<a href="/client" class="btn btn-danger">Annuler</a>
						
						
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