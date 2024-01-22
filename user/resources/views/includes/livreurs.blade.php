@foreach($livreurs as $livreur2) 

               <div class="container mt-5 d-flex justify-content-center">
    <div style="width: 400px;
    border: none;
    border-radius: 10px;
    background-color: #fff" class="card p-3">
        <div class="d-flex align-items-center">

            <div class="image">
                <button value="{{$livreur2->id}}"data-name="{{$livreur2->nom}}"class="btn btn-danger  signal mb-1">Signaler</button>
                <div class="avatar-section">
                             
             <img  @if(Storage::disk('s3')->exists($livreur2->photo))
                          src="{{Storage::disk('s3')->url($livreur2->photo)}}" 
                         class="image-block imaged big"
                         @else src="assets/img/sample/brand/1.jpg" 
                         class="image-block imaged "  @endif   width="100">

                         @if($livreur2->jibiat_reliability == '5')
                         <span class="button" >
                        <ion-icon name="camera-outline"></ion-icon>
                    </span>
                   
                    @endif
                    </div>
                          </div>
            <div class="ml-3 w-100">

                <h4 class="mb-0 mt-0">{{substr($livreur2->nom, 0, 30)}}@if($livreur2->certified_at != NULL)<span class="text-success"> <ion-icon  name="checkmark-outline"></ion-icon>Certifié</span> @endif</h4> 

                @if($livreur2->signalings->count() > 0)
                               <span class="text-danger">A été Signalé {{$livreur2->signalings->count()}} fois</span><br>
                               @endif
               Inscrit le: {{$livreur2->created_at->format('d-m-Y')}}
                <span>
                  
                    {{$livreur2->city}}  {{substr($livreur2->adresse, 0, 30)}}

                 
                </span>

                @if($livreur2->domlong != NULL && $livreur2->domlat != NULL) 
                <br>
                <span>
                            <a style="font-size: 10px" class="btn btn-primary phone" href="https://www.google.com/maps/search/?api=1&query={{$livreur2->domlat}}%2C{{$livreur2->domlong}}"><ion-icon name="navigate-outline"></ion-icon>Voir Localisation domicile</a>
                            @else
                            <a class="btn btn-primary phone" href="sms:{{$livreur2->phone}}?body=Bonjour {{substr($livreur2->nom, 0, 30)}}, Je suis vendeur en ligne. Je veux te confier des livraisons. Je souhaite connaitre la Localisation de ton domicile. Connecte toi sur ton compte https://livreurjibiat.site et clique sur 'envoyer les coodonnées de mon domicile' "><ion-icon name="navigate-outline"></ion-icon>Demander domicile</a>
                            @endif
                            </span>
                <div class="p-2 mt-2 bg-primary d-flex justify-content-between rounded text-white stats">
                    <div class="d-flex flex-column"> <span class="articles">Assignations</span> <span class="number1">{{$livreur2->commands->count()}}</span> </div>
                    <div class="d-flex flex-column"> <span class="followers">Livrés</span> <span class="number2">{{$livreur2->commands->where('etat', 'termine')->count()}}</span> </div>

                    
                    
                </div>
                 <div class="button mt-2 d-flex flex-row align-items-center">
                @if($client->livreurs->contains($livreur2->id))
                

                 <button data-id="{{$livreur2->id}}"  type="button" class="removelivreur btn  btn-secondary  w-100">
                 Retirer de ma liste</button> 


                 @else
                 <button data-id="{{$livreur2->id}}" style="font-size:10px"  type="button" class="addlivreur btn  btn-primary  w-100">
                 Ajouter à ma liste</button> 
                 @endif 


                 <a class="btn btn-icon btn-primary w-100 ml-1 phone" href="tel:{{$livreur2->phone}}" >
                            <ion-icon class="" name="call-outline"></ion-icon>
                         </a>


            @if($livreur2->wme != null)
            <a class="btn btn-icon btn-success w-100 ml-1 phone" href="https://wa.me/{{$livreur2->wme}}"><ion-icon name="logo-whatsapp"></ion-icon></a>
            
            @endif

            </div>

        </div>

    </div>
    @if($livreur2->commands->where('delivery_date', today())->where('client_id', $client->id)->count() > 0)
                 <br>
               {{$livreur2->commands->where('delivery_date','=', today())->where('etat', 'termine')->where('client_id', $client->id)->count()}} terminé sur {{$livreur2->commands->where('delivery_date', today())->where('client_id', $client->id)->count()}}
                 <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width:{{($livreur2->commands->where('etat', 'termine')->where('delivery_date', today() )->where('client_id', $client->id)->count() / $livreur2->commands->where('delivery_date', today())->where('client_id', $client->id)->count()) *100}}%;" aria-valuenow="{{round(($livreur2->commands->where('etat', 'termine')->where('delivery_date', today() )->where('client_id', $client->id)->count() / $livreur2->commands->where('delivery_date', today())->where('client_id', $client->id)->count()) *100)}}"
                            aria-valuemin="0" aria-valuemax="100">{{round(($livreur2->commands->where('etat', 'termine')->where('delivery_date', today() )->where('client_id', $client->id)->count() / $livreur2->commands->where('delivery_date', today())->where('client_id', $client->id)->count()) *100)}}%</div>
                      
                    </div>      
@endif

@if($livreur2->commands->where('etat', 'encours')->where('delivery_date', today())->where('client_id', $client->id)->count() > 0)
<br>
                        <div class="chip chip-warning ml-05 mb-05"><label class="chip-label">{{$livreur2->commands->where('etat', 'encours')->where('delivery_date', today())->where('client_id', $client->id)->count()}} à recuperer</label></div>
                        @endif
    
</div>


</div>     
             

{{$livreur2->commands->where('etat', '!=', 'termine')->where('etat', '!=', 'annule')->where('delivery_date', today())->count()}} livraisons encours actuellement. <br>
                     {{LivreurHelper::getLivreursCmds($livreur2->id)}}
                  <input  disabled class="rating rating-loading"  data-step="1" value="{{ $livreur2->AverageRating }}" data-size="xs">
                                   {{ $livreur2->Ratings()->count() }} @if($livreur2->Ratings()->count() <= 1) vote @else votes @endif
                  <!-- <form action="ratelivreur" method="post">
                    @csrf
                         <input  id="input-{{$loop->iteration}}" name="rate" class="rating rating-loading" data-min="0" data-max="5" data-step="1" value="{{ $livreur2->userAverageRating }}" data-size="xs"><button type="submit" class="btn btn-success">Noter</button>
                          <input type="hidden" name="id" required="" value="{{ $livreur2->id }}">
                            
                   </form> -->
               
                @endforeach