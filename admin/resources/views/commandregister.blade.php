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
					 @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}  
                        </div>
                    @endif
					<h2>Ajouter Commande</h2>
					
			   </div>
			   <div class="card-body">
			   	<div class="row">
			   			<div class="col-sm-6">
			   		

                    <form id="cmdform" action="command-fast-register" method="POST">
      @csrf


               <div class="form-group basic">
                                    <button type="submit" class="btn btn-primary btn-block btn-lg"
                                        >Enregister</button>
                                </div>

      <input id="cmdid" value="" hidden name="command_id">

      <div class="form-group">
      <label class="form-label">Nom du client</label>
      <input id="cmdcostumer" maxlength="150"  value="{{ old('costumer') }}"  name="costumer" class="form-control" type="text" placeholder="Nom du client" >
      </div>
      <div class="form-group">
      <label class="form-label">Nature du colis</label>
      <input id="cmdnature" maxlength="150" required value="{{ old('type') }}"  name="type" class="form-control" type="text" placeholder="Nature du colis" >
      </div>


      <div class="form-group">
      <label class="form-label">Date de livraison</label>
      <input 
         min="
         <?php
            echo date('Y-m-d');
            ?>
         " required type="date" value="{{ old('delivery_date') }}" name="delivery_date" class="form-control" type="text" id="cmddate" >
      @error('delivery_date')
      <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
      </span>
      @enderror
      </div>
      <div class="form-group"> 
      <label class="form-label">Prix(sans la livraison)</label>
      <input id="cmdprice"  value="{{ old('montant') }}"  name="montant" class="form-control @error('montant') is-invalid @enderror" type="number" placeholder="Prix (sans la livraison)" autocomplete="off">
      @error('montant')
      <span class="invalid-feedback" role="alert">
      <strong>{{$massage}}</strong>
      </span>
      @enderror
      </div>

      <div class="form-group"> 
      <label class="form-label">Remise</label>
      <input id="cmdremise"  value="{{ old('montant') }}"  name="remise" class="form-control @error('montant') is-invalid @enderror" type="number" placeholder="Remise" autocomplete="off">
      @error('montant')
      <span class="invalid-feedback" role="alert">
      <strong>{{$massage}}</strong>
      </span>
      @enderror
      </div>

      <div class="form-group">
      <div class="form-row">
       <div class="col-8">
      <label class="form-label ">Ville/commune</label>
      <select id="cmddestination"  required  class="form-control" name="fee">
      <option  value="">selectionner Une ville/commune</option>
      @foreach($fees as $fee)
      <option 
      @if(old('fee') == $fee->id) selected @endif
      value="{{$fee->id}}">{{$fee->destination}}</option>
      <div id="fee_price"></div>
      @endforeach
      </select>
      @error('fee')
      <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
      </span>
      @enderror
      </div>
      

      <div class="col">
      <label class="form-label">Tarif livrai.</label>
      <select   required   class="form-control livraison" name="livraison">
        <option value="">Chosir</option>
      <option value="1000">1000f</option>
      <option value="1500">1500f</option>
      <option value="2000">2000f</option>
      <option value="2500">2500f</option>
      <option value="3000">3000f</option>
      <option value="0">Gratuit</option>
      <option value="autre">Autre</option>
      </select>
      @error('fee')
      <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
      </span>
      @enderror
      </div>
     </div> 
   </div>


     <div hidden class="form-group autre">
      <label class="form-label"> Saisir tarif de livraison</label>
      <input name="other_liv"  value="{{ old('other_liv') }}" id="cmdothfee"  class="form-control tarif" type="number" placeholder="" >
      </div>


      <div class="form-group">
      <label class="form-label"> Précision sur l'adresse de livraison</label>
      <input maxlength="150" value="{{ old('lieu') }}" id="cmdlieu" name="adresse" class="form-control" type="text" placeholder="Exemple: grand carrefour... pharmacie... rivera jardin..." >
      </div>
      <div class="form-row">
        <div class="col">
          <label class="form-label">Indicatif</label>
          <select class="form-control">
            <option>+225</option>
          </select>
        </div>
        <div class="col-8">
      <label class="form-label">Contact</label>
      <input id="cmdphone" value="{{ old('phone') }}" required  name="phone" class="form-control" type="number" placeholder="Numero du client sans l'indicatif(225)"  autocomplete="off">
      @error('phone')
      <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
      </span>
      @enderror
      </div> 
      <span class="contact_div"></span>        
      </div>


     <div class="form-group">
                            <select class="form-control" name="livreur">
                            	<option value="">selectionner un livreur</option>
                               <option value="">Plutard</option>
                            	@foreach($livreurs as $livreur)
                            	<option value="{{$livreur->id}}">{{$livreur->nom}}</option>
                        
                            	@endforeach
                            </select>
						</div>
                       
						<div class="form-group">
                            <select class="form-control" name="client">
                            	<option value="">selectionner un utilisateur</option>
                            	<option value="">Plutard</option>
                            	@foreach($clients as $client)
                            	<option value="{{$client->id}}">{{$client->nom}}</option>
                        
                            	@endforeach
                            </select>
						</div>







      <div class="form-group">
      <label  class="form-label"> Information supplementaire.</label>
      <input id="comobservation" maxlength="150" value="{{ old('observation') }}"  name="observation" class="form-control" type="text" placeholder="Information supplementaire">
      </div>


                                <div class="form-group basic">
                                    <button type="submit" class="btn btn-primary btn-block btn-lg"
                                        >Enregister</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- * Deposit Action Sheet -->



        <!-- Deposit Action Sheet -->
        <div  class="modal fade modalbox" id="editModal" tabindex="-1" role="dialog">
            <div  class="modal-dialog" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title editModalTitle"></h5>
                        <a href="javascript:;" data-dismiss="modal">Fermer</a>
                        
                        

                    </div>
                    <div   class="modal-body">
                        <div class="action-sheet-content editBody">
                            <form  action="/command-update" method="POST"> 
                               @csrf
                               <div class="editBody1">
                               </div>
                                <div class="form-row">
       <div class="col-8">
      <label class="form-label ">Ville/commune</label>
      <select  required   class="form-control editFee" name="fee">
      <option  value="">selectionner Une ville/commune</option>
      @foreach($fees as $fee)
      <option 
      @if(old('fee') == $fee->id) selected @endif
      value="{{$fee->id}}">{{$fee->destination}}</option>
      <div id="fee_price"></div>
      @endforeach
      </select>
      @error('fee')
      <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
      </span>
      @enderror
      </div>


      <div class="col">
      <label class="form-label">Tarif Livrai.</label>
      <select   required   class="form-control livraison" name="livraison">
        <option value="">Chosir</option>
      <option value="1000">1000f</option>
      <option value="1500">1500f</option>
      <option value="2000">2000f</option>
      <option value="2500">2500f</option>
      <option value="3000">3000f</option>
      <option value="0">Gratuit</option>
      <option value="autre">Autre</option>
      </select>
      @error('fee')
      <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
      </span>
      @enderror
      </div>
     </div> 
     <div hidden class="form-group autre">
      <label class="form-label"> Saisir tarif livraison</label>
      <input name="other_liv"  value="{{ old('other_liv') }}"   class="form-control tarif" type="number" placeholder="" >
      </div>
                                <div class="editBody2">
                               </div>

                               <div class="form-group basic">
                                    <button type="submit" class="btn btn-primary btn-block btn-lg"
                                        >Confirmer</button>
                                </div>
                           </div>
                               
                           </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- * Deposit Action Sheet -->


        <!-- Deposit Action Sheet -->
        <div style="height: 100rem" class="modal fade modalbox" id="duplicateModal" tabindex="-1" role="dialog">
            <div  class="modal-dialog" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                        
                        <h5 class="modal-title">Nouvelle commande</h5>
                        <a href="javascript:;" data-dismiss="modal">Fermer</a>

                    </div>
                    <div   class="modal-body">
                        <div class="action-sheet-content duplicateBody">
                            <form  action="command-fast-register" method="POST"> 
      @csrf
      <div class="duplicateBody1">
      </div>
      
      <div class="form-group">
       <div class="form-row">
       <div class="col-8">
      <label class="form-label">Ville / Commune</label>
      <select  required   class="form-control duplicateFee" name="fee">
      <option   value="">selectionner Une ville/commune</option>
      @foreach($fees as $fee2)
      <option  
      
      value="{{$fee2->id}}">{{$fee2->destination}}</option>
      <div id="fee_price"></div>
     @endforeach
      </select>
      @error('fee')
      <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
      </span>
      @enderror
      </div>


      <div class="col">
      <label class="form-label">Tarif livrai.</label>
      <select id="cmdfee"  required   class="form-control livraison" name="livraison">
        <option value="">Chosir</option>
      <option value="1000">1000f</option>
      <option value="1000">1500f</option>
      <option value="2000">2000f</option>
      <option value="2500">2500f</option>
      <option value="3000">3000f</option>
      <option value="0">Gratuit</option>
      <option value="autre">Autre</option>
      </select>
      @error('fee')
      <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
      </span>
      @enderror
      </div>
     </div> 
     <div hidden class="form-group autre">
      <label class="form-label"> Saisir tarif livraison</label>
      <input name="other_liv"  value="{{ old('other_liv') }}"   class="form-control tarif" type="number" placeholder="" >
      </div>
     </div>



      <div class="duplicateBody2">
      </div>
      </div>
      <div class="form-group basic">
                                    <button type="submit" class="btn btn-primary btn-block btn-lg"
                                        >Enregister</button>
                                </div>
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