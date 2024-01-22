

<div  id="{{$command->id}}" class="section full target  mt-2">
         

    <div class="card" style="margin-bottom: 0; border-radius: 0;">
  <div class="card-body" >
    <div>
    
    @if($command->etat != 'termine' && $command->etat != 'annule')
   <input type="checkbox" class="cmd_chk" data-id="{{$command->id}}">
   @endif
   
   @if($command->etat == 'termine')
                           <i   class="fa fa-check text-success fa-2x"></i>
                           @endif

                           @if($command->etat == 'en chemin')
                           <i   class="fas fa-walking text-warning fa-2x"></i>
                           @endif

                            @if($command->etat == 'recupere')
                           <i   class="fas fa-dot-circle text-warning fa-2x"></i>
                           @endif

                           @if($command->etat == 'encours')

                           <i id="state_c{{$command->id}}"   class="fas fa-dot-circle text-danger fa-2x"></i>
                           @endif


                           @if($command->etat == 'annule')

                           <i id="state_c{{$command->id}}"   class="fas fa-window-close  fa-2x"></i>
                           @endif
                            
                           

                           <strong style="font-size: 20px; "> {{$command->id}}</strong> 

                           <span class="label">{{$command->updated_at->format('d-m-Y H:i')}} 
                                            </span>

                  
            
                  <button
                  
          data-desc="{{$command->description}}" data-id="{{$command->id}}" data-date="{{$command->delivery_date->format('Y-m-d')}}" data-montant="{{$command->montant}}" data-fee="{{$command->fee_id}}" 
          data-com="{{substr($command->adresse,strlen($command->fee->destination)+1)}}" 
          data-adrs="{{$command->adresse}}" data-phone="{{$command->phone}}" data-observation="{{$command->observation}}"
          data-etat="{{$command->etat}}" data-livphone ="{{$command->livreur->phone}}" data-total="@if($command->livraison != NULL) {{$command->montant+$command->livraison}}  @else {{$command->montant+$command->fee->price}} @endif" @if($command->livraison == NULL) data-liv="no" @else data-liv="{{$command->livraison}}" @endif

                   type="button" class="btn   btn-icon float-right cmd_menu" id="cmd_menu{{$command->id}}" >
                                    <ion-icon class="text-primary" name="ellipsis-vertical"></ion-icon>
                                </button>

           
            

            <input  type="checkbox" value="{{$command->id}}" data-onstyle="primary" data-offstyle="secondary" class="ready" @if($command->ready != NULL) checked @endif data-onlabel="Prêt" data-offlabel="Pas prêt"  data-toggle="switchbutton" data-size="sm" >

            

             @if($command->payment)
                              @if($command->payment->etat == 'termine' )
                                <span class="badge badge-success">Payé</span>
                                @endif
                              @endif  
          </div>
             
  </div>
  <div>                     
        @if($command->note->count()>0)

          <button   
            data-id="{{$command->id}}"  class="note btn text-warning"> 
            Note</button>
           @endif
           <span class="float-right">Enregistré le: {{$command->created_at->format('d-m-Y H:i')}}</span>
       </div> 
</div>
            <div   class="accordion " id="accordion02">


                

                <div class="item">
                    <div class="accordion-header">
                        <button class="btn collapsed" type="button" data-toggle="collapse" data-target="#accordion2b{{$command->id}}">
                           <ion-icon class="" name="location-outline"></ion-icon>
                             
                            
                            {{substr($command->adresse, 0, 50)}}@if(strlen($command->adresse)>49)... @endif
                        </button>

                    </div>
                    <div id="accordion2b{{$command->id}}" class="accordion-body collapse" data-parent="#accordion02">
                        <div class="accordion-content">
                            {{ $command->adresse}}<br>{{$command->phone}}<br>
                            {{$command->observation}}<br>
                            <a href="https://www.google.com/maps/search/?api=1&query={{urlencode($command->adresse)}}">Rechercher dans google map</a>
                        </div>
                    </div>
                </div>


                <div class="item">
                    <div class="accordion-header">
                        <button class="btn collapsed" type="button" data-toggle="collapse" data-target="#accordion6b{{$command->id}}">
                           <ion-icon class="" src="assets/img/bag-outline.svg"></ion-icon>
                           
                           {{substr($command->description, 0, 50)}}@if(strlen($command->description)>49)... @endif
                        </button>
                    </div>
                    <div id="accordion6b{{$command->id}}" class="accordion-body collapse" data-parent="#accordion02">
                        <div class="accordion-content">
                           {{$command->description}} 
                        </div>
                    </div>
                </div>

                <div class="item">
                    <div class="accordion-header">
                        <button class="btn collapsed" type="button" data-toggle="collapse" data-target="#accordion3b{{$command->id}}">
                            <ion-icon class="" name="cash-outline"></ion-icon>
                           {{$command->livraison + $command->montant}}  CFA
                        </button>
                    </div>
                    <div id="accordion3b{{$command->id}}" class="accordion-body collapse" data-parent="#accordion02">
                        <div class="accordion-content">
                            Prix: {{$command->montant}}.
                            Livraisons:
                             {{$command->livraison}}CFA.

                        </div>
                    </div>
                </div>

                 

            </div>
          @if(strlen($command->observation)>0)
            <div class="card" style="margin-top: 0;  border-radius: 0; ">
  <div class="card-body" >
    <ion-icon class="text-danger" name="information-circle-outline"></ion-icon>
    {{$command->observation}}
  </div>
</div>
@endif


            <div class="card" style="margin-top: 0;  border-radius: 0; ">
  <div class="card-body" >
    @if($client->manager_id == null)
    @if($command->etat != 'termine' && $command->etat != 'annule')
      
      <span  class="dropup " >
      
      <button  class="btn btn-primary   dropdown-toggle btn-block" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span  hidden="hidden" class="spinner-border spinner-border-sm spinner{{$command->id}}" role="status" aria-hidden="true"></span><span class="sr-only"></span>
      
      @if($command->livreur->id == 11)
                        Assigner 
                        @else
                        Réassigner
                        @endif
      
      </button>
      <span class="dropdown-menu dropdown-menu-left" aria-labelledby="dropdownMenuButton">
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
      <button onclick="window.location.href = 'livreurs'" class="dropdown-item" > <ion-icon  name="list-outline"></ion-icon>Ajouter des livreurs à votre liste</button>
      @endif
      <a class="dropdown-item nearByLivreur phone"  value="{{$command->id}}" ><ion-icon  name="navigate-outline"></ion-icon>Trouver un livreur à proximité</a>
      </span>
      </span>
  @endif
  @else
    gérées par {{$client->manager->nom}}    
@endif
<br>
 <ion-icon class="" name="bicycle-outline"></ion-icon>
    <span  id="cur_liv{{$command->id}}">
 @if($command->livreur->id == 11)
   Non assigné
    @else
  {{substr($command->livreur->nom, 0, 20)}}.

                            <a class="btn btn-icon btn-primary mr-1 phone" href="tel:{{$command->livreur->phone}}" >
                            <ion-icon class="" name="call-outline"></ion-icon>
                         </a>

                            @if( strstr($_SERVER['HTTP_USER_AGENT'],'iPhone') || strstr($_SERVER['HTTP_USER_AGENT'],'iPad') )
                            <a class="btn btn-icon btn-primary mr-1 phone" href="sms:{{$command->livreur->phone}}&body=une commande assignée. {{$command->adresse}}. {{$command->client->nom}}" >
                            <ion-icon  name="mail-outline"></ion-icon>
                         </a>
                         @else
                        
                              <a class="btn btn-icon btn-primary mr-1 phone" href="sms:{{$command->livreur->phone}}?body=une commande assignée. {{$command->adresse}}. {{$command->client->nom}}" >
                            <ion-icon name="mail-outline"></ion-icon>
                         </a>
                          @endif
    @endif
 </span>  

  </div>
</div>

        </div>



























