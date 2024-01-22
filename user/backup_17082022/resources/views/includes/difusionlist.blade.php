

<div id="{{$difusion->id}}" class="section full target  mt-2">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                {{$difusion->created_at->format('d-m-Y')}}
                </div>
                <div class="col-4">
                    <button value="{{$difusion->id}}" class="btn btn-sm btn-light @if($difusion->livreurs->count()>0)
                        candidates
                        @endif">
                    Postulants:
                {{$difusion->livreurs->count()}}
                </button>
                </div>
                <div id="status{{$difusion->id}}" class="float-right  @if($difusion->status == 'encours') text-danger @else text-success @endif">{{$difusion->status}}</div>
            </div>
            <div class=" row ">
               
              <strong style="font-weight: bolder; color: black">{{$difusion->description}}</strong>
                
            </div>
            <div>
                <button  value="{{$difusion->description}}" class="btn btn-primary share"><ion-icon name="share-social-outline"></ion-icon> Partager</button>

                <!-- <button  value="{{$difusion->id}}" class="btn btn-primary changestatus"><i class="fa fa-edit  "></i> Modifier</button>
                 -->
                @if($difusion->status == 'encours') 
                 <button id="changestatus{{$difusion->id}}" data-status='{{$difusion->status}}'  value="{{$difusion->id}}" class="btn btn-success changestatus ">Marquer terminé</button>
                 @else 
                 <button id="changestatus{{$difusion->id}}" data-status='{{$difusion->status}}'  value="{{$difusion->id}}" class="btn btn-danger changestatus ">Marquer encours</button>
                 @endif

                 <button onclick="$('.delete').val('{{$difusion->id}}'); $('#confirmModal').modal('show');" value="{{$difusion->id}}" class="btn btn-danger float-right btn-sm "><ion-icon name="trash-outline"></ion-icon></button>
               


            </div> 
       </div>
         
      </div>   
</div>



























