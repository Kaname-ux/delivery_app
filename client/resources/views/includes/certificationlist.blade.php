

<div id="{{$certification->id}}" class="section full target  mt-2">
     <div class="section mt-4 livreurs" >

            

            
   
            <div class="transactions">

                
                <span  class="item">
                    <div class="detail">
                        
                        <img @if(Storage::disk('s3')->exists($certification->photo_ref))
                          
                          src="{{Storage::disk('s3')->url($certification->photo_ref)}}" class="image-block imaged big"
                         @else src="assets/img/sample/brand/1.jpg" alt="img"
                         class="image-block imaged"
                          @endif alt="img" width="80">
                         
                        <div>

                            <strong>{{$certification->name}}</strong>
                           Date: {{$certification->created_at->format('d-m-Y')}}
                            <p></p>

                          <br>

                        <button data-liv="{{$certification->livreur_id}}" value="{{$certification->user_id}}" data-name="{{$certification->name}}" class="btn btn-success accept" data-photo="{{Storage::disk('s3')->url($certification->photo_ref)}}" data-p_photo="{{Storage::disk('s3')->url($certification->piece_ref)}}" data-phone='{{$certification->phone}}'
                            data-wphone='{{$certification->wphone}}' data-cert_id="{{$certification->id}}">Vérifier et certifier</button>

                          

                                         <div>
                                          
                      </div>
                        </div>


                    </div>
                     
                </span>


               
            </div>
        </div>
</div>



























