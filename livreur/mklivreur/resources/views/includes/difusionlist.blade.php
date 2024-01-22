

<div id="{{$difusion->id}}" class="section full target  mt-2">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                {{$difusion->created_at->format('d-m-Y H:i')}}
                </div>
                
                <div id="status{{$difusion->id}}" class="col  @if($difusion->status == 'encours') text-danger @else text-success @endif">{{$difusion->status}}</div>

                <div class="col float-right">
                  <button class="btn btn-light share"  value="{{strip_tags($difusion->description)}}" ><ion-icon  name="share-social-outline"></ion-icon>
                  </button>
                </div>
            </div>
            <div class=" row mt-2">
               
              {!!$difusion->description!!}<br>
              @if($difusion->cient)
              Diffusé par: {{$difusion->client->nom}}<br>
              @endif
              
                
            </div>
           
                
                
                <div class="row">

                 <div class="col">   
                <a class="btn btn-outline-success btn-sm "  id="wa{{$difusion->id}}" href="https://wa.me/225{{$difusion->wa}}"><ion-icon name="logo-whatsapp"></ion-icon></a>
                 </div>

                 <div class="col">
                <a class="btn btn-outline-success btn-sm"  id="call{{$difusion->id}}" href="tel:{{$difusion->ram_phone}}"><ion-icon name="call-outline"></ion-icon></a>

            </div>
            <div class="col">
                @if(!$difusion->livreurs->contains($livreur->id))
                <button  id="" data-id="{{$difusion->id}}" value="postule" class="btn btn-success btn-sm postule postule{{$difusion->id}}">Postuler</button>
                
            
                @else
                <button id="cancel{{$difusion->id}}"  data-id="{{$difusion->id}}"  value="cancel" class="btn btn-danger postule btn-sm postule{{$difusion->id}}">Me rétirer</button>
                
                @endif
            </div>
                </div>

                
                
                <div class="row mt-2">
                   <div class="col">
                
                @if(!$difusion->livreurs->contains($livreur->id))
                
                
                <span class="contact_status{{$difusion->id}}"></span>
                @else
                
                <span class="contact_status{{$difusion->id}}">Je suis intéréssé</span>
                @endif
            </div>
               </div>
                

             
       </div>
         
      </div>   
</div>



























