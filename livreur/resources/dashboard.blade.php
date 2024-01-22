@extends("layouts.master")

@section("title")
Espace livreur
@endsection




@section("content")
<style type="text/css">
  
  th { white-space: nowrap; }


  /* Style the tab */
.tab {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
 position: relative;
 top: 5px;
}

/* Style the buttons that are used to open the tab content */
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
  background-color: #ccc;
}

/* Style the tab content */
/*.tabcontent {
  display: none;
  
  border: 1px solid #ccc;
  border-top: none;

}*/



.tabcontent {
  animation: fadeEffect 1s; /* Fading effect takes 1 second */
}

/* Go from zero to full opacity */
@keyframes fadeEffect {
  from {opacity: 0;}
  to {opacity: 1;}
}

</style>
<div class="tab">
  <button class="tablinks" id="defaultOpen" onclick="openCity(event, 'london')">Livraison({{$commands->count()}})</button>
  <button class="tablinks" onclick="openCity(event, 'Paris')">Payment({{$real_payments->count('client_id')}})</button>

  <button class="tablinks" onclick="openCity(event, 'retour')">Retour({{$retours->count('client_id')}})</button>
  
</div>

<div id="london" class="tabcontent">
<div class="content">

  




        <div class="row ">

          
            <div class="card">
              <div class="card-header">
                 @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                <h6 class="card-title">Liste de livraison: {{Auth::user()->name}}</h6>
                <div class="col-md-6">
                 <div>
                  <div class="border border-danger rounded">
                <div>Total livré 
                <strong class=" float-right">
                {{$done->sum('montant') + array_sum($done_fees)}} FCFA ({{$done->count()}}) 
                </strong> 
                </div>
                @foreach($command_by_status as $status)
                <strong>{{$status->etat}}({{$status->nombre}})</strong> |
                @endforeach
              </div>
               </div>
              </div>
              </div>




              <div id="bulkAssign" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Assigner</h4>
      </div>
      <div class="modal-body">
     

        <form class="d-inline"    method="POST" action="bulk-assign">
                            @csrf
              
       <div hidden id="bulkDiv"></div>

       <div class="form-group">
        <select name="livreur" class="form-control">
          <option>Choisir un livreur</option>
         @foreach($livreurs as $livreur)
         <option value="{{$livreur->id}}" >{{$livreur->nom}}</option>
         @endforeach
         </select>
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


                
              
              <div class="card-body">
                <div class="table-responsive">
                



                          <div class="container box">
   
                   <div>
                    
                  
             @if($commands->count()>0)  
             <!-- <button class="btn btn-primary btn-sm">Prendre ma pose(30mns)</button> -->   
             
           <button  class="btn btn-danger btn-sm delete_all" data-url="{{ url('bulk-recup') }}">J'ai recupéré les selectionnés</button>

            <button class="d-inline btn btn-warning btn-sm" id="assignButton" >
                            Je relais les selectionnés</button>



           <meta name="csrf-token" content="{{ csrf_token() }}" />
               <p>Vous avez {{$commands->count()}} Commande à livrer aujourd'hui.</p>
               @foreach($final_destinations as $destination=> $nomber)
               {{$destination}}({{ $nomber}})
               @endforeach

               <a class="btn btn-success btn-sm" href="sms:@foreach($commands as $x=>$client_phone)
               @if($x == 19 || $x == $commands->count()-1)
               {{substr(preg_replace('/[^0-9]/', '',$client_phone->phone), 0, 8)}}
               <?php break; ?>
               @else
               {{substr(preg_replace('/[^0-9]/', '',$client_phone->phone), 0, 8)}},
               @endif
               
               @endforeach
                ?body=Bonjour! je suis {{Auth::user()->name}} votre livreur Jibiat. Je viens vous livrer aujourd'hui. Veuillez rester à l'écoute.">SMS à tous les clients(20max)</a>

                @if(count($client_phones)>0)
                <a class="btn btn-warning btn-sm" href="sms:@foreach($client_phones as $x=>$phone)
               @if($x == 19 || $x == count($client_phones)-1)
               {{substr(preg_replace('/[^0-9]/', '',$phone), 0, 8)}}
               <?php break; ?>
               @else
               {{substr(preg_replace('/[^0-9]/', '',$phone), 0, 8)}},
               @endif
               
               @endforeach
                ?body=Bonjour! je suis {{Auth::user()->name}} votre livreur Jibiat. Je viens Recuperer vos livraisons aujourd'hui. Veuillez rester à l'écoute.">SMS aux fournisseur(20max)</a>
                @endif
                  <table id="myTable" class="table table-striped">
                    <thead class=" text-primary">
                      <th><input type="checkbox" id="master"></th>
                      <th>
                       
                      
                        Action
                      </th>
                      <th>
                       Commande
                      </th>

                      
                    </thead>
                    <tbody>
                      
                      @foreach($commands as $command)

                      <tr id="tr_{{$command->id}}">
                        <td>
                        
                         <input onclick="add{{$command->id}}()" id="d{{$command->id}}"  data-id="{{$command->id}}" type="checkbox" class="sub_chk">


                          <script type="text/javascript">
                           function add{{$command->id}}()
                           {
                            var bulkDiv = document.getElementById("bulkDiv");
                            var node = document.getElementById("d{{$command->id}}");
                            
                             var x = document.createElement("INPUT");
                                x.setAttribute("type", "checkbox");
                                x.setAttribute("name", "commands[]");
                                x.setAttribute("value", "{{$command->id}}");
                                x.setAttribute("checked", "checked");
                                x.setAttribute("id", "{{$command->id}}");

                            if (node.checked == true){
                                                     
                                                        bulkDiv.appendChild(x);
                           
                                                    } else {
                           
                                                       document.getElementById("{{$command->id}}").remove();
                                                             }
                            }
                           
                         </script>
                         
                        </td>
                        <td>

                          
                          @if($command->observation)
                          
                          Note:{{$command->observation}}
                          <br>
                          @endif
                          
                          @if($command->etat == 'encours')

                         
                           


                          <form method="POST" action='command-update/{{$command->id}}'>
                            @csrf
                            <button value="recupere" name="etat" type="submit" class="btn btn-danger" type="">

                           
                          Récuperer
                           </button>
                            
                          </form>

                          @endif

                          @if($command->etat == 'recupere')
                          <form  method="POST" action='command-update/{{$command->id}}'>
                            @csrf
                            <button value="en chemin" name="etat" type="submit" class="btn btn-warning" type="">

                              @if($command->loc == 'jb')
                          Depart (base)
                          @else
                              Depart
                          @endif
                            </button>
                            
                          </form>

                            <p></p>
                          
                            <button class="btn btn-default" data-toggle="modal" data-target="#myModal{{$command->id}}" type="button">Relayer</button>
                            
                          

                          @endif

                          @if($command->etat == 'en chemin')
                          <form method="POST" action='command-update/{{$command->id}}'>
                            @csrf
                            <button value="termine" name="etat" type="submit" class="btn btn-success" type="">Livrer</button>
                            
                          </form>

                          @endif
                      </td>
                        <td>
                         <p  style="color: green; text-align: left;">{{$command->description}}</p>
                         <p> 
                           <span 
                          @if($command->etat == 'encours') 
                          class="badge badge-danger"
                          @endif

                          @if($command->etat == 'recupere')
                          class="badge badge-warning"
                          @endif

                          @if($command->etat == 'en chemin')
                          class="badge badge-warning"
                          @endif


                          @if($command->etat == 'termine')
                          class="badge badge-success"
                          @endif
                          >{{$command->etat}}</span><br>
                          <a class="btn btn-primary btn-sm" href="sms:{{substr(preg_replace('/[^0-9]/', '',$command->phone), 0, 8)}}?body=Bonjour! je {{Auth::user()->name}} suis votre livreur Jibiat. Je viens vous livrer aujourd'hui. Veuillez rester à l'écoute.">SMS Me</a>
                          <a href="tel:{{$command->phone}}" class="btn btn-info btn-sm">
                 <i class="fas fa-phone">Appeler</i>
                 
                     </a><br>

                          <strong>

                            Livrer ici:
                          #{{$command->id}}
                          {{$command->adresse}}<br> 
                          {{$command->phone}}<br> {{$command->fee->price + $command->montant}}CFA

                          
                           </strong>
                           </p>
                           Recuperer ici <br>
                            @if($command->client)
                           <a class="btn btn-primary btn-sm" href="sms:{{$command->client->phone}}?body=Bonjour! je suis  votre livreur Jibiat. Votre commande a été prise en compte, je passerai recuperer aujoud'hui. Veuillez rester à l'écoute.">SMS Me</a>
                           <a href="tel:{{$command->client->phone}}" class="btn btn-info btn-sm">
                 <i class="fas fa-phone">Appeler</i>
                 
                     </a><br>
                           #{{$command->client->id}}
                          {{$command->client->nom}}<br>
                          {{$command->client->phone}}<br>
                          {{$command->client->adresse}}

                          @else
                          Client non defini: contacté Admin
                          @endif
                         
                        </td>
                        
                      </tr>


                      <div id="myModal{{$command->id}}" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Je remet le colis à</h4>
      </div>
      <div class="modal-body">
        <form method="POST" action="relay/{{$command->id}}">
          @csrf
          <div class="form-group">
          <select name="relais" required class="form-control">
            <option>Choisir un livreur</option>
          @foreach($livreurs as $livreur)
          <option value="{{$livreur->id}}">{{$livreur->nom}}</option>
          @endforeach
          </select>
          </div>
          <div class="form-group">
          <input placeholder="Lieu du relais" class="form-control" type="text" name="lieu">
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
                      @endforeach

                    </tbody>
                   
                  </table>
                  @else
                      Vous n'avez aucune livraison aujourd'hui
                      @endif
                </div>
              </div>
            </div>
          </div>
         <!-- Modal -->

          

        </div>

</div>
</div>
</div>

<!-- Payements -->
<div id="Paris" class="tabcontent">
<div class="content">





 
        <div class="row">
        
            <div class="card">
              <div class="card-header">
                 @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                <h6 class="card-title">Liste de Payment: {{Auth::user()->name}}</h6>
               
              </div>

                
              
              <div class="card-body">
                <strong>Total = {{$payments->sum('montant')}}</strong>
                <div class="table-responsive">
                



                          <div class="container box">
   
                   <div>
                    
                  
             @if($payments->count()>0)     
             
           
          
               <p>Il vous reste {{$real_payments->count('client_id')}} clients à payer.</p>
                  <table id="myTable2" class="table">
                    <thead class=" text-primary">
                      
                      <th>
                       
                      
                        Action
                      </th>
                      <th>
                       Payment
                      </th>

                      
                    </thead>
                    <tbody>
                      
                      @foreach($payments as $payment)
                      @if($payment->montant > 0)
                      @foreach($clients as $client)
                      @if($client->id == $payment->client_id)
                      <tr id="tr_{{$payment->id}}">
                        
                        <td>
                        
                          
                           <button class="btn btn-default" data-toggle="modal" data-target="#myModal{{$payment->client_id}}" type="button">Payer</button>

                          
                      </td>
                        <td>

                        
                           
                           #{{$payment->client_id}}
                          {{$client->nom}}<br>
                          {{$client->phone}}<br>
                          {{$client->adresse}}<br>
                          <strong>{{$payment->montant}}</strong>
                          <!-- <a data-toggle="modal" data-target="#payDetail" class="badge badge-success" href="#">Voir détail</a> -->





                          
                         
                        </td>
                        
                      </tr>
                    

                      <div id="myModal{{$payment->client_id}}" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Payment</h4>
      </div>
      <div class="modal-body">
        <form method="POST" action="pay-update/{{$payment->client_id}}">
          @csrf
          <div class="form-group">
          <select name="pay_methode" required class="form-control">
            <option value="">Choisir moyen de payement</option>
         
          
          <option value="Main a Main">Main à main</option>
          <option value="Mobile money">Mobile money</option>
          
          </select>

          <p>Pour les payement mobile money exiger un reçu.</p>
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



 



  @endif                    
                     
      @endforeach
                     
                    @endif
                      @endforeach

                      @else
                      Vous n'avez aucun payement aujourd'hui
                      @endif

                    </tbody>
                   
                  </table>

                 


                  
                  
                </div>
              </div>
            </div>
          </div>
 </div>        <!-- Modal -->
</div>
</div>
</div>

       <div id="retour" class="tabcontent">
<div class="content">





 
        <div class="row">
          
            <div class="card">
              <div class="card-header">
                 @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                <h6 class="card-title">Liste de retour: {{Auth::user()->name}}</h6>
               
              </div>

                
              
              <div class="card-body">
                <strong>Total = {{$retours->sum('nombre')}}</strong>
                <div class="table-responsive">
                



                          <div class="container box">
   
                   <div>
                    
                  
             @if($retours->count('client_id')>0)     
             
           
          
               <p>Il vous reste {{$retours->count('client_id')}} retours.</p>
                  <table id="myTable2" class="table">
                    <thead class=" text-primary">
                      
                      <th>
                       
                      
                        Action
                      </th>
                      <th>
                       Retours
                      </th>

                      
                    </thead>
                    <tbody>
                      
                      @foreach($retours as $retour)
                    
                      @foreach($clients as $client)
                      @if($client->id == $retour->client_id)
                      <tr id="tr_{{$retour->id}}">
                        
                        <td>
                        
                          <form method="post" action="retour">
                             @csrf
                           <button class="btn btn-default" value="{{$retour->client_id}}" name="client_id" type="submit">Retourner</button>
                          </form>
                          
                      </td>
                        <td>

                        
                           
                           #{{$retour->client_id}}
                          {{$client->nom}}<br>
                          {{$client->phone}}<br>
                          {{$client->adresse}}<br>
                          <strong>{{$retour->nombre}} colis</strong>
                          <!-- <a data-toggle="modal" data-target="#payDetail" class="badge badge-success" href="#">Voir détail</a> -->





                          
                         
                        </td>
                        
                      </tr>


                      <div id="myModal{{$retour->client_id}}" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Payment</h4>
      </div>
      <div class="modal-body">
        <form method="POST" action="pay-update/{{$retour->client_id}}">
          @csrf
          <div class="form-group">
          <select name="pay_methode" required class="form-control">
            <option value="">Choisir moyen de payement</option>
         
          
          <option value="Main a Main">Main à main</option>
          <option value="Mobile money">Mobile money</option>
          
          </select>

          <p>Pour les payement mobile money exiger un reçu.</p>
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



 



  @endif                    
                     
      @endforeach
                     

                      @endforeach

                      @else
                      Vous n'avez aucun retour
                      @endif

                    </tbody>
                   
                  </table>

                 


                  
                  
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
@endsection

@section("script")
<script type="text/javascript">


// Get the element with id="defaultOpen" and click on it


 document.getElementById("defaultOpen").click();



function openCity(evt, cityName) {


  // Declare all variables
  var i, tabcontent, tablinks;

  // Get all elements with class="tabcontent" and hide them
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }

  // Get all elements with class="tablinks" and remove the class "active"
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }

  // Show the current tab, and add an "active" class to the button that opened the tab
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}




// endtap script


  $(document).ready(function() {
   
   $("#assignButton").click(function(){
 if($("#bulkDiv").children().length > 0)
      {$('#bulkAssign').modal('show');}
    else{alert("Veuillez selectionner commande");}
});

    $('#myTable').DataTable(  {

     "paging": false,

     "oLanguage": {
 
  "sZeroRecords": "Aucun résultat trouvé",
  
}


        
    }  );



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




} );


</script>

@endsection









