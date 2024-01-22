@extends("layouts.master")

@section("title")
{{$client->nom}}
@endsection




@section("content")
<style type="text/css">
  
  th { white-space: nowrap; }

  .stamp {
  transform: rotate(12deg);
  color: #555;
  font-size: 2rem;
  font-weight: 700;
  border: 0.25rem solid #555;
  display: inline-block;
  padding: 0.25rem 1rem;
  text-transform: uppercase;
  border-radius: 1rem;
  font-family: 'Courier';
  -webkit-mask-image: url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/8399/grunge.png');
  -webkit-mask-size: 470px 302px;
  mix-blend-mode: multiply;
}


.is-approved {
  color: #0A9928;
  border: 0.5rem solid #0A9928;
  -webkit-mask-position: 13rem 6rem;
  transform: rotate(-14deg);
  border-radius: 0;
} 
</style>



<div class="content">

@foreach($errors->all() as $error)
      {{$error}}
     @endforeach

        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                 @if (session('status') && session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                  @endif
                    @if(session('new_id'))
                    
                    <div class="alert alert-danger" role="alert">         
                <h3>Numero de commande {{ session('new_id') }}</h3> Inscrivez ce numero au marker sur votre colis(pas besoin d'autres information). <!-- Nous nous chargeaons du reste. -->  
               </div>
               @endif 
                    
               

             
                  
               
                <div class="card-title">
                



               
                <!-- <img src="../assets/img/Jibiatlogo.jpg"> --> {{$client->nom}}  </div> 


                <div class="card text-white bg-secondary mb-3" style="width: 100%;">
  <!-- <div class="card-header">Header</div> -->
  <div class="card-body">
    <h5 class="card-title">Total  <strong class="float-right">{{$total}}({{$commands->count()}})</strong></h5>
    <h5 class="card-title">Livré  <strong class="float-right">{{$done_montant}}({{$done}})</strong></h5>
    <h5 class="card-title">Annulé  <strong class="float-right">{{$canceled_montant}}({{$cancel}})</strong></h5>
    
  </div>
</div>

 <div class="card text-white bg-primary mb-3" style="width: 100%;">
  <!-- <div class="card-header">Header</div> -->
  <div class="card-body">
    <h6 class="card-title">Non préparé  <strong class="float-right">{{$commands->count()-$ready}}</strong></h6>
    <h6 class="card-title">Non assigné  <strong class="float-right">{{$assigned->count()}}</strong></h6>
    
  </div>
</div>

                  
               <!--  @if($assigned->count() == 0 && $commands->count()>0)
                     <div class="alert alert-success" > 
                     <strong style="color: black;">        
                Toutes vos commandes sont assignées
                </strong>
               </div>
               @else
               <div class="alert alert-warning" > 
                <strong style="color: black;">
               @if($assigned->count() == 1)        
                Vous avez 1 commande à assigner
                @else
                Vous avez {{$assigned->count()}} commandes à assigner
                @endif
                </strong>
               </div>
               @endif -->
               
                  @if(session('phone_check'))
<!-- Modal content-->
<div class="alert alert-danger">
ATTENTION
Vous avez déja enregistré une  commande avec ce numéro aujourd'hui<br>
 

<p><strong>{{session('phone')}}</strong></p>

 </div>     


     
       
        <form   action="/command-fast-register" method="POST">
              @csrf
           
           
          <div hidden="hidden">
                   <input type="text" name="confirm" value="yes">
                  <input required value="{{ session('goods_type') }}"  name="type"  type="text" >
                    <input type="text"   required  value="{{ session('delivery_date') }}" name="delivery_date"  >
                  <input  value="{{ session('montant') }}"  name="montant"  type="text" >
                   <input value="{{ session('fee_id') }}"  required id="fee"  name="fee">
                  <input value="{{ session('adresse') }}" name="adresse"  type="text"  >
                 <input value="{{ session('phone') }}" required  name="phone"  type="text" >
                <input maxlength="150" value="{{ session('observation') }}"  name="observation"  type="text" >
            </div>


        <button type="submit" class="btn btn-success" >Confirmer?</button>
       <a href="/dashboard" class="btn btn-success" >Annuler</a>
      </form>
   

@endif

                  
                

                  </div>
                  <div class="col-md-6">
                 <div>
                  @if($commands_by_livreurs->count()>0)
                    Point par livreur
                    @endif
                  <div class="border border-danger rounded">

                <div>

                 @foreach($commands_by_livreurs as $x=> $by_livreur) 
                 @foreach($livreurs as $livreur2)
                 @if($livreur2->id == $by_livreur->livreur_id)
                 {{$livreur2->nom}}:<br>
                 @endif
                 @endforeach 
                <strong class=" float-right">
                {{$by_livreur->montant}} @if($payed_by_livreurs->count()>0) @foreach ($payed_by_livreurs as $payed) @if($payed->livreur_id == $by_livreur->livreur_id) Payé: {{$payed->montant}} <strong style="color: red"> Reste: {{$by_livreur->montant-$payed->montant}} </strong> @endif @endforeach @endif
                </strong> <br>
                @if($x >= 6)
                @break
                <a href="">Voir la suite</a>
                @endif
                @endforeach
                
                </div>
              </div>
               </div>
              </div>



              <!--  <div class="col-md-6">
                 <div>
                  <div class="border border-danger rounded">
                <div>Jibiat doit vous retourner: 
                <strong class=" float-right">
                {{$retours->count()}} Articles
                </strong> 
                
                </div>
              </div>
               </div>
              </div> -->
            
              
 













      <div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Ajouter une commande</h4>
      </div>
      <div class="modal-body">
     

        <form  action="/command-fast-register" method="POST">
              @csrf
           

            <div class="form-group">
              <label class="form-label">Nature du colis</label>
                            <input required value="{{ old('type') }}" id="type" name="type" class="form-control" type="text" placeholder="Nature du colis" >
            </div>

           <div class="form-group">
            <label class="form-label">Date de livraison</label>
                            <input 
                             min=
     <?php
         echo date('Y-m-d');
     ?>


                             required type="date" value="{{ old('delivery_date') }}" name="delivery_date" class="form-control" type="text"  >
                            
                            @error('delivery_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
            </div>

            <div class="form-group"> 
                      <label class="form-label">Prix(sans la livraison)</label>
                            <input  value="{{ old('montant') }}"  name="montant" class="form-control @error('montant') is-invalid @enderror" type="text" placeholder="Prix (sans la livraison)">
                  
                            @error('montant')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{$massage}}</strong>
                                    </span>
                                @enderror
            </div>

            

            

            <div class="form-group">
                         <label class="form-label">Ville/commune</label>
                            <select  required id="fee"  class="form-control" name="fee">
                              <option  value="">selectionner Une ville/commune</option>
                              @foreach($fees as $fee)
                              <option 
                                  @if(old('fee') == $fee->id) selected @endif
                                value="{{$fee->id}}">{{$fee->destination}} : {{$fee->price}} CFA</option>
                                
                                <div id="fee_price"></div>
                              @endforeach
                            </select>
                          
            @error('fee')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            
            </div>

            <div class="form-group">
              <label class="form-label"> Précision sur l'adresse de livraison</label>
                            <input value="{{ old('lieu') }}" id="lieu" name="adresse" class="form-control" type="text" placeholder="Exemple: grand carrefour... pharmacie... rivera jardin..." >
                            
            </div>

            <div class="form-group">
                     <label class="form-label">Contact</label>
                            <input value="{{ old('phone') }}" required  name="phone" class="form-control" type="text" placeholder="Numero du client sans l'indicatif(225)">
                      
                   @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror         
            </div>

            <div class="form-group">
              <label  class="form-label"> Information supplementaire.</label>
                            <input maxlength="150" value="{{ old('observation') }}"  name="observation" class="form-control" type="text" placeholder="Information supplementaire">
                           
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
               <!-- @if(Auth::user()->approved == "yes")
                  <button class="btn btn-success" data-toggle="modal" data-target="#myModal" type="button">Nouvelle commande</button>

                  @else
                  <div class="alert alert-danger">Compte restreint</div>
                  <div class="alert alert-warning">Pour une meilleure prise en charge de vos livraisons, JibiaT restreint le nombre de ses partenaires. Tout partenariat est désormais soumis à une négociation préalable avec nos service. Merci pour votre fidélité. </div>
                @endif -->
               

               <button class="btn btn-success" data-toggle="modal" data-target="#myModal" type="button">Nouvelle commande</button>
                <p >  
                
                 
                 
                

                 <!-- @if($commands->count() >0)
                 <strong>{{$commands->count()}}</strong> Commandes ( @if($ready<$commands->count())  <strong> Il vous reste {{$commands->count()-$ready}} commandes à préparer </strong> @else Bravo! toutes vos commandes sont prête!  @endif )
               </p> <strong>{{$done}} </strong> Livrés. {{$commands->count() - $done -$cancel}} Restants. {{$cancel}} Annulés.
                @endif -->

                
                <!-- <div>

                  <p >Total commande : <strong class="float-right">{{$total}}</strong>  </p>
                  <p >Total annulé : <strong class="float-right">{{$canceled_montant}}</strong> </p>
                <p >Total livré : <strong class="float-right">{{$done_montant}}</strong> </p>
               

               
                </div> -->
                 
                
                  
                 <h4 class="float-center"> 
                 
                 {{$day}}

               </h4>
                
                <form  autocomplete="off" id="date-form" action='?bydate' class="float-right">
                  @csrf
                  <div class="form-group date">
                    <label class="form-label">Date</label>
                    
                  <input value="{{$day}}" id="day" class="form-control" type="text" name="route_day">
                  <div class="input-group-addon">
        <span class="glyphicon glyphicon-th"></span>
    </div>
                  </div>
                  <button id="submit_day" hidden type="submit" class="btn btn-primary">Choisir</button>
                  
                </form>

                          <div class="container box">
   
                   <div>
                    
                  
             @if($commands->count()>0)     
             
          <!--  <button  class="btn btn-danger btn-sm delete_all" data-url="{{ url('bulk-recup') }}">J'ai recupéré les selectionnés</button> -->
           <meta name="csrf-token" content="{{ csrf_token() }}" />
              
               
                  <table id="myTable" class="table table-striped">
                    <thead class=" text-primary">
                      <!-- <th><input type="checkbox" id="master"></th> -->
                     
                      <th>
                       Commande
                      </th>
                      

                      
                    </thead>
                    <tbody>
                      
                      @foreach($commands as $command)


                        

                      <tr id="tr_{{$command->id}}">
                        <!-- <td>
                        
                         <input  data-id="{{$command->id}}" type="checkbox" class="sub_chk">
                         
                        </td> -->
                        <td>
                          
                          
                          
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

                          @if($command->etat == 'annule')
                          class="badge badge-secondary"
                          @endif
                          >
                         @if($command->livreur_id == 11 && $command->etat != 'annule')
                         En attente de traitement 
                         @else
                          @if($command->etat != 'termine')
                          {{$command->etat}}
                           @else
                           Livré 
                           @endif
                           {{$command->updated_at->format('H:i:s')}}
                           @endif
                        </span>
                        @if($command->loc == 'retour')
                        <strong style="color: red">Retour en attente</strong>
                        @endif
                       
                        
                       <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal{{$command->id}}">Modifier</button> 
                      @if($command->etat == 'encours' || $command->etat == 'recupere' || $command->etat == 'en chemin')
                        <form class="form-inline" action="/cancel" method="POST">
                            @csrf
                            <input value="{{$command->id}}" type="text" name="id" hidden>
                            <input type="text" value="yes" name="cancel" hidden>
                          <button type="submit" class="badge badge-danger badge-sm">Annuler</button>
                          </form>
                      
                      


                      @endif

                      @if($command->etat == 'annule')
                      <form class="form-inline" action="/cancel" method="POST">
                            @csrf
                            <input value="{{$command->id}}" type="text" name="id" hidden>
                            <input type="text" value="no" name="cancel" hidden>
                          <button type="submit" class="badge badge-secondary badge-sm">Activer</button>
                          </form>
                      @endif
                      

    <div id="myModal{{$command->id}}" class="modal fade" role="dialog">
  <div class="modal-dialog">
   <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modifier commande {{$command->id}}</h4>
      </div>
      <div class="modal-body">
     <form  action="/command-update" method="POST">
              @csrf
<div class="form-group">
      <label class="form-label">Nature du colis</label>
      <input required value="{{$command->description }}" id="type" name="type" class="form-control" type="text" placeholder="Nature du colis" >
  </div>
  <input value="{{$command->id}}" hidden name="command_id">
  <div class="form-group">
    <label class="form-label">Date de livraison
      <input  required type="date" min=
     <?php
         echo date('Y-m-d');
     ?> value="{{$command->delivery_date->format('Y-m-d') }}" name="delivery_date" class="form-control" type="text" >
        </label>
          @error('delivery_date')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror
            </div>

            <div class="form-group">
              <label class="form-label">Prix(sans la livraison)</label>
                            <input  value="{{$command->montant }}"  name="montant" class="form-control @error('montant') is-invalid @enderror" type="text" placeholder="Prix(sans la livraison)">
                            @error('montant')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{$massage}}</strong>
                                    </span>
                                @enderror
            </div>

            

            

            <div class="form-group">
                         <label class="form-label">Ville / Commune</label>
                            <select  required id="fee"  class="form-control" name="fee">
                              <option  value="">selectionner Une ville/commune</option>
                              @foreach($fees as $fee)
                              <option 
                                  @if($command->fee_id == $fee->id) selected @endif
                                value="{{$fee->id}}">{{$fee->destination}} : {{$fee->price}} CFA</option>
                                
                                <div id="fee_price"></div>
                              @endforeach
                            </select>
            @error('fee')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            
            </div>

            <?php
$adresse = str_replace($command->fee->destination.":","",$command->adresse);
?>

            <div class="form-group">
                          <label class="form-label">Précision sur l'adresse de livraison</label>
                            <input value="{{$adresse}}" id="lieu" name="adresse" class="form-control" type="text" placeholder="Exemple: grand carrefour... pharmacie... rivera jardin..." >
            </div>

            <div class="form-group">
                            <input value="{{$command->phone}}" required  name="phone" class="form-control" type="text" placeholder="Contact du client">

                   @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror         
            </div>

            

            <div class="form-group">
              <label class="form-label"> Information supplementaire.</label>
                            <input maxlength="150" value="{{ $command->observation }}"  name="observation" class="form-control" type="text" placeholder="Information supplementaire">
                            
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


                       


                        <br>
                        <p  style="color: green; text-align: left;">{{$command->description}}</p>
                          <strong>
                           
                          #{{$command->id}}
                          {{$command->adresse}}<br> 
                          {{$command->phone}}<a style="font-weight: lighter;font-size: 5" href="tel:{{$command->phone}}" class="btn btn-info btn-sm">
                 <i  class="fas fa-phone"></i></a><br> {{$command->montant}}CFA
                           </strong>
                              <br><br>
                              @if($command->etat == 'encours')
                              
                              <button style="font-weight: lighter;font-size: 5" class="badge btn-primary btn-sm" data-toggle="modal" data-target="#assign{{$command->id}}" >Assigner un livreur</i></button><br>
                              @endif
                              
                           @if($command->livreur_id != 11)
                           Livreur: {{$command->livreur->nom}}({{$command->livreur->id}}):
                           {{$command->livreur->phone}}

                           <a style="font-weight: lighter;font-size: 5" href="tel:{{$command->livreur->phone}}" class="btn btn-info btn-sm">
                 <i class="fas fa-phone"></i></a>
                           @endif
                           </p>
                           @if(!empty($command->observation))
                          <p>{{$command->observation}}</p>
                          @endif
                          @if($command->payment)
                            @if($command->payment->etat == 'termine' )
                           
                          <span class="stamp is-approved">Payé</span>
                           @endif
                          @else
                          @if($command->etat != 'annule')
                            <input hidden="hidden" type="text" value="Votre commande {{$command->id}} a été enregistrée. Cliquez ici pour voir le status : https://client.livreurjibiat.site/tracking/{{$command->id}}" id="myInput">
                          

                           <button onclick="CopyBill()">Copier lien de facture</button>

                           <!-- <button class="btn btn-sm" onclick="copyLink()"><i class="fas fa-copy"></i></button> -->
                           @endif
                          @endif 

                           @if($command->note->count()>0)
                         <p class="float-right" style="position: relative;top: -150px;"> <a  data-toggle="modal" data-target="#noteViewModal{{$command->id}}" href=""> <i class="fa fa-sticky-note" ></i></a></p>
                      <div id="noteViewModal{{$command->id}}" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Note: {{$command->id}} ({{$command->note->count()}}) </h4>
      </div>
      <div class="modal-body">
     @foreach( $command->note->sortByDesc('created_at')  as $one)
     <p><strong>{{$one->updated_at->format('d-m-Y')}}</strong> - {{$one->updated_at->format('H:i:s')}} - {{$one->description}}  </p>
      @endforeach  
    </div>

  </div>
</div>



                          </div>
                          @endif




                          

                         
                         <div class="float-right" >
                          @if($command->etat == 'encours')
                          @if($command->ready == NULL)
                           <form  action="/ready" method="POST">
                            @csrf
                            <input value="{{$command->id}}" type="text" name="id" hidden>
                            <input type="text" value="yes" name="ready" hidden>
                          <button type="submit" class="btn btn-dark btn-sm">Prêt?</button>
                          </form>
                          @else
                          
                         
                          <form class="form-inline" action="/unready" method="POST">
                             @csrf
                            <input value="{{$command->id}}" type="text" name="id" hidden>
                            <input type="text" value="yes" name="ready" hidden >
                            <img width="30" height="30" src="/assets/img/packing.ico">
                          <button type="submit"   class="badge badge-danger badge-sm">Pas prêt?</button>
                          </form>
                          @endif

                          
                        </div>
                          @endif
                          

                       
                        </td>

                        
                        
                      </tr>


                    

  </div>
</div>
                      
   <div id="assign{{$command->id}}" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Assigner à un livreur</h4>
      </div>
      <div class="modal-body">
        <form method="POST" action="relay/{{$command->id}}">
          @csrf
          <div class="form-group">

           
          <select data-live-search="true" name="relais" required class="form-control selectpicker">

            <option>Choisir un livreur</option>
            
            @if($command->livreur_id != 11)
            <option value="11">Annuler assignation</option>
            @endif
          @foreach($livreurs as $livreur)
          <option value="{{$livreur->id}}">({{$livreur->id}}){{$livreur->nom}}  
           
          </option>
          <p class="font-weight-light">{{$livreur->adresse}}.</p>
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
                     


                      @endforeach

                    </tbody>
                   
                  </table>
                  
                  @else
                      Vous n'avez aucune commande 
                      @endif
                </div>
              </div>
            </div>
          </div>
         <!-- Modal -->

          

        </div>





@endsection
@if (count($errors) > 0)
    <script>
        $( document ).ready(function() {
            $('#myModal').modal('show');
        });
    </script>
@endif


@section("script")

<script type="text/javascript">
  $(document).ready(function() {





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
       
       $('#day ').datepicker({
language: 'fr',
autoclose: true,
todayHighlight: true
})

        $("#day").change(function(){
  $("#date-form").submit();
});

} );


setTimeout(function(){
       location.reload();
   },600000);



function CopyBill() {
  /* Get the text field */

  document.getElementById("myInput").hidden = false;
  var copyText = document.getElementById("myInput");

  /* Select the text field */
  
  copyText.select();
  copyText.setSelectionRange(0, 99999); /*For mobile devices*/

  /* Copy the text inside the text field */
  document.execCommand("copy");

  /* Alert the copied text */
  alert("Lien de facture copié");

  document.getElementById("myInput").hidden = true;
}

</script>

@endsection









