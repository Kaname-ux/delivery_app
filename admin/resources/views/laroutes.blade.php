@extends("layouts.master")

@section("title")
{{$livreur->nom}}
@endsection




@section("content")
<style type="text/css">
  
  th { white-space: nowrap; }


  th { white-space: nowrap; }
  .modal { overflow: auto !important; }
</style>


<div class="content">


<div id="app">

  <div id="bulkAssign" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Assigner</h4>
      </div>
       <form class="d-inline"    method="POST" action="/bulk-assign">
                            @csrf
      <div class="modal-body">
     

       
              
       <div hidden id="bulkDiv"></div>

       <div class="form-group">
        <select name="livreur" class="form-control">
          <option>Choisir un livreur</option>
         @foreach($livreurs as $livreur2)
         <option value="{{$livreur2->id}}" >{{$livreur2->nom}}</option>
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


<div  class="modal fade" id="depositActionSheet" tabindex="-1" role="dialog">
            <div  class="modal-dialog" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title cmdModalTitle">Nouvelle commande</h5>
                        <a href="javascript:;" data-dismiss="modal">Fermer</a>
                        

                    </div>
                    <div   class="modal-body">
                        <div class="action-sheet-content">
        <form id="cmdform" action="command-fast-register" method="POST">
      @csrf


             

      <input id="cmdid" value="" hidden name="command_id">

      <div class="form-group">
      <label class="form-label">Nom du client</label>
      <input id="cmdcostumer" maxlength="150"  value="{{ old('costumer') }}"  name="costumer" class="form-control" type="text" placeholder="Nom du client" >
      </div>
      <div class="form-group">
      <label class="form-label">Nature du colis</label>
      <input id="cmdnature" maxlength="150" required value="{{ old('type') }}"  name="type" class="form-control" type="text" placeholder="Nature du colis" >
      </div>

      @if($sources->count() > 0)
<div class="form-group">
      <label class="form-label">Canal(Vous pouvez le faire plustard)</label>
      <select  id="cmdsource"    class="form-control" name="source">
        <option value="">Chosir le canal</option>
        @foreach($sources as $source)
      <option value="{{$source->type. '_'.$source->antity}}">{{$source->type. "_".$source->antity}}</option>
      @endforeach
      </select>
      @error('source')
      <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
      </span>
      @enderror
      </div>
      @endif
      <div class="form-group">
      <label class="form-label">Date de livraison</label>
      <input 
         min="
         <?php
            echo date('Y-m-d');
            ?>
         " required type="date" value="{{ old('delivery_date') }}" name="delivery_date" class="form-control" type="text" id="cmddate" >
      @error('delivery_date')
      <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
      </span>
      @enderror
      </div>
      <div class="form-group"> 
      <label class="form-label">Prix(sans la livraison)</label>
      <input id="cmdprice"  value="{{ old('montant') }}"  name="montant" class="form-control @error('montant') is-invalid @enderror" type="number" placeholder="Prix (sans la livraison)" autocomplete="off">
      @error('montant')
      <span class="invalid-feedback" role="alert">
      <strong>{{$massage}}</strong>
      </span>
      @enderror
      </div>

      <div class="form-group"> 
      <label class="form-label">Remise</label>
      <input id="cmdremise"  value="{{ old('montant') }}"  name="remise" class="form-control @error('montant') is-invalid @enderror" type="number" placeholder="Remise" autocomplete="off">
      @error('montant')
      <span class="invalid-feedback" role="alert">
      <strong>{{$massage}}</strong>
      </span>
      @enderror
      </div>

      <div class="form-group">
      <div class="form-row">
       <div class="col-8">
      <label class="form-label ">Ville/commune</label>
      <select id="cmddestination"  required  class="form-control" name="fee">
      <option  value="">selectionner Une ville/commune</option>
      @foreach($fees as $fee)
      <option 
      @if(old('fee') == $fee->id) selected @endif
      value="{{$fee->id}}">{{$fee->destination}}</option>
      <div id="fee_price"></div>
      @endforeach
      </select>
      @error('fee')
      <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
      </span>
      @enderror
      </div>
      

      <div class="col">
      <label class="form-label">Tarif livrai.</label>
      <select   required   class="form-control livraison" name="livraison">
        <option value="">Chosir</option>
      <option value="1000">1000f</option>
      <option value="1500">1500f</option>
      <option value="2000">2000f</option>
      <option value="2500">2500f</option>
      <option value="3000">3000f</option>
      <option value="0">Gratuit</option>
      <option value="autre">Autre</option>
      </select>
      @error('fee')
      <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
      </span>
      @enderror
      </div>
     </div> 
   </div>


     <div hidden class="form-group autre">
      <label class="form-label"> Saisir tarif de livraison</label>
      <input name="other_liv"  value="{{ old('other_liv') }}" id="cmdothfee"  class="form-control tarif" type="number" placeholder="" >
      </div>


      <div class="form-group">
      <label class="form-label"> Précision sur l'adresse de livraison</label>
      <input maxlength="150" value="{{ old('lieu') }}" id="cmdlieu" name="adresse" class="form-control" type="text" placeholder="Exemple: grand carrefour... pharmacie... rivera jardin..." >
      </div>
      <div class="form-row">
        <div class="col">
          <label class="form-label">Indicatif</label>
          <select class="form-control">
            <option>+225</option>
          </select>
        </div>
        <div class="col-8">
      <label class="form-label">Contact</label>
      <input id="cmdphone" value="{{ old('phone') }}" required  name="phone" class="form-control" type="number" placeholder="Numero du client sans l'indicatif(225)"  autocomplete="off">
      @error('phone')
      <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
      </span>
      @enderror
      </div> 
      <span class="contact_div"></span>        
      </div>




@if($livreurs->count() > 0)
<div class="form-group">
      <label class="form-label">Livreur(Vous pouvez le faire plustard)</label>
      <select      class="form-control livreur" name="livreur">
        <option value="">Chosir</option>
        @foreach($livreurs as $livreur)
      <option value="{{$livreur->id}}">{{$livreur->nom}}</option>
      @endforeach
      </select>
      @error('livreur')
      <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
      </span>
      @enderror
      </div>
      @endif



      <div class="form-group">
      <label  class="form-label"> Information supplementaire.</label>
      <input id="comobservation" maxlength="150" value="{{ old('observation') }}"  name="observation" class="form-control" type="text" placeholder="Information supplementaire">
      </div>


                                <div class="form-group basic">
                                    <button type="submit" class="btn btn-primary btn-block btn-lg"
                                        >Enregister</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>



<div id="bulkRep" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Reporter selection</h4>
      </div>
      <form class="d-inline"    method="POST" action="/bulk-report">
                            @csrf
      <div class="modal-body">
     

        
              
       <div hidden id="bulkReport"></div>

       <div class="form-group">
        <input class="form-control" type="date" name="report_date">
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



<div id="bulkSts" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">changer status selection</h4>
      </div>
       <form class="d-inline"    method="POST" action="/bulk-status">
                            @csrf
      <div class="modal-body">
     

       
              
       <div hidden id="bulkStatus"></div>

       <div class="form-group">
        
                            <select  class="form-control" name="etat">
                            <option 
                              value="">selectionner état</option>
                              @foreach($etats as $etat)
                              <option value="{{$etat}}">{{$etat}}</option>
                        
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




        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                 @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                <!-- <a target="top" href="https://maps.app.goo.gl/NtXUbskFr6R9F1t37">Sur sur google map</a> -->
                
                @if($wme ==! NULL)
                
                <a class="fa fa-whatsapp" href="https://wa.me/{{$wme}}?text=Jibia'T Admin: Votre application est votre outil de travail. N'oubliez pas de la mettre à jour!">Envoyer une alert whatsapp</a>
                @endif
                <h6 class="card-title">
                

                  La route du livreur: {{$livreur->nom}}</h6> 
                  <h6 >
                

                  {{$livreur->phone}}</h6>
               
              </div>
           

              <button class="btn btn-default" data-toggle="modal" data-target="#depositActionSheet" type="button">Nouvelle commande</button>

              <br><button class="btn btn-sm btn-secondary" id="assignButton" >
                            Assigner selection</button>


                            <button class="btn btn-sm btn-secondary" id="reportButton" >
                            Reporter selection</button>

                             <button class="btn btn-sm btn-secondary" id="statusButton" >
                            Changer status selection</button>

                             



                            <br>



                   <div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Nouvelle commande</h4>
      </div>
      <form target="_blank" action="/command-fast-register" method="POST">
              @csrf
      <div class="modal-body">
        
           <div class="form-group">
            <label class="form-label">Date de livraison
                            <input required type="date" name="delivery_date" class="form-control" type="text" >
                            </label>
            </div>

            <div class="form-group">
                            <input required value="" name="montant" class="form-control" type="text" placeholder="Montant">
            </div>

            

            

            <div class="form-group">
                            <select required id="fee"  class="form-control" name="fee">
                              <option  value="">selectionner adresse</option>
                              @foreach($fees as $fee)
                              <option  value="{{$fee->id}}">{{$fee->destination}} : {{$fee->price}} CFA</option>
                                
                                <div id="fee_price"></div>
                              @endforeach
                            </select>


                            
            </div>

            <div class="form-group">
                            <input  id="lieu" name="adresse" class="form-control" type="text" placeholder="Lieu de livraison" *>
            </div>

            <div class="form-group">
                            <input required value="" name="phone" class="form-control" type="text" placeholder="Contact">
            </div>

            <div class="form-group">
                            <input value="" name="observation" class="form-control" type="text" placeholder="Note">
            </div>

            


            



           <input hidden type="text" value="{{$livreur->id}}" name="livreur">
                       
            <div class="form-group">
                            <select class="form-control" name="client">
                              <option value="">selectionner Le client</option>
                              @foreach($clients as $client)
                              <option value="{{$client->id}}">{{$client->nom}}</option>
                        
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
                

                <p > {{$commands->count()}} Commande à livrer 
                

                 


                 @if($commands->count() >0)
               </p> <strong>{{$done}} </strong> Livré. {{$commands->count() - $done -$cancel}} Restant. {{$cancel}} Annulés.
                @endif

                
                <div class="float-right">
                <p >Montant terminé : <strong class="float-right">{{$done_montant}}</strong> </p>
                <p >Montant livraison : <strong class="float-right">{{$done_livraison}}</strong> </p>

                <p >Total : <strong class="float-right">{{$done_montant+$done_livraison}}</strong> </p>
                </div>
                 <h4 class="float-center">{{$day}}</h4>
                 <span class="border border-danger">
                  
                  @foreach($last_action as $last)
                  Dernière action: {{$last->action}} {{$last->action_date}}
                  @endforeach
                </span>
                <form  action='?bydate' class="float-right">
                  @csrf
                  <div class="form-group">
                    <label class="form-label">Date
                  <input class="form-control" type="date" name="route_day"></label>
                  <button type="submit" class="btn btn-primary">Choisir</button>
                  </div>
                </form>

   
                   <div>
                     <meta name="csrf-token" content="{{ csrf_token() }}" />

                       <ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Livraison</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Route</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Payment</a>
  </li>
</ul>
<div class="tab-content" id="myTabContent">

  <!--Livrison -->
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">@if($commands->count()>0)     
             
          <!--  <button  class="btn btn-danger btn-sm delete_all" data-url="{{ url('bulk-recup') }}">J'ai recupéré les selectionnés</button> -->
          

                 @include("includes.cmdtable")
               
                
       
        
                  @else
                      Aucune livraison 
                      @endif</div>
  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">@if($actions->count()>0)     
             
          <!--  <button  class="btn btn-danger btn-sm delete_all" data-url="{{ url('bulk-recup') }}">J'ai recupéré les selectionnés</button> -->
          

         
               
                  <table id="myTable" class="table">
                    <thead class=" text-primary">
                      <!-- <th><input type="checkbox" id="master"></th> -->
                      <th>
                       
                      
                        Action
                      </th>
                      <th>
                       Heure
                      </th>
                      

                      
                    </thead>
                    <tbody>
                      
                      @foreach($actions as $action)

                      <tr id="tr_{{$action->id}}">
                        <!-- <td>
                        
                         <input  data-id="{{$action->id}}" type="checkbox" class="sub_chk">
                         
                        </td> -->
                        <td>
                          {{$action->action}}
                       
                      </td>
                        <td>
                         {{$action->action_date->format('H:m')}}
                         
                        </td>

                        
                      </tr>


                      @endforeach

                    </tbody>
                   
                  </table>
        
        
                  @else
                      Aucune Action
                      @endif</div>
  <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">

    <div>Total à payer <strong class="float-right">{{$payment_sum}} </strong></div>
    @if($payments->count()>0)     
             
          <!--  <button  class="btn btn-danger btn-sm delete_all" data-url="{{ url('bulk-recup') }}">J'ai recupéré les selectionnés</button> -->
          

         
               
                  <table id="myTable" class="table">
                    <thead class=" text-primary">
                      <!-- <th><input type="checkbox" id="master"></th> -->
                      <th>
                       
                      
                        Payements
                      </th>
                      
                      <th>Date</th>

                      
                    </thead>
                    <tbody>
                      
                      @foreach($payments as $payment)

                      <tr id="tr_{{$payment->id}}">
                        <!-- <td>
                        
                         <input  data-id="{{$payment->id}}" type="checkbox" class="sub_chk">
                         
                        </td> -->
                       
                        <td>

                         <p> 
                           <span 
                          @if($payment->etat == 'en attente') 
                          class="badge badge-danger"
                          @endif

                         


                          @if($payment->etat == 'termine')
                          class="badge badge-success"
                          @endif
                          >{{$payment->etat}}</span><br>
                          <strong>{{$payment->montant}}</strong>
                           </p>
                          
                            @if($payment->client)
                           
                           #{{$payment->client->id}}
                          {{$payment->client->nom}}<br>
                          {{$payment->client->phone}}<br>
                          {{$payment->client->adresse}}

                          @else
                          Client non defini: contacté Admin
                          @endif
                         
                        </td>

                        <td>
                          @if($payment->payment_date)
                          {{$payment->payment_date->format('d-m-Y')}}
                          @endif
                        </td>
                        
                      </tr>


                     
                      @endforeach

                    </tbody>
                   
                  </table>
        
        
                  @else
                      Aucune payment 
                      @endif</div>
</div>
                  
             
                </div>
             
            </div>
          </div>
         <!-- Modal -->

          

        </div>
</div>
</div>
</div>
</div>

@endsection

@section("script")
<script type="text/javascript">
  $(document).ready(function() {
 
     $("#assignButton").click(function(){
 if($("#bulkDiv").children().length > 0)
      {$('#bulkAssign').modal('show');}
    else{alert("Veuillez selectionner commande");}
});

   $("#reportButton").click(function(){
 if($("#bulkReport").children().length > 0)
      {$('#bulkRep').modal('show');}
    else{alert("Veuillez selectionner commande");}
}); 


 $("#statusButton").click(function(){
 if($("#bulkStatus").children().length > 0)
      {$('#bulkSts').modal('show');}
    else{alert("Veuillez selectionner commande");}
});  


   


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


setTimeout(function(){
       location.reload();
   },2000000);

</script>

@endsection









