
               <div class="item target">
                    <!-- card block -->

            <div class="card text-white @if($loop->first) badge-tertiary @else @if($loop->odd) badge-fith @elseif($loop->even) badge-fourth
              @endif
               @endif mb-2">
                <div class="card-header">

              @if(request()->path() == 'commands' && $command->etat != 'termine' && $command->etat != 'annule')
                           <div class="custom-control d-inline custom-checkbox">
                             <input data-id="{{$command->id}}" type="checkbox" class="custom-control-input cmd_chk" id="customCheck{{$chk}}a" />
                              <label style="font-size: 20px; font-weight: bold;" class="custom-control-label" for="customCheck{{$chk}}a">{{$command->id}}</label>
                           </div>
                           @else
                             <strong style="font-size: 20px"> {{$command->id}}</strong>
                             @endif
                  


        @if($command->etat == 'annule')
    <button class="btn btn-danger btn-sm del" value="{{$command->id}}">Supprimer</button>
    <button class="btn btn-success btn-sm activate" value="{{$command->id}}">Activer</button>
    
    @endif

         @if($command->etat == 'encours')
      @if($client->livreurs->count()>0)
      <span class="dropdown">
      
      <button  class="btn btn-primary btn-sm   dropdown-toggle " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span  hidden="hidden" class="spinner-border spinner-border-sm spinner{{$command->id}}" role="status" aria-hidden="true"></span><span class="sr-only"></span>
      <ion-icon name="bicycle-outline"></ion-icon>Assigner 
      </button>
      <span class="dropdown-menu dropdown-menu-left" aria-labelledby="dropdownMenuButton">
      <button  class="dropdown-item showLivreur"  value="{{$command->id}}" data-livid="{{$command->livreur->id}}"
         data-livname="{{$command->livreur->nom}}">
       <ion-icon name="list-outline"></ion-icon>
       
      @if($command->livreur->id == 11)
      Choisir un livreur dans ma liste
      @else
      Choisir un autre livreur
      @endif</button>@else
      <a class="dropdown-item" href="livreur"><i class="fas fa-list">Ajouter des livreurs à votre liste</a>
      @endif
      <button class="dropdown-item nearByLivreur"  value="{{$command->id}}" ><ion-icon name="navigate-outline"></ion-icon>Trouver un livreur à proximité</button>
      </span>
      </span>

      
      @endif



                    
                    
                  <button
                  
          data-desc="{{$command->description}}" data-id="{{$command->id}}" data-date="{{$command->delivery_date->format('Y-m-d')}}" data-montant="{{$command->montant}}" data-fee="{{$command->fee_id}}" data-adrs="{{str_replace($command->fee->destination.':','',$command->adresse)}}" data-phone="{{$command->phone}}" data-observation="{{$command->observation}}"
          data-etat = "{{$command->etat}}" data-livphone ="{{$command->livreur->phone}}" data-total="@if($command->livraison != NULL) {{$command->montant+$command->livraison}}  @else {{$command->montant+$command->fee->price}} @endif" @if($command->livraison == NULL) data-liv="no" @else data-liv="{{$command->livraison}}" @endif

                   type="button" class="btn  text-white btn-icon float-right cmd_menu" >
                                    <ion-icon name="ellipsis-vertical"></ion-icon>
                                </button>

           
            

            <input  type="checkbox" value="{{$command->id}}" data-onstyle="primary" data-offstyle="light" class="ready" @if($command->ready != NULL) checked @endif data-onlabel="Prêt" data-offlabel="Pas prêt"  data-toggle="switchbutton"  data-size="sm">
        </div>
                <div class="card-body">
                    <h5 class="card-title">{{substr($command->description, 0, 30)}} @if(strlen($command->description)>31)... @endif</h5>
                    <p class="card-text">
                      @if(request()->path() == 'dashboard')
                        
                        {{ substr($command->adresse, 0, 30)}}
                        @if(strlen($command->adresse)>31)... @endif

                        @else
                        {{ $command->adresse}}
                        @endif
                        {{$command->phone}}

                        
                   </p>

                   
                            <div class="section mt-2">
                                <div  class="row">
                                    <div  class="col-4">
                                        <span class="label">montant</span>
                                         {{$command->montant}}CFA 
                                    </div>
                                    <div  class="col-4">
                                        <span class="label">{{$command->updated_at->format('H:i:s')}} 
                                            </span>
                                        <span id="cmd_state{{$command->id}}" 
                                        @if($command->etat == 'encours') 
                                        class="badge badge-danger"
                                        @endif
                                        @if($command->etat == 'recupere')
                                        class="badge badge-warning"
                                        @endif
                                        @if($command->etat == 'en chemin')
                                        class="badge badge-info"
                                        @endif
                                        @if($command->etat == 'termine')
                                        class="badge badge-success"
                                        @elseif($command->etat == 'annule')
                                        class="badge badge-secondary"
                                        @endif
                                        >
                                        @if($command->livreur_id == 11 && $command->etat != 'annule')
                                        En attente  
                                        @else
                                        @if($command->etat != 'termine')
                                        {{$command->etat}}
                                        @else
                                        Livré 
                                        @endif
                                        
                                        @endif
                                        </span>
                                         @if($command->payment)
                                        @if($command->payment->etat == 'termine' )
                                        <span class="badge badge-success">Commade encaissée</span>
                                        @else
                                        <span class="badge badge-danger">Encaisser la commande</span>
                                        @endif
                                        @endif
                                            
                                    </div>
                                    
                                    <div class="col-4">
                                        <span class="label">Livreur</span>@if($command->note->count()>0)
                                         <a style="color: orange"  
                                         data-id="{{$command->id}}"  class="note"> 
                                         <i class="fa fa-sticky-note" >Note</i></a>
                                         @endif<br>
                                         <span id="cur_liv{{$command->id}}">
                                        @if($command->livreur_id != 11)
                                          
                                         {{substr($command->livreur->nom, 0, 10)}}.
                                         
                                         
                                          @endif 

                                          </span>
                                    </div>
                                    
                                   
                                </div>
                            </div>

                            @if(request()->path() == 'commands')
                             <span class="text-warning">{{$command->observation}}</span> 
                             @endif
                </div>
            </div>
                    
                </div>
              

                