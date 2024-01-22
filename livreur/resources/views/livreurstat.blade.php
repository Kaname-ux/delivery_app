@extends('layouts.master')

@section("title")
livreur | Stat
@endsection

@section("content")
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h6>Statistique livreur </h6>
					{{Auth::user()->name}}
					<h3>
						@if($cur_month != "Toute l'année")
						@foreach($months as $key=>$month)
                          @if($key == $cur_month)
                          {{$month}} 

                          @endif
                        @endforeach 
                        @else
                         {{$cur_month}} 
                      @endif {{$cur_year}}</h3>
                 <div class="row">
                 	<div class="col-md-6">
					<form action="?period" class="form-inline"  >
			   			@csrf
						


						<div  class="form-group ">
                            <select required  name="month" class="form-control" type="text" >
                            	<option value="">Mois</option>
                            	<option value="all">Toutes l'année</option>
                            	@foreach($months as $key=>$month)
                            	<option  value="{{$key}}">{{$month}}</option>
                            	@endforeach
                          
                            </select>
						</div>

						<div class="form-group ">
                            <select required  name="year" class="form-control" type="text" >
                            	<option value="">Année</option>
                            	@foreach($years as $year)
                            	<option  value="{{$year}}">{{$year}}</option>
                            	@endforeach

                            </select>
						</div>

						<button type="submit" class="btn btn-success btn-sm">Valider</button>
						
						
						
					</form>
					</div>
				</div>	
			   </div>
			  <div class="row">
  <div class="col-sm-6 ">
    <div class="card  ">
			   	<div class="card-body">
			   
			   	
			   	<h4>Nombre de ivraison <strong  class="float-right">{{$commands->count()}}</strong></h4><br>
			   	<h4>Montant <strong  class="float-right">{{$montant}}</strong></h4>
			   </div>
              </div>
			   </div>
              <!-- <div class="col-sm-6 ">
    <div class="card  text-center">
    	<div class="card-body">
    	<div class="card-title"><h1>Bonus</h1></div>
			   	<strong class="align-center">
			   <h1>	@if($commands->count()-$objectif > 0)
			   	{{($commands->count()-$objectif)*250}}
			   	@else
			   	0
			   	@endif
			   	</h1>
			   	</strong>
			   </div>
			   </div>
             </div> -->
             </div>
             




			 

			   	
			   	
			   </div>
					
				
				
			</div>
		</div>
	</div>
</div>

                         
@endsection

@section("script")
                    

                            
@endsection