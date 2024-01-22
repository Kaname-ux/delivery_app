

@foreach($livreurs as $livreur2) 

               <div class="container mt-5 d-flex justify-content-center">
    <div style="width: 400px;
    border: none;
    border-radius: 10px;
    background-color: #fff" class="card p-3">
        <div class="d-flex align-items-center">

            <div class="image">
                             
             <img  @if(Storage::disk('s3')->exists($livreur2->photo))
                          src="{{Storage::disk('s3')->url($livreur2->photo)}}" 
                         class="image-block imaged big"
                         @else src="assets/img/sample/brand/1.jpg" 
                         class="image-block imaged "  @endif   width="100">

                          </div>
            <div class="ml-3 w-100">

                <h4 class="mb-0 mt-0">{{substr($livreur2->nom, 0, 30)}}@if($livreur2->certified_at != NULL)<span class="text-success"> <ion-icon  name="checkmark-outline"></ion-icon>Certifié</span> @endif</h4> 

                @if($livreur2->signalings->count() > 0)
                               <span class="text-danger">A été Signalé {{$livreur2->signalings->count()}} fois</span><br>
                               @endif
               Inscrit le: {{$livreur2->created_at->format('d-m-Y')}}
                <span>
                  
                    {{$livreur2->city}}  {{substr($livreur2->adresse, 0, 30)}}

              @if($livreur2->domlong != NULL && $livreur2->domlat != NULL) 
                           <br> <a style="font-size: 10px" class="btn btn-primary phone" href="https://www.google.com/maps/search/?api=1&query={{$livreur2->domlat}}%2C{{$livreur2->domlong}}"><ion-icon name="navigate-outline"></ion-icon>Voir Localisation domicile</a>
                           @else
                           <a class="btn btn-primary phone" href="sms:{{$livreur2->phone}}?body=Bonjour {{substr($livreur2->nom, 0, 30)}}, Je suis vendeur en ligne. Je veux te confier des livraisons. Je souhaite connaitre la Localisation de ton domicile. Connecte toi sur ton compte https://livreurjibiat.site et clique sur 'envoyer les coodonnées de mon domicile' "><ion-icon name="navigate-outline"></ion-icon>Demander domicile</a>
                            @endif

                </span>
                <div class="p-2 mt-2 bg-primary d-flex justify-content-between rounded text-white stats">
                    <div class="d-flex flex-column"> <span class="articles">Assignations</span> <span class="number1">{{$livreur2->commands->count()}}</span> </div>
                    <div class="d-flex flex-column"> <span class="followers">Livrés</span> <span class="number2">{{$livreur2->commands->where('etat', 'termine')->count()}}</span> </div>

                    
                    
                </div>
                 <div class="button mt-2 d-flex flex-row align-items-center">
                


                 <a class="btn btn-icon btn-primary w-100 ml-1 phone" href="tel:{{$livreur2->phone}}" >
                            <ion-icon class="" name="call-outline"></ion-icon>
                         </a>

                         <a class="btn btn-icon btn-primary w-100 ml-1 phone" href="https://wa.me/225{{$livreur2->wme}}" >
                            <ion-icon name="logo-whatsapp"></ion-icon>
                         </a>


            </div>

        </div>

    </div>
   


    
</div>


</div>     
             

{{$livreur2->commands->where('etat', '!=', 'termine')->where('etat', '!=', 'annule')->where('delivery_date', today())->count()}} livraisons encours actuellement. <br>
                     {{LivreurHelper::getLivreursCmds($livreur2->id)}}
                  <input  disabled class="rating rating-loading"  data-step="1" value="{{ $livreur2->AverageRating }}" data-size="xs">
                                   {{ $livreur2->Ratings()->count() }} @if($livreur2->Ratings()->count() <= 1) vote @else votes @endif
                 

   

 @endforeach


