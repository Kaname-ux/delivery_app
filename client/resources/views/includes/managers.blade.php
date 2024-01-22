@foreach($managers as $manager2) 

               <div class="container mt-5 d-flex justify-content-center">
    <div style="width: 400px;
    border: none;
    border-radius: 10px;
    background-color: #fff" class="card p-3">
<div class="d-flex align-items-center">
            <div class="image"> <img  @if(Storage::disk('s3')->exists($manager2->photo))
                          src="{{Storage::disk('s3')->url($manager2->photo)}}" 
                         class="image-block imaged big"
                         @else src="assets/img/sample/brand/1.jpg" 
                         class="image-block imaged "  @endif   width="100"> </div>
            <div class="ml-3 w-100">

                <h4 class="mb-0 mt-0">{{substr($manager2->company, 0, 30)}}</h4>
                {{substr($manager2->nom, 0, 30)}}<br> 
               Inscrit le: {{$manager2->created_at->format('d-m-Y')}}
                <span>
                  
                    {{$manager2->city}}  {{substr($manager2->adresse, 0, 30)}}</span>
                <div class="p-2 mt-2 bg-primary d-flex justify-content-between rounded text-white stats">
                    <div class="d-flex flex-column"> <span class="articles">Assignations</span> <span class="number1"></span> </div>
                    <div class="d-flex flex-column"> <span class="followers">Livrés</span> <span class="number2"></span> </div>

                    
                    
                </div>
                 <div class="button mt-2 d-flex flex-row align-items-center">
                @if($client->manager_id == $manager2->id)
                

                 <form method="POST" action="unsetmanager">@csrf
                    <input hidden value="{{$manager2->id}}" type="text" name="manager_id">
                 <button   type="submit" class=" btn  btn-primary  w-100">
                 Ne plus gérer mes assignation</button> 
                 </form> 

                 @else
                 <form method="POST" action="setmanager">
                    @csrf
                    <input hidden value="{{$manager2->id}}" type="text" name="manager_id">
                 <button   type="submit" class=" btn  btn-primary  w-100">
                 Gérer mes assignations</button> 
                 </form>
                 @endif 


                 <a class="btn btn-icon btn-primary w-100 ml-1 phone" href="tel:{{$manager2->phone}}" >
                            <ion-icon class="" name="call-outline"></ion-icon>
                         </a>


            </div>

        </div>

    </div>
   
                       



                        
                       
    
</div>


</div>     
             


               
                @endforeach