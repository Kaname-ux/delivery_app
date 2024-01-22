@extends("layouts.master")

@section("title")
espace livreur
@endsection




@section("content")

 <div id="app-div" >
  <button style="display: none;" class="btn btn-danger btn-block add-button">
  Installer l'application Livreur Jibiat</button>
 
  </div>



@foreach($errors->all() as $error)
      {{$error}}
     @endforeach

      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity= 
"sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
            crossorigin="anonymous"> </script>
       <script type="text/javascript">var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');</script>
        <div  class="row justify-content-center" style="margin-bottom: 40px; margin-right: 0; margin-left: 0">
                   
 

                       <script type="text/javascript">
                         $("#my_liv").click( function() {
                          $("#my_liv_form").submit();
                         });
                       </script>
          <div class="tab-content">
             <div id="home" class="tab-pane fade in active">

              
             @foreach($command_by_status as $status)
              @if($status->etat == "encours")
                    <div class="alert alert-danger">
                    <strong>Vous avez {{$status->nombre}} commandes à récuperer</strong>
                    </div>
                 
                  @endif
                 
                
                @endforeach


                <div style="color: green">
                Mes gains: {{array_sum($total_fees)}} FCFA
              </div>

                <div style="margin-left: 5px; margin-right: 5px; margin-bottom: 5px"> 
              


              <form  autocomplete="off" id="date-form" action='?bydate' class=" form-inline">
                    
                  @csrf
                  

                 

                  <div class="input-group  date">
                     
      <div class="input-group-prepend">
      <span class="input-group-text purple lighten-3" id="basic-text1"><i class="fas fa-calendar text-dark"
         aria-hidden="true">{{$day}}</i></span>
      </div>
      <input placeholder="Choisir une date"  id="day" class="form-control" type="text" onfocus="(this.type='date')" name="route_day">
      </div>
                  <button id="submit_day" hidden type="submit" class="btn btn-primary">Choisir</button>
                  
                </form>
              </div>
              
             @if($commands->count()>0)     
             <div >
               @foreach($final_destinations as $destination=> $nomber)
               {{$destination}}({{ $nomber}})
               @endforeach
               <a class="btn btn-success btn-sm float-right" href="sms:@foreach($commands as $x=>$client_phone)
              @if($client_phone->etat != 'termine' && $client_phone->etat != 'annule')
               @if($x == 19 || $x == $commands->count()-1)
               {{substr(preg_replace('/[^0-9]/', '',$client_phone->phone), 0, 8)}}
               <?php break; ?>
               @else
               {{substr(preg_replace('/[^0-9]/', '',$client_phone->phone), 0, 8)}},
               @endif
               @endif
               @endforeach
                ?body=Bonjour! je suis {{Auth::user()->name}}  votre livreur. soyez rassuré, Je viens vous livrer aujourd'hui. Vous pouvez me joindre au {{$livreur->phone}} pour plus de détails.">SMS aux client</a>
                  
                  
                </div>

                <div  id="clientModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div  class="modal-content">
      <button type="button"  class="close btn bt" data-dismiss="modal">&times;</button>
     
      <div  id="clientModalBody" class="modal-body">
       
    </div>

  </div>
  
</div>
</div>



           @foreach($commands as $command)
            @if($command->etat != 'annule')  
             
            <div id="noteModal{{$command->id}}" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Ajouter une note: {{$command->id}}</h4>
      </div>
      <div class="modal-body">
     

        <form class="d-inline"    method="POST" action="deliv-note">
                            @csrf
              
       
       <input hidden="hidden" type="text" name="command_id" value="{{$command->id}}">

        <input hidden="hidden" type="text" name="client_phone" value="{{$command->client->phone}}">

        <input hidden="hidden" type="text" name="command_phone" value="{{$command->phone}}">

       <div class="form-group">
        <select  id="d2{{$command->id}}" required="required" name="note" class="form-control">
          <option value="">Choisir une note</option>
         @foreach($notes as $note)
         <option value="{{$note}}" >{{$note}}</option>
         @endforeach
         </select>
       </div>
      <div id="noteDateDiv{{$command->id}}" class="form-group" >
         <label hidden="hidden" class="form-label" id="lab{{$command->id}}">
          Date de report
           <input class="form-control" id="report_date{{$command->id}}" type="date" name="report_date">
         </label>
       </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
        <button type="submit" class="btn btn-success" >Confirmer</button>
      </div>
      </form>
    </div>

  </div>
</div>


<div id="noteViewModal{{$command->id}}" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Note: {{$command->id}} ({{$command->note->count()}}) </h4>
      </div>
      <div class="modal-body">
        @if($command->note->count()>0)
     @foreach( $command->note->sortByDesc('created_at')  as $one)
     <p>{{$one->created_at->format('H:m:i')}} - {{$one->description}}  </p>
      @endforeach  
      @endif
    </div>

  </div>
</div>
</div>

<script type="text/javascript">

         $("#d2{{$command->id}}").change(function(){
          if($(this).children("option:selected").val() == "Reporté par le client")
           {$("#lab{{$command->id}}").removeAttr("hidden");
             $("#report_date{{$command->id}}").attr("required", "required");}

             else{
              $("#lab{{$command->id}}").attr("hidden", "hidden");
             $("#report_date{{$command->id}}").removeAttr("required");
             }
            });
   
                          
                           
                         </script>   
            <div   class="card border border-dark" style="width: 100%;">          
            <ul class="list-group list-group-flush">

               <li  class=" list-group-item">
                <div>
                 <span>
                    @if($command->etat == 'encours')

                          <div class="input-group">
    <div class="input-group-prepend">
      <div class="input-group-text" id="btnGroupAddon">{{$command->etat}} <span class="float-left"  style="font-size: 20px; font-weight: bold;"> #{{$command->id}} </span></div>
    </div>

     <button style="font-size: 20px; " data-id="{{$command->id}}" value="recupere" name="etat"  class="btn btn-danger recup form-control" type="">
        Je Recupère
    </button>

    <button style="font-size: 20px; " data-id="{{$command->id}}" id="scndDep{{$command->id}}" hidden value="en chemin" name="etat"  class="btn btn-warning recup form-control" >
                           
                               Je Démarre
                          
                            </button>
                            
                            <button style="font-size: 20px;" hidden data-id="{{$command->id}}" id="liv{{$command->id}}"  value="termine" name="etat"  class="btn btn-success recup form-control" >
                           
                               Je livre
                          
                            </button>
    
  </div>
                         
                           

                           

                           
                              
                          

                          @endif

                          @if($command->etat == 'recupere')


                          <div class="input-group">
    <div class="input-group-prepend">
      <div class="input-group-text" id="btnGroupAddon">{{$command->etat}} <span class="float-left"  style="font-size: 20px; font-weight: bold;"> #{{$command->id}} </span></div>
    </div>

    

          <button style="font-size: 20px;" data-id="{{$command->id}}" id=""  value="en chemin" name="etat"  class="btn btn-warning recup form-control" >
                           
                              Je Demarre
                          
                            </button>
    
  </div>
                          
                            @endif
                          
                         
                          
                          @if($command->etat == 'en chemin')


                          <div class="input-group">
    <div class="input-group-prepend">
      <div class="input-group-text" id="btnGroupAddon">{{$command->etat}} <span class="float-left"  style="font-size: 20px; font-weight: bold;"> #{{$command->id}} </span></div>
    </div>

    

                    <button style="font-size: 20px;" data-id="{{$command->id}}" id=""  value="termine" name="etat"  class="btn btn-success recup form-control" >
                           
                               Je livre
                          
                            </button>        
    
  </div>
                          
                          
                             @endif


                              @if($command->etat == 'termine')


                          <div class="input-group">
    <div class="input-group-prepend">
      <div class="input-group-text" id="btnGroupAddon">Terminé <span class="float-left"  style="font-size: 20px; font-weight: bold;"> #{{$command->id}} </span></div>
    </div>

    

                    <button style="font-size: 20px;"   class="btn btn-success" >
                           
                               <i class="fa fa-check"></i>
                          
                            </button>        
    
  </div>
                          
                          
                             @endif
                          <!-- <form method="POST" action='command-update/{{$command->id}}'>
                            @csrf
                            <button  value="termine" name="etat" type="submit" class="btn btn-success" type="">Livrer</button> <span  style="font-size: 30px; font-weight: bold;"> #{{$command->id}} </span>
                            
                          </form> -->
                       </span>   

                     
                     
                   
       
       <!--  <a  class="float-right nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink{{$command->id}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Assigner
        </a>
        <div class="dropdown-menu bg-light " aria-labelledby="navbarDropdownMenuLink{{$command->id}}">
          <a class="dropdown-item  border" data-toggle="modal" 
          data-target="#cmdAssignModal{{$command->id}}"  id="cmdAssign{{$command->id}}" href="#">
          Commandes</a>
          <a class="dropdown-item  border" data-toggle="modal" data-target="#zoneAssignModal{{$command->id}}" id='zoneAssign{{$command->id}}' href="#">Zones</a>
        </div> -->

        <span class="float-right">
                          
                          @if($command->note->count()>0) 
                          <br>
                          <a data-toggle="modal" data-target="#noteViewModal{{$command->id}}" href="#">Voir note</a>
                          
            </span>       

              </div>   
  
                        @endif
                        
                       
                           
                          <div  style="color: green; text-align: left;">{{$command->description}} 
                          @if($command->ready == 'yes') 
                          <img width="30" height="30" src="/assets/img/packing.ico">
                          @endif
                         
                        </div>

                          
                          
                         <span style="background-color: black;" class=" text-white">Total: {{$command->fee->price + $command->montant}}CFA  </span><br>
                          <strong style="font-size: 20px">{{$command->adresse}}</strong><br>
                          <span style="font-size: 20px">{{$command->phone}}</span><span class="float-right">

                            <button data-toggle="modal" data-target="#noteModal{{$command->id}}"  class="btn btn-warning">
                            <i class="fas fa-edit"></i>
                          </button>

                            <a class="btn btn-primary " href="sms:{{substr(preg_replace('/[^0-9]/', '',$command->phone), 0, 8)}}?body=Bonjour! je {{Auth::user()->name}} suis votre livreur Jibiat. Je viens vous livrer aujourd'hui. Veuillez rester à l'écoute."><i class="fas fa-sms"></i></a>
                          <a href="tel:{{$command->phone}}" class="btn btn-info ">
                 <i class="fas fa-phone"></i>
                 
                     </a></span>
  
                     <br> 

                    
                   

                   @if($command->observation)
                          
                          Note:<strong style="color: red;">{{$command->observation}}</strong>
                          <br>
                          @endif
                          <br>
Vendeur: 
                            @if($command->client)
                           
                           
                    {{$command->client->nom}} <a class="clientDetail" data-address="{{$command->client->adresse}}" data-phone="{{$command->client->phone}}" data-client="{{$command->client->nom}}" href="#">Voir détails</a>
                           
                         
                          
                          

                          @else
                          Client non defini: contacté Admin
                          @endif
                
                
                
              </li>

              

             
                       </ul> 
              
  

  
</div>


  

               @endif
                @endforeach
               


               
            
              @else
                     Pas de livraison encours
                  
                      @endif


                      
                      
                
    </div>        
    <div id="menu1" class="tab-pane fade">
      <h3>Payment</h3>
     @if($payments->count()>0)  
      @foreach($payments as $payment)
                      @if($payment->montant > 0)
                      @foreach($clients as $client)
                      @if($client->id == $payment->client_id)
      <div   class="card border border-dark" style="width: 100%;"> 

            <ul class="list-group list-group-flush">

               <li style="font-weight: bold" class="pt-6 list-group-item">
                
                          {{$client->nom}}<br>
                          
                          <strong>{{$payment->montant}}</strong>
             </li>
             </ul>
      </div>   

      @endif                    
                     
      @endforeach
                     
                    @endif
                      @endforeach






                      @else
                      Il n'y a aucun impayé
                      @endif
    </div>
    <div id="menu2" class="tab-pane fade">
      <h3>Retours</h3>
      
    </div>
    
  </div>
              
          </div>
          </div>
        </div>


@if(session('success'))
<a hidden id="success" href="{{session('success')}}"></a>

<script type="text/javascript">
  document.getElementById("success").click();
</script>
@endif


@if(session('facture'))
<a hidden id="facture" href="{{session('facture')}}"></a>

<script type="text/javascript">
  document.getElementById("facture").click();
</script>
@endif

@if(session('note_message'))
<a hidden id="note_message" href="{{session('note_message')}}"></a>

<script type="text/javascript">
  document.getElementById("note_message").click();
</script>
@endif


@endsection







@section("script")

<script type="text/javascript">
  
  $(document).ready(function() {
    

    $(".clientDetail").click( function() {
   var phone = $(this).data('phone');
   var adress = $(this).data('address');
   var client = $(this).data('client');
   $("#clientModalBody").html('<span>'+client+'<br>'+adress+'<br>'+phone+'</span><br>'+ '<a href="tel:'+phone+'" class="btn btn-info btn-block"><i class="fas fa-phone">Appler le Vendeur</i></a><a class="btn btn-primary btn-block" href="sms:'+phone+'?body=Bonjour! je suis {{Auth::user()->name}}  livreur Jibiat. J ai bien recu la commnde, je viens vers vous."><i class="fas fa-sms">Envoyer un SMS au Vendeur</i></a>');
      $("#clientModal").modal("show");});  
   

    $("#day").change(function(){
    $("#submit_day").click();
   });

     $(".recup").click( function() {
   var cmd_id = $(this).data('id');
   var etat = $(this).val();
   var btn = $(this);
   if(etat == "recupere")
   {var wait = "Récuperation...";}
    else
    {var wait = "Mise en chemin...";}
  $(this).html('<span id="recupSpin'+cmd_id+'"  class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only"></span><span id="wait">'+wait);
  btn.attr('disabled', 'disabled');
     $.ajax({
       url: 'recup',
       type: 'post',
       data: {_token: CSRF_TOKEN,cmd_id: cmd_id, etat:etat},
       success: function(response){
        if(etat == 'recupere')   
       {(btn).attr('hidden', 'hidden');
               $('#scndDep'+cmd_id).removeAttr("hidden");
               
               $("#stateModalBody").html(response.message);
               $("#stateModal").modal("show");
               $("#state_c"+cmd_id).attr("class", "badge badge-warning")
               setTimeout(function(){$('#stateModal').modal('hide')}, 1000);
           }
        else if(etat == 'en chemin')
        {
          
          $('#scndDep'+cmd_id).html('<span id="recupSpin'+cmd_id+'"  class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only"></span><span id="wait">Prêt pour le départ...</span>');
          $('#scndDep'+cmd_id).attr("class", "btn btn-success");
               
               setTimeout(function(){location.reload();}, 1000);
        }

        else
        {
          
          $('#liv'+cmd_id).html('<span id="livSpin'+cmd_id+'"  class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only"></span><span id="wait">Une livraison de plus...</span>');
          $('#liv'+cmd_id).attr("class", "btn btn-success");
               
               setTimeout(function(){location.reload();}, 1000);
        }


   
 $("#set").click();







      },
      error: function(){

      }
     });
   });  
});

 




</script>



@endsection









