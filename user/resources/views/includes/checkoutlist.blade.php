

<div @mouseover="updateVariant({{$x}})" id="{{$command->id}}" class="target  mt-2 col-sm-6 col-lg-4 mt-2">
      <div class="card">
          <div class="card-body">
            <div class="row">

                     @if($command->payment)
                    
                    @if($command->payment->etat == 'termine' )
                    <div class="col">
                    <button id="pay{{$command->id}}"  :class="payedClass">Commande encaissee</button>

                   </div>
                   @else
                   <button id="pay{{$command->id}}" @click="confirmpay('{{$command->id}}')" data-toggle="modal" data-target="#confirmModal"   :class="unpayedClass">Encaisser la commande</button>
                    @endif

                    @endif

                    <div class="col delivery_date{{$command->id}}">
                    Date de livraison: {{$command->delivery_date->format('d-m-Y')}}
                   </div>
                
            </div>
            <div class="row " style="color: black;" >
                     <div class="col" style="font-size: 13px; line-height: 1.6; font-style: italic;"> 
                        Via: {{$command->canal}}
                        </div>

                     <div class="col" style="font-size: 13px; line-height: 1.6; font-style: italic;"> 
                       Client: {{substr($command->nom_client, 0, 50)}}@if(strlen($command->nom_client)>50)...@else . @endif
                       </div>  
 
                     
                 </div>
            <div class=" row ">
             
              <div style="line-height: 1.6;" class="col-4">
                <span >
                    @if($command->etat != 'termine' && $command->etat != 'annule')
   <input id="cmd_chk{{$command->id}}" type="checkbox" class="cmd_chk" data-id="{{$command->id}}">
   @endif
</span>
                    <span id="idbox{{$command->id}}" style="font-size:20px;color:black; ">
                        @if($command->is_difused == "yes")
           <ion-icon class="text-info" name="radio-outline"></ion-icon> 
           @endif
                     {{$command->id}} 
                 </span>
                    

                           </div>
                           <div class="col-7">
                          <span  style="font-size:17px; " class="ml-3">
                        <ion-icon name="cash-outline"></ion-icon>
                           {{$command->livraison + $command->montant}} 


                    </span> 
                    
                        
                        

             </div>
                <div class="col-1 float-right">
                  <button
                  class="btn   btn-icon  cmd_menu float-right" id="cmd_menu{{$command->id}}" 
          data-desc="{{$command->description}}" data-id="{{$command->id}}" data-date="{{$command->delivery_date->format('Y-m-d')}}" data-date2="{{$command->delivery_date->format('d-m-Y')}}" data-montant="{{$command->montant}}" data-livreur="{{$command->livreur_id}}" data-fee="{{$command->fee_id}}" 
          data-com="{{substr($command->adresse,strlen($command->fee->destination)+1)}}" 
          data-adrs="{{$command->adresse}}" data-phone="{{$command->phone}}" data-observation="{{$command->observation}}"
          data-etat="{{$command->etat}}" data-livphone ="{{$command->livreur->phone}}" data-costumer="{{$command->nom_client}}" data-remise="{{$command->remise}}"  @if($client->sources->count() > 0) data-canal="{{$command->canal}}" @else data-canal="none" @endif data-total="@if($command->livraison != NULL) {{$command->montant+$command->livraison}}  @else {{$command->montant+$command->fee->price}} @endif" @if($command->livraison == NULL) data-liv="no" @else data-liv="{{$command->livraison}}" @endif

                   >
                                    <ion-icon class="text-primary" name="ellipsis-vertical"></ion-icon>
                                </button>  
                </div>
             </div>

             <div class="row mt-0">
                 <div style="line-height: 1.6; font-size:13px" class="col">
                 
                 @if($command->etat == 'en chemin')
                 <button data-toggle="modal" data-target="#etatModal" @click="updateSelectedState('{{$command->etat}}','{{$command->id}}','{{$command->livreur_id}}')" class="btn btn-outline-warning btn-sm">
                           <i   class="fas fa-walking text-warning "></i>En chemin
                            </button>
                           @endif
                      
                            @if($command->etat == 'recupere')
                            <button data-toggle="modal" data-target="#etatModal"  @click="updateSelectedState('{{$command->etat}}','{{$command->id}}','{{$command->livreur_id}}')" value="" class="btn btn-outline-warning btn-sm">
                           <i   class="fas fa-dot-circle text-warning "></i>Récupéré
                       </button>
                           @endif

                           @if($command->etat == 'encours')
                            <button data-toggle="modal" data-target="#etatModal"  @click="updateSelectedState('{{$command->etat}}','{{$command->id}}','{{$command->livreur_id}}')" value="" class="btn btn-outline-danger btn-sm">
                           <i id="state_c{{$command->id}}"   class="fas fa-dot-circle text-danger "></i>
                       
                           @if($command->livreur->id == 11)
                           En Attente
                           @else
                           Encours
                           @endif
                           </button>
                           @endif
                          
                           @if($command->etat == 'annule')
                           <button data-toggle="modal" data-target="#etatModal"   @click="updateSelectedState('{{$command->etat}}','{{$command->id}}','{{$command->livreur_id}}')" value="" class="btn btn-outline-secondary btn-sm">      
                           <i id="state_c{{$command->id}}"   class="fas fa-window-close  "></i>Annulé
                       </button>
                           @endif

                            @if($command->etat == 'termine')
                            <button data-toggle="modal" data-target="#etatModal"  @click="updateSelectedState('{{$command->etat}}','{{$command->id}}','{{$command->livreur_id}}')" value="" class="btn btn-outline-success btn-sm">
                           <i   class="fa fa-check text-success "></i>Livré
                       </button>
                           @endif
                          
                           <br>
                           {{$command->updated_at->format('d-m-Y H:i')}}
                           

                           </div>

            @if($command->note->count()>0)
            <div class="col">
          <button   
            data-id="{{$command->id}}"  class="note btn text-warning"> 
            Note</button>
            </div>
           @endif

         
              


           
  @if($command->observation)
  <div class="col">
           <ion-icon class="text-danger ml-1" name="information-circle-outline"></ion-icon>
    {{$command->observation}}
    </div>
    @endif
             </div>
             <a href="#" class="cmd_detail phone"  data-desc="{{$command->description}}" data-id="{{$command->id}}" 
                data-created="{{$command->created_at->format('d-m-Y')}}"
                data-updated="{{$command->updated_at->format('d-m-Y H:i:s')}}"
                data-date="{{$command->delivery_date->format('Y-m-d')}}" data-date2="{{$command->delivery_date->format('d-m-Y')}}" data-montant="{{$command->montant}}" data-fee="{{$command->fee_id}}" 
          data-com="{{substr($command->adresse,strlen($command->fee->destination)+1)}}" 

          data-notes="@if($command->note->count()>0) @foreach($command->note as $note) <li>{{$note->description}} - {{$note->created_at->format('d-m-Y')}}</li> @endforeach @endif"

          data-products="@if($command->products->count()>0) @foreach($command->products as $product) <li>{{$product->name}} * {{$product->qty}} = {{$product->qty*$product->price}}</li> @endforeach @endif"
          data-adrs="{{$command->adresse}}" data-phone="{{$command->phone}}" data-observation="{{$command->observation}}"
          @if($command->livreur->id == 11)
          data-livnom="Non assigné"
          data-livphone =""
          @else
          data-livnom="{{$command->livreur->nom}}"
          data-livphone ="{{$command->livreur->phone}}"
          @endif
          data-etat="{{$command->etat}}"  data-total="@if($command->livraison != NULL) {{$command->montant+$command->livraison}}  @else {{$command->montant+$command->fee->price}} @endif" @if($command->livraison == NULL) data-liv="no" @else data-liv="{{$command->livraison}}" @endif >
             <div class="row mt-2" style="color: black;" >
                     <div class="col" style=" line-height: 1.6; font-weight: bold;"> 
                        <ion-icon name="location-outline"></ion-icon>
                        {{substr($command->adresse, 0, 50)}}@if(strlen($command->adresse)>50)...@else . @endif </div>

                     <div class="col" style="font-size: 13px; line-height: 1.6; font-weight: bold;"> 
                         <ion-icon class="" src="assets/img/bag-outline.svg"></ion-icon>{{substr($command->description, 0, 50)}}@if(strlen($command->description)>50)...@else . @endif </div>
 
                     
                 </div>

                 
                 <div class="row">
                     <div    style=" font-weight: bold;">
                     <ion-icon class="" name="bicycle-outline"></ion-icon> 
                        <span id="cur_liv{{$command->id}}">
                     
                      @if($command->livreur_id == 11)
   Non assigné
    @else
  {{substr($command->livreur->nom, 0, 50)}}.
  @endif
</span>
                         </div>


                 </div>
                 </a>
           <!--  <div class="mt-2 row">
               
                
                 <div class="col" id="">
                <button class="btn btn-primary">Reporter</button>
                         </div>

      <div class="col">
         <button class="btn btn-danger">Annuler</button>
      </div>
  
</div> -->

<div class="row text-warning" style="font-style: italic;">
    @if($command->note->count()>0)
           Derniere note:<strong>{{$command->note->last()->created_at->format("d-m-Y")}} -
                          {{$command->note->last()->description}}</strong>  
           @endif
</div>
          </div>
         
      </div>   

    
        </div>



























