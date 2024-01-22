

<div  id="{{$command->id}}" class="target col-sm-6 col-lg-4 mt-2">
      <div class="card">
          <div class="card-body">
            <div class="row">

                     @if($command->payment)
                    @if($command->payment->etat == 'termine' )
                    <span class="badge badge-success">Commade encaissée</span>
                   
                    @endif
                    @endif
                
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
            <div class="mt-2 row">
                <div class="col-2">
                 <input  type="checkbox" value="{{$command->id}}" data-onstyle="primary" data-offstyle="secondary" class="ready" @if($command->ready != NULL) checked @endif data-onlabel="Prêt" data-offlabel="prêt?"  data-toggle="switchbutton" data-size="sm" >
                 </div>
                 
                 <div class="col-6" id="sms_btn{{$command->id}}">
                 @if($command->products->count() > 0)

                

                              <a @click="updateProducts({{($command->products()->select('product_id', 'command_product.qty')->get())->toJson()}} ,{{$command->id}})" data-toggle="modal" data-target="#productsModal" class="btn  btn-primary  phone btn-sm ml-1" href="#" >
                            <ion-icon name="cart-outline"></ion-icon>
                            {{$command->products->count()}} articles
                         </a>
                          @else
                          <a data-toggle="modal" data-target="#productsModal" @click="updateProducts({}, {{$command->id}})" class="btn  btn-primary  phone btn-sm ml-1" href="#" >
                            <ion-icon name="cart-outline"></ion-icon>
                            Ajoueter articles
                         </a>
                          @endif
                         </div>

                          @if($client->manager_id == null)
    @if($command->etat != 'termine' && $command->etat != 'annule')
      <div class="col-4">

        <button h  class="btn btn-primary btn-sm showLivreur"  value="{{$command->id}}" data-livid="{{$command->livreur->id}}"
         data-livname="{{$command->livreur->nom}}">
      <span  hidden="hidden" class="spinner-border spinner-border-sm spinner{{$command->id}}" role="status" aria-hidden="true"></span><span class="sr-only"></span>
       @if($client->livreurs->count()>0)
        <ion-icon  name="bicycle-outline"></ion-icon>
      @if($command->livreur->id == 11)
      Assigner
      @else
      Réassigner
      @endif</button>

      @else
      <button onclick="window.location.href = 'livreurs'" class="dropdown-item" > <ion-icon  name="list-outline"></ion-icon>Trouver des livreurs</button>
      @endif
      <!-- <span  class="dropup mt-1" >
      
      <button style="font-weight: bold;"  class="btn btn-primary btn-sm   dropdown-toggle "  id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span  hidden="hidden" class="spinner-border spinner-border-sm spinner{{$command->id}}" role="status" aria-hidden="true"></span><span class="sr-only"></span>
      
      @if($command->livreur->id == 11)
                        Assigner 
                        @else
                        Réassigner
                        @endif
      
      </button>
      <span class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
      <button href="#"  class="dropdown-item showLivreur"  value="{{$command->id}}" data-livid="{{$command->livreur->id}}"
         data-livname="{{$command->livreur->nom}}">
      
       @if($client->livreurs->count()>0)
        <ion-icon  name="list-outline"></ion-icon>
      @if($command->livreur->id == 11)
      Choisir un livreur dans ma liste
      @else
      Choisir un autre livreur
      @endif</button>

      @else
      <button onclick="window.location.href = 'livreurs'" class="dropdown-item" > <ion-icon  name="list-outline"></ion-icon>Trouver des livreurs</button>
      @endif
      <a class="dropdown-item nearByLivreur phone"  value="{{$command->id}}" ><ion-icon  name="navigate-outline"></ion-icon>Trouver un livreur à proximité</a>
      </span>
      </span> -->
      </div>
  @endif
  @else
    gérées par {{$client->manager->company}}    
@endif
</div>

<div class="row text-warning" style="font-style: italic;">
    @if($command->note->count()>0)
           Derniere note:<strong>{{$command->note->last()->created_at->format("d-m-Y")}} -
                          {{$command->note->last()->description}}</strong>  
           @endif
</div>
          </div>
         
      </div>   

    
        </div>



























