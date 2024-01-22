@extends("layouts.master")

@section("title")
{{$client->nom}}
@endsection




@section("content")





@foreach($errors->all() as $error)
      {{$error}}
     @endforeach

      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity= 
"sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
            crossorigin="anonymous"> </script>
       <script type="text/javascript">var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');</script>
        <div  class="row">

          <div  class="col-md-14">


            <div class="card">
              <div class="content">
                

            
                   
                    
               
                          <div  class="container box">
   
                   <div>

                <br><br>
                    <?php 
                          $communes = array("Adjamé", "Cocody", "Attécoubé", "Bingerville", "Anyama", "Koumassi", "Plateau", "Treichville", "Marcory", "Port-Bouet", "Bassam", "Songon", "Abobo", "Yopougon" );

                          sort($communes);
                           ?>
                        <p class="align-right">
                         <form id="filter_form" action="?filter_by_city" >
                          
                         <select id="filter" name="city" >

                                <option>
                                  Choisir zone
                                </option>

                                <?php 
                                foreach($communes as $commune) 
                                   echo "<option value='$commune'>$commune</option>";
                                ?>
                                
                              </select>
                              <a class="badge badge-primary badge-sm" href="/livreurs">Afficher Tout</a>
                        </p>
                         </form>   
            
                         
             @if($livreurs->count()>0)     
             
           @foreach($livreurs as $livreur)
                 
            <div   class="card border border-warning" style="width: 22rem;">          
            <ul class="list-group list-group-flush">

              <li class="pt-6 list-group-item">
                ID {{$livreur->id}} 
                @if($livreur->command->where('delivery_date', today())->count>0)
                <strong class="float-right" style="color: green; font-size: 9px">{{$livreur->command->where('delivery_date', today())->where('etat', '!=', 'termine')->count()}} commandes en cours actuellement.</strong>
                <strong class="float-right" style="color: green; font-size: 9px">
                  @foreach($livreur->command->where('delivery_date', today())->last() as $last)
                 Dernier mouvement:@foreach($fees as $fee2)
                 @if($fee2->id == $last->fee_id)
                 {{$fee2->destination}}
                 @endif
                 @endforeach
                  {{$last->updated_at->format("d-m-Y")}}
                  
                   
                  @endforeach
                  </strong>
                  @else
                  <strong style="font-size: 9px">Aucune commande encoure</strong>
                  @endif
              </li>
              <li class="pt-6 list-group-item">
                     {{$livreur->nom}}
                   
       
       <!--  <a  class="float-right nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink{{$livreur->id}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Assigner
        </a>
        <div class="dropdown-menu bg-light " aria-labelledby="navbarDropdownMenuLink{{$livreur->id}}">
          <a class="dropdown-item  border" data-toggle="modal" 
          data-target="#cmdAssignModal{{$livreur->id}}"  id="cmdAssign{{$livreur->id}}" href="#">
          Commandes</a>
          <a class="dropdown-item  border" data-toggle="modal" data-target="#zoneAssignModal{{$livreur->id}}" id='zoneAssign{{$livreur->id}}' href="#">Zones</a>
        </div> -->
      
                          {{$livreur->city}}:
                          {{$livreur->adresse}}<br>
                          {{$livreur->phone}}<br> <a style="color: blue" href="tel:{{$livreur->phone}}" class="btn btn-outline-warning btn-sm">
                 <i class="fas fa-phone"></i></a> 
                <!--  @if($livreur->command->count()>0)
                 @foreach($livreur->command->where('delivery_date', today()) as $liv_cmd)

                 {{$liv_cmd->fee}}  {{$liv_cmd->number}}

                 @endforeach
                 @endif -->

                  
                 <button style="color: blue" type="button"  class="btn btn-outline-warning btn-sm">
                 Ajouter à ma lsite</button> <a style="color: blue" class=" nav-link btn btn-outline-warning btn-sm" href="#" id="cmdAssign{{$livreur->id}}" data-toggle="modal" 
          data-target="#cmdAssignModal{{$livreur->id}}" >
          Assigner
        </a>
                
                        </li>

                       </ul> 
              
  </div>

  



  <div id="cmdAssignModal{{$livreur->id}}" class="modal fade cmdAssignModal" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
        <button type="button" id="close{{$livreur->id}}" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title">Assigner des Commandes à</h5>
        <br> <span style="color: green"> {{strtoupper($livreur->nom)}}</span> 
      </div>
      <div class="modal-body" id="assignCmd{{$livreur->id}}">
        
          @if($client_commands->count() > 0)
         @foreach($client_commands as $x=>$command)
         <ul id="cmdUl{{$livreur->id}}" class="border border-warning">
         <li>{{$command->id}} {{$command->adresse}} 
          
          <span class="info font-weight-light">Date de liv.:{{$command->delivery_date->format("d-m-Y")}}</span><br>
          <span id="cur_liv{{$livreur->id}}">
          @if($command->livreur_id != 11)
          <strong> Livreur actuel: {{strtoupper($command->livreur->nom)}}</strong>
          <?php $assign_text = "Réassigner"; ?>
          @else
          <?php $assign_text = "Assigner"; ?>
          Non assigné
          @endif
          </span>

          @if($command->livreur_id == $livreur->id) 
          <button type="button" value="{{$livreur->id}}" id="assbtn_{{$command->id}}" disabled   class="assign btn  btn-sm" data-cur="cur_liv{{$livreur->id}}"  data-id="{{$command->id}}" ><?php echo $assign_text; ?></button>
          @else
         <button type="button" data-cur="cur_liv{{$livreur->id}}" value="{{$livreur->id}}" id="assbtn_{{$command->id}}"   class=" assign btn btn-info btn-sm"    data-id="{{$command->id}}" ><?php echo $assign_text; ?></button>
          @endif 
        </li>
        
        </ul>
        

        @if($x > 15)
        @break
        @endif


         @endforeach 
         @else
         Pas de commande à assigner.
         @endif
         
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
         <button type="submit" class="btn btn-success" >Confirmer</button> 
      </div> -->
     
       
    </div>
  </div>
</div>

<script type="text/javascript">
       
        

     </script>

<div id="zoneAssignModal{{$livreur->id}}" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Assigner des Commandes a {{$livreur->nom}} </h4>
      </div>
      <div class="modal-body">
     
        @if($cmd_by_zone->count() > 0)
         @foreach($cmd_by_zone as $cmd)
         <ul id="cmdUl{{$livreur->id}}" class="border border-warning">
         <li>@foreach($fees as $fee)
          @if($fee->id == $cmd->fee_id)
          {{$fee->destination}}: {{$cmd->nbre}} commandes 
          @endif
          @endforeach

        </li>
        </ul>
         @endforeach 
         @else
         Pas de commande à assigner.
         @endif
            
           
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
        <button type="submit" class="btn btn-success" >Confirmer</button>
      </div>
      </form>
    </div>

  </div>
</div>



                @endforeach
                {{ $livreurs->links() }}
              @else
                      Aucun livreur disponible 

                      @endif

                
              
              
          </div>
          </div>
        </div>





@endsection







@section("script")

<script type="text/javascript">
  
  $(document).ready(function() {


      $('.cmdAssignModal').on('hidden.bs.modal', function () { 
  
            location.reload(true);
        }); 


 // Update record
$(".assign").click( function() {
  var cmd_id = $(this).data('id');
  var cur_liv = $(this).data('cur');
  var current_livreur = $("#"+cur_liv);
  var livreur_id = $(this).val();
  var current = $(this);
  
 

  
    $.ajax({
      url: 'assigncommand',
      type: 'post',
      data: {_token: CSRF_TOKEN,cmd_id: cmd_id,livreur_id: livreur_id},
      success: function(response){
         alert("Commande assigné à "+response.cur_liv);
         (current).attr("disabled","disabled");
         (current).text("Assigné à" +response.cur_liv);
         (current).attr("class", "assign btn  btn-sm");
         (current_livreur).html("<strong> Livreur actuel:"+response.cur_liv+ "</strong>");
         
         
      }
    });
  
});


// $(".cmdAssignModal").click( function() {
//   var cmd_id = $(this).data('id');

//   var livreur_id = $(this).val();
//   var current = $(this);
//   var cur_liv = $(this).id();
  
//     $.ajax({
//       url: 'assigncommand',
//       type: 'post',
//       data: {_token: CSRF_TOKEN,cmd_id: cmd_id,livreur_id: livreur_id},
//       success: function(){
//          alert("Commande assigné");
//          (current).attr("disabled","disabled");
//          (current).text("Assigné");
//          (current).attr("class", "assign btn  btn-sm");

         
         
//       }
//     });
  
// });





$(".unassign").click( function() {
  var cmd_id = $(this).data('id');

  var livreur_id = $(this).val();
  

  
    $.ajax({
      url: 'unassigncommand',
      type: 'post',
      data: {_token: CSRF_TOKEN,cmd_id: cmd_id,livreur_id: livreur_id},
      success: function(){
        alert("Commande Désassigné");
        $(this).attr("class","unassign btn btn-success btn-sm");
         $(this).val("Assigner");
      }
    });
  
});






    // $('#myTable').DataTable(  {

     


        
    // }  );



 $('#master').on('click', function(e) {
         if($(this).is(':checked',true))  
         {
            $(".sub_chk").prop('checked', true);  
         } else {  
            $(".sub_chk").prop('checked',false);  
         }  
        });


        $('.delete_all').on('click', function(e) {


            var allVals = [];  
            $(".sub_chk:checked").each(function() {  
                allVals.push($(this).attr('data-id'));
            });  


            if(allVals.length <=0)  
            {  
                alert("Veuillez seletionner commande.");  
            }  else {  


                var check = confirm("Confirmer?");  
                if(check == true){  


                    var join_selected_values = allVals.join(","); 


                    $.ajax({
                        url: $(this).data('url'),
                        type: 'POST',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: 'ids='+join_selected_values,
                        success: function (data) {
                            if (data['status']) {
                                $(".sub_chk:checked").each(function() {  
                                    $(this).parents("tr").remove();
                                });
                                alert(data['status']);
                            } else if (data['error']) {
                                alert(data['error']);
                            } else {
                                alert('Whoops Something went wrong!!');
                            }
                        },
                        error: function (data) {
                            alert(data.responseText);
                        }
                    });


                  
                }  
            }  
        });


        $('[data-toggle=confirmation]').confirmation({
            rootSelector: '[data-toggle=confirmation]',
            onConfirm: function (event, element) {
                element.trigger('confirm');
            }
        });


        $(document).on('confirm', function (e) {
            var ele = e.target;
            e.preventDefault();


            $.ajax({
                url: ele.href,
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    if (data['success']) {
                        $("#" + data['tr']).slideUp("slow");
                        alert(data['success']);
                    } else if (data['error']) {
                        alert(data['error']);
                    } else {
                        alert('Whoops Something went wrong!!');
                    }
                },
                error: function (data) {
                    alert(data.responseText);
                }
            });


            return false;
        });
       


        $("#filter").change(function(){
  $("#filter_form").submit();
});

 $('.mdb-select').materialSelect();       

} );


setTimeout(function(){
       location.reload();
   },600000);





</script>



@endsection









