

<div id="{{$difusion->id}}" class="section full target  mt-2">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                {{$difusion->created_at->format('d-m-Y')}}
                </div>
                <div class="col-4">
                    Postulants:
                {{$difusion->livreurs->count()}}
                </div>
                <div class="float-right status{{$difusion->id}} @if($difusion->status == 'encours') text-danger @else text-success @endif">{{$difusion->status}}</div>
            </div>
            <div class=" row ">
               
              <strong style="font-weight: bolder; color: black">{{$difusion->description}}</strong>
                
            </div>
            <div>
                <button  value="{{$difusion->description}}" class="btn btn-primary share"><ion-icon name="share-social-outline"></ion-icon> Partager</button>

                <!-- <button  value="{{$difusion->id}}" class="btn btn-primary changestatus"><i class="fa fa-edit  "></i> Modifier</button>
                 -->
                @if($difusion->status == 'encours') 
                 <button data-status='{{$difusion->status}}'  value="{{$difusion->id}}" class="btn btn-success changestatus changestatus{{$difusion->id}}">Marquer terminé</button>
                 @else 
                 <button data-status='{{$difusion->status}}'  value="{{$difusion->id}}" class="btn btn-danger changestatus changestatus{{$difusion->id}}">Marquer encours</button>
                 @endif

                 <button onclick="$('.delete').val('{{$difusion->id}}'); $('#confirmModal').modal('show');" value="{{$difusion->id}}" class="btn btn-danger float-right btn-sm "><ion-icon name="trash-outline"></ion-icon></button>
               


            </div> 
       </div>
         
      </div>   
</div>



























